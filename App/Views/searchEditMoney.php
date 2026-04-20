<?php
// เรียกใช้งาน ไฟล์ autoload เพือให้โหลดคลาสต่าง ๆ มาทำงาน
require_once "../../config.php";

//ตรวจสอบว่าเข้าสู่ระบบหรือยัง
require_once BASE_PATH . "/App/Auth/Controllers/auth.php";

//ตรวจสอบระดับของสิทธิ์ว่าเป็น admin เปล่าหน้านี้เฉพาะ admin เท่านั้น
if ($_SESSION['role'] > 1) {
  header("location: ../../views/budget/groupCardShow.php");
}

require_once BASE_PATH . "/App/Inc/header.php";
require_once BASE_PATH . "/App/Inc/sidebar.php";

?>

<!-- แสดงข้อมูลในหน้าหลัก -->
<section id="content-types " class="d-flex justify-content-center">
  <div class="col-md-8 col-sm-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">แก้ไขข้อมูลการใช้เงินตามแผน</h4>
      </div>
      <div class="card-content">

        <div class="card-body">
          <form action="formEditMoney.php" class="form form-vertical" method="POST">
            <div class="col-12">
              <div class="form-group has-icon-left">
                <label for="mobile-id-icon">เลขที่คำขอ</label>
                <div class="position-relative">
                  <input type="text" class="form-control round" placeholder="เลขที่คำขอ..." id="mobile-id-icon"
                    name="pay_order" required>
                  <div class="form-control-icon">
                    <i data-feather="dollar-sign"></i>
                  </div>
                </div>
              </div>
            </div>

            <!-- ส่งข้อมูลแบบซ้อนไปด้วยเพื่อประมวลผล -->
            <!--<input type="hidden" id="action" name="action" value="edit">-->
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
<?php require_once BASE_PATH . "/App/Inc/footer.php"; ?>