<?php
require_once "../../config.php";

session_start();

use Ncw\Models\Activity;

// เพิ่ม create_by จาก session ของผู้ใช้
$_REQUEST['create_by'] = $_SESSION['id'];

$activityObj = new Activity();
$activityObj->addActivity($_REQUEST);

header("location: ../Views/manageActivity.php");
?>