<?php
// เรียกใช้งาน ไฟล์ autoload เพือให้โหลดคลาสต่าง ๆ มาทำงาน
require_once "../../config.php";

//ตรวจสอบว่าเข้าสู่ระบบหรือยัง
require_once BASE_PATH . "/App/Auth/Controllers/auth.php";

//ตรวจสอบระดับของสิทธิ์ว่าเป็น admin เปล่าหน้านี้เฉพาะ admin เท่านั้น
if ($_SESSION['role'] > 2) {
  header("location: ../../views/budget/groupCardShow.php");
}

// นำเข้า Model เพื่อใช้ตารางในฐานข้อมูล
use Ncw\Models\PayPlan;
use Ncw\Models\Department;
use Ncw\Models\Activity;
use Ncw\Models\Ref;

$payplanObj = new PayPlan();
$payplan = $payplanObj->getPayOrderToReport($_REQUEST);

//$lastpayObj = new Payplan;
//$lastpay = $lastpayObj->getLastPayOrder();

require_once BASE_PATH . "/App/Inc/header.php";
require_once BASE_PATH . "/App/Inc/sidebar.php";

?>

<!-- แสดงข้อมูลในหน้าหลัก -->
<section id="content-types " class="d-flex justify-content-center">
  <div class="col-md-8 col-sm-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title" style="font-size: 1.5rem;">แก้ข้อมูลใบคำขอ</h4>
      </div>
      <div class="card-content">

        <div class="card-body">
          <form action="../Controllers/editPayPlan.php" class="form form-vertical" method="POST">
            <div class="col-12">
              <div class="form-group has-icon-left">
                <label for="mobile-id-icon">
                  <h4><span
                      class="bage bg-info round mx-2 px-2"><?php echo $payplan['pay_order'] . "-" . str_pad($payplan['dep_id'], 2, '0', STR_PAD_LEFT) . str_pad($payplan['pro_id'], 2, '0', STR_PAD_LEFT); ?></span>
                  </h4>
                </label>
              </div>
            </div>

            <h6>ด้วยกลุ่มบริหาร/กลุ่มสาระการเรียนรู้ -> <?php echo $payplan['dep_name']; ?></h6>
            <div class="form-group">
              <select class="choices form-select " name="dep_order" required>
                <option value="">เลือกกลุ่ม....</option>
                <?php
                $departmentObj = new department();
                $departments = $departmentObj->getAlldepartments();
                foreach ($departments as $department) {
                  echo "<option value='{$department['dep_id']}'";
                  if ($payplan['dep_order'] == $department['dep_id'])
                    echo "selected";
                  echo ">{$department['dep_name']}</option>";
                }
                ?>
              </select>
            </div>

            <h6>มีความประสงค์ที่จะขอใช้เงินในการดำเนินงาน</h6>
            <select class="choices form-select " name="act_id" disabled>
              <option value="">เลือกกิจกรรม....</option>
              <?php
              $activityObj = new Activity();
              $activitys = $activityObj->getAllActivitys();
              foreach ($activitys as $activity) {
                echo "<option value='{$activity['act_id']}'";
                // echo $retVal = ($activity['lg_id'] == $person['lg_id']) ? "selected" : "";
                if ($payplan['act_id'] == $activity['act_id'])
                  echo "selected";
                echo ">{$activity['act_name']}</option>";
              }
              ?>
            </select>

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
                    echo "<input class='form-check-input' type='radio' name='pay_type' id='pay_type' value='{$ref['ref_id']}' ";
                    if ($payplan['pay_type'] == $ref['ref_id'])
                      echo "checked>";
                    echo "<label class='form-check-label' for='pay_type{$ref['ref_id']}'><h6>{$ref['title']}</h6></label></div>";
                  }
                  ?>
                </div>
              </div>

              <div class="col-12">
                <div class="form-group has-icon-left">
                  <label for="mobile-id-icon">เพื่อใช้ในการ</label>
                  <div class="position-relative">
                    <input type="text" class="form-control round" <?php echo 'value="' . $payplan['pay_objective'] . '"'; ?>
                      name="pay_objective" required></input>
                    <div class="form-control-icon">
                      <i data-feather="file-text"></i>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-12">
                <div class="form-group has-icon-left">
                  <label for="mobile-id-icon">จำนวนเงินที่ขอใช้</label>
                  <div class="position-relative">
                    <input type="text" class="form-control round" <?php echo 'value="' . $payplan['pay_money'] . '"'; ?>
                      id="mobile-id-icon" name="pay_money" readonly>
                    <div class="form-control-icon">
                      <i data-feather="dollar-sign"></i>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-12">
                <div class="form-group has-icon-left">
                  <label for="mobile-id-icon">ผู้ขอใช้</label>
                  <div class="position-relative">
                    <input type="text" class="form-control round" <?php echo 'value="' . $payplan['pay_user'] . '"'; ?>
                      id="mobile-id-icon" name="pay_user" required>
                    <div class="form-control-icon">
                      <i data-feather="user"></i>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-12">
                <div class="form-group has-icon-left">
                  <label for="email-id-icon">วันที่ขอใช้ ใส่เป็นปี ค.ศ. -> <?php echo $payplan['pay_date']; ?></label>
                  <div class="position-relative">
                    <input type="date" class="form-control round" <?php echo 'value="' . $payplan['pay_date'] . '"'; ?>
                      id="email-id-icon" name="pay_date" required>
                    <div class="form-control-icon">
                      <i data-feather="clock"></i>
                    </div>
                  </div>
                </div>
              </div>

              <!-- ส่งข้อมูลแบบซ้อนไปด้วยเพื่อประมวลผล -->
              <input type="hidden" id="action" name="action" value="edit">
              <input type="hidden" id="action" name="pay_order" value="<?php echo $payplan['pay_order'] ?>">
              <input type="hidden" id="person_id" name="person_id" value="<?php echo $payplan['person_id'] ?>">
              <div class="col-12 d-flex justify-content-end">
                <a href='showPayPlan.php' class='btn btn-outline-warning round mr-2'>ยกเลิก</a>
                <button type="submit" class="btn btn-outline-primary round">แก้ไข</button>
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
<?php require $_SERVER['DOCUMENT_ROOT'] . "/ncwbudget/App/Inc/footer.php"; ?>