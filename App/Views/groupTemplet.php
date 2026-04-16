<?php
use Ncw\Models\Activity;
$activityObj = new Activity();
// สำหรับเก็บยอดรวมของแต่ละฝ่ายและยอดจ่าย
$income = 0;
$pay = 0;
$data['id'] = $department['dep_id'];
$activitys = $activityObj->getActDepID($data);
$n = 0;
foreach ($activitys as $activity) {
    $n++;
    $income += $activity['act_money'];
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
}
$sum = $income - $pay;
echo "<div class='col-md-4'><h5><span class='badge rounded-pill bg-primary'>ยอดรวมอนุมัติ  " . number_format($income, 2) . " บาท</span></h5></div>";
echo "<div class='col-md-4'><h5><span class='badge rounded-pill bg-success'>เบิกแล้ว  " . number_format($pay, 2) . " บาท</span></h5></div>";
echo "<div class='col-md-4'><h5><span class='badge rounded-pill bg-danger'>คงเหลือ  " . number_format($sum, 2) . " บาท</span></h5></div>";
?>