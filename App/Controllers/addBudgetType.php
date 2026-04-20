<?php
require_once "../../config.php";

use Ncw\Models\BudgetType;

$budgettypeObj = new BudgetType();
$budgettypeObj->addBudgetType($_REQUEST);

header("location: ../Views/showbudgettype.php");

?>