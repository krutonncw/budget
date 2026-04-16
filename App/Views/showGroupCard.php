<?php
// เรียกใช้งาน ไฟล์ autoload เพือให้โหลดคลาสต่าง ๆ มาทำงาน
require $_SERVER['DOCUMENT_ROOT'] . "/budget/vendor/autoload.php";

//ตรวจสอบว่าเข้าสู่ระบบหรือยัง
require $_SERVER['DOCUMENT_ROOT'] . "/budget/App/Auth/Controllers/auth.php";

// นำเข้า Model เพื่อใช้ตารางในฐานข้อมูล
use Ncw\Models\Activity;
use Ncw\Models\PayPlan;
use Ncw\Models\Department;
use Ncw\Models\BudgetType;

use function PHPSTORM_META\type;

$total = 0;
$totalpay = 0;

$paySumObj = new PayPlan;
$paySum = $paySumObj->getPayGraph();

//คำนวณผลรวมยอดจัดสรร
$typeObj = new Activity;
$payObj = new Payplan;

// นำเข้าส่วนหัวและเมนูของ page
require $_SERVER['DOCUMENT_ROOT'] . "/budget/App/Inc/header.php";
require $_SERVER['DOCUMENT_ROOT'] . "/budget/App/Inc/sidebar.php";

?>

