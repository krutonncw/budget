<?php
// เรียกใช้งาน ไฟล์ autoload เพือให้โหลดคลาสต่าง ๆ มาทำงาน
require_once "../../config.php";

//ตรวจสอบว่าเข้าสู่ระบบหรือยัง
require_once BASE_PATH . "/App/Auth/Controllers/auth.php";

use Ncw\Models\Activity;
use Ncw\Models\Project;
use Ncw\Models\BudgetType;

require_once BASE_PATH . "/App/Inc/header.php";
require_once BASE_PATH . "/App/Inc/sidebar.php";

$activityObj = new Activity();
$activitys = $activityObj->getAllActivitys();

$projectObj = new Project();
$projects = $projectObj->getAllProjects();

$budgettypeObj = new BudgetType();
$budgettypes = $budgettypeObj->getAllBudgetTypes();

$currentUserId = $_SESSION['id'];
$isAdmin = ($_SESSION['role'] == 1);

// print_r($settings);
?>

<!-- แสดงข้อมูลในหน้าหลัก -->
<div class="main-content container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>จัดการข้อมูลกิจกรรม</h3>
            </div>
            <?php if ($settings['menu_activity'] == 1) { ?>
                <div class="col-12 col-md-6 order-md-2 order-first text-md-right">
                    <button class="btn btn-success round" data-toggle="modal" data-target="#addActivityModal">
                        <i data-feather="plus-circle"></i> เพิ่มกิจกรรม
                    </button>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- แสดง alert เมื่อมี msg -->
    <?php if (isset($_GET['msg'])) { ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($_GET['msg']); ?>
            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php } ?>

    <section class="section">
        <div class="card">
            <div class="card-header">
                รายการกิจกรรมทั้งหมด
            </div>
            <div class="card-body">
                <table class='table table-striped' id="table1">
                    <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>ชื่อกิจกรรม</th>
                            <th>โครงการ</th>
                            <th>กลุ่ม</th>
                            <th>ประเภทงบ</th>
                            <th>งบที่ได้รับ</th>
                            <th>จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        foreach ($activitys as $activity) {
                            $n++;
                            $canManage = ($activity['create_by'] == $currentUserId) || $isAdmin;
                            echo "
                <tr>
                  <td>{$n}</td>
                  <td>{$activity['act_name']}</td>
                  <td>{$activity['pro_name']}</td>
                  <td>{$activity['dep_name']}</td>
                  <td>{$activity['bgt_name']}</td>
                  <td>" . number_format($activity['act_money'], 2) . "</td>
                  <td>
              ";
                            if ($canManage) {
                                echo "
                    <button class='btn btn-outline-warning btn-sm round mr-1' data-toggle='modal' data-target='#editActivityModal{$activity['act_id']}'>
                      <i data-feather='edit'></i> แก้ไข
                    </button>
                    <button class='btn btn-outline-danger btn-sm round' data-toggle='modal' data-target='#deleteActivityModal{$activity['act_id']}'>
                      <i data-feather='trash-2'></i> ลบ
                    </button>
                ";
                            } else {
                                echo "<span class='text-muted'>-</span>";
                            }
                            echo "
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

<!-- ===== Modal เพิ่มกิจกรรม ===== -->
<div class="modal fade" id="addActivityModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="addActivityModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="../Controllers/addActivity.php" method="post">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="addActivityModalLabel" style="font-size: 1.8rem;">เพิ่มกิจกรรม</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="add_act_name" class="form-label">ชื่อกิจกรรม</label>
                        <input type="text" class="form-control" name="act_name" id="add_act_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="add_pro_id" class="form-label">โครงการ</label>
                        <select class="form-select form-control" name="pro_id" id="add_pro_id" required>
                            <option value="">-- เลือกโครงการ --</option>
                            <?php
                            foreach ($projects as $project) {
                                echo "<option value='{$project['pro_id']}'>{$project['pro_name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="add_bgt_id" class="form-label">ประเภทเงินงบประมาณ</label>
                        <select class="form-select form-control" name="bgt_id" id="add_bgt_id" required>
                            <option value="">-- เลือกประเภทงบ --</option>
                            <?php
                            foreach ($budgettypes as $budgettype) {
                                echo "<option value='{$budgettype['bgt_id']}'>{$budgettype['bgt_name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="add_act_money" class="form-label">งบประมาณที่ได้รับ</label>
                        <input type="number" step="0.01" class="form-control" name="act_money" id="add_act_money"
                            required>
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

<!-- ===== Modal แก้ไขกิจกรรม (สร้างให้แต่ละรายการที่มีสิทธิ์) ===== -->
<?php foreach ($activitys as $activity) {
    $canManage = ($activity['create_by'] == $currentUserId) || $isAdmin;
    if (!$canManage)
        continue;
?>
    <div class="modal fade" id="editActivityModal<?php echo $activity['act_id']; ?>" data-backdrop="static"
        data-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="../Controllers/updateActivity.php" method="post">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title" style="font-size: 1.8rem;">แก้ไขกิจกรรม</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="act_id" value="<?php echo $activity['act_id']; ?>">
                        <div class="mb-3">
                            <label class="form-label">ชื่อกิจกรรม</label>
                            <input type="text" class="form-control" name="act_name"
                                value="<?php echo htmlspecialchars($activity['act_name']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">โครงการ</label>
                            <select class="form-select form-control" name="pro_id" required>
                                <option value="">-- เลือกโครงการ --</option>
                                <?php
                                foreach ($projects as $project) {
                                    $selected = ($project['pro_id'] == $activity['pro_id']) ? "selected" : "";
                                    echo "<option value='{$project['pro_id']}' {$selected}>{$project['pro_name']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">ประเภทเงินงบประมาณ</label>
                            <select class="form-select form-control" name="bgt_id" required>
                                <option value="">-- เลือกประเภทงบ --</option>
                                <?php
                                foreach ($budgettypes as $budgettype) {
                                    $selected = ($budgettype['bgt_id'] == $activity['bgt_id']) ? "selected" : "";
                                    echo "<option value='{$budgettype['bgt_id']}' {$selected}>{$budgettype['bgt_name']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">งบประมาณที่ได้รับ</label>
                            <input type="number" step="0.01" class="form-control" name="act_money"
                                value="<?php echo $activity['act_money']; ?>" required>
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

<!-- ===== Modal ยืนยันลบกิจกรรม (สร้างให้แต่ละรายการที่มีสิทธิ์) ===== -->
<?php foreach ($activitys as $activity) {
    $canManage = ($activity['create_by'] == $currentUserId) || $isAdmin;
    if (!$canManage)
        continue;
?>
    <div class="modal fade" id="deleteActivityModal<?php echo $activity['act_id']; ?>" data-backdrop="static"
        data-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" style="font-size: 1.8rem;">ยืนยันการลบ</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p style="font-size: 1.2rem;">ต้องการลบกิจกรรม <strong>
                            <?php echo htmlspecialchars($activity['act_name']); ?>
                        </strong> ใช่หรือไม่?</p>
                    <p class="text-danger"><small>* การลบกิจกรรมจะทำให้ข้อมูลการเบิกที่เกี่ยวข้องมีปัญหา</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary round" data-dismiss="modal">ยกเลิก</button>
                    <a href="../Controllers/deleteActivity.php?act_id=<?php echo $activity['act_id']; ?>"
                        class="btn btn-danger round">ลบ</a>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<!-- นำเข้าส่วน footer page -->
<?php require_once BASE_PATH . "/App/Inc/footer.php"; ?>