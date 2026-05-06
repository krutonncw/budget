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
        <th>กิจกรรม</th>
        <th>ประเภทเงิน</th>
        <th>จำนวนเงิน</th>
        <th>เงินที่ใช้</th>
        <th>เงินคงเหลือ</th>
        <th>ผู้รับผิดชอบ</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $lastProId = null;
      foreach ($reportData as $row) {
        echo "<tr>";
        if ($lastProId !== $row['pro_id']) {
          echo "<td rowspan='' style='font-weight: bold;'>" . htmlspecialchars($row['pro_name']) . "</td>";
          $lastProId = $row['pro_id'];
        } else {
          echo "<td></td>";
        }
        echo "<td>" . htmlspecialchars($row['act_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['bgt_name']) . "</td>";
        echo "<td>" . number_format($row['act_money'], 2) . "</td>";
        echo "<td>" . number_format($row['spent'], 2) . "</td>";
        echo "<td>" . number_format($row['remaining'], 2) . "</td>";
        echo "<td>" . htmlspecialchars($row['act_responsible'] ?? '-') . "</td>";
        echo "</tr>";
      }
      ?>
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

  $reportData = $reportObj->getActionPlanReport();
  
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
      th, td {
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
        margin: 10px 0;
      }
      .header-info {
        text-align: center;
        margin: 10px 0;
      }
      @page {
        margin-top: 1cm;
        margin-bottom: 0.5cm;
      }
    </style>
  </header>
  <body>
    <div class="header-title">รายงานการใช้เงินตามแผนปฏิบัติการ</div>
    <div class="header-info"><?php echo htmlspecialchars($settings['title_name']); ?></div>
    <div class="header-info">ประจำปี <?php echo htmlspecialchars($settings['year_name']); ?></div>
    
    <table>
      <thead>
        <tr>
          <th>โครงการ</th>
          <th>กิจกรรม</th>
          <th>ประเภทเงิน</th>
          <th width="12%">จำนวนเงิน</th>
          <th width="12%">เงินที่ใช้</th>
          <th width="12%">เงินคงเหลือ</th>
          <th>ผู้รับผิดชอบ</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $lastProId = null;
        $totalMoney = 0;
        $totalSpent = 0;
        $totalRemaining = 0;
        
        foreach ($reportData as $row) {
          echo "<tr>";
          echo "<td>" . htmlspecialchars($row['pro_name']) . "</td>";
          echo "<td>" . htmlspecialchars($row['act_name']) . "</td>";
          echo "<td>" . htmlspecialchars($row['bgt_name']) . "</td>";
          echo "<td style='text-align: right;'>" . number_format($row['act_money'], 2) . "</td>";
          echo "<td style='text-align: right;'>" . number_format($row['spent'], 2) . "</td>";
          echo "<td style='text-align: right;'>" . number_format($row['remaining'], 2) . "</td>";
          echo "<td>" . htmlspecialchars($row['act_responsible'] ?? '-') . "</td>";
          echo "</tr>";
          
          $totalMoney += $row['act_money'];
          $totalSpent += $row['spent'];
          $totalRemaining += $row['remaining'];
        }
        ?>
        <tr style="font-weight: bold; background-color: #e8e8e8;">
          <td colspan="3" style="text-align: right;">รวมทั้งสิ้น</td>
          <td style="text-align: right;"><?php echo number_format($totalMoney, 2); ?></td>
          <td style="text-align: right;"><?php echo number_format($totalSpent, 2); ?></td>
          <td style="text-align: right;"><?php echo number_format($totalRemaining, 2); ?></td>
          <td></td>
        </tr>
      </tbody>
    </table>

    <div style="margin-top: 30px; text-align: center; font-size: 12pt;">
      <p>วันที่พิมพ์: <?php echo $thaitimeObj->dateThaiFullMonth(date('Y-m-d')); ?></p>
    </div>
  </body>
  </html>
  <?php
  $html = ob_get_contents();
  $mpdf->WriteHTML($html);
  $filename = "ReportActionPlan_" . date('YmdHis') . ".pdf";
  $filepath = "../Reports/" . $filename;
  if (!is_dir("../Reports/")) {
    mkdir("../Reports/", 0755, true);
  }
  $mpdf->Output($filepath, 'F');
  header("Location: " . $filepath);
  ob_end_flush();
  exit;
}

require_once BASE_PATH . "/App/Inc/header.php";
require_once BASE_PATH . "/App/Inc/sidebar.php";

$reportData = $reportObj->getActionPlanReport();
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
          <table class="table table-striped table-hover" id="table1">
            <thead>
              <tr>
                <th>โครงการ</th>
                <th>กิจกรรม</th>
                <th>ประเภทเงิน</th>
                <th>จำนวนเงิน</th>
                <th>เงินที่ใช้</th>
                <th>เงินคงเหลือ</th>
                <th>ผู้รับผิดชอบกิจกรรม</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $lastProId = null;
              $totalMoney = 0;
              $totalSpent = 0;
              $totalRemaining = 0;
              
              foreach ($reportData as $row) {
                echo "<tr>";
                echo "<td><strong>" . htmlspecialchars($row['pro_name']) . "</strong></td>";
                echo "<td>" . htmlspecialchars($row['act_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['bgt_name']) . "</td>";
                echo "<td>" . number_format($row['act_money'], 2) . "</td>";
                echo "<td>" . number_format($row['spent'], 2) . "</td>";
                
                // Color code for remaining balance
                $remainingBalance = $row['remaining'];
                if ($remainingBalance >= 5000) {
                  $badge = "badge bg-info";
                } elseif ($remainingBalance >= 2000) {
                  $badge = "badge bg-warning";
                } else {
                  $badge = "badge bg-danger";
                }
                
                echo "<td><span class='" . $badge . "'>" . number_format($remainingBalance, 2) . "</span></td>";
                echo "<td>" . htmlspecialchars($row['act_responsible'] ?? '-') . "</td>";
                echo "</tr>";
                
                $totalMoney += $row['act_money'];
                $totalSpent += $row['spent'];
                $totalRemaining += $row['remaining'];
              }
              ?>
              <tr style="font-weight: bold; background-color: #f0f0f0;">
                <td colspan="3" style="text-align: right;">รวมทั้งสิ้น</td>
                <td><?php echo number_format($totalMoney, 2); ?></td>
                <td><?php echo number_format($totalSpent, 2); ?></td>
                <td><?php echo number_format($totalRemaining, 2); ?></td>
                <td></td>
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
