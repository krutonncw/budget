<?php
require $_SERVER['DOCUMENT_ROOT'] . "/budget/vendor/autoload.php";

//ตรวจสอบว่าเข้าสู่ระบบหรือยัง
require $_SERVER['DOCUMENT_ROOT'] . "/budget/App/Auth/Controllers/auth.php";

use Ncw\Models\PayPlan;

$editpayplan['pay_order'] = $_REQUEST['pay_order'];
$editpayplan['pay_step'] = 5;
$editpayplan['pay_bill'] = $_REQUEST['pay_bill'];

// เช็คยอดเงินเดิมที่ขอ กับ ยอดเงินใหม่ที่ขอ
if ($_REQUEST['pay_money'] >= $_REQUEST['pay_bill']) {
    $payplanObj = new Payplan;
    $payplan = $payplanObj->editPayBill($editpayplan);
    header("location: ../Views/showPayBill.php");

} else {
    echo "<h3>ยอดเงินที่จ่าย น้อยกว่า เงินที่ขออนุมัติ</h3>";
    echo "<a href='/budget/App/Views/searchEditPayBill.php'>Back</a>";
}

