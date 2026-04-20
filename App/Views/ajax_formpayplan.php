<?php
require_once BASE_PATH . "../../config.php";

//ตรวจสอบว่าเข้าสู่ระบบหรือยัง
require_once BASE_PATH . "/App/Auth/Controllers/auth.php";

// บน XAMPP
$servername = "localhost";
$username = "root";
$password = "";
$dbName = "na_budget";

// บนเว็บ ncwschool
// $servername = "localhost";
// $username = "na_budget";
// $password = "na2569";
// $dbName = "na_budget";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbName", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

if (isset($_POST['function']) && $_POST['function'] == 'project') {
    $id = $_POST['id'];
    $stmt = $conn->prepare("SELECT * FROM project WHERE dep_id = '$id'");
    $stmt->execute();
    echo '<option selected disabled>เลือกโครงการ...</option>';
    foreach ($stmt as $value) {
        echo '<option value="' . $value['pro_id'] . '">' . $value['pro_name'] . '</option>';
    }
    exit();
}

if (isset($_POST['function']) && $_POST['function'] == 'activity') {
    $id = $_POST['id'];
    $stmt = $conn->prepare("SELECT * FROM activity WHERE pro_id = '$id'");
    $stmt->execute();
    echo '<option selected disabled>เลือกกิจกรรม...</option>';
    foreach ($stmt as $value) {
        echo '<option value="' . $value['act_id'] . '">' . $value['act_name'] . '</option>';
    }
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
