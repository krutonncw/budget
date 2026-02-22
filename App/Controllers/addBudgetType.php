<?php
require $_SERVER['DOCUMENT_ROOT'] . "/budget/vendor/autoload.php";

use Ncw\Models\BudgetType;

$budgettypeObj = new BudgetType();
$budgettypeObj->addBudgetType($_REQUEST);

header("location: ../Views/showbudgettype.php");

?>