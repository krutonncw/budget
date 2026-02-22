<?php
require $_SERVER['DOCUMENT_ROOT'] . "/ncwbu dget/vendor/autoload.php";

use Ncw\Models\Project;
use Ncw\Models\BudgetType;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <form action="../Controllers/addActivity.php" method="post">
    <label for="act_name">ชื่อกิจกรรม</label><br>
    <input type="text" name="act_name" id="act_name"><br><br>

    <label for="pro_id">โครงการ</label><br>
    <select name="pro_id" id="pro_id">
      <option value="">โครงการ</option>
      <?php
      $projectObj = new Project();
      $projects = $projectObj->getAllprojects();
      foreach ($projects as $project) {
        echo "
        <option value='{$project['pro_id']}'>{$project['pro_name']}</option>
      ";
      }
      ?>
    </select><br><br>

    <label for="bgt_id">ประเภทเงินงบประมาณ</label><br>
    <select name="bgt_id" id="bgt_id">
      <option value="">ประเภทเงินงบประมาณ</option>
      <?php
      $budgettypeObj = new BudgetType();
      $budgettypes = $budgettypeObj->getAllBudgetTypes();
      foreach ($budgettypes as $budgettype) {
        echo "
        <option value='{$budgettype['bgt_id']}'>{$budgettype['bgt_name']}</option>
      ";
      }
      ?>
    </select><br><br>

    <label for="act_money">งบประมาณที่ได้รับ</label><br>
    <input type="text" name="act_money" id="act_money"><br><br>

    <br><br>
    <input type="submit" value="Submit">
  </form>

</body>

</html>