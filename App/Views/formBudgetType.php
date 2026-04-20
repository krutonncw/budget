<?php
// เรียกใช้งาน ไฟล์ autoload เพือให้โหลดคลาสต่าง ๆ มาทำงาน
require_once "../../config.php";

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
  <form action="../Controllers/addBudgetType.php" method="post">
    <label for="bgt_name">ประเภทงบประมาณ</label><br>
    <input type="text" name="bgt_name" id="bgt_name"><br><br>
    <input type="submit" value="Submit">
  </form>
</body>

</html>