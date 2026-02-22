<?php
// เรียกใช้งาน ไฟล์ autoload เพือให้โหลดคลาสต่าง ๆ มาทำงาน
require $_SERVER['DOCUMENT_ROOT'] . "/ncwbudget/vendor/autoload.php";

//ตรวจสอบว่าเข้าสู่ระบบหรือยัง
require $_SERVER['DOCUMENT_ROOT'] . "/ncwbudget/App/Auth/Controllers/auth.php";

use Ncw\Models\PayPlan;

require $_SERVER['DOCUMENT_ROOT'] . "/ncwbudget/App/Inc/header.php";
require $_SERVER['DOCUMENT_ROOT'] . "/ncwbudget/App/Inc/sidebar.php";

?>

<!-- แสดงข้อมูลในหน้าหลัก -->
<section class="main-content container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <?php
            $paystepObj = new PayPlan;
            if (isset($_REQUEST['pay_order'])) {
                $paystep = $paystepObj->getPayStepByID($_REQUEST);
            }
            ?>
            <div class="row">
                <div class="col-md-6 col-sm-12 justify-content-center">
                    <?php
                    if ($paystep['pay_step'] == 0) {
                        echo '<div style="font-size: 1.5rem;" id="myAlert" class="alert alert-success fade show"><i data-feather="check-square"></i> ยังไม่มีการเบิกจ่าย</div>';
                    }
                    ?>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title text-primary" style="font-size: 1.5rem;">ฝ่าย/กลุ่มสาระ :=> <?php echo $paystep['act_name']  ?></h2>
                    <p class="card-text ">
                        การดำเนินการของกิจกรรมตามโครงการ แสดงสถานะว่า ณ ขณะนี้อยู่ช่วงดำเนินใดเป็นกรอบสีแดงกระพริบ
                    </p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 col-sm-6">
                            <?php $retVal = ($paystep['pay_step'] == 1) ? "stepshow" : "";
                            echo '<img class="imgstep round m-1 ' . $retVal . ' "' . ' src="../../assets/images/step/step01.jpg" alt="Card image cap" />';
                            ?>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <?php $retVal = ($paystep['pay_step'] == 2) ? "stepshow" : "";
                            echo '<img class="imgstep round m-1 ' . $retVal . ' "' . ' src="../../assets/images/step/step02.jpg" alt="Card image cap" />';
                            ?>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <?php $retVal = ($paystep['pay_step'] == 3) ? "stepshow" : "";
                            echo '<img class="imgstep round m-1 ' . $retVal . ' "' . ' src="../../assets/images/step/step03.jpg" alt="Card image cap" />';
                            ?>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <?php $retVal = ($paystep['pay_step'] == 4) ? "stepshow" : "";
                            echo '<img class="imgstep round m-1 ' . $retVal . ' "' . ' src="../../assets/images/step/step04.jpg" alt="Card image cap" />';
                            ?>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <?php $retVal = ($paystep['pay_step'] == 5) ? "stepshow" : "";
                            echo '<img class="imgstep round m-1 ' . $retVal . ' "' . ' src="../../assets/images/step/step05.jpg" alt="Card image cap" />';
                            ?>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="col-md-12 col-sm-12 d-flex justify-content-center">
                        <a href='showPayPlan.php' class='btn btn-primary round'>กลับ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- จบส่วนของ modal -->

<!-- นำเข้าส่วน footer page -->
<?php require $_SERVER['DOCUMENT_ROOT'] . "/ncwbudget/App/Inc/footer.php"; ?>