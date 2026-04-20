<?php
require_once "../../config.php";

//ตรวจสอบว่าเข้าสู่ระบบหรือยัง
require_once BASE_PATH . "/App/Auth/Controllers/auth.php";

use Ncw\Models\PayPlan;
use Ncw\Models\Activity;

$checkActBal['act_id'] = $_REQUEST['act_id'];
$editpayplan['pay_order'] = $_REQUEST['pay_order'];
$editpayplan['pay_money'] = $_REQUEST['pay_money_edit'];

// ทำการเรียนยอดเงินมาตรวจสอบ
$getActBalByIdObj = new Activity;
$getActBalById = $getActBalByIdObj->getActBalById($checkActBal);

// เช็คยอดเงินเดิมที่ขอ กับ ยอดเงินใหม่ที่ขอ
if ($_REQUEST['pay_money'] > $_REQUEST['pay_money_edit']) {
    $getActBalById['act_balance'] = $getActBalById['act_balance'] + ($_REQUEST['pay_money'] - $_REQUEST['pay_money_edit']);
} else {
    $getActBalById['act_balance'] = $getActBalById['act_balance'] - ($_REQUEST['pay_money_edit'] - $_REQUEST['pay_money']);
}
;

//กำหนดค่าให้ตัวแปร editActBal เพื่อส่งไป updateActBal
$payplanObj = new Payplan;
$activityObj = new Activity;

$editActBal['act_id'] = $_REQUEST['act_id'];
$editActBal['pay_money'] = $getActBalById['act_balance'];

$payplan = $payplanObj->editPayMoney($editpayplan);
$activity = $activityObj->updateActBal($editActBal);

if ($_REQUEST['pay_money_edit'] == 0) {
    // กำหนดค่าให้ตัวแปร editstep เพื่อส่งไป updatePayStep
    $editstep['pay_order'] = $_REQUEST['pay_order'];
    $editstep['pay_step'] = 0;

    $paystepObj = new Payplan;
    $step = $paystepObj->updatePayStep($editstep);
}

header("location: ../Views/showPayPlan.php");
