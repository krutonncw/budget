<?php

define('SERVERROOT', dirname(dirname(dirname(__FILE__))));

// เรียกใช้งาน ไฟล์ autoload เพือให้โหลดคลาสต่าง ๆ มาทำงาน
require_once "../../config.php";

//ตรวจสอบว่าเข้าสู่ระบบหรือยัง
require_once BASE_PATH . "/App/Auth/Controllers/auth.php";

use Ncw\Models\Report;
use Ncw\Models\ThaiTime;
use Ncw\Models\ThaiBath;
use Ncw\Models\Setting;

$reportObj = new Report();
$thaitimeObj = new ThaiTime();
$thaibathObj = new ThaiBath();
$settingObj = new Setting();
$settings = $settingObj->getSetting();

// สำหรับ export to excel
if (isset($_GET['act']) && $_GET['act'] == 'excel') {
  // Excel export
  header("Content-Type: application/vnd.ms-excel; charset=utf-8");
  header('Content-Disposition: attachment; filename="reportActionPlan.xls"');
  header("Pragma: no-cache");
  header("Expires: 0");

  $reportData = $reportObj->getActionPlanReport();

?>
  <meta charset="UTF-8">
  <table border="1" cellpadding="10">
    <thead>
      <tr style="background-color: #4CAF50; color: white; font-weight: bold;">
        <th>โครงการ</th>
        <th>ประเภทเงิน</th>
        <th>จำนวนเงิน</th>
        <th>เงินคงเหลือ</th>
        <th>ผู้รับผิดชอบ</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $totalMoney = 0;
      $totalBalance = 0;

      $projectData = $reportObj->getAllProjects();
      foreach ($projectData as $row) {
        echo "<tr>";
        echo "<td colspan='4'><strong>" . htmlspecialchars($row['pro_code']) . " - " . htmlspecialchars($row['pro_name']) . "</strong></td>";
        echo "<td>" . htmlspecialchars($row['pro_user'] ?? '-') . "</td>";
        echo "</tr>";

        $activitytData = $reportObj->getAllActivity($row['pro_id']);
        foreach ($activitytData as $activity) {
          echo "<tr>";
          echo "<td>" . htmlspecialchars($activity['act_name']) . "</td>";
          echo "<td>" . htmlspecialchars($activity['bgt_name']) . "</td>";
          echo "<td>" . number_format($activity['act_money'], 2) . "</td>";
          echo "<td>" . number_format($activity['act_balance'], 2) . "</td>";
          echo "<td>" . htmlspecialchars($activity['act_user'] ?? '-') . "</td>";
          echo "</tr>";
          $totalMoney += $activity['act_money'];
          $totalBalance += $activity['act_balance'];
        }
      }
      ?>
      <tr style="font-weight: bold; background-color: #f0f0f0;">
        <td colspan="2" style="text-align: right;">รวมทั้งสิ้น</td>
        <td><?php echo number_format($totalMoney, 2); ?></td>
        <td><?php echo number_format($totalBalance, 2); ?></td>
        <td></td>
      </tr>
    </tbody>
  </table>

  //สรุปจำนวนเงินตามประเภทงบประมาณ
  <table class="table table-striped table-hover" id="table">
    <thead>
      <tr>
        <th>ประเภทเงิน</th>
        <th>จำนวนเงิน</th>
        <th>เบิกแล้ว</th>
        <th>เงินคงเหลือ</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $totalActMomeys = 0;
      $totalActBalances = 0;
      $totalPayMomeys = 0;

      $BudgetTypes = $reportObj->getAllBudgetTypes();
      foreach ($BudgetTypes as $BudgetType) {
        $type['bgt_id'] = $BudgetType['bgt_id'];
        $sumActMoneys = $reportObj->getSumActMoneyGroupByBgt($type);
        $sumPayMoneys = $reportObj->getSumPayMoneyGroupByBgt($type);
        $sumActBalances = $reportObj->getSumActBalanceGroupByBgt($type);
        if ($sumPayMoneys === false) {
          $sumPayMoneys['sumPayMoney'] = 0;
        }
        echo "<tr>";
        echo "<td>" . htmlspecialchars($BudgetType['bgt_name']) . "</td>";
        echo "<td>" . number_format($sumActMoneys['sumActMoney'], 2) . "</td>";
        echo "<td>" . number_format($sumPayMoneys['sumPayMoney'], 2) . "</td>";
        echo "<td>" . number_format($sumActBalances['sumActBalance'], 2) . "</td>";
        echo "</tr>";
        $totalActMomeys += $sumActMoneys['sumActMoney'];
        $totalActBalances += $sumActBalances['sumActBalance'];
        $totalPayMomeys += $sumPayMoneys['sumPayMoney'];
      }
      ?>
      <tr style="font-weight: bold; background-color: #f0f0f0;">
        <td style="text-align: right;">รวมทั้งสิ้น</td>
        <td><?php echo number_format($totalActMomeys, 2); ?></td>
        <td><?php echo number_format($totalPayMomeys, 2); ?></td>
        <td><?php echo number_format($totalActBalances, 2); ?></td>
      </tr>
    </tbody>
  </table>
<?php
  exit;
}

