<?php
// เรียกใช้งาน ไฟล์ autoload เพือให้โหลดคลาสต่าง ๆ มาทำงาน
require $_SERVER['DOCUMENT_ROOT'] . "/budget/vendor/autoload.php";

//ตรวจสอบว่าเข้าสู่ระบบหรือยัง
require $_SERVER['DOCUMENT_ROOT'] . "/budget/App/Auth/Controllers/auth.php";

//ตรวจสอบระดับของสิทธิ์ว่าเป็น admin เปล่าหน้านี้เฉพาะ admin เท่านั้น
if ($_SESSION['role'] > 1) {
  header("location: showGroupCard.php");
}

// นำเข้า Model เพื่อใช้ตารางในฐานข้อมูล
use Ncw\Models\PayPlan;

require $_SERVER['DOCUMENT_ROOT'] . "/budget/App/Inc/header.php";
require $_SERVER['DOCUMENT_ROOT'] . "/budget/App/Inc/sidebar.php";

?>

<!-- แสดงข้อมูลในหน้าหลัก -->
<section id="content-types " class="d-flex justify-content-center">
  <div class="col-md-8 col-sm-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">แก้ไขการจ่ายเงิน</h4>
      </div>
      <div class="card-content">

        <div class="card-body">
          <form action="../Controllers/editPayBill.php" class="form form-vertical" method="POST">
            <div class="col-12">
              <div class="form-group has-icon-left">
                <label for="mobile-id-icon">
                  <h4><span class="bage bg-info round mx-2 px-3" style="font-size:1em; font-weight:400;">เลขที่ <?php echo $_REQUEST['pay_order']; ?></span>
                  </h4>
                </label>
              </div>
            </div>

            <?php
            $payplanObj = new PayPlan();
            $payplan = $payplanObj->getPayOrdByPO($_REQUEST);
            echo "<h5><b>โครงการ : </b>" . $payplan['pro_name'] . "</h5>";
            echo "<h5><b>กิจกรรม : </b>" . $payplan['act_name'] . "</h5>";
            echo "<h5><b>กลุ่ม : </b>" . $payplan['dep_name'] . "</h5>";
            echo "<h5><b>วัตถุประสงค์ : </b>" . $payplan['pay_objective'] . "</h5>";
            echo "<h5><b>ชื่อผู้ขออนุมัติ : </b>" . $payplan['pay_user'] . "</h5>";
            echo "<h5><b>ชื่อผู้กรอกข้อมูล : </b>" . $payplan['firstname'] . "  " . $payplan['lastname'] . "</h5>";
            echo "<h5><b>เงินที่ขออนุมัติ : </b>" . $payplan['pay_money'] . "</h5>";
            echo "<h5><b>สถานะ : </b>" . $payplan['pay_step'] . "</h5>";
            ?>

            <div class="col-12">
              <div class="form-group has-icon-left">
                <label for="mobile-id-icon">จำนวนเงินที่จ่าย</label>
                <div class="position-relative">
                  <input type="text" class="form-control round" placeholder="จำนวนเงิน..." id="mobile-id-icon"
                    name="pay_bill" required>
                  <div class="form-control-icon">
                    <i data-feather="dollar-sign"></i>
                  </div>
                </div>
              </div>
            </div>

            <!-- ส่งข้อมูลแบบซ้อนไปด้วยเพื่อประมวลผล -->
            <input type="hidden" id="pay_order" name="pay_order" value="<?php echo $payplan['pay_order'] ?>">
            <input type="hidden" id="pay_money" name="pay_money" value="<?php echo $payplan['pay_money'] ?>">
            <input type="hidden" id="act_id" name="act_id" value="<?php echo $payplan['act_id'] ?>">
            <div class="col-12 d-flex justify-content-end">
              <a href='showPayPlan.php' class='btn btn-outline-warning round mr-2'>ยกเลิก</a>
              <button type="submit" class="btn btn-outline-primary round">บันทึก</button>
            </div>
          </form>

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