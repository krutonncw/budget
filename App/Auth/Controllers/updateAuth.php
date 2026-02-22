<?php
// เรียกใช้งาน ไฟล์ autoload เพือให้โหลดคลาสต่าง ๆ มาทำงาน
require $_SERVER['DOCUMENT_ROOT'] . "/budget/vendor/autoload.php";

//ตรวจสอบว่าเข้าสู่ระบบหรือยัง
require $_SERVER['DOCUMENT_ROOT'] . "/budget/App/Auth/Controllers/auth.php";

// สำหรับไว้ตรวจสอบ error
error_reporting(E_ALL);
ini_set('display_errors', 1);

use Ncw\Auth\Models\Person;
use Ncw\Auth\Models\User;

// var_dump($_FILES);
// echo $_FILES['upload']['tmp_name'];

if (isset($_FILES['avatar']['tmp_name'])) {

	if ($_FILES['avatar']['tmp_name']) {
		// explode โดยใช้จุดเพื่อแยกนามสกุลไฟล์ออกมาใช้งาน
		$ext = end(explode(".", $_FILES['avatar']['name']));

		// กำหนดชื่อให้ใหม่ไม่ซ้ำกันแบบเข้ารหัสแทน จากนั้นเชื่อมกับนามสกุล
		$avatar = "/ncwbudget/assets/images/avatar/" . md5(uniqid()) . ".{$ext}";
		// จากนั้นส่งไฟล์ไปเก็บ
		move_uploaded_file($_FILES['avatar']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $avatar);
	}
}

// สำหรับตรวจสอบว่ามี action อะไรส่งเข้ามาให้ทำ
if ($_REQUEST['action'] == "setAuth") {
	$userObj = new User;
	$user = $userObj->updateRoleUser($_REQUEST);
	if ($user) {
		header("location: ../Views/showPerson.php");
		// print("สำเร็จ");
	} else {
		header("location: ../Views/error.php");
	}
} elseif ($_REQUEST['action'] == "update") {
	if ($_SESSION['role'] == 1) {
		$userObj = new User;
		$user = $_REQUEST; //ส่ง array ที่ได้จากฟอร์มไปให้ตัวแปรเพื่อบันทึกได้เลย
		unset($user['action']);
		unset($user['gender_id']);
		unset($user['firstname']);
		unset($user['lastname']);
		unset($user['dep_id']);
		unset($user['avatar']);
		$userObj->updateUsername($user);
	}

	$personObj = new Person;
	$person = $_REQUEST; //ส่ง array ที่ได้จากฟอร์มไปให้ตัวแปรเพื่อบันทึกได้เลย
	unset($person['action']);
	unset($person['username']);

	// เช็คว่าถ้ามีการ upload รูปใหม่มาไหม ถ้ามีก็ให้ใช้ $avatar ที่ได้จากข้างบน แต่ถ้าไม่ก็ใช้ข้อมูลเดิม
	if ($_FILES['avatar']['tmp_name']) {
		if ($person['avatar']) {
			// ลบรูปเก่า
			unlink($_SERVER['DOCUMENT_ROOT'] . $person['avatar']);
		}
		$person['avatar'] = $avatar;
	}
	if ($personObj->updatePerson($person)) {
		header("location: ../../Views/showGroupCard.php");
	} else {
		header("location: ../Views/error.php");
	}
} elseif ($_REQUEST['action'] == "delete") {
	$userObj = new User;
	$personObj = new Person;
	unset($_REQUEST['action']);
	$data = $_REQUEST['id'];
	if ($userObj->deleteUser($data) && $personObj->deletePerson($data)) {
		header("location: ../Views/showPerson.php");
	} else {
		header("location: ../Views/error.php");
	}
} elseif ($_REQUEST['action'] == "repassword") {
	$userObj = new User;

	unset($_REQUEST['action']);
	$user = $_REQUEST;

	if ($userObj->updatePassword($user)) {
		if ($_SESSION['role'] == 1) {
			header("location: ../Views/showPerson.php");
		} else {
			header("location: ../Views/logout.php");
		}
	} else {
		header("location: ../Views/error.php");
	}
}
