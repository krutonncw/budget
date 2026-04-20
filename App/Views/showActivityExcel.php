<?php
// เรียกใช้งาน ไฟล์ autoload เพือให้โหลดคลาสต่าง ๆ มาทำงาน
require_once "../../config.php";;

//ตรวจสอบว่าเข้าสู่ระบบหรือยัง
require_once BASE_PATH . "/App/Auth/Controllers/auth.php";

use Ncw\Models\Activity;
use Ncw\Models\PayPlan;

require_once BASE_PATH . "/App/Inc/header.php";
//require_once BASE_PATH . "/App/Inc/sidebar.php";

// สำหรับ export to excel
if (isset($_GET['act'])) {
  if ($_GET['act'] == 'excel') {
    header("Content-Type: application/vnd.ms-excel"); // ประเภทของไฟล์
    header('Content-Disposition: attachment; filename="activity.xls"'); //กำหนดชื่อไฟล์
    header("Pragma: no-cache");
    header("Expires: 0");
  }
}

?>

<!-- แสดงข้อมูลในหน้าหลัก -->
<div class="main-content container-fluid">
  <div class="page-title">
    <div class="row">
      <div class="col-12 col-md-6 order-md-1 order-last">
        <h3>ข้อมูลกิจกรรม</h3>
      </div>
    </div>
  </div>
  <section class="section">
    <div class="card">
      <div class="card-header">
        กิจกรรมตามโครงการ <a href="?act=excel" class="btn btn-primary"> Export->Excel </a>
        <span class="bage bg-info round mx-2 px-2">เหลือมากกว่า 5000</span>
        <span class="bage bg-warning round mx-2 px-2">เหลือมากกว่า 2000</span>
        <span class="bage bg-danger round mx-2 px-2">เหลือน้อยกว่า 2000</span>
      </div>
      <div class="card-body">
        <table class='table table-striped' id="table1">
          <thead>
            <tr>
              <th>ลำดับ</th>
              <th>ชื่อกิจกรรม</th>
              <th>ชื่อโครงการ</th>
              <th>กลุ่ม</th>
              <th>ประเภทงบประมาณ</th>
              <th>เงินที่ได้รับจัดสรร</th>
              <th>เงินที่เบิกไปแล้ว</th>
              <th>เงินคงเหลือ</th>
              <th>เงินจากใบเบิก</th>
              <th>ส่วนต่าง</th>
            </tr>
          </thead>
          <tbody>
            <form action="" method="get">
              <?php
              $activityObj = new Activity();
              $activitys = $activityObj->getAllActivitys();
              $pay = 0;
              foreach ($activitys as $activity) {
                echo "											
									<td>{$activity['act_id']}</td>                                                
                  <td>{$activity['act_name']}</td>
                  <td>{$activity['pro_name']}</td>											
                  <td>{$activity['dep_name']}</td>											
                  <td>{$activity['bgt_name']}</td>	
                ";
                echo "<td>" . number_format($activity['act_money'], 2) . "</td>";

                // ทำการคำนวณเงินตามความเป็นจริง
                if ($activity['act_money'] == $activity['act_balance']) {
                  $a = 0;
                } elseif ($activity['act_balance'] == 0) {
                  $pay += $activity['act_money'];
                  $a = $activity['act_money'];
                } elseif ($activity['act_balance'] < 0) {
                  $pay += $activity['act_money'] + abs($activity['act_balance']); //ฟังก์ชั้นถอดค่าติดลบออกเพื่อนำไปคำนวณ absolute 
                  $a = $activity['act_money'] + abs($activity['act_balance']);
                } else {
                  $pay += $activity['act_balance'];
                  $a = $activity['act_money'] - $activity['act_balance'];
                }
                echo "<td>" . number_format($a, 2) . "</td>";

                if ($activity['act_balance'] >= 5000) {
                  echo "<td ><span class='badge bg-info round'>" . number_format($activity['act_balance'], 2) . "</span></td>";
                } elseif ($activity['act_balance'] >= 2000) {
                  echo "<td ><span class='badge bg-warning round'>" . number_format($activity['act_balance'], 2) . "</span></td>";
                } else {
                  echo "<td ><span class='badge bg-danger round'>" . number_format($activity['act_balance'], 2) . "</span></td>";
                }

                $act_id['act_id'] = $activity['act_id'];
                $payplanObj = new Payplan();
                $payplans = $payplanObj->getSumPayMoneyByAct($act_id);
                echo "<td>" . number_format($payplans['sumPayMoneyAct'], 2) . "</td>";

                echo "<td>" . number_format($a - $payplans['sumPayMoneyAct'], 2) . "</td>";

                echo "</tr>";
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

<?php require $_SERVER['DOCUMENT_ROOT'] . "/ncwbudget/App/Inc/footer.php"; ?>