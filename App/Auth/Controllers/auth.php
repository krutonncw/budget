<?php

// เริ่มใช้ตัวแปร session และตรวจสอบการ login
session_start();
if (!$_SESSION['login']) {
	header("location: ../Views/index.php");
	exit;
} else {
	// ตรวจสอบว่า สถานะรออนุมัติเปล่า
	if ($_SESSION['role'] == 9) {
		$_SESSION = [];
		header("location: ../Views/status_login.php");
		exit;
	}
}
?>