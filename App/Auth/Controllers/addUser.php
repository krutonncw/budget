<?php
require $_SERVER['DOCUMENT_ROOT'] . "/budget/vendor/autoload.php";

use Ncw\Auth\Models\User;

$user = $_POST;
unset($user['firstname']);
unset($user['lastname']);
unset($user['dep_id']);
unset($user['confirm']);

$userObj = new User();
$result = $userObj->createUser($user);
if ($result) {
  header("location: /ncwbudget/App/Auth/Views/showUser.php");
  // header("location: /ncwbudget/App/Auth/Views/showPerson.php");
} else {
  header("location: /ncwbudget/index.php?msg=error");
}
?>