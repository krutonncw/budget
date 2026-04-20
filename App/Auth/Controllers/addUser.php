<?php
require_once "../../../config.php";

use Ncw\Auth\Models\User;

$user = $_POST;
unset($user['firstname']);
unset($user['lastname']);
unset($user['dep_id']);
unset($user['confirm']);

$userObj = new User();
$result = $userObj->createUser($user);
if ($result) {
  header("location: /budget/App/Auth/Views/showUser.php");
  // header("location: /budget/App/Auth/Views/showPerson.php");
} else {
  header("location: /budget/index.php?msg=error");
}
?>