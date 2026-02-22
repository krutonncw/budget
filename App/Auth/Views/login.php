<?php
require $_SERVER['DOCUMENT_ROOT'] . "/budget/vendor/autoload.php";
error_reporting(error_reporting() & ~E_NOTICE);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="/ncwbudget/assets/css/bootstrap.css">
</head>

<body>
  <?php
  if ($_GET['msg']) {
    echo "<h5>Password ไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง</h5>";
  }
  ?>
  <form action="../Controllers/checkLogin.php" method="POST">
    <label for="username">ชื่อผู้ใช้ภาษาอังกฤษ</label><br>
    <input type="text" name="username" id="username" require><br><br>

    <label for="password">รหัสผ่าน</label><br>
    <input type="password" name="password" id="password" require><br><br>

    <br><br>
    <input type="submit" value="เข้าสู่ระบบ">
  </form>

</body>

</html>