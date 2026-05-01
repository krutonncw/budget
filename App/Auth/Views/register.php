<?php
// เรียกใช้งาน ไฟล์ autoload เพือให้โหลดคลาสต่าง ๆ มาทำงาน
require_once "../../../config.php";

//ตรวจสอบว่าเข้าสู่ระบบหรือยัง
require_once BASE_PATH . "/App/Auth/Controllers/auth.php";

use Ncw\Models\Department;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="/budget/assets/css/style.css" />
  <!-- <link rel="stylesheet" href="/budget/assets/css/bootstrap.css"> -->
  <!-- <link rel="stylesheet" href="/budget/assets/css/app.css"> -->
  <!-- ใส่ icon บนแถบ title bar -->
  <link rel="shortcut icon" href="<?= BASE_URL ?>/assets/images/budgetIcon.svg" type="image/x-icon">
  <title>NAbudget</title>
</head>

<body>
  <!-- <form action="../Controllers/addPerson.php" method="GET">
    <label for="firstname">ชื่อ</label><br>
    <input type="text" name="firstname" id="firstname" require><br><br>

    <label for="lastname">นามสกุล</label><br>
    <input type="text" name="lastname" id="lastname" require><br><br>

    <label for="dep_id">กลุ่ม</label><br>
    <select name="dep_id" id="dep_id">
      <option value="">ฝ่าย/กลุ่มสาระ</option>
      <?php
      $departmentObj = new Department();
      $departments = $departmentObj->getAllDepartments();
      foreach ($departments as $department) {
        echo "
        <option value='{$department['dep_id']}'>{$department['dep_name']}</option>
      ";
      }
      ?>
    </select><br><br>

    <label for="username">ชื่อผู้ใช้ภาษาอังกฤษ</label><br>
    <input type="text" name="username" id="username" require><br><br>

    <label for="email">อีเมล์</label><br>
    <input type="email" name="email" id="email" require><br><br>

    <label for="password">รหัสผ่าน</label><br>
    <input type="password" name="password" id="password" require><br><br>

    <label for="confirm">รหัสผ่านอีกครั้ง</label><br>
    <input type="password" name="confirm" id="confirm" require><br><br>
    <br><br>
    <input type="submit" value="ลงทะเบียน">
  </form> -->

  <!-- <form action="App/Auth/Controllers/addPerson.php" method="get" name="new"> -->
  <form action="../Controllers/addPerson.php" method="get" name="new">
    <h2 class="title">ลงทะเบียนผู้ใช้งาน NAbudget</h2>
    <h4 style="font-size: 35px;font-weight: 350;color: #f11818;">โรงเรียนนิยมศิลป์อนุสรณ์</h4>
    <div class="input-field" id="ftname">
      <i class="fas fa-user"></i>
      <input type="text" name="firstname" id="firstname" placeholder="ชื่อ" required />
    </div>
    <div class="input-field" id="ltname">
      <i class="fas fa-user"></i>
      <input type="text" name="lastname" id="lastname" placeholder="นามสกุล" required />
    </div>
    <div class="input-field" id="dep_id">
      <i class="fas fa-user"></i>
      <select class="select-field" name="dep_id">
        <option value="">ฝ่าย/กลุ่มสาระ</option>
        <?php
        $departmentObj = new Department;
        $departments = $departmentObj->getAllDepartments();
        foreach ($departments as $department) {
          echo "<option value='{$department['dep_id']}' >{$department['dep_name']}</option>";
        }
        ?>
      </select>
    </div>
    <div class="input-field" id="userRe">
      <i class="fas fa-user"></i>
      <input type="text" name="username" id="username" placeholder="ชื่อผู้ใช้ภาษาอังกฤษ" required />
    </div>
    <div class="input-field" id="emailRe">
      <i class="fas fa-envelope"></i>
      <input type="email" name="email" id="email" placeholder="อีเมล์" />
    </div>
    <div class="input-field" id="passRe">
      <i class="fas fa-lock"></i>
      <input type="password" name="password" id="password" placeholder="รหัสผ่าน" required minlength="6"
        maxlength="10" />
    </div>
    <div class="input-field" id="passCon">
      <i class="fas fa-lock"></i>
      <input type="password" name="confirm" id="confirm" placeholder="รหัสผ่านอีกครั้ง" required />
    </div>
    <input type="submit" class="btn" value="บันทึกข้อมูล" />
    <input type="hidden" name="role" id="role" value="8" />

  </form>

  <div style="text-align: center;">
    <button class="btn"><a href="<?= BASE_URL ?>/App/Views/showGroupCard.php">กลับ</a></button>
  </div>
</body>

</html>