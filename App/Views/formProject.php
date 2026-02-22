<?php
require $_SERVER['DOCUMENT_ROOT'] . "/budget/vendor/autoload.php";

use Ncw\Models\Department;
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
  <form action="../Controllers/addProject.php" method="post">
    <label for="pro_name">ชื่อโครงการ</label><br>
    <input type="text" name="pro_name" id="pro_name"><br><br>
    <label for="dep_id">กลุ่ม</label><br>
    <select name="dep_id" id="dep_id">
      <option value="">กลุ่ม</option>
      <?php
      $departmentObj = new Department();
      $departments = $departmentObj->getAllDepartments();
      foreach ($departments as $department) {
        echo "
        <option value='{$department['dep_id']}'>{$department['dep_name']}</option>
      ";
      }
      ?>
    </select>
    <br><br>
    <input type="submit" value="Submit">
  </form>

</body>

</html>