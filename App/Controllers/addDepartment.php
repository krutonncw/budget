<?php
require_once "../../config.php";

use Ncw\Models\Department;

$departmentObj = new Department();
$departmentObj->addDepartment($_REQUEST);

header("location: ../Views/showDepartment.php");

?>