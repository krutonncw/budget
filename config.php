<?php
// config.php
// ตัวแปรนี้จะเก็บ Path เต็มของเครื่อง Server จนถึงโฟลเดอร์ที่ไฟล์นี้อยู่
define('BASE_PATH', __DIR__); 
// print_r(BASE_PATH);

// ถ้าต้องการทำ Link สำหรับ CSS/JS (ฝั่ง Client)
// ตัวแปรนี้จะหาชื่อโฟลเดอร์ปัจจุบันให้เอง ไม่ว่าจะชื่อ budget หรือชื่ออื่น
$folder_name = basename(__DIR__);
define('BASE_URL', '/' . $folder_name);
// print_r(BASE_URL);

// เรียกใช้งาน ไฟล์ autoload เพือให้โหลดคลาสต่าง ๆ มาทำงาน
require_once BASE_PATH . "/vendor/autoload.php";