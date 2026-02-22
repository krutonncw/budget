<?php
// เริ่มใช้ตัวแปร session และตรวจสอบการ login
session_start();
if (!$_SESSION['login']) {
	header("location: /budget/App/Views/index.php");
	exit;
} else {
	// ตรวจสอบว่า สถานะรออนุมัติเปล่า
	if ($_SESSION['role'] == 4) {
		$_SESSION = [];
		header("location: /budget/App/Auth/Views/status_login.php");
		exit;
	}
}
?>