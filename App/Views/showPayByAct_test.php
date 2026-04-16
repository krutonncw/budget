<?php
// เรียกใช้งาน ไฟล์ autoload เพือให้โหลดคลาสต่าง ๆ มาทำงาน
require $_SERVER['DOCUMENT_ROOT'] . "/budget/vendor/autoload.php";

//ตรวจสอบว่าเข้าสู่ระบบหรือยัง
require $_SERVER['DOCUMENT_ROOT'] . "/budget/App/Auth/Controllers/auth.php";

use Ncw\Models\PayPlan;
use Ncw\Models\ThaiTime;
use Ncw\Models\Activity;

require $_SERVER['DOCUMENT_ROOT'] . "/budget/App/Inc/header.php";
require $_SERVER['DOCUMENT_ROOT'] . "/budget/App/Inc/sidebar.php";

// สำหรับเก็บยอดรวมของแต่ละกิจกรรม
$actmoney = 0;
$sumpay = 0;

$activityObj = new Activity();
$activity = $activityObj->getDepIdByActId($_REQUEST);

?>

<!-- แสดงข้อมูลในหน้าหลัก -->
<div class="main-content container-fluid">
  <div class="page-title">
    <div class="row">
      <div class="col-12 col-md-6 order-md-1 order-last">
        <h3><?php echo $activity[0]['dep_name'] ?><span class='badge bg-success round '> <?php echo $activity[0]['pro_name'] ?> </span></h3>
      </div>
    </div>
  </div>
  <section class="section">
    <div class="card">
      <div class="card-header">

        <div class="row">
          <div class="col-md-3">
            <span style="color:blue;">ข้อมูลการเบิกการขออนมุติใช้เงินโครงการ</span>
          </div>          
          <div class="col-md-9 d-flex justify-content-end">
          <?php
            echo "
            <a href='showActByDep_test.php?dep_id={$activity[0]['dep_id']}' class='btn btn-primary round mr-2'>กลับ</a>";
          ?>
          </div>
        </div>
      </div>
      <div class="card-body">
        <table class='table table-striped' id="table1">
          <thead>
            <tr>
              <th>เลขที่คำขอ</th>
              <th>ชื่อกิจกรรม</th>
              <th>จำนวนเงินที่เบิก</th>
              <th>ประเภทเงิน</th>
              <th>วัตถุประสงค์</th>
              <th>ผู้ขอเบิก</th>
              <th>วันที่ขอเบิก</th>
              <th>สถานะ</th>
            </tr>
          </thead>
          <tbody>
            <form action="" method="get">
              <?php

              $payplanObj = new Payplan();
              $thaitimeObj = new ThaiTime();
              $payplans = $payplanObj->getPayPlanByActID($_REQUEST);
              
              
              foreach ($payplans as $payplan) {
                $sumpay += $payplan['pay_money'];
                echo "
								<tr>
									<td>{$payplan['pay_order']}</td>                                                
                  <td>{$payplan['act_name']}</td>
                ";
                echo "<td>" . number_format($payplan['pay_money'], 2) . "</td>";
                echo "<td>{$payplan['bgt_name']}</td>";
                echo "<td>{$payplan['pay_objective']}</td>												
                      <td>{$payplan['pay_user']}</td>	
                ";
                $thaitime = $thaitimeObj->dateThaiNoTime($payplan['pay_date']);
                echo "<td>" . $thaitime . "</td>";

                if ($_SESSION['role'] > 2) {
                  echo "<td><a href='showPayStep.php?pay_order={$payplan['pay_order']}' class='mr-2 btn btn-outline-info round'>ขั้นตอน " . $payplan['pay_step'] . "</a>";
                }

                if ($_SESSION['role'] < 3) {
                  echo "<td><a href='addPayStep.php?pay_order={$payplan['pay_order']}' class='btn btn-outline-info round'>แก้ไข " . $payplan['pay_step'] . "</a>";
                }

                echo "<span class='badge bg-info round '> <a href='../Reports/PayOrder" . $payplan['pay_order'] . ".pdf' target='_blank'>พิมพ์</a></span>";
                echo "</td></tr>";
              }
              ?>
            </form>
          </tbody>
        </table>
      </div>
      <div class="card-footer">
        <div class="row">
          <?php
          $actmoney = $activity[0]['act_money'];
          $balance = $actmoney - $sumpay;
          echo "<div class='col-md-4'><h4><span class='badge rounded-pill bg-primary'>ยอดรวมอนุมัติ  " . number_format($actmoney, 2) . " บาท</span></h4></div>";
          echo "<div class='col-md-4'><h4><span class='badge rounded-pill bg-success'>เบิกแล้ว  " . number_format($sumpay, 2) . " บาท</span></h4></div>";
          echo "<div class='col-md-4'><h4><span class='badge rounded-pill bg-danger'>คงเหลือ  " . number_format($balance, 2) . " บาท</span></h4></div>";
          ?>
        </div>
      </div>
    </div>
  </section>
</div> <!-- จบส่วนแสดงข้อมูลในหน้าหลก -->
<!-- จบส่วนของ modal -->

<!-- นำเข้าส่วน footer page -->
<?php require $_SERVER['DOCUMENT_ROOT'] . "/budget/App/Inc/footer.php"; ?>