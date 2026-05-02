<?php
// เรียกใช้งาน ไฟล์ autoload เพือให้โหลดคลาสต่าง ๆ มาทำงาน
require_once "../../../config.php";

//ตรวจสอบว่าเข้าสู่ระบบหรือยัง
require_once BASE_PATH . "/App/Auth/Controllers/auth.php";

// นำเข้า Model เพื่อใช้ตารางในฐานข้อมูล
use Ncw\Auth\Models\Person;
use Ncw\Models\Department;
use Ncw\Models\Ref;

// นำเข้าส่วนหัวและเมนูของ page
require_once BASE_PATH . "/App/Inc/header.php";
require_once BASE_PATH . "/App/Inc/sidebar.php";

// อ่านข้อมูล
$refsObj = new Ref;
$departmentObj = new Department();
$groupid['ref_group_id'] = 1;
$refs = $refsObj->getRefByGroup($groupid);
$departments = $departmentObj->getAllDepartments();
// print_r($refs);exit;
?>


<!-- แสดงข้อมูลในหน้าหลัก -->
<section id="content-types " class="d-flex justify-content-center">
  <div class="col-md-8 col-sm-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">แบบฟอร์มเพิ่มสมาชิกใหม่</h4>
      </div>
      <div class="card-content">
        <div class="card-body">
          <form action="../Controllers/addPerson.php" class="form form-vertical" method="POST" name="new"
            enctype="multipart/form-data">
            <div class=" form-body">
              <div class="row">
                <div class="col-12">
                  <div class="form-group has-icon-left">
                    <label for="first-name-icon">คำนำหน้า</label>
                    <div class="position-relative">
                      <select class="form-control form-select round" name="gender_id" id="gender_id">
                        <option value="">คำนำหน้า</option>
                        <?php
                        foreach ($refs as $ref) {
                          echo "<option value='{$ref['ref_id']}' >{$ref['title']}</option>";
                        }
                        ?>
                      </select>
                      <div class="form-control-icon">
                        <i data-feather="edit-2"></i>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group has-icon-left">
                    <label for="first-name-icon">ชื่อ</label>
                    <div class="position-relative">
                      <input type="text" class="form-control round" placeholder="ชื่อ" id="first-name-icon" name="firstname" id="firstname" required />
                      <div class="form-control-icon">
                        <i data-feather="edit-2"></i>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group has-icon-left">
                    <label for="first-name-icon">นามสกุล</label>
                    <div class="position-relative">
                      <input type="text" class="form-control round" placeholder="นามสกุล" id="first-name-icon" name="lastname" id="lastname" required />
                      <div class="form-control-icon">
                        <i data-feather="edit-2"></i>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group has-icon-left">
                    <label for="first-name-icon">ฝ่าย/กลุ่มสาระ</label>
                    <div class="position-relative">
                      <select class="form-control form-select round" name="dep_id" id="dep_id">
                        <option value="">ฝ่าย/กลุ่มสาระ</option>
                        <?php
                        foreach ($departments as $department) {
                          echo "<option value='{$department['dep_id']}' >{$department['dep_name']}</option>";
                        }
                        ?>
                      </select>
                      <div class="form-control-icon">
                        <i data-feather="file-text"></i>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group has-icon-left">
                    <label for="first-name-icon">ชื่อผู้ใช้</label>
                    <div class="position-relative">
                      <input type="text" class="form-control round" placeholder="ชื่อผู้ใช้ภาษาอังกฤษ" id="first-name-icon" name="username" id="username" required />
                      <div class="form-control-icon">
                        <i data-feather="user"></i>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group has-icon-left">
                    <label for="first-name-icon">อีเมล์</label>
                    <div class="position-relative">
                      <input type="email" class="form-control round" placeholder="email" id="first-name-icon" name="email" id="email" required />
                      <div class="form-control-icon">
                        <i data-feather="mail"></i>
                      </div>
                    </div>
                  </div>
                </div>   
                <div class="col-12">
                  <div class="form-group has-icon-left">
                    <label for="first-name-icon">รหัสผ่าน</label>
                    <div class="position-relative">
                      <input type="password" class="form-control round" placeholder="รหัสผ่าน" id="first-name-icon" name="password" id="password" required />
                      <div class="form-control-icon">
                        <i data-feather="user"></i>
                      </div>
                    </div>
                  </div>
                </div>   
                <!-- <div class="col-12">
                  <div class="form-group has-icon-left">
                    <label for="first-name-icon">รหัสผ่านอีกครั้ง</label>
                    <div class="position-relative">
                      <input type="password" class="form-control round" placeholder="รหัสผ่านอีกครั้ง" id="first-name-icon" name="รหัสผ่านอีกครั้ง" id="รหัสผ่านอีกครั้ง" required />
                      <div class="form-control-icon">
                        <i data-feather="user"></i>
                      </div>
                    </div>
                  </div>
                </div>                 -->
              </div>
              <!-- ส่งข้อมูลแบบซ้อนไปด้วยเพื่อประมวลผล -->
               <input type="hidden" name="role" id="role" value="8" />
              <div class="col-12 d-flex justify-content-end">
                <a href='../../Views/showGroupCard.php' class='btn btn-outline-warning round mr-2'>ยกเลิก</a>
                <button type="submit" class="btn btn-outline-primary round">บันทึก</button>
              </div>
            </div>
        </div>
        </form>
      </div>
    </div>
  </div>
  </div>
</section>
<!-- จบส่วนของ modal -->

<!-- นำเข้าส่วน footer page -->
<?php require_once BASE_PATH . "/App/Inc/footer.php"; ?>