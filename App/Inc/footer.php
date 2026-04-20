<footer>
    <div class="footer clearfix mb-0 text-muted">
        <div class="float-left">
            <p>หากมีข้อส่งสัยเรื่องงบประมาณกรุณาติดต่องานนโยบายและแผน</p>
        </div>
        <div class="float-right">
            <p>2026 &copy; NAbudget <span class='text-danger'><i data-feather="heart"></i></span> by <a
                    href="#">งานนโยบายและแผน</a> V.1.0</p>
        </div>
    </div>
</footer>
</div>
</div>

<!-- สำหรับ modal ต้องการสอบถามว่าวาออกจากระบบไหม่ -->
<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
    Launch static backdrop modal
</button> -->

<!-- Modal -->
<div class="modal fade" id="logoutModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel" style="font-size: 2.2rem;">ออกจากระบบ</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5>ต้องการออกจากระบบใช่หรือไม่</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-info round" data-dismiss="modal">ยกเลิก</button>
                <a class="btn btn-outline-warning round" href="<?=  BASE_URL ?>/App/Auth/Views/logout.php">ตกลง</a>
            </div>
        </div>
    </div>
</div>
<!-- จบ modal -->

<!-- <script src="<?=  BASE_URL ?>/assets/js/bootstrap.js"></script>
<script src="<?=  BASE_URL ?>/assets/js/bootstrap.esm.min.js"></script> -->
<script src="<?=  BASE_URL ?>/assets/js/feather-icons/feather.min.js"></script>
<script src="<?=  BASE_URL ?>/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<!-- <script src="<?=  BASE_URL ?>/assets/js/app.js"></script> -->
<script src="<?=  BASE_URL ?>/assets/js/bootstrap.js"></script>

<script src="<?=  BASE_URL ?>/assets/vendors/chartjs/Chart.min.js"></script>
<script src="<?=  BASE_URL ?>/assets/vendors/apexcharts/apexcharts.min.js"></script>

<script src="<?=  BASE_URL ?>/assets/js/pages/dashboard.js"></script>

<script src="<?=  BASE_URL ?>/assets/vendors/simple-datatables/simple-datatables.js"></script>
<script src="<?=  BASE_URL ?>/assets/js/vendors.js"></script>

<script src="<?=  BASE_URL ?>/assets/js/main.js"></script>

<!-- script สำหรับปิด การแจ้งเตือน alert -->
<!-- <script>
    var myAlert = document.getElementById('myAlert')
    var bsAlert = new bootstrap.Alert(myAlert)
    var alertNode = document.querySelector('.alert')
    var alert = bootstrap.Alert.getInstance(alertNode)
    setTimeout(function() {
        // Closing the alert 
        alert.close()
    }, 3000);
</script> -->

</body>

</html>