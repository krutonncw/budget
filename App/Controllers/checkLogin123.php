<?php
require $_SERVER['DOCUMENT_ROOT'] . "/budget/vendor/autoload.php";
?>

<?php
use Ncw\Model\User;

$user_obj = new User;

$result = $user_obj->checkUser($_POST);

if ($result) {
	header("location: ../../views/budget/groupCardShow.php");
} else {
	header("location: ../../index.php?msg=error");
}
?>