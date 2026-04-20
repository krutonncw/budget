<?php
require_once "../../../config.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

use Ncw\Auth\Models\User;
use Ncw\Auth\Models\Person;

//ทำการกรองข้อมูลออกเพื่อเอาแต่ที่จำเป็นไปใช้งาน
//สำหรับเก็บในตาราง persons
$person = $_REQUEST;
unset($person['username']);
unset($person['email']);
unset($person['password']);
unset($person['confirm']);
unset($person['role']);
$person += array("dob" => "2020/01/01");
$person += array("gender_id" => 1);
$person += array("avatar" => '');
$person += array("salary" => 0);

//สำหรับเก็บในตาราง users
$user = $_REQUEST;
unset($user['firstname']);
unset($user['lastname']);
unset($user['dep_id']);
unset($user['confirm']);

//print_r($person);
//print_r($user);
//exit;

//ส่งข้อมูลไปตาราง person เพื่อเก็บ 
$personObj = new Person;
$resultPer = $personObj->addPerson($person);

if ($resultPer) {
  $resultPer = $personObj->getLastPersonId(); //ต้องการเลข id ล่าสุด มาเก็บที่ตาราง users อีกครั้ง
  //ส่งข้อมูลไปตาราง user เพื่อเก็บ
  $userObj = new User;

  $user['person_id'] = $resultPer['id']; //เพิ่ม id ลงใน person_id
  $result = $userObj->createUser($user);

  // header("location: ../Views/status_login.php");
  header("location: ../Views/showPerson.php");
} else {
  header("location: ../../index.php?msg=error");
}

?>
?>