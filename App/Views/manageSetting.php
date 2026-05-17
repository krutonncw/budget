<?php
// เรียกใช้งาน ไฟล์ autoload เพือให้โหลดคลาสต่าง ๆ มาทำงาน
require_once "../../config.php";

//ตรวจสอบว่าเข้าสู่ระบบหรือยัง
require_once BASE_PATH . "/App/Auth/Controllers/auth.php";

//ตรวจสอบระดับของสิทธิ์ว่าเป็น admin เปล่าหน้านี้เฉพาะ admin เท่านั้น
if ($_SESSION['role'] > 2) {
    header("location: ../../views/budget/groupCardShow.php");
}

use Ncw\Models\Setting;

require_once BASE_PATH . "/App/Inc/header.php";
require_once BASE_PATH . "/App/Inc/sidebar.php";

$settingObj = new Setting();
$settings = $settingObj->getSetting();
// print_r($settings);exit;
?>

<!-- แสดงข้อมูลในหน้าหลัก -->
<section id="content-types " class="d-flex justify-content-center">
    <div class="col-md-8 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">ตั้งค่าระบบ</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form action="../Controllers/updateSetting.php" class="form form-vertical" method="post"
                        enctype="multipart/form-data">
                        <div class=" form-body">
                            <img class="card-img-top rounded-circle mx-auto d-block" <?php echo "src=" . $retVal = ($settings['logo_url'] != "") ? BASE_URL . $settings['logo_url'] : BASE_URL . "/assets/images/logo/logo_main.png"; ?> alt="Logo Main"
                                style="width: 200px; text-align: center; margin-top:10px;" />
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group has-icon-left">
                                        <label for="first-name-icon">ชื่อระบบ</label>
                                        <div class="position-relative">
                                            <input type="text" class="form-control round" placeholder="ชื่อระบบ" id="first-name-icon"
                                                name="sys_name" <?php $retVal = ($settings['sys_name'] == "") ? "" : $settings['sys_name'];
                                                                echo 'value="' . $retVal . '"'; ?>>
                                            <div class="form-control-icon">
                                                <i data-feather="layout"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group has-icon-left">
                                        <label for="first-name-icon">แผนปฏิบัติการประจำ</label>
                                        <div class="position-relative">
                                            <input type="text" class="form-control round" placeholder="ปีการศึกษา/ปีงบประมาณ" id="first-name-icon"
                                                name="year_name" <?php $retVal = ($settings['year_name'] == "") ? "" : $settings['year_name'];
                                                                    echo 'value="' . $retVal . '"'; ?>>
                                            <div class="form-control-icon">
                                                <i data-feather="book"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group has-icon-left">
                                        <label for="first-name-icon">ชื่อโรงเรียน</label>
                                        <div class="position-relative">
                                            <input type="text" class="form-control round" placeholder="ชื่อโรงเรียน" id="first-name-icon"
                                                name="school_name" <?php $retVal = ($settings['school_name'] == "") ? "" : $settings['school_name'];
                                                                    echo 'value="' . $retVal . '"'; ?>>
                                            <div class="form-control-icon">
                                                <i data-feather="book-open"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group has-icon-left">
                                        <label for="first-name-icon">ส่วนราชการ</label>
                                        <div class="position-relative">
                                            <input type="text" class="form-control round" placeholder="ชื่อส่วนราชการ" id="first-name-icon"
                                                name="title_name" <?php $retVal = ($settings['title_name'] == "") ? "" : $settings['title_name'];
                                                                    echo 'value="' . $retVal . '"'; ?>>
                                            <div class="form-control-icon">
                                                <i data-feather="file-text"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group has-icon-left">
                                        <label for="first-name-icon">ชื่อผู้อำนวยการโรงเรียน</label>
                                        <div class="position-relative">
                                            <input type="text" class="form-control round" placeholder="ชื่อผู้อำนวยการโรงเรียน" id="first-name-icon"
                                                name="dir_name" <?php $retVal = ($settings['dir_name'] == "") ? "" : $settings['dir_name'];
                                                                echo 'value="' . $retVal . '"'; ?>>
                                            <div class="form-control-icon">
                                                <i data-feather="user"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group has-icon-left">
                                        <label for="first-name-icon">ชื่อรองผู้อำนวยการโรงเรียน กลุ่มบริหารบประมาณ</label>
                                        <div class="position-relative">
                                            <input type="text" class="form-control round" placeholder="ชื่อผู้อำนวยการโรงเรียน" id="first-name-icon"
                                                name="man_name" <?php $retVal = ($settings['man_name'] == "") ? "" : $settings['man_name'];
                                                                echo 'value="' . $retVal . '"'; ?>>
                                            <div class="form-control-icon">
                                                <i data-feather="user"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group has-icon-left">
                                        <label for="first-name-icon">ชื่อแผนงานโรงเรียน</label>
                                        <div class="position-relative">
                                            <input type="text" class="form-control round" placeholder="ชื่อแผนงานโรงเรียน" id="first-name-icon"
                                                name="plan_name" <?php $retVal = ($settings['plan_name'] == "") ? "" : $settings['plan_name'];
                                                                    echo 'value="' . $retVal . '"'; ?>>
                                            <div class="form-control-icon">
                                                <i data-feather="user"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group has-icon-left">
                                        <label for="menu_project-icon">สถานะการเพิ่มโครงการ</label>
                                        <select class="choices form-select round" name="menu_project">
                                            <option value="0" <?php if ($settings['menu_project'] == 0) echo "selected"; ?>>ไม่เปิดใช้งาน</option>
                                            <option value="1" <?php if ($settings['menu_project'] == 1) echo "selected"; ?>>เปิดใช้งาน</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group has-icon-left">
                                        <label for="menu_activity-icon">สถานะการเพิ่มกิจกรรม</label>
                                        <select class="choices form-select round" name="menu_activity">
                                            <option value="0" <?php if ($settings['menu_activity'] == 0) echo "selected"; ?>>ไม่เปิดใช้งาน</option>
                                            <option value="1" <?php if ($settings['menu_activity'] == 1) echo "selected"; ?>>เปิดใช้งาน</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group has-icon-left">
                                        <label for="menu_payplan-icon">สถานะการขออนุมัติ</label>
                                        <select class="choices form-select round" name="menu_payplan">
                                            <option value="0" <?php if ($settings['menu_payplan'] == 0) echo "selected"; ?>>ไม่เปิดใช้งาน</option>
                                            <option value="1" <?php if ($settings['menu_payplan'] == 1) echo "selected"; ?>>เปิดใช้งาน</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group has-icon-left">
                                        <label for="file-id-icon">อัพโหลดโลโก้</label>
                                        <div class="position-relative">
                                            <input type="file" class="form-control round" name="logo_url" id="logo_url">
                                            <div class="form-control-icon">
                                                <i data-feather="file-plus"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ส่งข้อมูลแบบซ้อนไปด้วยเพื่อประมวลผล -->
                            <div class="col-12 d-flex justify-content-end">
                                <a href='showGroupCard.php' class='btn btn-outline-warning round mr-2'>ยกเลิก</a>
                                <button type="submit" class="btn btn-outline-primary round">บันทึก</button>
                            </div>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</section>
<!-- จบส่วนของ modal -->

<!-- นำเข้าส่วน footer page -->
<?php require_once BASE_PATH . "/App/Inc/footer.php"; ?>