<?php
// เรียกใช้งาน ไฟล์ autoload เพือให้โหลดคลาสต่าง ๆ มาทำงาน
require $_SERVER['DOCUMENT_ROOT'] . "/budget/vendor/autoload.php";

//ตรวจสอบว่าเข้าสู่ระบบหรือยัง
require $_SERVER['DOCUMENT_ROOT'] . "/budget/App/Auth/Controllers/auth.php";

// นำเข้า Model เพื่อใช้ตารางในฐานข้อมูล
use Ncw\Auth\Models\Person;
use Ncw\Auth\Models\User;

// นำเข้าส่วนหัวและเมนูของ page
require $_SERVER['DOCUMENT_ROOT'] . "/budget/App/Inc/header.php";
require $_SERVER['DOCUMENT_ROOT'] . "/budget/App/Inc/sidebar.php";

?>

<!-- เรียกใช้การค้นหาสมาชิก -->
<?php

$personObj = new Person();
$persons = $personObj->getPersonById($_GET['id']);

// ดึงข้อมูลผู้ใช้ระบบมาตรวจสอบระดับกาารใช้งาน
$userObj = new User;
$user = $userObj->getUserById($_GET['id']);

?>
<!-- แสดงข้อมูลในหน้าหลัก -->
<section id="content-types " class="d-flex justify-content-center">
  <div class="col-md-8 col-sm-12">
    <div class="card">
      <div class="card-content">
        <img class="card-img-top rounded mx-auto d-block" <?php echo "src=/budget/assets/images/avatar/" . $retVal = ($persons['avatar'] != "") ? $persons['avatar'] : "femalavatar.svg"; ?> alt="Card image cap"
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
          <form action="../Controllers/updateAuth.php" method="GET">
            <div class="row">
              <div class="col-3">
                <div class="form-check form-check-danger ">
                  <input class="form-check-input" type="radio" name="role" value="1" <?php echo $role = ($user['role'] == 1) ? "checked" : ""; ?>>
                  <label class="form-check-label" for="Primary">
                    ผู้ดูแลระบบ
                  </label>
                </div>
              </div>
              <div class="col-3">
                <div class="form-check form-check-warning ">
                  <input class="form-check-input" type="radio" name="role" value="2" <?php echo $role = ($user['role'] == 2) ? "checked" : ""; ?>>
                  <label class="form-check-label" for="Primary">
                    ผู้ปฏิบัติงาน
                  </label>
                </div>
              </div>
              <div class="col-3">
                <div class="form-check form-check-primary ">
                  <input class="form-check-input" type="radio" name="role" value="3" <?php echo $role = ($user['role'] == 3) ? "checked" : ""; ?>>
                  <label class="form-check-label" for="Primary">
                    เจ้าหน้าที่การเงิน
                  </label>
                </div>
              </div>
              <div class="col-3">
                <div class="form-check form-check-primary ">
                  <input class="form-check-input" type="radio" name="role" value="4" <?php echo $role = ($user['role'] == 4) ? "checked" : ""; ?>>
                  <label class="form-check-label" for="Primary">
                    เจ้าหน้าที่พัสดุ
                  </label>
                </div>
              </div>
              <div class="col-3">
                <div class="form-check form-check-primary ">
                  <input class="form-check-input" type="radio" name="role" value="5" <?php echo $role = ($user['role'] == 5) ? "checked" : ""; ?>>
                  <label class="form-check-label" for="Primary">
                    เจ้าหน้าที่
                  </label>
                </div>
              </div>
              <div class="col-3">
                <div class="form-check form-check-success ">
                  <input class="form-check-input" type="radio" name="role" value="6" <?php echo $role = ($user['role'] == 6) ? "checked" : ""; ?>>
                  <label class="form-check-label" for="Primary">
                    หัวหน้ากลุ่ม
                  </label>
                </div>
              </div>
              <div class="col-3">
                <div class="form-check form-check-success ">
                  <input class="form-check-input" type="radio" name="role" value="7" <?php echo $role = ($user['role'] == 7) ? "checked" : ""; ?>>
                  <label class="form-check-label" for="Primary">
                    แผนงานกลุ่ม
                  </label>
                </div>
              </div>
              <div class="col-3">
                <div class="form-check form-check-secondary ">
                  <input class="form-check-input" type="radio" name="role" value="8" <?php echo $role = ($user['role'] == 8) ? "checked" : ""; ?>>
                  <label class="form-check-label" for="Primary">
                    ผู้ใช้ทั่วไป
                  </label>
                </div>
              </div>
              <div class="col-3">
                <div class="form-check form-check-dark ">
                  <input class="form-check-input" type="radio" name="role" value="9" <?php echo $role = ($user['role'] == 9) ? "checked" : ""; ?>>
                  <label class="form-check-label" for="Primary">
                    รออนุมัติ
                  </label>
                </div>
              </div>

            </div>

            </p>
            <!-- ส่งข้อมูลแบบซ้อนไปด้วยเพื่อประมวลผล -->
            <input type="hidden" id="custId" name="id" <?php echo "value={$persons['id']}"; ?>>
            <input type="hidden" id="custId" name="action" value="setAuth">
            <div class="d-flex justify-content-center">
              <a href='showPerson.php' class='btn btn-outline-warning round mr-2'>ยกเลิก</a>
              <button type="submit" class="btn btn-outline-primary round">บันทึก</button>
          </form>
        </div>

      </div>
    </div>
  </div>
  </div>
</section>
<!-- จบส่วนของ modal -->


<!-- นำเข้าส่วน footer page -->
<?php require $_SERVER['DOCUMENT_ROOT'] . "/budget/App/Inc/footer.php"; ?>