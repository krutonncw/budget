<?php
require_once "../../config.php";

//ตรวจสอบว่าเข้าสู่ระบบหรือยัง
require_once BASE_PATH . "/App/Auth/Controllers/auth.php";

use Ncw\Models\PayPlan;
use Ncw\Models\Activity;

// print_r($_REQUEST);
// exit();

// สำหรับตรวจสอบว่ามี action อะไรส่งเข้ามาให้ทำ
if ($_REQUEST['action'] == "add") {
  $payplanObj = new Payplan;
  $activityObj = new Activity;

  //นำ field ที่ไม่ใช้ออกจาก array เพื่อไม่ให้เกิดปัญหาในการนำไปประมวลผล
  unset($_REQUEST['action']);
  unset($_REQUEST['depAjax']);
  unset($_REQUEST['projectAjax']);
  $checkActBal['act_id'] = $_REQUEST['act_id'];
  $upActBal = $_REQUEST;
  // unset($_REQUEST['pay_order']);

  //สร้างตัวแปร checkActBal เพื่อตรวจสอบยอดเงินคงเหลือกิจกรรม
  //unset($checkActBal['pay_objective']);
  //unset($checkActBal['pay_user']);
  //unset($checkActBal['pay_date']);
  //unset($checkActBal['pay_money']);
  //unset($checkActBal['pay_order']);

  //สร้างตัวแปร upActBal เพื่ออัปเดทยอดเงินคงเหลือกิจกรรม
  unset($upActBal['dep_order']);
  unset($upActBal['pay_type']);
  unset($upActBal['pay_objective']);
  unset($upActBal['pay_user']);
  unset($upActBal['pay_date']);
  unset($upActBal['person_id']);
  //unset($upActBal['pay_order']);

  //กำหนดค่าให้กับการอัพเดท สถานะกิจกรรม
  //$step['act_id'] = $_REQUEST['act_id'];
  //$step['act_step'] = 1;

  $lastpayObj = new Payplan;
  $lastpay = $lastpayObj->getLastPayOrder();
  $_REQUEST['pay_order'] = $lastpay['pay_order'] + 1;
  $_SESSION['pay_order'] = $_REQUEST['pay_order'];

  // กรอกเป็น พ.ศ. มาให้ทำการลบออกเป็น ค.ศ.
  $OldYear = explode("-", $_REQUEST['pay_date']);
  (int) $intYear = $OldYear[0];
  if ($intYear >= 2500) {
    $NewYear = $intYear - 543 . "-" . $OldYear[1] . "-" . $OldYear[2];
    $_REQUEST['pay_date'] = $NewYear;
  }

  // ทำการเรียนยอดเงินมาตรวจสอบก่อน
  $getActBalByIdObj = new Activity;
  $getActBalById = $getActBalByIdObj->getActBalById($checkActBal);
  if (($getActBalById['act_balance'] - $upActBal['pay_money']) >= 0) {
    $upActBal['pay_money'] = $getActBalById['act_balance'] - $upActBal['pay_money'];
    $activity = $activityObj->updateActBal($upActBal);
    if ($activity == 1) {
      $payplan = $payplanObj->addPayPlan($_REQUEST);
      //$paystep = $paystepObj->updatePayStep($step);
      //header("location: ../Views/reportPayOrder.php?pay_order={$_REQUEST['pay_order']}");
      header("location: ../Views/reportPayOrder.php");
      // print("สำเร็จ");
    } else {
      header("location: ../Auth/views/error.php");
    }
  } else {
    echo "<h3>ยอดเงินคงเหลือน้อยกว่า 0 </h3>";
  }
}
