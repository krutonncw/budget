<?php
// เรียกใช้งาน ไฟล์ autoload เพือให้โหลดคลาสต่าง ๆ มาทำงาน
require $_SERVER['DOCUMENT_ROOT'] . "/budget/vendor/autoload.php";

//ตรวจสอบว่าเข้าสู่ระบบหรือยัง
require $_SERVER['DOCUMENT_ROOT'] . "/budget/views/auth/auth.php";

?>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ระบบแผนงานงบประมาณ</title>
  <link rel="stylesheet" href="/ncwbudget/assets/css/bootstrap.css">

  <link rel="shortcut icon" href="/ncwbudget/assets/images/favicon.svg" type="image/x-icon">
  <link rel="stylesheet" href="/ncwbudget/assets/css/app.css">
</head>

<body>
  <div id="error">

    <div class="container text-center pt-32">
      <img src="/ncwbudget/assets/images/error.svg" alt="" srcset="" style="width: 300px;height:300px;">
      <h1 class='status_login'>ไม่สามารถบันทึกข้อมูลได้</h1>
      <p style="font-size: 1.5rem;">กรุณาตรวจสอบข้อมูลให้เรียบร้อยและลองใหม่อีกครั้ง</p>
      <!-- <a href="index.html" class='btn btn-primary'>Go Home</a> -->
    </div>
    <div class="d-flex justify-content-center">
      <a href='/ncwbudget/App/Auth/Views/showPerson.php' class='btn btn-outline-warning round mr-2'>หน้าหลัก</a>
    </div>

    <div class="footer pt-32">
      <p class="text-center">Copyright &copy; โรงเรียนหนองฉางวิทยา 2020</p>
    </div>
  </div>
</body>

</html>