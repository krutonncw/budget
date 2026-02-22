<?php
// เรียกใช้งาน ไฟล์ autoload เพือให้โหลดคลาสต่าง ๆ มาทำงาน
require $_SERVER['DOCUMENT_ROOT'] . "/ncwbudget/vendor/autoload.php";

//ตรวจสอบว่าเข้าสู่ระบบหรือยัง
require $_SERVER['DOCUMENT_ROOT'] . "/ncwbudget/App/Auth/Controllers/auth.php";

use Ncw\Models\PayPlan;

$act_id = 1;
$payplanObj = new Payplan();
$payplans = $payplanObj->getSumPayMoneyByAct(1);
echo   number_format($payplans, 2) ;

?>