// สำหรับ export to PDF
if (isset($_GET['act']) && $_GET['act'] == 'pdf') {
  try {
    $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir'];

    $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata'];

    $mpdf = new \Mpdf\Mpdf([
      'mode' => 'utf-8',
      'format' => 'A4',
      'fontDir' => array_merge($fontDirs, [
        __DIR__ . '/fonts',
      ]),
      'fontdata' => $fontData + [
        'sarabun' => [
          'R' => 'THSarabunNew.ttf',
          'I' => 'THSarabunNew Italic.ttf',
          'B' => 'THSarabunNew Bold.ttf',
          'BI' => 'THSarabunNew BoldItalic.ttf',
        ],
      ],
      'default_font' => 'sarabun',
    ]);
  } catch (Exception $e) {
    echo "Error creating PDF: " . $e->getMessage();
    exit;
  }

  // $reportData = $reportObj->getActionPlanReport();

  ob_start();
?>
  <html>
  <header>
    <meta charset="UTF-8">
    <title>รายงานการใช้เงินตามแผนปฏิบัติการ</title>
    <style>
      body {
        font-family: sarabun, Arial, sans-serif;
        font-size: 16pt;
      }

      table {
        width: 100%;
        border-collapse: collapse;
      }

      th,
      td {
        border: 1px solid #000;
        padding: 8px;
        text-align: left;
      }

      th {
        background-color: #4CAF50;
        color: white;
        font-weight: bold;
      }

      .header-title {
        text-align: center;
        font-size: 18pt;
        font-weight: bold;
        /* margin: 10px 0; */
      }

      .header-info {
        text-align: center;
        /* margin: 10px 0; */
      }

      @page {
        margin-top: 1cm;
        margin-bottom: 1cm;
      }
    </style>
  </header>

  <body>
    <div class="header-title">รายงานการใช้เงินตามแผนปฏิบัติการประจำ<?php echo htmlspecialchars($settings['year_name']); ?></div>
    <!-- <div class="header-info"><?php echo htmlspecialchars($settings['title_name']); ?></div> -->

    <table>
      <thead>
        <tr>
          <th>โครงการ</th>
          <th>ประเภทเงิน</th>
          <th>จำนวนเงิน</th>
          <th>เงินคงเหลือ</th>
          <th>ผู้รับผิดชอบ</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $projectData = $reportObj->getAllProjects();
        foreach ($projectData as $row) {
          echo "<tr>";
          echo "<td colspan='4'><strong>" . htmlspecialchars($row['pro_code']) . " - " . htmlspecialchars($row['pro_name']) . "</strong></td>";
          echo "<td style='font-size: 15px;'>" . htmlspecialchars($row['pro_user'] ?? '-') . "</td>";
          echo "</tr>";

          $activitytData = $reportObj->getAllActivity($row['pro_id']);
          foreach ($activitytData as $activity) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($activity['act_name']) . "</td>";
            echo "<td>" . htmlspecialchars($activity['bgt_name']) . "</td>";
            echo "<td>" . number_format($activity['act_money'], 2) . "</td>";
            echo "<td>" . number_format($activity['act_balance'], 2) . "</td>";
            echo "<td style='font-size: 15px;'>" . htmlspecialchars($activity['act_user'] ?? '-') . "</td>";
            echo "</tr>";
            $totalMoney += $activity['act_money'];
            $totalBalance += $activity['act_balance'];
          }
        }
        ?>
        <tr style="font-weight: bold; background-color: #f0f0f0;">
          <td colspan="2" style="text-align: right;">รวมทั้งสิ้น</td>
          <td><?php echo number_format($totalMoney, 2); ?></td>
          <td><?php echo number_format($totalBalance, 2); ?></td>
          <td></td>
        </tr>
      </tbody>
    </table>

    <div style="page-break-before: always;"></div>

    <div class="header-title">สรุปจำนวนเงินตามประเภทงบประมาณ</div>
    <table class="table table-striped table-hover" id="table">
      <thead>
        <tr>
          <th>ประเภทเงิน</th>
          <th>จำนวนเงิน</th>
          <th>เบิกแล้ว</th>
          <th>เงินคงเหลือ</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $totalActMomeys = 0;
        $totalActBalances = 0;
        $totalPayMomeys = 0;

        $BudgetTypes = $reportObj->getAllBudgetTypes();
        foreach ($BudgetTypes as $BudgetType) {
          $type['bgt_id'] = $BudgetType['bgt_id'];
          $sumActMoneys = $reportObj->getSumActMoneyGroupByBgt($type);
          $sumPayMoneys = $reportObj->getSumPayMoneyGroupByBgt($type);
          $sumActBalances = $reportObj->getSumActBalanceGroupByBgt($type);
          if ($sumPayMoneys === false) {
            $sumPayMoneys['sumPayMoney'] = 0;
          }
          echo "<tr>";
          echo "<td>" . htmlspecialchars($BudgetType['bgt_name']) . "</td>";
          echo "<td>" . number_format($sumActMoneys['sumActMoney'], 2) . "</td>";
          echo "<td>" . number_format($sumPayMoneys['sumPayMoney'], 2) . "</td>";
          echo "<td>" . number_format($sumActBalances['sumActBalance'], 2) . "</td>";
          echo "</tr>";
          $totalActMomeys += $sumActMoneys['sumActMoney'];
          $totalActBalances += $sumActBalances['sumActBalance'];
          $totalPayMomeys += $sumPayMoneys['sumPayMoney'];
        }
        ?>
        <tr style="font-weight: bold; background-color: #f0f0f0;">
          <td style="text-align: right;">รวมทั้งสิ้น</td>
          <td><?php echo number_format($totalActMomeys, 2); ?></td>
          <td><?php echo number_format($totalPayMomeys, 2); ?></td>
          <td><?php echo number_format($totalActBalances, 2); ?></td>
        </tr>
      </tbody>
    </table>

    <div style="margin-top: 30px; text-align: center; font-size: 12pt;">
      <p>วันที่พิมพ์: <?php echo $thaitimeObj->dateThaiFullMonth(date('Y-m-d')); ?></p>
    </div>
  </body>

  </html>
