function DangKy(e){
    event.preventDefault();
    var email = document.getElementById("inputEmail4").value;
    var password = document.getElementById("inputPassword4").value;
    var rePassword = document.getElementById("inputrePassword4").value;
    var brday = document.getElementById("inputBrday").value;
    var sigin = {
        Email : email,
        Password : password,
        RePassword : rePassword,
        Brday : brday,
    }
    var json = JSON.stringify(sigin);
    localStorage.setItem(email, json);
    alert("Đăng Ký Thành Công");
}

function DangNhap(e){
    event.preventDefault();
    var email = document.getElementById("inputEmail4").value;
    var password = document.getElementById("inputPassword4").value;
    var user = localStorage.getItem(email);
    var data = JSON.parse(user);
    if(email == data.Email && password == data.Password){
        alert("Đăng Nhập Thành Công!");
        window.location.href="TrangChu.html";
    }
    else{
        alert("Đăng nhập thất bại.");
    }
    
}

// Initialization for ES Users
import { Carousel, initMDB } from "mdb-ui-kit";

initMDB({ Carousel });