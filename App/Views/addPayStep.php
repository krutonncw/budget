<?php
// เรียกใช้งาน ไฟล์ autoload เพือให้โหลดคลาสต่าง ๆ มาทำงาน
require $_SERVER['DOCUMENT_ROOT'] . "/budget/vendor/autoload.php";

//ตรวจสอบว่าเข้าสู่ระบบหรือยัง
require $_SERVER['DOCUMENT_ROOT'] . "/budget/App/Auth/Controllers/auth.php";



//ตรวจสอบระดับของสิทธิ์ว่าเป็น ผู้ปฏิบัติงาน เปล่าหน้านี้เฉพาะ admin และผู้ปฏิบัติงาน เท่านั้น
if ($_SESSION['role'] > 2) {
    header("location: groupCardShow.php");
}

// นำเข้า Model เพื่อใช้ตารางในฐานข้อมูล
use Ncw\Models\PayPlan;

$paystepObj = new PayPlan;

$message = false; //สำหรับไว้แจ้งว่าบันทึกเสร็จแล้ว

// ตรวจสอบว่ามีการเรียกมาครั้งแรก หรือเรียกมาอัปเดต
if (isset($_REQUEST['pay_order'])) {
    if (isset($_REQUEST['action']) == "add") {
        unset($_REQUEST['action']);
        $paystep = $paystepObj->updatePayStep($_REQUEST);
        if ($paystep == 1) {
            unset($_REQUEST['pay_step']);
            $paystep = $paystepObj->getPayStepByID($_REQUEST);
            $message = true;
        }
    } else {
        $paystep = $paystepObj->getPayStepByID($_REQUEST);
    }
}

// นำเข้าส่วนหัวและเมนูของ page
require $_SERVER['DOCUMENT_ROOT'] . "/budget/App/Inc/header.php";
require $_SERVER['DOCUMENT_ROOT'] . "/budget/App/Inc/sidebar.php";
?>


<!-- แสดงข้อมูลในหน้าหลัก -->
<section class="main-content container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="row">
                <div class="col-md-6 col-sm-12 justify-content-center">
                    <?php
                    if ($message) {
                        echo '<div style="font-size: 1.5rem;" id="myAlert" class="alert alert-success fade show"><i data-feather="check-square"></i> บันทึกเรียบร้อยแล้ว</div>';
                    }
                    ?>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title text-primary" style="font-size: 1.5rem;">กิจกรรม :=>
                        <?php echo $paystep['act_name'] ?></h2>
                    <p class="card-text">
                        คลิกที่ลำดับขั้นตอนที่อยู่ระหว่างการดำเนินการได้เลยครับ
                    </p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 col-sm-6">
                            <?php $retVal = ($paystep['pay_step'] == 1) ? "stepshow" : "";
                            echo '<a  href="?pay_order=' . $paystep['pay_order'] . '&pay_step=1&action=add" > <img class="imgstep round m-1 ' . $retVal . ' "' . ' src="../../assets/images/step/step01.jpg" alt="Card image cap" /></a>';
                            ?>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <?php $retVal = ($paystep['pay_step'] == 2) ? "stepshow" : "";
                            echo '<a  href="?pay_order=' . $paystep['pay_order'] . '&pay_step=2&action=add" > <img class="imgstep round m-1 ' . $retVal . ' "' . ' src="../../assets/images/step/step02.jpg" alt="Card image cap" /></a>';
                            ?>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <?php $retVal = ($paystep['pay_step'] == 3) ? "stepshow" : "";
                            echo '<a  href="?pay_order=' . $paystep['pay_order'] . '&pay_step=3&action=add" > <img class="imgstep round m-1 ' . $retVal . ' "' . ' src="../../assets/images/step/step03.jpg" alt="Card image cap" /></a>';
                            ?>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <?php $retVal = ($paystep['pay_step'] == 4) ? "stepshow" : "";
                            echo '<a  href="?pay_order=' . $paystep['pay_order'] . '&pay_step=4&action=add" > <img class="imgstep round m-1 ' . $retVal . ' "' . ' src="../../assets/images/step/step04.jpg" alt="Card image cap" /></a>';
                            ?>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <?php $retVal = ($paystep['pay_step'] == 5) ? "stepshow" : "";
                            echo '<a  href="?pay_order=' . $paystep['pay_order'] . '&pay_step=5&action=add" > <img class="imgstep round m-1 ' . $retVal . ' "' . ' src="../../assets/images/step/step05.jpg" alt="Card image cap" /></a>';
                            ?>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <?php $retVal = ($paystep['pay_step'] == 0) ? "stepshow" : "";
                            echo '<a  href="?pay_order=' . $paystep['pay_order'] . '&pay_step=0&action=add" > <img class="imgstep round m-1 ' . $retVal . ' "' . ' src="../../assets/images/step/step00.jpg" alt="Card image cap" /></a>';
                            ?>
                        </div>
                        <!-- <?php if ($_SESSION['role'] < 2) {
                            echo "<div class='col-md-3 col-sm-6'>";
                            $retVal = ($paystep['pay_step'] == 0) ? "stepshow" : "";
                            echo '<a  href="?pay_order=' . $paystep['pay_order'] . '&pay_step=0&action=add" > <img class="imgstep round m-1 ' . $retVal . ' "' . ' src="../../assets/images/step/step00.jpg" alt="Card image cap" /></a>';
                            echo "</div>";
                        }
                        ?>-->
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