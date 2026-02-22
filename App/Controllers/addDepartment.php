<?php
require $_SERVER['DOCUMENT_ROOT'] . "/budget/vendor/autoload.php";

use Ncw\Models\Department;

$departmentObj = new Department();
$departmentObj->addDepartment($_REQUEST);

header("location: ../Views/showDepartment.php");

?>