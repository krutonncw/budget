<?php
require_once "../../config.php";

session_start();

use Ncw\Models\Activity;

$activityObj = new Activity();

// ตรวจสอบสิทธิ์: ต้องเป็นเจ้าของ หรือ admin
$activity = $activityObj->getActivityById(['act_id' => $_REQUEST['act_id']]);

// เพิ่ม create_by จาก session ของผู้ใช้
$_REQUEST['create_by'] = $_SESSION['id'];
$_REQUEST['create_at'] = date('Y-m-d H:i:s');

if ($activity['create_by'] == $_SESSION['id'] || $_SESSION['role'] == 1) {
    $activityObj->updateActivity($_REQUEST);
    header("location: ../Views/manageActivity.php?msg=แก้ไขข้อมูลสำเร็จ");
} else {
    header("location: ../Views/manageActivity.php?msg=คุณไม่มีสิทธิ์แก้ไขรายการนี้");
}
?>