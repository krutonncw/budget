<?php
// เรียกใช้งานไฟล์ autoload เพือให้โหลดคลาสต่าง ๆ มาทำงาน
require $_SERVER['DOCUMENT_ROOT'] . "/budget/vendor/autoload.php";

//ตรวจสอบว่าเข้าสู่ระบบหรือยัง
require $_SERVER['DOCUMENT_ROOT'] . "/budget/App/Auth/Controllers/auth.php";

//ตรวจสอบระดับของสิทธิ์ว่าเป็น admin เปล่าหน้านี้เฉพาะ admin เท่านั้น
if ($_SESSION['role'] > 3) {
  header("location: ../../views/budget/groupCardShow.php");
}

// นำเข้า Model เพื่อใช้ตารางในฐานข้อมูล
use Ncw\Models\Activity;
//use Ncw\Models\Payplan;
use Ncw\Models\Department;
use Ncw\Models\Ref;

//$personid = $_SESSION['id'];

//$lastpayObj = new Payplan;
//$lastpay = $lastpayObj->getLastPayOrder();

require $_SERVER['DOCUMENT_ROOT'] . "/budget/App/Inc/header.php";
require $_SERVER['DOCUMENT_ROOT'] . "/budget/App/Inc/sidebar.php";

?>

<!-- แสดงข้อมูลในหน้าหลัก -->
<section id="content-types " class="d-flex justify-content-center">
  <div class="col-md-8 col-sm-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title" style="font-size: 1.5rem;">บันทึกข้อมูลการใช้เงินตามแผน</h4>
      </div>
      <div class="card-content">

        <div class="card-body">
          <form action="../Controllers/addPayPlan.php" class="form form-vertical" method="POST">
            <!--<div class="col-12">
              <div class="form-group has-icon-left">
                <label for="mobile-id-icon">ใส่เลขที่คำขอบล่าสุด<h4><span class="bage bg-info round mx-2 px-2"><?php echo $lastpay['pay_order']; ?></span></h4></label>
                <div class="position-relative">
                  <input type="text" class="form-control round" placeholder="เลขที่คำขอ..." id="mobile-id-icon" name="pay_order" required>
                  <div class="form-control-icon">
                    <i data-feather="edit-3"></i>
                  </div>
                </div>
              </div>
            </div>-->

            <h6>ด้วยกลุ่มบริหาร/กลุ่มสาระการเรียนรู้</h6>
            <div class="form-group">
              <select class="choices form-select " name="dep_order" required>
                <option value="">เลือกกลุ่ม....</option>
                <?php
                $departmentObj = new department();
                $departments = $departmentObj->getAlldepartments();
                foreach ($departments as $department) {
                  echo "<option value='{$department['dep_id']}'";
                  echo ">{$department['dep_name']}</option>";
                }
                ?>
              </select>
            </div>

            <div class="form-group">
              <div class="col-12">
                <div class="form-group has-icon-left">
                  <label for="mobile-id-icon">มีความต้องการจะ</label>
                  <?php
                  $groupid['ref_group_id'] = 2;
                  $refObj = new ref();
                  $refs = $refObj->getRefByGroup($groupid);

                  foreach ($refs as $ref) {
                    echo "<div class='form-check'>";
                    echo "<input class='form-check-input' type='radio' name='pay_type' id='pay_type{$ref['ref_id']}' value='{$ref['ref_id']}' require>";
                    echo "<label class='form-check-label' for='pay_type{$ref['ref_id']}'><h5>{$ref['title']}</h5></label></div>";
                  }
                  ?>
                </div>
              </div>

              <h6>ตามกิจกรรม (เลือกกิจกรรมที่ต้องการใช้งบประมาณ)</h6>
              <select class="choices form-select " name="act_id" required>
                <option value="">เลือกกิจกรรม....</option>
                <?php
                $activityObj = new Activity();
                $activitys = $activityObj->getAllActivitys();
                foreach ($activitys as $activity) {
                  echo "<option value='{$activity['act_id']}'";
                  // echo $retVal = ($activity['lg_id'] == $person['lg_id']) ? "selected" : "";
                  echo ">{$activity['act_name']}</option>";
                }
                ?>
              </select>

              <div class="col-12">
                <div class="form-group has-icon-left">
                  <label for="mobile-id-icon">เพื่อใช้ในการ</label>
                  <div class="position-relative">
                    <textarea rows="4" class="form-control round" placeholder="วัตถุประสงค์ในการเบิก..."
                      name="pay_objective" required></textarea>
                    <div class="form-control-icon">
                      <i data-feather="file-text"></i>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-12">
                <div class="form-group has-icon-left">
                  <label for="mobile-id-icon">จำนวนเงินที่ขอเบิก</label>
                  <div class="position-relative">
                    <input type="text" class="form-control round" placeholder="ไม่ต้องใส่เครื่องหมายจุลภาค (,)"
                      id="mobile-id-icon" name="pay_money" required>
                    <div class="form-control-icon">
                      <i data-feather="dollar-sign"></i>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-12">
                <div class="form-group has-icon-left">
                  <label for="mobile-id-icon">ผู้ขอเบิก</label>
                  <div class="position-relative">
                    <input type="text" class="form-control round" placeholder="ผู้ขอเบิก..." id="mobile-id-icon"
                      name="pay_user" required>
                    <div class="form-control-icon">
                      <i data-feather="user"></i>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-12">
                <div class="form-group has-icon-left">
                  <label for="email-id-icon">วันที่ของเบิก ใส่เป็นปี ค.ศ.</label>
                  <div class="position-relative">
                    <input type="date" class="form-control round" placeholder="ใส่เป็น วัน/เดือน/ปี ค.ศ."
                      id="email-id-icon" name="pay_date" required>
                    <div class="form-control-icon">
                      <i data-feather="clock"></i>
                    </div>
                  </div>
                </div>
              </div>

              <!-- ส่งข้อมูลแบบซ้อนไปด้วยเพื่อประมวลผล -->
              <input type="hidden" id="action" name="action" value="add">
              <input type="hidden" id="person_id" name="person_id" value="<?php echo $_SESSION['id'] ?>">
              <div class="col-12 d-flex justify-content-end">
                <a href='showPayPlan.php' class='btn btn-outline-warning round mr-2'>ยกเลิก</a>
                <button type="submit" class="btn btn-outline-primary round">บันทึก</button>
              </div>

            </div>
        </div>
      </div>
    </div>
</section>
<!-- จบส่วนของ modal -->

<!-- Include Choices JavaScript -->
<script src="../../assets/vendors/choices.js/choices.min.js"></script>

<!-- นำเข้าส่วน footer page -->
<?php require $_SERVER['DOCUMENT_ROOT'] . "/budget/App/Inc/footer.php"; ?>