<!-- แสดงข้อมูลในหน้าหลัก -->
<!-- แสดงข้อมูลในหน้าหลัก -->
<div class="main-content container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-12 order-md-1 order-last">
                <h3>งบประมาณของโรงเรียนนิยมศิลป์อนุสรณ์ ปีการศึกษา 2569</h3>
            </div>
        </div>
    </div>
    <section class="section">
        <!-- <div class="row " id="top">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class='card-heading p-1 pl-3'>สรุปการเบิกจ่ายงบประมาณประจำเดือน</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 col-12">
                                <div class="pl-3">
                                    <h2>สรุปยอดรวมการเบิก</h2>
                                    <h2 class='mt-0 text-red'><?php echo number_format($paySum['sum'], 2); ?></h2>
                                    <div class="legends">
                                        <p class='text-xl'><span class="text-green"><i data-feather="bar-chart"
                                                    width="15"></i></span> ประเภทงบประมาณ</p>
                                        <div class="legend d-flex flex-row align-items-center">
                                            <div class='w-3 h-3 rounded-full bg-red mr-2'></div><span
                                                class='text-xs'>อุดหนุนรายหัว</span>
                                        </div>
                                        <div class="legend d-flex flex-row align-items-center">
                                            <div class='w-3 h-3 rounded-full bg-green mr-2'></div><span
                                                class='text-xs'>ค่าหนังสือ/อุปกรณ์/เครื่องแบบ</span>
                                        </div>
                                        <div class="legend d-flex flex-row align-items-center">
                                            <div class='w-3 h-3 rounded-full bg-green mr-2'></div><span
                                                class='text-xs'>กิจกรรมพัฒนาคุณภาพผู้เรียน</span>
                                        </div>
                                        <div class="legend d-flex flex-row align-items-center">
                                            <div class='w-3 h-3 rounded-full bg-blue mr-2'></div><span
                                                class='text-xs'>รายได้สถานศึกษา</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9 col-12">
                                <canvas id="bar"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- <div class="row" id="total">
            <div class="card">
                <div class="card-heder pt-3">
                    <h3>งบประมาณทั้งหมดของโรงเรียน</h3>
                </div>
                <div class="card-body">
                    <div class="row ">
                        <?php

                        $BudgetTypeObj = new BudgetType();
                        $sumActMoneyObj = new Activity();
                        $sumPayMoneyObj = new PayPlan();
                        $BudgetTypes = $BudgetTypeObj->getAllBudgetTypes();
                        $totalActMomeys = 0;
                        $totalPayMomeys = 0;
                        foreach ($BudgetTypes as $BudgetType) {
                            $type['bgt_id'] = $BudgetType['bgt_id'];
                            $sumActMoneys = $sumActMoneyObj->getSumActMoneyGroupByBgt($type);
                            $sumPayMoneys = $sumPayMoneyObj->getSumPayMoneyGroupByBgt($type);

                            echo "<div class='col-md-3'>
                            <div class='card'>
                                <div class='card-header'>
                                    <h4><i class='icofont-dollar-plus icofont-2x mr-2' style='color: #00BFFF;'></i>{$BudgetType['bgt_name']}</h4>
                                </div>
                                <div class='card-body ml-0'>
                                    <div id='radialBarsincome' class='mx-0'></div>
                                    <div class='text-center'>";
                            echo "<h6>ยอดจัดสรร</h6>
                                        <h4 class='text-primary'>" . number_format($sumActMoneys['sumActMoney'], 2) . "</h4>";
                            echo "<h6>เบิกแล้ว</h6>
                                        <h4 class='text-success'>" . number_format($sumPayMoneys['sumPayMoney'], 2) . "</h4>";
                            echo "<h6>คงเหลือ</h6>
                                        <h4 class='text-danger'>" . number_format($sumActMoneys['sumActMoney'] - $sumPayMoneys['sumPayMoney'], 2) . "</h4>
                                    </div>
                                </div>
                            </div>
                        </div>";
                            $totalActMomeys += $sumActMoneys['sumActMoney'];
                            $totalPayMomeys += $sumPayMoneys['sumPayMoney'];
                        }
                        ?>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">

                        <?php
                        echo "<div class='d-flex justify-content-end col-md-4 col-sm-12 '><h4><span class='badge rounded-pill bg-primary'>ยอดรวมทุกประเภท  " . number_format($totalActMomeys, 2) . " บาท</span></h4></div>";
                        echo "<div class='d-flex justify-content-start col-md-4 col-sm-12 '><h4><span class='badge rounded-pill bg-success'>ยอดรวมเบิกแล้วทุกประเภท  " . number_format($totalPayMomeys, 2) . " บาท</span></h4></div>";
                        echo "<div class='d-flex justify-content-start col-md-4 col-sm-12 '><h4><span class='badge rounded-pill bg-danger'>คงเหลือทุกประเภท  " . number_format($totalActMomeys - $totalPayMomeys, 2) . " บาท</span></h4></div>";
                        ?>

                    </div>
                </div>
            </div>
        </div> -->

    </section>
    <section class="section">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h4>ข้อมูลกลุ่มบริหาร/กลุ่มสาระตามยอดจัดสรร</h4>
                </div>
            </div>
        </div>
        <div class="row">

            <?php
            $departmentObj = new department();
            $departments = $departmentObj->getAlldepartments();
            foreach ($departments as $department) {
                echo "<div class='col-md-4 col-sm-12'>";
                echo "<div class='card'>
                    <div class='card-content'>
                        <img class='card-img-top img-fluid mt-2 mt-2' style='width: 100%;height:120px;' src='../../assets/images/group/group{$department['dep_id']}.svg' alt='Card image cap' />
                        <div class='card-body'>
                            <h3 class='card-title'>{$department['dep_name']}</h3>
                            <p class='card-text'>";

                require 'groupTemplet.php';

                echo "</p>
                            <a href='showActByDep.php?dep_id={$department['dep_id']}' class='mr-2 btn btn-outline-info round'>ดูข้อมูล</a>
                        </div>
                    </div>
                </div>
            </div>";
            }
            ?>
            <!--จบ row -->
    </section>
</div>

<!-- จบส่วนของ modal -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.5.1/gsap.min.js"></script>
<script>
    gsap.from("#top", {
        duration: 2,
        x: 300,
        opacity: 0,
        scale: 0.5
    });
    gsap.from("#total", {
        duration: 2,
        x: 300,
        opacity: 0,
        scale: 0.5
    });
</script>

<!-- นำเข้าส่วน footer page -->
<?php require $_SERVER['DOCUMENT_ROOT'] . "/budget/App/Inc/footer.php"; ?>