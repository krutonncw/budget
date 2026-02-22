<?php
require $_SERVER['DOCUMENT_ROOT'] . "/budget/vendor/autoload.php";

session_start();

use Ncw\Models\Activity;

$activityObj = new Activity();

// ตรวจสอบสิทธิ์: ต้องเป็นเจ้าของ หรือ admin
$activity = $activityObj->getActivityById(['act_id' => $_REQUEST['act_id']]);

if ($activity['create_by'] == $_SESSION['id'] || $_SESSION['role'] == 1) {
    $activityObj->updateActivity($_REQUEST);
    header("location: ../Views/manageActivity.php?msg=แก้ไขข้อมูลสำเร็จ");
} else {
    header("location: ../Views/manageActivity.php?msg=คุณไม่มีสิทธิ์แก้ไขรายการนี้");
}
?>