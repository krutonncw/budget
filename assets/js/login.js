const sign_in_btn = document.querySelector("#sign-in-btn");
const sign_up_btn = document.querySelector("#sign-up-btn");
const container = document.querySelector(".container");
// สำหรับลงชื่อเข้าใช้
const userlogin = document.querySelector("#userlogin");
const passwordlogin = document.querySelector("#passwordlogin");
const login = document.querySelector("#login");
const uslogin = document.querySelector("#uslogin");

// สำหรับลงทะเบียน
const firstname = document.querySelector("#firstname");
const lastname = document.querySelector("#lastname");
const user = document.querySelector("#user");
const email = document.querySelector("#email");
const password = document.querySelector("#password");
const confirm = document.querySelector("#confirm");

const ftname = document.querySelector("#ftname");
const ltname = document.querySelector("#ltname");
const userRe = document.querySelector("#userRe");
const emailRe = document.querySelector("#emailRe");
const passwordRe = document.querySelector("#passwordRe");
const passwordCon = document.querySelector("#passwordCon");


sign_up_btn.addEventListener("click", () => {
    container.classList.add("sign-up-mode");
});

sign_in_btn.addEventListener("click", () => {
    container.classList.remove("sign-up-mode");
});

confirm.addEventListener("change", () => {
    if (password.value != confirm.value) {
        alert("รหัสผ่านไม่ตรงกัน กรุณาตรวจสอบอีกครั้ง");
    }
});
// เมื่อช่องรหัสไม่กรอกข้อมูล
passwordlogin.addEventListener("focusout", () => {
    if (passwordlogin.value == "") {

        login.classList.add("warning");
    }
});
passwordlogin.addEventListener("input", () => {

    login.classList.remove("warning");

});
userlogin.addEventListener("focusout", () => {
    if (userlogin.value == "") {
        uslogin.classList.add("warning");
    }
});
userlogin.addEventListener("input", () => {

    uslogin.classList.remove("warning");

});

// ลงทะเบียน
firstname.addEventListener("focusout", () => {
    if (firstname.value == "") {
        ftname.classList.add("warning");
    }
});
firstname.addEventListener("input", () => {

    ftname.classList.remove("warning");

});
lastname.addEventListener("focusout", () => {
    if (lastname.value == "") {
        ltname.classList.add("warning");
    }
});
lastname.addEventListener("input", () => {

    ltname.classList.remove("warning");

});
user.addEventListener("focusout", () => {
    if (user.value == "") {
        userRe.classList.add("warning");
    }
});
user.addEventListener("input", () => {

    userRe.classList.remove("warning");

});

email.addEventListener("focusout", () => {
    if (email.value == "") {

        emailRe.classList.add("warning");
    }
});
email.addEventListener("input", () => {

    emailRe.classList.remove("warning");

});
password.addEventListener("focusout", () => {
    if (password.value == "" || password.value.toString().length < 6) {

        passRe.classList.add("warning");
    }
});
password.addEventListener("input", () => {

    passRe.classList.remove("warning");

});
confirm.addEventListener("focusout", () => {
    if (confirm.value == "") {

        passCon.classList.add("warning");
    }
});
confirm.addEventListener("input", () => {

    passCon.classList.remove("warning");

});