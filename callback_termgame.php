<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../../../library/connect.rand.php';
require_once __DIR__ . '/../api_seller/class.termgame.php'; //EDIT

function dd_q($str, $arr = []) {
    global $conn;
    try {
        $exec = $conn->prepare($str);
        $exec->execute($arr);
    } catch (PDOException $e) {
        return false;
    }
    return $exec;
}

$json_str = file_get_contents('php://input');
$json_obj = json_decode($json_str);
 // $respFile = fopen("logTermseller.txt", "w") or die("Unable to open file!");
        //fwrite($respFile, $json_str . "\n\n");
        //fclose($respFile);
if(isset($json_obj->id) && isset($json_obj->secret)) {

    $orderId = $json_obj->id;
    $secret = $json_obj->secret;
    $classAPI = new TermgameSeller(null);
    $statusReq = $classAPI->status($orderId,$secret);
    if(isset($statusReq['id']) && $statusReq['id'] !== '' 
    && isset($statusReq['status']) && $statusReq['status'] !== ''
    && isset($statusReq['errorCode']) && $statusReq['errorCode'] !== '') {
        $status = 0;

        $q1 = dd_q('SELECT id,userId,price_sell,order_id FROM termgameseller_history WHERE order_id = ? AND status = ?' , [$orderId,$status]);
        if($q1->rowCount() <= 0) {
                dd_return(false, 'ไม่พบสินค้า');
        }else{
                $result1 = $q1->fetch(PDO::FETCH_ASSOC);
                $message = "-";

                if($statusReq['status'] === 'SUCCESS') {
                    $status = 2;
                    $message = "ทำรายการสำเร็จ (".$statusReq['status']."|".$statusReq['errorCode'].")";
                }elseif($statusReq['status'] === 'FAIL'){
                    $status = -1;
                    $message = "ทำรายการไม่สำเร็จ คืนเงิน (".$statusReq['status']."|".$statusReq['errorCode'].")";
                }elseif($statusReq['status'] === 'ERROR'){
                    $status = -1;
                    $message = "ทำรายการไม่สำเร็จ คืนเงิน (".$statusReq['status']."|".$statusReq['errorCode'].")";
                }elseif($statusReq['status'] === 'PENDING'){
                    $status = 0; //wait
                }
        
                if($status !== 0) {
                    $q_upcredit = dd_q('UPDATE termgameseller_history SET message = ?,status = ? WHERE id = ? LIMIT 1', [$message,$status, $result1['id']]);
                    if($status === -1) {
                        $q_upcredit = dd_q('UPDATE users SET credit = credit + ? WHERE id = ? LIMIT 1', [$result1['price_sell'], $result1['userId']]);
                    }
                }

        }
        

    }else{
        echo "FAIL";
      
    }

}