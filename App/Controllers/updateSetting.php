<?php
require_once "../../config.php";

use Ncw\Models\Setting;

$settingObj = new Setting();
$settings = $_REQUEST;
// print_r($settings);

$new_file_name = null; 

if (isset($_FILES['logo_url']) && $_FILES['logo_url']['error'] === UPLOAD_ERR_OK) {
    
    // 1. ตรวจสอบประเภทไฟล์ที่อนุญาต (Whitelist)
    $allowed_exts = ['jpg', 'jpeg', 'png', 'gif'];
    $file_name = $_FILES['logo_url']['name'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    
    if (!in_array($file_ext, $allowed_exts)) {
        die("ไม่อนุญาตให้ไฟล์ประเภทนี้");
    }

    // 2. สร้างชื่อไฟล์ใหม่เพื่อป้องกันชื่อซ้ำและอักขระพิเศษ
    $new_file_name = "logo_main." . $file_ext;

    // 3. กำหนดโฟลเดอร์ปลายทาง (ใช้ path จริง)
    $upload_dir = $_SERVER['DOCUMENT_ROOT'] . BASE_URL . '/assets/images/logo/'; 
    
    // สร้างโฟลเดอร์ถ้ายังไม่มี
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    $dest_path = $upload_dir . $new_file_name;

    // 4. ย้ายไฟล์
    if (move_uploaded_file($_FILES['logo_url']['tmp_name'], $dest_path)) {
        echo "อัปโหลดสำเร็จ: " . $new_file_name;
        // เก็บ $new_file_name ลง Database
    } else {
        echo "เกิดข้อผิดพลาดในการย้ายไฟล์";
    }
}

// เช็คว่าถ้ามีการ upload รูปใหม่มาไหม ถ้ามีก็ให้ใช้ $avatar ที่ได้จากข้างบน แต่ถ้าไม่ก็ใช้ข้อมูลเดิม
if ($new_file_name) {
    if (!empty($settings['logo_url'])) {
        // ลบรูปเก่า
        $old_file_path = $_SERVER['DOCUMENT_ROOT'] . BASE_URL . $settings['logo_url'];
        if (file_exists($old_file_path)) {
            unlink($old_file_path);
        }
    }
    $settings['logo_url'] = '/assets/images/logo/' . $new_file_name;
}

$settings['set_id'] = 1; // เพิ่ม set_id สำหรับการอัปเดต

if ($settingObj->updateSetting($settings)) {
    header("location: ../Views/manageSetting.php");
} else {
    header("location: ../Views/error.php");
}

