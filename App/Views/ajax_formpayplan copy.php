<?php
require_once "../../config.php";

//ตรวจสอบว่าเข้าสู่ระบบหรือยัง
require_once BASE_PATH . "/App/Auth/Controllers/auth.php";

use Ncw\Models\Project;
use Ncw\Models\Activity;
use Ncw\Models\PayPlan;

if (isset($_POST['function']) && $_POST['function'] == 'project') {
    $id = $_POST['id'];
    $projectObj = new Project();
    $projects = $projectObj->getProjectsByDep(['dep_id' => $id]);
    echo '<option value="" disabled selected>เลือกโครงการ...</option>';
    $found = false;
    foreach ($projects as $project) {
        $found = true;
        echo '<option value="' . $project['pro_id'] . '">' . $project['pro_name'] . '</option>';
    }
    if (!$found) {
        echo '<option value="" disabled selected>ไม่พบโครงการ</option>';
    }
    exit();
}

if (isset($_POST['function']) && $_POST['function'] == 'activity') {
    $id = $_POST['id'];
    $activityObj = new Activity();
    $activities = $activityObj->getActivitiesByPro(['pro_id' => $id]);
    echo '<option value="" disabled selected>เลือกกิจกรรม...</option>';
    $found = false;
    foreach ($activities as $activity) {
        $found = true;
        echo '<option value="' . $activity['act_id'] . '">' . $activity['act_name'] . '</option>';
    }
    if (!$found) {
        echo '<option value="" disabled selected>ไม่พบกิจกรรม</option>';
    }
    eactivityObj = new Activity();
    $activity = $activityObj->getActivityById(['act_id' => $id]);
    $act_money = $activity['act_money'] ?? 0;

    $payplanObj = new PayPlan();
    $sum_pay_data = $payplanObj->getSumPayMoneyByAct(['act_id' => $id]);
    $sum_pay = $sum_pay_data['sumPayMoneyAct'] ?? 0;

    $activity = $stmt->fetch();
    $act_money = $activity['act_money'];
    $stmt2 = $conn->prepare("SELECT SUM(pay_money) as sum_pay FROM payplan WHERE act_id = '$id'");
    $stmt2->execute();
    $sum_pay = $stmt2->fetch()['sum_pay'] ?? 0;
    $balance = $act_money - $sum_pay;
    echo number_format($balance, 2);
    exit();
}

// if (isset($_POST['function']) && $_POST['function'] == 'dep_order') {
//     $id = $_POST['id'];
//     $sql = "SELECT * FROM activity WHERE pro_id = '$id'";
//     $query = mysqli_query($connection, $sql);
//     foreach ($query as $value) {
//         echo '<option value="' . $value['act_id'] . '">' . $value['act_name'] . '</option>';
//     }
//     exit();
// }
