<?php
// เรียกใช้งาน ไฟล์ autoload เพือให้โหลดคลาสต่าง ๆ มาทำงาน
require $_SERVER['DOCUMENT_ROOT'] . "/budget/vendor/autoload.php";

//ตรวจสอบว่าเข้าสู่ระบบหรือยัง
require $_SERVER['DOCUMENT_ROOT'] . "/budget/App/Auth/Controllers/auth.php";

use Ncw\Models\Project;
use Ncw\Models\PayPlan;

require $_SERVER['DOCUMENT_ROOT'] . "/budget/App/Inc/header.php";
require $_SERVER['DOCUMENT_ROOT'] . "/budget/App/Inc/sidebar.php";

?>

<!-- แสดงข้อมูลในหน้าหลัก -->
<div class="main-content container-fluid">
  <div class="page-title">
    <div class="row">
      <div class="col-12 col-md-6 order-md-1 order-last">
        <h3>ข้อมูลโครงการ</h3>
      </div>
    </div>
  </div>
  <section class="section">
    <div class="card">
      <div class="card-header">
        โครงการ
        <span class="bage bg-info round mx-2 px-2">เหลือมากกว่า 5000</span>
        <span class="bage bg-warning round mx-2 px-2">เหลือมากกว่า 2000</span>
        <span class="bage bg-danger round mx-2 px-2">เหลือน้อยกว่า 2000</span>
      </div>
      <div class="card-body">
        <table class='table table-striped' id="table1">
          <thead>
            <tr>
              <th>ลำดับ</th>
              <th>ชื่อโครงการ</th>
              <th>ชื่อกลุ่ม</th>
              <th>เงินที่ได้รับจัดสรร</th>
              <th>เงินที่เบิกไป</th>
              <th>เงินคงเหลือ</th>
              <th>เงินจากใบเบิก</th>
              <th>ส่วนต่าง</th>
            </tr>
          </thead>
          <tbody>
            <form proion="" method="get">
              <?php
              $projectObj = new Project();
              $projects = $projectObj->getProByGroup();
              $pay = 0;
              foreach ($projects as $project) {
                echo "
                  <tr>
                    <td>{$project['pro_id']}</td>
                    <td>{$project['pro_name']}</td>
                    <td>{$project['dep_name']}</td>
                ";
                echo "<td>" . number_format($project['pro_money'], 2) . "</td>";

                // ทำการคำนวณเงินตามความเป็นจริง
                if ($project['pro_money'] == $project['pro_balance']) {
                  $a = 0;
                } elseif ($project['pro_balance'] == 0) {
                  $pay += $project['pro_money'];
                  $a = $project['pro_money'];
                } elseif ($project['pro_balance'] < 0) {
                  $pay += $project['pro_money'] + abs($project['pro_balance']); //ฟังก์ชั้นถอดค่าติดลบออกเพื่อนำไปคำนวณ absolute 
                  $a = $project['pro_money'] + abs($project['pro_balance']);
                } else {
                  $pay += $project['pro_balance'];
                  $a = $project['pro_money'] - $project['pro_balance'];
                }
                echo "<td>" . number_format($a, 2) . "</td>";

                if ($project['pro_balance'] >= 5000) {
                  echo "<td ><span class='badge bg-info round'>" . number_format($project['pro_balance'], 2) . "</span></td>";
                } elseif ($project['pro_balance'] >= 2000) {
                  echo "<td ><span class='badge bg-warning round'>" . number_format($project['pro_balance'], 2) . "</span></td>";
                } else {
                  echo "<td ><span class='badge bg-danger round'>" . number_format($project['pro_balance'], 2) . "</span></td>";
                }

                $pro_id['pro_id'] = $project['pro_id'];
                $payplanObj = new Payplan();
                $payplans = $payplanObj->getSumPayMoneyByPro($pro_id);
                echo "<td>" . number_format($payplans['sumPayMoneyPro'], 2) . "</td>";

                echo "<td>" . number_format($a - $payplans['sumPayMoneyPro'], 2) . "</td>";

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

<!-- นำเข้าส่วน footer page -->
<?php require $_SERVER['DOCUMENT_ROOT'] . "/budget/App/Inc/footer.php"; ?>