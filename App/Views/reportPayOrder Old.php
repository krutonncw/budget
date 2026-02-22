<?php

define('SERVERROOT',dirname(dirname(dirname(__FILE__))));

// เรียกใช้งาน ไฟล์ autoload เพือให้โหลดคลาสต่าง ๆ มาทำงาน
require $_SERVER['DOCUMENT_ROOT'] . "/ncwbudget/vendor/autoload.php";

//ตรวจสอบว่าเข้าสู่ระบบหรือยัง
require $_SERVER['DOCUMENT_ROOT'] . "/ncwbudget/App/Auth/Controllers/auth.php";

use Ncw\Models\PayPlan;
use Ncw\Models\ThaiTime;
use Ncw\Models\ThaiBath;
use Ncw\Models\Ref;

?>

<?php
$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

$mpdf = new \Mpdf\Mpdf([
  'mode' => 'utf-8', 'format' => 'A4',
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
?>
<?php
$pay_order['pay_order'] = $_SESSION['pay_order'];
$payplanObj = new PayPlan();
$payplans = $payplanObj->getPayOrderToReport($pay_order);

$thaitimeObj = new ThaiTime();
$thaitime = $thaitimeObj->dateThaiFullMonth($payplans['pay_date']);

$thaibathObj = new ThaiBath();
$thaibath = $thaibathObj->textBath($payplans['pay_money']);

$ID['ref_id'] = $payplans['pay_type'];
$ID['ref_group_id'] = 2;
$RefTitleObj = new Ref();
$RefTitle = $RefTitleObj->getRefTitleByID($ID);

?>

<a href="../Reports/PayOrder<?php echo $pay_order['pay_order']; ?>.pdf" target="_blank">พิมพ์ใบคำขอ</a> &nbsp;&nbsp;
<a href="showPayPlan.php">ข้อมูลการเบิก</a>

<?php
ob_start();
?>

<html>
<header>
  <title>แบบขออนุมัติใช้เงินตามแผนปฏิบัติการปีการศึกษา</title>

  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Sarabun&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Sarabun', sans-serif;
      font-size: 16pt;
    }

    table {
      table-layout: fixed;
      width: 18cm;
      border: 0px solid black;
      margin: auto;
    }

    @page {
      margin-top: 1cm;
      margin-bottom: 0.5cm;
    }
  </style>

</header>

<body>
  <table>
    <tr style="width: 100%">
      <td colspan="2">
        <table style="border: 0px; width: 100%">
          <tr>
            <td width=30%><img src="<?php echo SERVERROOT.'/App/Reports/krut.png';?>" style="width: 1.5cm;"></td>
            <td valign="bottom" style="text-align: center; font-size: 22pt; font-weight: bold;">บันทึกข้อความ</td>
            <td width=30% valign="top" style="text-align: right;">เลขที่ <?php echo $payplans['pay_order']."-".str_pad($payplans['pro_id'], 2, '0', STR_PAD_LEFT).str_pad($payplans['act_id'], 2, '0', STR_PAD_LEFT) ?></td>
          </tr>
        </table>
      </td>
    </tr>

    <tr>
      <td colspan="2">
        <span style="font-size: 20pt; font-weight: bold;">ส่วนราชการ </span><span>โรงเรียนหนองฉางวิทยา อำเภอหนองฉาง จังหวัดอุทัยธานี 61110</span>
      </td>
    </tr>

    <tr>
      <td>
        <span style="font-size: 20pt ; font-weight: bold;">ที่ </span><span></span>
      </td>

      <td>
        <span style="font-size: 20pt; font-weight: bold;">วันที่ </span><span><?php echo $thaitime ?></span>
      </td>
    </tr>

    <tr>
      <td colspan="2" style="border-bottom: 1px solid black ;">
        <span style="font-size: 20pt; font-weight: bold;">เรื่อง </span><span>ขออนุมัติใช้เงินตามแผนปฏิบัติการประจำปีการศึกษา 2565</span>
      </td>
    </tr>

    <!--<tr height="5px">
      <td colspan="2">
        <hr color="black" size="1px">
      </td>
    </tr>-->

    <tr>
      <td colspan="2">เรียน ผู้อำนวยการโรงเรียนหนองฉางวิทยา</td>
    </tr>

   <tr>
      <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        ด้วย<?php echo $payplans['dep_name']; ?> มีความต้องการจะ<?php echo $RefTitle['title']; ?>
        เพื่อใช้ในการ <?php echo $payplans['pay_objective']; ?> <?php echo "มีความประสงค์ที่จะขอใช้เงินในการดำเนินงาน ตามแผนปฏิบัติการประจำปี ". $payplans['pro_name']; ?> - <?php echo $payplans['act_name']; ?>
        เป็นจำนวนเงิน <?php echo number_format($payplans['pay_money'], 2); ?> บาท (<?php echo $thaibath; ?>) ประเภทเงิน <?php echo $payplans['bgt_name']; ?>
        <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        กิจกรรมนี้ได้รับเงินจัดสรรประจำปี จำนวน <?php echo number_format($payplans['act_money'], 2); ?> บาท ใช้ไปแล้ว <?php echo number_format($payplans['act_money'] - $payplans['act_balance'] - $payplans['pay_money'], 2); ?> บาท <br>เบิกครั้งนี้แล้วคงเหลือ <?php echo number_format($payplans['act_balance'], 2); ?> บาท
      </td>
    </tr>
    
    <tr>
      <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;จึงเรียนมาเพื่อโปรดพิจารณาอนุมัติ</td>
    </tr>

    <tr>
      <td style="text-align: center; width:50%"><br><br>
        ลงชื่อ ..............................................&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
        (<?php echo $payplans['pay_user']; ?>)<br>
        ผู้ขออนุมัติ
      </td>
      <td style="text-align: center;"><br><br>
        ลงชื่อ ..............................................&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
        (<?php echo $payplans['dep_user']; ?>)<br>
        <?php echo $payplans['dep_pos']; ?>
      </td>
    </tr>
    <tr><td colspan="2">หมายเหตุ ให้ดำเนินการจัดซื้อ/จัดจ้างให้แล้วเสร็จภายใน 10 วัน นับแต่วันที่ได้รับการอนุมัติ</td></tr>
  </table>
  
  <table style="border: 1px solid black;">
    <tr>
      <td style="width:50%; border-right: 1px solid black;" valign="top">
        <table style="border: 0px; width: 100%;">
          <tr>
            <td>
              1.ความเห็น<?php echo $payplans['man_pos']; ?><br>
              &nbsp;&nbsp;&nbsp;(&nbsp;&nbsp;) เห็นสมควรอนุมัติ <br>
              &nbsp;&nbsp;&nbsp;(&nbsp;&nbsp;) ไม่สมควรอนุมัติ เพราะ.......................................... <br><br><br>
            </td>
          </tr>
          <tr>
            <td style="text-align: center;">
              ลงชื่อ ..............................................&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
              (<?php echo $payplans['man_user']; ?>)<br>
              ........../.................../..........
            </td>
          </tr>
          <tr>
            <td>
              2.ได้ตรวจสอบงาน/โครงการแล้ว ปรากฎว่า<br>
              &nbsp;&nbsp;&nbsp;(&nbsp;&nbsp;) มีในแผนปฏิบัติการประจำปี <br>
              &nbsp;&nbsp;&nbsp;(&nbsp;&nbsp;) ไม่มีในแผนปฏิบัติการประจำปี <br><br><br>
            </td>
          </tr>
          <tr>
            <td style="text-align: center;">
              ลงชื่อ ..............................................&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
              (นายปุณณรัตน์ ทองธรรม)<br>
              ........../.................../..........
            </td>
          </tr>
        </table>
      </td>

      <td style="width:50%;">
        <table style="border: 0px; width: 100%">
          <tr>
            <td>
              3.ความเห็นรองผู้อำนวยการโรงเรียนกลุ่มบริหารงบประมาณ<br>
              &nbsp;&nbsp;&nbsp;(&nbsp;&nbsp;) เห็นสมควรอนุมัติ <br>
              &nbsp;&nbsp;&nbsp;(&nbsp;&nbsp;) ไม่สมควรอนุมัติ เพราะ..........................................<br><br><br>
            </td>
          </tr>
          <tr>
            <td style="text-align: center;">
              ลงชื่อ ..............................................&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
              (นางสาววันวิสา วิเชียรรัตน์)<br>
              ........../.................../..........
            </td>
          </tr>
          <tr>
            <td>
              4.ผลการพิจารณาของผู้อำนวยการโรงเรียน<br>
              &nbsp;&nbsp;&nbsp;(&nbsp;&nbsp;) อนุมัติ <br>
              &nbsp;&nbsp;&nbsp;(&nbsp;&nbsp;) ไม่อนุมัติ เพราะ.................................................... <br><br><br>
            </td>
          </tr>
          <tr>
            <td style="text-align: center;">
              ลงชื่อ ..............................................&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
              (นายธนกฤต นิโรจน์)<br>
              ผู้อำนวยการโรงเรียนหนองฉางวิทยา<br>
              ........../.................../..........
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <br>

  <?php
  //จุดสิ้นสุดการสร้าง pfd
  $html = ob_get_contents();
  $mpdf->WriteHTML($html);
  $mpdf->Output("../Reports/PayOrder{$pay_order['pay_order']}.pdf");
  ob_end_flush();
  ?>

</body>

</html>