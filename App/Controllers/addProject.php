<?php
require_once "../../config.php";

use Ncw\Models\Project;

$projectObj = new Project();
$projectObj->addProject($_REQUEST);

header("location: ../Views/manageProject.php");

?>