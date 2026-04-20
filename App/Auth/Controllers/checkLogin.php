<?php
require_once "../../../config.php";

use Ncw\Auth\Models\User;

$userObj = new User();
$result = $userObj->checkUser($_POST);
if ($result) {
  header("location: ../../../App/Views/showGroupCard.php");
} else {
  header("location: ../../../index.php?msg=error");
}
?>