<?php
  // $html = ob_get_contents();
  $html = ob_get_clean();
  $mpdf->WriteHTML($html);
  $filename = "ReportActionPlan_" . date('YmdHis') . ".pdf";
  $mpdf->Output($filename, 'I'); // 'I' (Inline display in browser)
  exit;

  // บันทึก PDF ลงไฟล์ และดาวน์โหลด
  // $html = ob_get_contents();
  // $mpdf->WriteHTML($html);
  // $filename = "ReportActionPlan_" . date('YmdHis') . ".pdf";
  // $filepath = "../Reports/" . $filename;
  // if (!is_dir("../Reports/")) {
  //   mkdir("../Reports/", 0755, true);
  // }
  // $mpdf->Output($filepath, 'F'); // 'F' (ซึ่งหมายถึง Save to File)  
  // header("Location: " . $filepath);
  // ob_end_flush();
  // exit;
}

require_once BASE_PATH . "/App/Inc/header.php";
require_once BASE_PATH . "/App/Inc/sidebar.php";

// $reportData = $reportObj->getActionPlanReport();

?>

<!-- Display Content -->
<div class="main-content container-fluid">
  <div class="page-title">
    <div class="row">
      <div class="col-12 col-md-6 order-md-1 order-last">
        <h3>รายงานการใช้เงินตามแผนปฏิบัติการ</h3>
      </div>
      <div class="col-12 col-md-6 order-md-2 order-first text-md-right">
        <a href="?act=excel" class="btn btn-success btn-sm" target="_blank">
          <i data-feather="download"></i> Export → Excel
        </a>
        <a href="?act=pdf" class="btn btn-danger btn-sm" target="_blank">
          <i data-feather="download"></i> Export → PDF
        </a>
      </div>
    </div>
  </div>

  <section class="section">
    <div class="card">
      <div class="card-header">
        <h5>สรุปการใช้เงินตามแผนปฏิบัติการประจำปี <?php echo htmlspecialchars($settings['year_name']); ?></h5>
      </div>
      <div class="card-body">
        <div class="table-responsive">

          <table class="table table-striped table-hover" id="table">
            <thead>
              <tr>
                <th>โครงการ</th>
                <th>ประเภทเงิน</th>
                <th>จำนวนเงิน</th>
                <th>เงินคงเหลือ</th>
                <th>ผู้รับผิดชอบกิจกรรม</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $totalMoney = 0;
              $totalBalance = 0;

              $projectData = $reportObj->getAllProjects();
              foreach ($projectData as $row) {
                echo "<tr>";
                echo "<td colspan='4'><strong>" . htmlspecialchars($row['pro_code']) . " - " . htmlspecialchars($row['pro_name']) . "</strong></td>";
                echo "<td>" . htmlspecialchars($row['pro_user'] ?? '-') . "</td>";
                echo "</tr>";

                $activitytData = $reportObj->getAllActivity($row['pro_id']);
                foreach ($activitytData as $activity) {
                  echo "<tr>";
                  echo "<td>" . htmlspecialchars($activity['act_name']) . "</td>";
                  echo "<td>" . htmlspecialchars($activity['bgt_name']) . "</td>";
                  echo "<td>" . number_format($activity['act_money'], 2) . "</td>";
                  echo "<td>" . number_format($activity['act_balance'], 2) . "</td>";
                  echo "<td>" . htmlspecialchars($activity['act_user'] ?? '-') . "</td>";
                  echo "</tr>";
                  $totalMoney += $activity['act_money'];
                  $totalBalance += $activity['act_balance'];
                }
              }
              ?>
              <tr style="font-weight: bold; background-color: #f0f0f0;">
                <td colspan="2" style="text-align: right;">รวมทั้งสิ้น</td>
                <td><?php echo number_format($totalMoney, 2); ?></td>
                <td><?php echo number_format($totalBalance, 2); ?></td>
                <td></td>
              </tr>
            </tbody>
          </table>

          //สรุปจำนวนเงินตามประเภทงบประมาณ
          <table class="table table-striped table-hover" id="table">
            <thead>
              <tr>
                <th>ประเภทเงิน</th>
                <th>จำนวนเงิน</th>
                <th>เบิกแล้ว</th>
                <th>เงินคงเหลือ</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $totalActMomeys = 0;
              $totalActBalances = 0;
              $totalPayMomeys = 0;

              $BudgetTypes = $reportObj->getAllBudgetTypes();
              foreach ($BudgetTypes as $BudgetType) {
                $type['bgt_id'] = $BudgetType['bgt_id'];
                $sumActMoneys = $reportObj->getSumActMoneyGroupByBgt($type);
                $sumPayMoneys = $reportObj->getSumPayMoneyGroupByBgt($type);
                $sumActBalances = $reportObj->getSumActBalanceGroupByBgt($type);
                if ($sumPayMoneys === false) {
                  $sumPayMoneys['sumPayMoney'] = 0;
                }
                echo "<tr>";
                echo "<td>" . htmlspecialchars($BudgetType['bgt_name']) . "</td>";
                echo "<td>" . number_format($sumActMoneys['sumActMoney'], 2) . "</td>";
                echo "<td>" . number_format($sumPayMoneys['sumPayMoney'], 2) . "</td>";
                echo "<td>" . number_format($sumActBalances['sumActBalance'], 2) . "</td>";
                echo "</tr>";
                $totalActMomeys += $sumActMoneys['sumActMoney'];
                $totalActBalances += $sumActBalances['sumActBalance'];
                $totalPayMomeys += $sumPayMoneys['sumPayMoney'];
              }
              ?>
              <tr style="font-weight: bold; background-color: #f0f0f0;">
                <td style="text-align: right;">รวมทั้งสิ้น</td>
                <td><?php echo number_format($totalActMomeys, 2); ?></td>
                <td><?php echo number_format($totalPayMomeys, 2); ?></td>
                <td><?php echo number_format($totalActBalances, 2); ?></td>
              </tr>
            </tbody>
          </table>

        </div>
      </div>
    </div>
  </section>
</div>

<!-- Load Footer -->
<?php require_once BASE_PATH . "/App/Inc/footer.php"; ?>