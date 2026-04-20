<?php
// เรียกใช้งาน ไฟล์ autoload เพือให้โหลดคลาสต่าง ๆ มาทำงาน
require __DIR__ . "/vendor/autoload.php";

use Ncw\Models\Department;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/style.css" />
    <!-- ใส่ icon บนแถบ title bar -->
    <link rel="shortcut icon" href="<?php echo $base_url; ?>/assets/images/budgetIcon.svg" type="image/x-icon">
    <title>NAbudget</title>
</head>

<body>
    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">
                <form action='App/Auth/Controllers/checkLogin.php' class="sign-in-form" method="POST">
                <!-- <form action='#' class="sign-in-form" method="POST"> // เปิดเพื่อไม่ให้สามารถใช้งาน login ได้-->
                    <?php if (isset($_GET['msg'])) {
                        echo '<h2 class="alert" >ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง</h2> ';
                    } ?>
                    <h2 class="title">ลงชื่อเข้าใช้</h2>
                    <div class="input-field" id="username">
                        <i class="fas fa-user"></i>
                        <input type="text" name="username" id="username" placeholder="ชื่อผู้ใช้" required />
                    </div>
                    <div class="input-field" id="login">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" id="password" placeholder="รหัสผ่าน" required />
                    </div>
                    <input type="submit" value="ลงชื่อเข้าใช้" class="btn solid" />
                    <!-- <p class="social-text">หรือลงชื่อเข้าใช้ในบัญชี</p>
                    <div class="social-media">
                        <a href="#" class="social-icon">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-google"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div> -->
                </form>

                <form action="App/Auth/Controllers/addPerson.php" class="sign-up-form" method="get" name="new">
                    <h2 class="title">ลงทะเบียนใหม่</h2>
                    <!-- <h4 style="font-size: 35px;font-weight: 350;color: #f11818;">เฉพาะบุคลากรของโรงเรียนนิยมศิลป์อนุสรณ์เท่านั้น</h4> -->
                    <h4 style="font-size: 20px;font-weight: 350;color: #f11818;">ติดต่อเจ้าหน้าที่แผนงานโรงเรียน !</h4>
                    <!-- <div class="input-field" id="ftname">
                        <i class="fas fa-user"></i>
                        <input type="text" name="firstname" id="firstname" placeholder="ชื่อ" required />
                    </div>
                    <div class="input-field" id="ltname">
                        <i class="fas fa-user"></i>
                        <input type="text" name="lastname" id="lastname" placeholder="นามสกุล" required />
                    </div>
                    <div class="input-field" id="dep_id">
                        <i class="fas fa-user"></i>
                        <select class="select-field" name="dep_id">
                            <option value="">ฝ่าย/กลุ่มสาระ</option>
                            <?php
                            $departmentObj = new Department;
                            $departments = $departmentObj->getAllDepartments();
                            foreach ($departments as $department) {
                                echo "<option value='{$department['dep_id']}' >{$department['dep_name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="input-field" id="userRe">
                        <i class="fas fa-user"></i>
                        <input type="text" name="username" id="username" placeholder="ชื่อผู้ใช้ภาษาอังกฤษ" required />
                    </div>
                    <div class="input-field" id="emailRe">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" id="email" placeholder="อีเมล์" />
                    </div>
                    <div class="input-field" id="passRe">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" id="password" placeholder="รหัสผ่าน" required minlength="6" maxlength="10" />
                    </div>
                    <div class="input-field" id="passCon">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="confirm" id="confirm" placeholder="รหัสผ่านอีกครั้ง" required />
                    </div>
                    <input type="submit" class="btn" value="ลงทะเบียนใหม่" /> -->
                    <!-- <p class="social-text">หรือลงชื่อเข้าใช้ในบัญชี</p>
                    <div class="social-media">
                        <a href="#" class="social-icon">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-google"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div> -->
                </form>
            </div>
        </div>

        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>ลงทะเบียนใหม่</h3>
                    <h4 style="font-size: 20px;font-weight: 350;color: #fff34d;">เฉพาะบุคลากรของโรงเรียนนิยมศิลป์อนุสรณ์</h4>
                    <p>
                        ถ้าท่านยังไม่มีบัญชีให้ลงทะเบียนใหม่
                    </p>
                    <button class="btn transparent" id="sign-up-btn">
                        ลงทะเบียนใหม่
                    </button>
                </div>
                <img src="<?php echo $base_url; ?>/assets/images/log.svg" class="image" alt="" />
            </div>
            <div class="panel right-panel">
                <div class="content">
                    <h3>ลงชื่อเข้าใช้</h3>
                    <p>
                        ถ้าท่านมีบัญชีอยู่แล้วสามารถลงชื่อเข้าใช้งานได้เลยครับ
                    </p>
                    <button class="btn transparent" id="sign-in-btn">
                        ลงชื่อเข้าใช้
                    </button>
                </div>
                <img src="<?php echo $base_url; ?>/assets/images/register.svg" class="image" alt="" />
            </div>
        </div>
    </div>

    <script src="<?php echo $base_url; ?>/assets/js/login.js"></script>
</body>

</html>