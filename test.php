<pre>
<?php
require 'class.termgame.php';

$api_key = "l2msif8dhl2c9ppe648ld04kx6gshyoy9vkh2anjqai4zxnzhxm4je7k0xjnzqgh";

$tg = new TermgameSeller($api_key);

// แสดงยอดเงินคงเหลือ
// echo $tg->getBalance()["balance"];

// เกมส์ทั้งหมด
// print_r($tg->games());

// เซิฟเวอร์
// print_r($tg->servers());

// แพ็คเกจ
// print_r($tg->packages());

// ประวัติเติมเกมส์
// print_r($tg->transactions());

// ซื้อ
print_r($tg->buy([
    "gameUID" => "12011158193",// UID ภายในเกมส์
    "packageId" => "49d89f30-11c8-4738-b3b7-77515667636c", // id ของแพ็คเกจ
    "serverId" => "c259b81d-dc64-497a-840b-074d8c1a1043", // id ของเซิฟเวอร์ที่ได้มาจากการดึง server
    //   "callbackUrl": "string" url สำหรับส่งกลับสถานะรายการ
]));
?>
</pre>