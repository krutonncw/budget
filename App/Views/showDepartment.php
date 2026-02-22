<?php
// เรียกใช้งาน ไฟล์ autoload เพือให้โหลดคลาสต่าง ๆ มาทำงาน
require $_SERVER['DOCUMENT_ROOT'] . "/budget/vendor/autoload.php";

//ตรวจสอบว่าเข้าสู่ระบบหรือยัง
require $_SERVER['DOCUMENT_ROOT'] . "/budget/App/Auth/Controllers/auth.php";

use Ncw\Models\Department;

require $_SERVER['DOCUMENT_ROOT'] . "/budget/App/Inc/header.php";
require $_SERVER['DOCUMENT_ROOT'] . "/budget/App/Inc/sidebar.php";

?>

<!-- แสดงข้อมูลในหน้าหลัก -->
<div class="main-content container-fluid">
  <div class="page-title">
    <div class="row">
      <div class="col-12 col-md-6 order-md-1 order-last">
        <h3>ข้อมูลฝ่าย/กลุ่มสาระ</h3>
      </div>
    </div>
  </div>
  <section class="section">
    <div class="card">
      <div class="card-header">
        ข้อมูลฝ่าย/กลุ่มสาระ
      </div>
      <div class="card-body">
        <table class='table table-striped' id="table1">
          <thead>
            <tr>
              <th>#</th>
              <th>รหัสกลุ่มสาระ</th>
              <th>ฝ่าย/กลุ่มสาระ</th>
              <th>ดูข้อมูล</th>
            </tr>
          </thead>
          <tbody>
            <form action="" method="get">
              <?php

              $departmentObj = new Department();

              $departments = $departmentObj->getAllDepartments();
              $n = 0;
              foreach ($departments as $department) {
                $n++;
                echo "
								<tr>
									<td>{$n}</td>                                                
                  <td>{$department['dep_id']}</td>
                  <td>{$department['dep_name']}</td>
									<td>
										<a href='showActByDep.php?dep_id={$department['dep_id']}' class='mr-2 btn btn-outline-info round'>ดูข้อมูล</a>													
									</td>
								</tr>
								";
              }
              ?>
            </form>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div> <!-- จบส่วนแสดงข้อมูลในหน้าหลก -->

<!-- นำเข้าส่วน footer page -->
<?php require $_SERVER['DOCUMENT_ROOT'] . "/ncwbudget/App/Inc/footer.php"; ?>