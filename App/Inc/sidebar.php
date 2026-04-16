<body>
    <div id="app">
        <div id="sidebar" class='active'>
            <div class="sidebar-wrapper active">
                <div class="sidebar-header" style="text-align:center">
                    <img src="/budget/assets/images/logo_main.png" alt="" srcset="" style="width: 150px;height:150px;">
                </div>
                <div class="">
                    <ul class="menu">
                        <li class='sidebar-title'>ปีการศึกษา 2569</li>
                        <li class="sidebar-item ">
                            <a href="/budget/App/Views/showGroupCard.php" class='sidebar-link'>
                                <i data-feather="home" width="20"></i>
                                <span>ภาพรวมการใช้เงิน</span>
                            </a>
                        </li>

                        <li class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i data-feather="triangle" width="20"></i>
                                <span>สรุปการใช้เงิน</span>
                            </a>

                            <ul class="submenu ">
                                <li>
                                    <a href="/budget/App/Views/showDepartment.php">ข้อมูลกลุ่มสาระ</a>
                                </li>
                                <li>
                                    <a href="/budget/App/Views/showProject.php">ข้อมูลโครงการ</a>
                                </li>
                                <li>
                                    <a href="/budget/App/Views/showActivity.php">ข้อมูลกิจกรรม</a>
                                </li>
                                <li>
                                    <a href="/budget/App/Views/showPayPlan.php">ข้อมูลการเบิก</a>
                                </li>
                                <!-- <li>
                                    <a href="/budget/App/Views/getPayByDate.php">สรุปตามช่วงเวลา</a>
                                </li> -->
                            </ul>
                        </li>

                        <!-- เข้าถึงได้ตั้งแต่ละดับแผนงานกลุ่มขึ้นไป (7) เท่านั้น -->
                        <?php
                        if ($_SESSION['role'] <= 7) {
                            echo "
                            <li class='sidebar-item  has-sub'>
                                <a href='#' class='sidebar-link'>
                                    <i data-feather='pen-tool' width='20'></i>
                                    <span>เบิกเงินตามแผน</span>
                                </a>

                                <ul class='submenu '>
                                    <li>
                                        <a href='/budget/App/Views/formPayPlan.php'>ใบคำขออนมุติใช้เงิน</a>
                                    </li>
                                    <li>
                                        <a href='/budget/App/Views/showPayPlan.php'>ข้อมูลการเบิก</a>
                                    </li>
                                </ul>
                            </li>

                            <!-- <li class='sidebar-item'>
                                <a href='/budget/document/แบบสรุปโครงการ2564.docx' class='sidebar-link'>
                                    <i data-feather='triangle' width='20'></i>
                                    <span>แบบสรุปโครงการปี 2564</span>
                                </a>
                            </li>

                            <li class='sidebar-item'>
                                <a href='https://drive.google.com/drive/folders/10lbb2oCK1EN5yT9p9R833f19MvhAm9VG?usp=sharing' class='sidebar-link'>
                                    <i data-feather='triangle' width='20'></i>
                                    <span>ประชุมจัดทำแผนปีการศึกษา 2566</span>
                                </a>
                            </li> 

                            <li class='sidebar-item'>
                                <a href='#' class='sidebar-link'>
                                    <i data-feather='triangle' width='20'></i>
                                    <span>อัปโหลดไฟล์ประมาณการ</span>
                                </a>
                            </li> -->

                            <li class='sidebar-item'>
                                <a href='/budget/App/Views/manageActivity.php' class='sidebar-link'>
                                    <i data-feather='clipboard' width='20'></i>
                                    <span>จัดการข้อมูลกิจกรรม</span>
                                </a>
                            </li>
                            ";
                        }
                        ?>

                        <!-- เข้าถึงได้เฉพาะ ระดับ admin เท่านั้น -->
                        <?php
                        if ($_SESSION['role'] == 1) {
                            echo "
                                <li class='sidebar-item'>
                                    <a href='/budget/App/Views/manageProject.php' class='sidebar-link'>
                                        <i data-feather='book' width='20'></i>
                                        <span>จัดการข้อมูลโครงการ</span>
                                    </a>
                                </li>
                                ";
                        }
                        ?>


                        <!-- เข้าถึงได้เฉพาะ ระดับ admin ผู้ปฏิบัติงาน เจ้าหน้าที่การเงิน เจ้าหน้าที่พัสดุ เจ้าหน้าที่ เท่านั้น -->
                        <?php
                        if ($_SESSION['role'] <= 5) {
                            echo "
                                <li class='sidebar-item  has-sub'>
                                    <a href='#' class='sidebar-link'>
                                    <i data-feather='edit-2' width='20'></i>
                                    <span>จัดการสถานะการเบิก</span>
                                    </a>
                                    <ul class='submenu '>                                    
                                    <li>
                                        <a href='/budget/App/Views/showPayPlan.php'>จัดการสถานะตามการเบิก</a>
                                    </li>  
                                    <!-- <li>
                                        <a href='/budget/App/Auth/views/activityShow.php'>จัดการสถานะตามกิจกรรม</a>
                                    </li>  -->
                                    </ul>
                                </li>
                                ";
                        }
                        ?>

                        <!-- เข้าถึงได้เฉพาะ ระดับ admin เท่านั้น -->
                        <?php
                        if ($_SESSION['role'] == 1) {
                            echo "                                
                                <li class='sidebar-item  has-sub'>
                                    <a href='#' class='sidebar-link'>
                                    <i data-feather='edit' width='20'></i>
                                    <span>จัดการข้อมูลการเบิก</span>
                                    </a>
                                    <ul class='submenu '>
                                    <li>
                                        <a href='/budget/App/Views/formPayPlan.php'>เพิ่มข้อมูลการเบิก</a>
                                    </li>
                                    <li>
                                        <a href='/budget/App/Views/searchEditReport.php'>แก้ไขข้อมูลใบคำขอ</a>
                                    </li>
                                    <li>
                                        <a href='/budget/App/Views/searchEditMoney.php'>แก้ยอดเงินเบิก</a>
                                    </li> 
                                    <li>
                                        <a href='/budget/App/Views/showGroupCard_admin.php'>ตรวจสอบยอดเงินรวม</a>
                                    </li>
                                    <li>
                                        <a href='/budget/App/Views/showProject_admin.php'>ตรวจสอบยอดเงินโครงการ</a>
                                    </li>
                                    <li>
                                        <a href='/budget/App/Views/showActivity_admin.php'>ตรวจสอบยอดเงินกิจกรรม</a>
                                    </li>
                                    <li>
                                        <a href='/budget/App/Views/showProjectExcel.php' target='_blank'>Excel โครงการ</a>
                                    </li>
                                    <li>
                                        <a href='/budget/App/Views/showActivityExcel.php' target='_blank'>Excel กิจกรรม</a>
                                    </li>
                                    <li>
                                        <a href='/budget/App/Views/showPayPlanExcel.php' target='_blank'>Excel ข้อมูลการเบิก</a>
                                    </li>
                                    </ul>
                                </li>
                                ";
                        }
                        ?>

                        <!-- เข้าถึงได้เฉพาะ ระดับ admin เท่านั้น -->
                        <?php
                        if ($_SESSION['role'] == 1) {
                            echo "
                                <li class='sidebar-item  has-sub'>
                                    <a href='#' class='sidebar-link'>
                                    <i data-feather='user' width='20'></i>
                                    <span>จัดการบัญชีผู้ใช้</span>
                                    </a>
                                    <ul class='submenu '>
                                        <li>
                                            <a href='/budget/App/Auth/Views/showPerson.php'>ข้อมูลสมาชิก</a>
                                        </li>
                                        <li>
                                            <a href='/budget/App/Auth/Views/register.php'>เพิ่มสมาชิก</a>
                                        </li>  
                                    </ul>
                                </li>
                                ";
                        }
                        ?>
                        <!-- <li class="sidebar-item ">
                            <a href="https://ncwschool.com/budget" class='sidebar-link'>
                                <i data-feather="home" width="20"></i>
                                <span>ขู้อมูลปีการศึกษา 2566</span>
                            </a>
                        </li> -->

                        <li class="sidebar-item ">
                            <a href="#" data-toggle="modal" data-target="#logoutModal" class='sidebar-link'>
                                <i data-feather="home" width="20"></i>
                                <span>ออกจากระบบ</span>
                            </a>

                        </li>
                    </ul>
                    <!--ปิดแท็ก menu -->
                </div>
                <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
            </div>
        </div>

        <!-- ส่วนแสดงเมนูบาร์บนด้านขวา -->
        <div id="main">
            <nav class="navbar navbar-header navbar-expand navbar-light">
                <a class="sidebar-toggler" href="#"><span class="navbar-toggler-icon"></span></a>
                <button class="btn navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav d-flex align-items-center navbar-light ml-auto">
                        <li class="dropdown">
                            <a href="#" data-toggle="dropdown"
                                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                                <div class="avatar avatar-xl  mr-1">
                                    <?php

                                    use Ncw\Auth\Models\Person;

                                    $avatarObj = new Person;
                                    $avatar = $avatarObj->getPersonById($_SESSION['id']);
                                    ?>
                                    <img <?php echo "src=" . $retVal = ($avatar['avatar'] != "") ? $avatar['avatar'] : "/budget/assets/images/avatar/femalavatar.svg"; ?> alt="Card image cap"
                                        style="width:60px;" alt="" srcset="">
                                </div>
                                <div class="d-none d-md-block d-lg-inline-block">Hi,<?php echo $_SESSION['username']; ?>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" <?php echo 'href="/budget/App/Auth/Views/showEditPerson.php?id=' . $_SESSION['id'] . '&action=update' . '"'; ?>><i data-feather="user"></i> แก้ไขข้อมูล</a>
                                <a class="dropdown-item " <?php echo 'href="/budget/App/Auth/Views/showEditPass.php?id=' . $_SESSION['id'] . '&action=repassword' . '"'; ?>><i data-feather="lock"></i>
                                    เปลี่ยนรหัสผ่าน</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal"><i
                                        data-feather="log-out"></i> ออกจากระบบ</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav><!-- แสดงเมนูบนขวา -->