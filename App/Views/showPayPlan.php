<?php
// เรียกใช้งาน ไฟล์ autoload เพือให้โหลดคลาสต่าง ๆ มาทำงาน
require $_SERVER['DOCUMENT_ROOT'] . "/budget/vendor/autoload.php";

//ตรวจสอบว่าเข้าสู่ระบบหรือยัง
require $_SERVER['DOCUMENT_ROOT'] . "/budget/App/Auth/Controllers/auth.php";

use Ncw\Models\PayPlan;
use Ncw\Models\ThaiTime;

require $_SERVER['DOCUMENT_ROOT'] . "/budget/App/Inc/header.php";
require $_SERVER['DOCUMENT_ROOT'] . "/budget/App/Inc/sidebar.php";

?>

<!-- แสดงข้อมูลในหน้าหลัก -->
<div class="main-content container-fluid">
  <div class="page-title">
    <div class="row">
      <div class="col-12 col-md-6 order-md-1 order-last">
        <h3>ข้อมูลการเบิก</h3>
      </div>
    </div>
  </div>
  <section class="section">
    <div class="card">
      <div class="card-header">
        ข้อมูลการเบิกตามกิจกรรม
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

              $payplans = $payplanObj->getAllPayPlans();

              foreach ($payplans as $payplan) {

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
                  echo "<td><a href='showPayStep.php?pay_order={$payplan['pay_order']}' class='mr-2 btn btn-outline-info round btn-sm'>ขั้นตอน " . $payplan['pay_step'] . "</a>";
                }

                if ($_SESSION['role'] < 3) {
                  echo "<td><a href='addPayStep.php?pay_order={$payplan['pay_order']}' class='btn btn-outline-info round'>แก้ไข " . $payplan['pay_step'] . "</a>";
                }

                echo "<span class='badge bg-info round '> <a href='../Reports/PayOrder" . $payplan['pay_order'] . ".pdf' target='_blank'>พิมพ์</a></span>";

                //if ($_SESSION['role'] > 2) {
                //  echo "<td><a href='showPayStep.php?pay_order={$payplan['pay_order']}' class='mr-2 btn btn-outline-info round'>สถานะ</a>";
                //  if ($payplan['pay_step'] == 4) {
                //    echo "<span class='badge bg-success round '> ขั้นตอน " . $payplan['pay_step'] . "</span>";
                //  } else {
                //    echo "<span class='badge bg-info round '> ขั้นตอน " . $payplan['pay_step'] . "</span>";
                //  }
                //}

                //if ($_SESSION['role'] < 3) {
                //  echo "<td><a href='addPayStep.php?pay_order={$payplan['pay_order']}' class='btn btn-outline-info round'>แก้ไข</a>";
                //  if ($payplan['pay_step'] == 4) {
                //    echo "<span class='badge bg-success round '> ขั้นตอน " . $payplan['pay_step'] . "</span>";
                //  } else {
                //    echo "<span class='badge bg-info round '> ขั้นตอน " . $payplan['pay_step'] . "</span>";
                //  }
                //}               

                echo "</td></tr>";
              }
              ?>
            </form>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div> <!-- จบส่วนแสดงข้อมูลในหน้าหลก -->
<!-- จบส่วนของ modal -->

<!-- นำเข้าส่วน footer page -->
<?php require $_SERVER['DOCUMENT_ROOT'] . "/budget/App/Inc/footer.php"; ?>