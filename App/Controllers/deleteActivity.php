<?php
require_once "../../config.php";

session_start();

use Ncw\Models\Activity;

$activityObj = new Activity();

// ตรวจสอบสิทธิ์: ต้องเป็นเจ้าของ หรือ admin
$activity = $activityObj->getActivityById(['act_id' => $_REQUEST['act_id']]);

if ($activity['create_by'] == $_SESSION['id'] || $_SESSION['role'] == 1) {
    $activityObj->deleteActivity($_REQUEST);
    header("location: ../Views/manageActivity.php?msg=ลบข้อมูลสำเร็จ");
} else {
    header("location: ../Views/manageActivity.php?msg=คุณไม่มีสิทธิ์ลบรายการนี้");
}
?>