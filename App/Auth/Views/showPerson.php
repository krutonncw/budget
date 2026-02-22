<?php
// เรียกใช้งาน ไฟล์ autoload เพือให้โหลดคลาสต่าง ๆ มาทำงาน
require $_SERVER['DOCUMENT_ROOT'] . "/ncwbudget/vendor/autoload.php";

//ตรวจสอบว่าเข้าสู่ระบบหรือยัง
require $_SERVER['DOCUMENT_ROOT'] . "/budget/App/Auth/Controllers/auth.php";

use Ncw\Auth\Models\Person;

require $_SERVER['DOCUMENT_ROOT'] . "/budget/App/Inc/header.php";
require $_SERVER['DOCUMENT_ROOT'] . "/budget/App/Inc/sidebar.php";

?>

<!-- แสดงข้อมูลในหน้าหลัก -->
<div class="main-content container-fluid">
  <div class="page-title">
    <div class="row">
      <div class="col-12 col-md-6 order-md-1 order-last">
        <h3>ข้อมูลสมาชิก</h3>
      </div>
    </div>
  </div>
  <section class="section">
    <div class="card">
      <div class="card-header">
        <i class="icofont-user-alt-7 icofont-md"></i> ข้อมูลสมาชิก
      </div>
      <div class="card-body">
        <table class='table table-striped' id="table1">
          <thead>
            <tr>
              <th>#</th>
              <th>รูป</th>
              <th>คำนำหน้า</th>
              <th>ชื่อ</th>
              <th>สกุล</th>
              <th>กลุ่ม</th>
              <th>ชื่อผู้ใช้</th>
              <th>จัดการ</th>
            </tr>
          </thead>
          <tbody>
            <form action="" method="get">
              <?php

              $personObj = new Person();

              $persons = $personObj->getAllPersons();
              $n = 0;
              foreach ($persons as $person) {
                $n++;
                $avatar = ($person['avatar'] != "") ? $person['avatar'] : "/budget/assets/images/avatar/femalavatar.svg";
                echo "
                  <tr>
                    <td>{$n}</td>
                    <td><img src='{$avatar}' class='avatar' style='width:50px;height:50px;'></td>
                    <td>{$person['gender']}</td>
                    <td>{$person['firstname']}</td>
                    <td>{$person['lastname']}</td>                    
                    <td>{$person['dep_name']}</td>												
                    <td>{$person['username']}</td>
                    
                    <td>
                      <a href='showEditPerson.php?id={$person['id']}&action=update' class='mr-2 btn btn-outline-info round'>แก้ไข</a>
                      <button type='button' data-id='{$person['id']}'  class='btn btn-outline-danger round' onclick='confirmDelete(this);'  data-toggle='modal' data-target='#del' >ลบ</button>
                      <a href='showEditRole.php?id={$person['id']}' class='btn btn-outline-primary round' >สิทธิ์</a>
                      <a href='showEditPass.php?id={$person['id']}&action=repassword' class='btn btn-outline-warning round' >รหัสผ่าน</a>
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
<!-- ดึงข้อมูลคนที่เลือกเข้ามา -->
<!-- เริ่มส่วยของ modal -->
<!-- ตัว tigger เอาด้านล่างใส่ไป button -->
<!-- data-toggle='modal' data-target='#authority' data-backdrop='false' id='setauth' -->
<div class="modal-info mr-1 mb-1 d-inline-block">
  <!--info theme Modal -->
  <div class="modal fade text-left" id="del" tabindex="-1" role="dialog" aria-labelledby="myModalLabel130"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
      <form class="modal-content" action="../Controllers/updateAuth.php" id="form-delete-user">
        <div class="modal-content">
          <div class="modal-header bg-danger">
            <h5 class="modal-title white" id="myModalLabel130">การลบข้อมูลสมาชิก</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <i data-feather="x"></i>
            </button>
          </div>
          <div class="modal-body">
            <!-- ส่งข้อมูลแบบซ่อนไปด้วยเพื่อใช้ในการประมวลผล -->
            <input type="hidden" name="action" id="action" value="delete">
            <input type="hidden" name="id" id="id" value="">
            <!-- เริ่มส่วนบอดี้ของ modal เพื่อไว้ใส่ข้อมูบ -->
            <h3>ต้องการลบข้อมูลใช่หรือไม่</h3>
            <h5 id="show-url"></h5>
            <!-- จบส่วนบอดี้ modal -->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary round" data-dismiss="modal">
              <i class="bx bx-x d-block d-sm-none"></i>
              <span class="d-none d-sm-block">ยกเลิก</span>
            </button>
            <button type="submit" form="form-delete-user" class="btn btn-outline-danger round">
              <i class="bx bx-x d-block d-sm-none"></i>
              <span class="d-none d-sm-block">ลบข้อมูล</span>
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- จบส่วนของ modal -->


<script>
  function confirmDelete(self) {
    let id = self.getAttribute("data-id");
    // console.log(id);
    var myModal = document.getElementById('del');
    var show_url = document.getElementById('show-url');
    var userID = document.getElementById('id');
    show_url.innerHTML = "รหัสสมาชิกนี้ : " + id;
    document.querySelector("#form-delete-user").id.value = id;
    userID.id.value = id;

    // myModal.addEventListener('show.bs.modal', function(e) {            

    // });
  }
</script>

<!-- นำเข้าส่วน footer page -->
<?php require $_SERVER['DOCUMENT_ROOT'] . "/budget/App/Inc/footer.php"; ?>