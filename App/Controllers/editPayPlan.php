<?php
require_once "../../config.php";

//ตรวจสอบว่าเข้าสู่ระบบหรือยัง
require_once BASE_PATH . "/App/Auth/Controllers/auth.php";

use Ncw\Models\PayPlan;
//print_r($_REQUEST);
//exit;

// สำหรับตรวจสอบว่ามี action อะไรส่งเข้ามาให้ทำ
if ($_REQUEST['action'] == "edit") {
    $editpayplan['pay_order'] = $_REQUEST['pay_order'];
    $editpayplan['dep_order'] = $_REQUEST['dep_order'];
    $editpayplan['pay_type'] = $_REQUEST['pay_type'];
    $editpayplan['pay_user'] = $_REQUEST['pay_user'];
    $editpayplan['pay_objective'] = $_REQUEST['pay_objective'];
    $editpayplan['pay_date'] = $_REQUEST['pay_date'];
    $editpayplan['person_id'] = $_REQUEST['person_id'];

    $_SESSION['pay_order'] = $editpayplan['pay_order'];

    //print_r($editpayplan);
    //exit;
    $payplanObj = new Payplan;
    $payplan = $payplanObj->editPayPlan($editpayplan);

    header("location: ../Views/reportPayOrder.php");
} else {
    header("location: ../Views/showPayPlan.php");
}
