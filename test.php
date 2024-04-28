<?php
require 'class.termgame.php';

$api_key = "ใส่ api key ที่นี่!!!";

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
    "gameUID" => "username",// UID ภายในเกมส์
    "packageId" => "", // id ของแพ็คเกจ
    "serverId" => "", // id ของเซิฟเวอร์
    //   "callbackUrl": "string" url สำหรับส่งกลับสถานะรายการ
]));
?>
