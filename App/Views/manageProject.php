<?php
// เรียกใช้งาน ไฟล์ autoload เพือให้โหลดคลาสต่าง ๆ มาทำงาน
require_once "../../config.php";

//ตรวจสอบว่าเข้าสู่ระบบหรือยัง
require_once BASE_PATH . "/App/Auth/Controllers/auth.php";

use Ncw\Models\Project;
use Ncw\Models\Department;

require_once BASE_PATH . "/App/Inc/header.php";
require_once BASE_PATH . "/App/Inc/sidebar.php";

$projectObj = new Project();
$projects = $projectObj->getAllProjects();

$departmentObj = new Department();
$departments = $departmentObj->getAllDepartments();
?>

<!-- แสดงข้อมูลในหน้าหลัก -->
<div class="main-content container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>จัดการข้อมูลโครงการ</h3>
            </div>
            <?php if ($settings['menu_project'] == 1) { ?>
                <div class="col-12 col-md-6 order-md-2 order-first text-md-right">
                    <button class="btn btn-success round" data-toggle="modal" data-target="#addProjectModal">
                        <i data-feather="plus-circle"></i> เพิ่มโครงการ
                    </button>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- แสดง alert เมื่อมี msg -->
    <?php if (isset($_GET['msg'])) { ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($_GET['msg']); ?>
            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php } ?>

    <section class="section">
        <div class="card">
            <div class="card-header">
                รายการโครงการทั้งหมด
            </div>
            <div class="card-body">
                <table class='table table-striped' id="table1">
                    <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>รหัสโครงการ</th>
                            <th>ชื่อโครงการ</th>
                            <th>กลุ่มสาระ</th>
                            <th>จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        foreach ($projects as $project) {
                            $n++;
                            echo "
                <tr>
                <!-- <td>{$n}</td> -->
                  <td>{$project['pro_id']}</td>
                  <td>{$project['pro_code']}</td>
                  <td>{$project['pro_name']}</td>
                  <td>{$project['dep_name']}</td>
                  <td>
                    <button class='btn btn-outline-warning btn-sm round mr-1' data-toggle='modal' data-target='#editProjectModal{$project['pro_id']}'>
                      <i data-feather='edit'></i> แก้ไข
                    </button>
                    <button class='btn btn-outline-danger btn-sm round' data-toggle='modal' data-target='#deleteProjectModal{$project['pro_id']}'>
                      <i data-feather='trash-2'></i> ลบ
                    </button>
                  </td>
                </tr>
              ";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div> <!-- จบส่วนแสดงข้อมูลในหน้าหลัก -->

<!-- ===== Modal เพิ่มโครงการ ===== -->
<div class="modal fade" id="addProjectModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="addProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="../Controllers/addProject.php" method="post">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="addProjectModalLabel" style="font-size: 1.8rem;">เพิ่มโครงการ</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="add_pro_code" class="form-label">เลขรหัสโครงการ</label>
                        <input type="text" class="form-control" name="add_pro_code" id="add_pro_code" required>
                    </div>
                    <div class="mb-3">
                        <label for="add_pro_name" class="form-label">ชื่อโครงการ</label>
                        <input type="text" class="form-control" name="pro_name" id="add_pro_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="add_dep_id" class="form-label">กลุ่มสาระ</label>
                        <select class="form-select form-control" name="dep_id" id="add_dep_id" required>
                            <option value="">-- เลือกกลุ่ม --</option>
                            <?php
                            foreach ($departments as $department) {
                                echo "<option value='{$department['dep_id']}'>{$department['dep_name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary round" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-success round">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ===== Modal แก้ไขโครงการ (สร้างให้แต่ละรายการ) ===== -->
<?php foreach ($projects as $project) { ?>
    <div class="modal fade" id="editProjectModal<?php echo $project['pro_id']; ?>" data-backdrop="static"
        data-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="../Controllers/updateProject.php" method="post">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" style="font-size: 1.8rem;">แก้ไขโครงการ</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="pro_id" value="<?php echo $project['pro_id']; ?>">
                        <div class="mb-3">
                            <label class="form-label">เลขรหัสโครงการ</label>
                            <input type="text" class="form-control" name="pro_code"
                                value="<?php echo htmlspecialchars($project['pro_code']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">ชื่อโครงการ</label>
                            <input type="text" class="form-control" name="pro_name"
                                value="<?php echo htmlspecialchars($project['pro_name']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">กลุ่มสาระ</label>
                            <select class="form-select form-control" name="dep_id" required>
                                <option value="">-- เลือกกลุ่ม --</option>
                                <?php
                                foreach ($departments as $department) {
                                    $selected = ($department['dep_id'] == $project['dep_id']) ? "selected" : "";
                                    echo "<option value='{$department['dep_id']}' {$selected}>{$department['dep_name']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary round" data-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-warning round">บันทึกการแก้ไข</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>

<!-- ===== Modal ยืนยันลบโครงการ (สร้างให้แต่ละรายการ) ===== -->
<?php foreach ($projects as $project) { ?>
    <div class="modal fade" id="deleteProjectModal<?php echo $project['pro_id']; ?>" data-backdrop="static"
        data-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" style="font-size: 1.8rem;">ยืนยันการลบ</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p style="font-size: 1.2rem;">ต้องการลบโครงการ <strong>
                            <?php echo htmlspecialchars($project['pro_name']); ?>
                        </strong> ใช่หรือไม่?</p>
                    <p class="text-danger"><small>* หากโครงการนี้มีกิจกรรมอยู่ การลบอาจทำให้ข้อมูลกิจกรรมมีปัญหา</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary round" data-dismiss="modal">ยกเลิก</button>
                    <a href="../Controllers/deleteProject.php?pro_id=<?php echo $project['pro_id']; ?>"
                        class="btn btn-danger round">ลบ</a>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<!-- นำเข้าส่วน footer page -->
<?php require_once BASE_PATH . "/App/Inc/footer.php"; ?>