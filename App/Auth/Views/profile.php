<?php
// เรียกใช้งาน ไฟล์ autoload เพือให้โหลดคลาสต่าง ๆ มาทำงาน
require $_SERVER['DOCUMENT_ROOT'] . "/budget/vendor/autoload.php";

//ตรวจสอบว่าเข้าสู่ระบบหรือยัง
require $_SERVER['DOCUMENT_ROOT'] . "/budget/App/Auth/Controllers/auth.php";

// นำเข้าส่วนหัวและเมนูของ page
require $_SERVER['DOCUMENT_ROOT'] . "/budget/App/Inc/header.php";
require $_SERVER['DOCUMENT_ROOT'] . "/budget/App/Inc/sidebar.php";

?>


<!-- แสดงข้อมูลในหน้าหลัก -->
<div class="row" id="profile1">
    <div class="col-md-4 col-sm-12">
        <div class="card-container">
            <div class="upper-container">
                <div class="image-container">
                    <img src="/budget/assets/images/profile/han.jpg" />
                </div>
            </div>
            <div class="lower-container">
                <div>
                    <h3>นายบรรหาญ เดชมา</h3>
                    <h4>กลุ่มสาระวิทยาศาสตร์</h4>
                    <h4>และเทคโนโลยี</h4>
                </div>
                <div>
                    <p>Wep Programming Developer</p>
                </div>
                <div>
                    <a href="#" class="btn">View profile</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-12">
        <div class="card-container">
            <div class="upper-container">
                <div class="image-container">
                    <img src="/budget/assets/images/profile/avartar.jpeg" />
                </div>
            </div>
            <div class="lower-container">
                <div>
                    <h3>นายปุณณรัตน์ ทองธรรม</h3>
                    <h4>กลุ่มสาระวิทยาศาสตร์</h4>
                    <h4>และเทคโนโลยี</h4>
                </div>
                <div>
                    <p>Wep Designer</p>
                </div>
                <div>
                    <a href="#" class="btn">View profile</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-12">
        <div class="card-container">
            <div class="upper-container">
                <div class="image-container">
                    <img src="/budget/assets/images/profile/avartar.jpeg" />
                </div>
            </div>
            <div class="lower-container">
                <div>
                    <h3>นายไพฑูรย์ นพกาศ</h3>
                    <h4>กลุ่มสาระวิทยาศาสตร์</h4>
                    <h4>และเทคโนโลยี</h4>
                </div>
                <div>
                    <p>Wep Programming Developer</p>
                </div>
                <div>
                    <a href="#" class="btn">View profile</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row" id="profile2">
    <div class="col-md-12 col-sm-12">
        <div class="card-container">
            <div class="upper-container">
                <div class="image-container">
                    <img src="/budget/assets/images/profile/logo.gif" />
                </div>
            </div>
            <div class="lower-container">
                <div>
                    <h6>นางดาวเรือง เพียรพานิช</h6>
                    <h6>นายอุทิศ แจ้งถิ่นป่า</h6>
                    <h6>นางสาวทิพมาศ กลทิพย์</h6>
                    <h6>นางฤทัยรัตน์ เกษการณ์</h6>
                    <h6>นางเยาวเรศ กันเพ็ง</h6>
                    <h6>นางสาวฐิติกาญจน์ จันทร์ล้อมเพชร</h6>
                    <h6 style="color: #7F00FF;">กลุ่มสาระวิทยาศาสตร์และเทคโนโลยี</h6>
                </div>
                <div>
                    <p>Inspection department</p>
                </div>
                <div>
                    <a href="#" class="btn">View profile</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- จบส่วนของ modal -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.5.1/gsap.min.js"></script>
<script>
    gsap.from("#profile1", {
        duration: 2,
        y: -500,
        opacity: 0,
        scale: 0.5
    });
    gsap.from("#profile2", {
        duration: 2,
        y: 500,
        opacity: 0,
        scale: 0.5
    });
</script>
<!-- นำเข้าส่วน footer page -->
<?php include_once '../../inc/footer.php' ?>