<?php
require_once "../../config.php";

use Ncw\Models\Project;

$projectObj = new Project();
$projectObj->updateProject($_REQUEST);

header("location: ../Views/manageProject.php");
?>