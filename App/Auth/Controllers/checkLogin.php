<?php
require $_SERVER['DOCUMENT_ROOT'] . "/budget/vendor/autoload.php";

use Ncw\Auth\Models\User;

$userObj = new User();
$result = $userObj->checkUser($_POST);
if ($result) {
  header("location: /budget/App/Views/showGroupCard.php");
} else {
  header("location: /budget/index.php?msg=error");
}
?>