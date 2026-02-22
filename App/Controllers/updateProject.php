<?php
require $_SERVER['DOCUMENT_ROOT'] . "/budget/vendor/autoload.php";

use Ncw\Models\Project;

$projectObj = new Project();
$projectObj->updateProject($_REQUEST);

header("location: ../Views/manageProject.php");
?>