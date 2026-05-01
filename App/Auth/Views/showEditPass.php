<?php
// เรียกใช้งาน ไฟล์ autoload เพือให้โหลดคลาสต่าง ๆ มาทำงาน
require_once "../../../config.php";

//ตรวจสอบว่าเข้าสู่ระบบหรือยัง
require_once BASE_PATH . "/App/Auth/Controllers/auth.php";

// นำเข้า Model เพื่อใช้ตารางในฐานข้อมูล
use Ncw\Auth\Models\Person;
use Ncw\Auth\Models\User;

// นำเข้าส่วนหัวและเมนูของ page
require_once BASE_PATH . "/App/Inc/header.php";
require_once BASE_PATH . "/App/Inc/sidebar.php";

?>

<!-- เรียกใช้การค้นหาสมาชิก -->
<?php

$personObj = new Person();
$persons = $personObj->getPersonById($_GET['id']);

// อ่านข้อมูลเข้ามาแก้ไข
if ($_REQUEST['action'] == 'repassword') {
  $userObj = new User;
  $user = $userObj->getUserById($_REQUEST['id']);
}
?>

<!-- แสดงข้อมูลในหน้าหลัก -->
<section id="content-types " class="d-flex justify-content-center">
  <div class="col-md-8 col-sm-12">
    <div class="card">
      <div class="card-content">
        <img class="card-img-top rounded mx-auto d-block" <?php echo "src=../../../assets/images/avatar/" . $retVal = ($persons['avatar'] != "") ? $persons['avatar'] : "avatar.png"; ?> alt="Card image cap"
          style="width: 200px;height:200px; text-align: center; margin-top:10px;" />
        <div class="card-body">
          <h4 class="card-title" style="font-size: 2rem;">ข้อมูลสมาชิก</h4>
          <p class="card-text">
            <?php
            echo '<h2>' . $persons['gender'] . $persons['firstname'] . ' ' . $persons['lastname'] . '</h2>';
            echo '<h3>ฝ่าย/กลุ่มสาระ ' . $persons['dep_name'] . '</h3>';
            ?>
          </p>
          <p class="card-text ">
          <form action="../Controllers/updateAuth.php" class="form form-vertical" method="post">
            <div class=" form-body">
              <div class="row">
                <div class="col-12">
                  <div class="form-group has-icon-left">
                    <label for="first-name-icon">รหัสผ่านใหม่</label>
                    <div class="position-relative">
                      <input type="text" class="form-control round" placeholder="รหัสผ่านใหม่" id="first-name-icon"
                        name="password">
                      <div class="form-control-icon">
                        <i data-feather="lock"></i>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- ส่งข้อมูลแบบซ้อนไปด้วยเพื่อประมวลผล -->
                <input type="hidden" id="custId" name="id" <?php echo "value={$user['id']}"; ?>>
                <input type="hidden" name="action" value="repassword">
                <div class="col-12 d-flex justify-content-end">
                  <?php if ($_SESSION['role'] == 1) {
                    echo "<a href='showPerson.php' class='btn btn-outline-warning round mr-2'>ยกเลิก</a>";
                 
                  }
                  else {
                    echo "<a href='../../Views/showGroupCard.php' class='btn btn-outline-warning round mr-2'>ยกเลิก</a>";
                  } ?>
                  <button type="submit" class="btn btn-outline-primary round">บันทึก</button>
                </div>
              </div>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
  </div>
</section>
<!-- จบส่วนของ modal -->


<!-- นำเข้าส่วน footer page -->
<?php require_once BASE_PATH . "/App/Inc/footer.php"; ?>