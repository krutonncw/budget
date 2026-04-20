<?php
// เรียกใช้งาน ไฟล์ autoload เพือให้โหลดคลาสต่าง ๆ มาทำงาน
require_once "../../config.php";

use Ncw\Models\PayPlan;
?>

<?php
$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

$mpdf = new \Mpdf\Mpdf([
  'fontDir' => array_merge($fontDirs, [
    __DIR__ . '/tmp',
  ]),
  'fontdata' => $fontData + [
    'sarabun' => [
      'R' => 'THSarabunNew.ttf',
      'I' => 'THSarabunNew Italic.ttf',
      'B' => 'THSarabunNew Bold.ttf',
      'BI' => 'THSarabunNew BoldItalic.ttf',
    ]
  ],
  'default_font' => 'sarabun'
]);
ob_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <table>
    <thead>
      <tr>
        <th>ลำดับ</th>
        <th>เลขที่คำขออนุมัติใช้เงิน</th>
        <th>ชื่อกิจกรรม</th>
        <th>จำนวนเงินที่ขอใช้</th>
        <th>ประเภทงบประมาณ</th>
        <th>ผู้ขอใช้เงิน</th>
        <th>ขอใช้เพื่อ</th>
        <th>วันที่ขอใช้</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $pay_order['pay_order'] = 605;
      $payplanObj = new PayPlan();
      $payplan = $payplanObj->getPayOrdByPO($pay_order);

      echo "
        <tr>
          <td>{$payplan['pay_id']}</td>
          <td>{$payplan['pay_order']}</td>
          <td>{$payplan['act_name']}</td>
          <td>{$payplan['pay_money']}</td>
          <td>{$payplan['bgt_name']}</td>
          <td>{$payplan['pay_user']}</td>
          <td>{$payplan['pay_objective']}</td>
          <td>{$payplan['pay_date']}</td>
        </tr>
        ";

      ?>
    </tbody>
  </table>
  <?php
  //จุดสิ้นสุดการสร้าง pfd
  $html = ob_get_contents();
  $mpdf->WriteHTML($html);
  $mpdf->Output("MyReport.pdf");
  ob_end_flush();
  ?>
  <a href="MyReport.pdf">ดาวน์โหลด</a>
</body>

</html>