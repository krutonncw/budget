<?php
// เรียกใช้งาน ไฟล์ autoload เพือให้โหลดคลาสต่าง ๆ มาทำงาน
require $_SERVER['DOCUMENT_ROOT'] . "/budget/vendor/autoload.php";

//ตรวจสอบว่าเข้าสู่ระบบหรือยัง
require $_SERVER['DOCUMENT_ROOT'] . "/budget/App/Auth/Controllers/auth.php";

use Ncw\Models\Activity;

require $_SERVER['DOCUMENT_ROOT'] . "/budget/App/Inc/header.php";
require $_SERVER['DOCUMENT_ROOT'] . "/budget/App/Inc/sidebar.php";

// สำหรับเก็บยอดรวมของแต่ละฝ่ายและยอดจ่าย
$income = 0;
$pay = 0;

$activityObj = new Activity();
if (isset($_REQUEST['dep_id'])) {
  $data['id'] = $_REQUEST['dep_id'];
}
$activitys = $activityObj->getActByDep($_REQUEST);
?>



<!-- แสดงข้อมูลในหน้าหลัก -->
<div class="main-content container-fluid">
  <div class="page-title">
    <div class="row">
      <div class="col-12 col-md-6 order-md-1 order-last">
        <h3>ข้อมูลกิจกรรมตามกลุ่มบริหาร/กลุ่มสาระ<span class='badge bg-success round '>
            <?php echo $activitys[0]['dep_name'] ?> </span></h3>
      </div>
    </div>
  </div>
  <section class="section">
    <div class="card">
      <div class="card-header">

        <div class="row">
          <div class="col-md-3">
            <span style="color:blue;">ยอดเงินคงเหลือกิจกรรมตามกลุ่มสาระ/ฝ่าย</span>
          </div>
          <div class="col-md-7">
            <span class="bage bg-info round  px-2">เหลือมากกว่า 5000</span>
            <span class="bage bg-warning round  px-2">เหลือมากกว่า 2000</span>
            <span class="bage bg-danger round  px-2">เหลือน้อยกว่า 2000</span>
          </div>
          <div class="col-md-2 d-flex justify-content-end">
            <a href='showDepartment.php' class='btn btn-primary round mr-2'>กลับ</a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <table class='table table-striped' id="table1">
          <thead>
            <tr>
              <th>#</th>
              <th>ชื่อโครงการ</th>
              <th>ชื่อกิจกรรม</th>
              <th>ประเภทเงิน</th>
              <th>เงินที่ได้รับจัดสรร</th>
              <th>เงินที่เบิกไป</th>
              <th>เงินคงเหลือ</th>
              <th>ดูข้อมูล</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $n = 0;
            foreach ($activitys as $activity) {
              $n++;
              $income += $activity['act_money'];

              echo "	
                <tr>										
                <td>{$n}</td>                                                
                <td>{$activity['pro_name']}</td>
                <td>{$activity['act_name']}</td>												
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
                $pay += $activity['act_money'] - $activity['act_balance'];
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

              echo "<td>
									    <a href='showPayByAct.php?act_id={$activity['act_id']}' class='mr-2 btn btn-outline-info round'>ข้อมูล</a>													
							      </td>
                </tr>";
            }
            ?>

          </tbody>
        </table>
      </div>
      <div class="card-footer">
        <div class="row">
          <?php
          $sum = $income - $pay;
          echo "<div class='col-md-4'><h4><span class='badge rounded-pill bg-primary'>ยอดรวมอนุมัติ  " . number_format($income, 2) . " บาท</span></h4></div>";
          echo "<div class='col-md-4'><h4><span class='badge rounded-pill bg-success'>เบิกแล้ว  " . number_format($pay, 2) . " บาท</span></h4></div>";
          echo "<div class='col-md-4'><h4><span class='badge rounded-pill bg-danger'>คงเหลือ  " . number_format($sum, 2) . " บาท</span></h4></div>";
          ?>
        </div>
      </div>
    </div>
  </section>
</div> <!-- จบส่วนแสดงข้อมูลในหน้าหลก -->
<!-- จบส่วนของ modal -->

<!-- นำเข้าส่วน footer page -->
<?php require $_SERVER['DOCUMENT_ROOT'] . "/ncwbudget/App/Inc/footer.php"; ?>