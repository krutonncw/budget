<?php
// เรียกใช้งานไฟล์ autoload เพือให้โหลดคลาสต่าง ๆ มาทำงาน
require $_SERVER['DOCUMENT_ROOT'] . "/budget/vendor/autoload.php";

//ตรวจสอบว่าเข้าสู่ระบบหรือยัง
require $_SERVER['DOCUMENT_ROOT'] . "/budget/App/Auth/Controllers/auth.php";

// นำเข้า Model เพื่อใช้ตารางในฐานข้อมูล
use Ncw\Auth\Models\Person;
use Ncw\Models\Department;
use Ncw\Models\Ref;

// นำเข้าส่วนหัวและเมนูของ page
require $_SERVER['DOCUMENT_ROOT'] . "/budget/App/Inc/header.php";
require $_SERVER['DOCUMENT_ROOT'] . "/budget/App/Inc/sidebar.php";


// อ่านข้อมูลเข้ามาแก้ไข
if ($_REQUEST['action'] == 'update') {
  $personObj = new Person;
  $person = $personObj->getPersonById($_REQUEST['id']);
}


// อ่านข้อมูลจาก refs
$refsObj = new Ref;
$refs = $refsObj->getRefsAll();
?>


<!-- แสดงข้อมูลในหน้าหลัก -->
<section id="content-types " class="d-flex justify-content-center">
  <div class="col-md-8 col-sm-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">
          แบบฟอร์ม<?php echo ($_REQUEST['action'] == 'update') ? "แก้ไขข้อมูลสมาชิก" : "เพิ่มสมาชิกใหม่"; ?></h4>
      </div>
      <div class="card-content">
        <img class="card-img-top rounded-circle mx-auto d-block" <?php echo "src=" . $retVal = ($person['avatar'] != "") ? $person['avatar'] : "/ncwbudget/assets/images/avatar/femalavatar.svg"; ?> alt="Card image cap"
          style="width: 200px;height:200px; text-align: center; margin-top:10px;" />
        <div class="card-body">
          <form action="../Controllers/updateAuth.php" class="form form-vertical" method="post"
            enctype="multipart/form-data">
            <div class=" form-body">
              <div class="row">
                <div class="col-12">
                  <div class="form-group has-icon-left">
                    <label for="first-name-icon">คำนำหน้า</label>
                    <div class="position-relative">
                      <select class="form-control form-select round" name="gender_id">
                        <option value="">คำนำหน้า</option>
                        <?php
                        foreach ($refs as $ref) {
                          echo "<option value='{$ref['id']}'";
                          echo $retVal = ($ref['id'] == $person['gender_id']) ? "selected" : "";
                          echo ">{$ref['title']}</option>";
                        }
                        ?>
                      </select>
                      <div class="form-control-icon">
                        <i data-feather="user"></i>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group has-icon-left">
                    <label for="first-name-icon">ชื่อ</label>
                    <div class="position-relative">
                      <input type="text" class="form-control round" placeholder="ชื่อ" id="first-name-icon"
                        name="firstname" <?php $retVal = ($person['firstname'] == "") ? "" : $person['firstname'];
                        echo 'value="' . $retVal . '"'; ?>>
                      <div class="form-control-icon">
                        <i data-feather="user"></i>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group has-icon-left">
                    <label for="first-name-icon">นามสกุล</label>
                    <div class="position-relative">
                      <input type="text" class="form-control round" placeholder="นามสกุล" id="first-name-icon"
                        name="lastname" <?php $retVal = ($person['lastname'] == "") ? "" : $person['lastname'];
                        echo 'value="' . $retVal . '"'; ?>>
                      <div class="form-control-icon">
                        <i data-feather="user"></i>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group has-icon-left">
                    <label for="first-name-icon">ฝ่าย/กลุ่มสาระ</label>
                    <div class="position-relative">
                      <select class="form-control form-select round" name="dep_id">
                        <option value="">ฝ่าย/กลุ่มสาระ</option>
                        <?php
                        $departmentObj = new Department;
                        $departments = $departmentObj->getAllDepartments();
                        foreach ($departments as $department) {
                          echo "<option value='{$department['dep_id']}'";
                          echo $retVal = ($department['dep_id'] == $person['dep_id']) ? "selected" : "";
                          echo ">{$department['dep_name']}</option>";
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
                      <input type="text" class="form-control round" placeholder="ชื่อผู้ใช้" id="first-name-icon"
                        name="username" <?php $retVal = ($person['username'] == "") ? "" : $person['username'];
                        echo 'value="' . $retVal . '"'; ?>>
                      <div class="form-control-icon">
                        <i data-feather="user"></i>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group has-icon-left">
                  <label for="file-id-icon">อัพโหลดรูปภาพ</label>
                  <div class="position-relative">
                    <input type="file" class="form-control round" name="avatar" id="avatar">
                    <div class="form-control-icon">
                      <i data-feather="file-plus"></i>
                    </div>
                  </div>
                </div>
              </div>
              <!-- ส่งข้อมูลแบบซ้อนไปด้วยเพื่อประมวลผล -->
              <input type="hidden" id="custId" name="id" <?php echo "value={$person['id']}"; ?>>
              <input type="hidden" name="action"
                value="<?php echo ($_REQUEST['action'] == 'update') ? "update" : "add"; ?>">
              <input type="hidden" name="avatar" id="avatar" value="<?php echo $person['avatar']; ?>">
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
<?php require $_SERVER['DOCUMENT_ROOT'] . "/ncwbudget/App/Inc/footer.php"; ?>