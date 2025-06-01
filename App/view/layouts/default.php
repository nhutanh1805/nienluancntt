<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title><?= $this->e($title) ?></title>

  <!-- Styles -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="/css/trangchu.css" rel="stylesheet">


  <?= $this->section("page_specific_css") ?>
  <style>
 body {
  background-color: #fff; 
  color: #333; 
}

.responsive-video {
  width: 100%; 
  height: 50; 
  max-width: 100vw; 
  max-height: 90vh; 
  object-fit: cover;
}

</style>
</head>

<body">
  <header>
    <!-- Phần tiêu đề -->
    <div class="p-2 text-center bg-white border-bottom">
      <div class="container-fluid">
        <div class="row">
          <!-- Phần logo -->
          <div class="col-md-3 d-flex justify-content-center justify-content-md-start mb-3 mb-md-0">
  <a href="#!" class="ms-md-4 text-decoration-none">
    <h1 style="text-shadow: 2px 2px 4px rgba(0,0,0,0.3); font-weight: 900; font-style: italic; font-family: 'Poppins', sans-serif;">
      <span style="
        font-size: 3rem; 
        background: linear-gradient(45deg, #0066ff, #00ccff);
        -webkit-background-clip: text; 
        -webkit-text-fill-color: transparent; 
        text-shadow: 0 0 8px rgba(0,102,255,0.7);
        letter-spacing: 2px;
        ">
        Lap
      </span>
      <span style="
        font-size: 2rem; 
        color: #ff6f61; 
        text-shadow: 1px 1px 4px rgba(255,111,97,0.8);
        font-family: 'Georgia', serif;
        letter-spacing: 1.5px;
        ">
        Store
      </span>
    </h1>
  </a>
</div>

          <!-- Phần thanh tìm kiếm -->
          <div class="col-md-6 d-flex justify-content-center align-items-center mb-3 mb-md-0">
  <form action="/search" method="GET" class="d-flex w-100">
    <input type="text" class="form-control rounded-start border-0 shadow-sm px-3 py-2" name="query" placeholder="Tìm kiếm laptop..." required>
    <button type="submit" class="btn btn-primary ms-2 d-lg-flex px-4 py-2 rounded-end shadow-lg transition-all">
      <i class="fas fa-search"></i>
    </button>
  </form>
</div>

         <!-- Phần các biểu tượng và menu dropdown -->
<div class="col-md-3 d-flex justify-content-center justify-content-md-end align-items-center">
  <div class="d-flex">
    <!-- Biểu tượng giỏ hàng -->
    <a class="text-reset ms-3 position-relative" href="/cart" title="Giỏ hàng">
      <i class="fas fa-shopping-cart fa-lg"></i>
      <span class="badge rounded-pill bg-danger position-absolute top-0 start-100 translate-middle p-1">1</span>
    </a>
 <!-- Biểu tượng đơn hàng -->
 <a class="text-reset ms-3" href="/orders/index" title="Đơn hàng">
  <i class="fas fa-box fa-lg"></i>
</a>

    <!-- Biểu tượng ngôn ngữ -->
    <div class="dropdown ms-3" title="Ngôn ngữ">
      <a class="nav-link dropdown-toggle text-dark" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fa-solid fa-language fa-lg"></i>
      </a>
      <ul class="dropdown-menu shadow-lg rounded-3">
        <li><a class="dropdown-item" href="#">English</a></li>
        <li><a class="dropdown-item" href="#">Polski</a></li>
        <li><a class="dropdown-item" href="#">中文</a></li>
        <li><a class="dropdown-item" href="#">日本語</a></li>
        <li><a class="dropdown-item" href="#">iDeutsch</a></li>
        <li><a class="dropdown-item" href="#">Français</a></li>
        <li><a class="dropdown-item" href="#">Español</a></li>
        <li><a class="dropdown-item" href="#">Русский</a></li>
        <li><a class="dropdown-item" href="#">Português</a></li>
      </ul>
    </div>

<!-- Biểu tượng thông báo -->
<div class="dropdown ms-3" title="Thông báo mới">
  <a class="nav-link dropdown-toggle text-dark" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
    <i class="fas fa-bell fa-lg"></i>
  </a>
  <ul class="dropdown-menu shadow-lg rounded-3">
    <li><a class="dropdown-item" href="#">Tin tức mới nhất</a></li>
    <li><a class="dropdown-item" href="#">Cập nhật quan trọng</a></li>
    <li><a class="dropdown-item" href="#">Những điều thú vị</a></li>
  </ul>
</div>
  </div>
</div>

   <!-- Câu giới thiệu về cửa hàng -->
  <marquee class="mt-2 text-muted fs-4" behavior="scroll" direction="left" scrollamount="20">
  💎 <strong>LapStore</strong> – đỉnh cao thời thượng,  
  🖥️ Công nghệ hội tụ, dẫn đường tương lai.  
  💻 <strong>Laptop</strong> bền bỉ, dáng hình sang,  
  🎛️ Đẳng cấp dẫn lối, vững vàng bước đi.  
  🖥️ <strong>Màn hình</strong> sắc nét diệu kỳ,  
  🖱️ Trải nghiệm mượt lướt, tinh vi từng giờ.  
  💻 <strong>Phần cứng ổn</strong> – nét say sưa,  
  🧑‍💻 Học hành, công việc, chẳng thừa phút giây.  
</marquee>

    <!-- Phần menu điều hướng -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white mb-2">
  <div class="container-fluid mt-2">
    <button class="navbar-toggler mb-3" type="button" data-bs-toggle="collapse"
      data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
      aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item ms-1">
          <a class="btn btn-primary text-white shadow-sm px-3 py-2 d-flex align-items-center" href="/">
            <i class="fa-solid fa-house me-2"></i> TRANG CHỦ
          </a>
        </li>
        <li class="nav-item ms-1">
          <a class="btn btn-success text-white shadow-sm px-3 py-2 d-flex align-items-center" href="/product">
            <i class="fa-brands fa-product-hunt me-2"></i> SẢN PHẨM
          </a>
        </li>
        <li class="nav-item ms-1">
          <a class="btn btn-danger text-white shadow-sm px-3 py-2 d-flex align-items-center" href="/homeAmin">
            <i class="fa-solid fa-house me-2"></i> QUẢN TRỊ
          </a>
        </li>

      <!-- Tài khoản -->
<li class="nav-item ms-1 dropdown">
  <a class="btn btn-info text-white shadow-sm px-3 py-2 d-flex align-items-center dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
    <i class="fa-solid fa-user me-2"></i> TÀI KHOẢN
  </a>
  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
    <?php if (!AUTHGUARD()->isUserLoggedIn()) : ?>
      <li><a class="dropdown-item" href="/login">Đăng Nhập</a></li>
      <li><a class="dropdown-item" href="/register">Đăng Ký</a></li>
    <?php else : ?>
      <li><a class="dropdown-item" href="/account">Quản lý tài khoản</a></li>

      <!-- Thêm liên kết quản lý đơn hàng -->
      <li><a class="dropdown-item" href="/orders/index">Đơn hàng</a></li> <!-- Liên kết đến trang quản lý đơn hàng -->
      <li><a class="dropdown-item" href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Đăng Xuất</a></li>
      <form id="logout-form" class="d-none" action="/logout" method="POST"></form>
    <?php endif ?>
  </ul>
</li>

      <div class="collapse navbar-collapse" id="app-navbar-collapse">

        <!-- Left Side Of Navbar -->
        <div class="navbar-nav">
          &nbsp;
        </div>
        <ul class="navbar-nav ms-auto">
     
  </header>

  <?= $this->section("page") ?>

  <footer class="text-center text-lg-start text-light mt-4" style="background-color: #1a1a2e; box-shadow: 0 4px 8px rgba(0,0,0,0.3);">
  <div class="container p-4 pb-0">
    <section>
      <div class="row">
        <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
          <h6 class="text-uppercase mb-4 font-weight-bold" style="color:#e94560;">
            Slogan
          </h6>
          <p>
            Khám phá thế giới laptop đa dạng và đột phá, nơi mỗi chiếc máy là một tác phẩm công nghệ và là chìa khóa mở ra trải nghiệm số đỉnh cao. Hãy để chúng tôi đồng hành cùng bạn trên hành trình lựa chọn công cụ hoàn hảo – mở rộng giới hạn sáng tạo và hiệu suất làm việc!
          </p>
        </div>

        <hr class="w-100 clearfix d-md-none" />

        <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
          <h6 class="text-uppercase mb-4 font-weight-bold" style="color:#e94560;">Brand</h6>
          <p>
            <a class="text-light" href="#laptops" style="text-decoration:none;">LapTop Apple</a>
          </p>
          <p>
            <a class="text-light" href="#phones" style="text-decoration:none;">Laptop Dell</a>
          </p>
          <p>
            <a class="text-light" style="text-decoration:none;">Laptop Asus</a>
          </p>
          <p>
            <a class="text-light" style="text-decoration:none;">Laptop MSI</a>
          </p>
        </div>

        <hr class="w-100 clearfix d-md-none" />

        <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mt-3">
          <h6 class="text-uppercase mb-4 font-weight-bold" style="color:#e94560;">
            Useful links
          </h6>
          <p>
            <a class="text-light" style="text-decoration:none;">Your Account</a>
          </p>
          <p>
            <a class="text-light" style="text-decoration:none;">Become an Affiliate</a>
          </p>
          <p>
            <a class="text-light" style="text-decoration:none;">Shipping Rates</a>
          </p>
          <p>
            <a class="text-light" style="text-decoration:none;">Help</a>
          </p>
        </div>

        <hr class="w-100 clearfix d-md-none" />

        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
          <h6 class="text-uppercase mb-4 font-weight-bold" style="color:#e94560;">Contact</h6>
          <p><i class="fas fa-home mr-3"></i> VietNam</p>
          <p><i class="fas fa-envelope mr-3"></i> nhutanh1805vlog@gmail.com</p>
          <p><i class="fas fa-phone mr-3"></i> + 08 237 372 58</p>
          <p><i class="fas fa-print mr-3"></i> + 08 237 372 58</p>
        </div>
      </div>
    </section>

    <hr class="my-3" style="border-color:#555;" />

    <section class="p-3 pt-0">
      <div class="row d-flex align-items-center">
        <div class="col-md-7 col-lg-8 text-center text-md-start">
          <div class="p-3" style="color:#ccc;">
            © 2025 Copyright:
            <a class="text-light" href="http://nienluannganh.localhost/" style="text-decoration:none; font-weight:bold;">LapStore.com</a>
          </div>
        </div>

        <div class="col-md-5 col-lg-4 ml-lg-0 text-center text-md-end">
          <a class="btn btn-outline-light btn-floating m-1 social-icon" role="button" style="border-color:#e94560; color:#e94560;"><i
              class="fab fa-facebook-f"></i></a>

          <a class="btn btn-outline-light btn-floating m-1 social-icon" role="button" style="border-color:#e94560; color:#e94560;"><i
              class="fab fa-twitter"></i></a>

          <a class="btn btn-outline-light btn-floating m-1 social-icon" role="button" style="border-color:#e94560; color:#e94560;"><i
              class="fab fa-google"></i></a>

          <a class="btn btn-outline-light btn-floating m-1 social-icon" role="button" style="border-color:#e94560; color:#e94560;"><i
              class="fab fa-instagram"></i></a>
        </div>
      </div>
    </section>
  </div>

  <style>
    .social-icon:hover {
      background-color: #e94560 !important;
      color: #fff !important;
      transition: 0.3s ease-in-out;
    }
  </style>
</footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Lấy tất cả các liên kết danh mục
      const categoryLinks = document.querySelectorAll('.list-group-item');

      // Thêm sự kiện click cho từng liên kết
      categoryLinks.forEach(link => {
        link.addEventListener('click', function(event) {
          event.preventDefault();
          const categoryId = this.getAttribute('href').substring(1);
          const section = document.getElementById(categoryId);

          // Cuộn mượt đến phần mục tiêu
          section.scrollIntoView({
            behavior: 'smooth'
          });
        });
      });
    });
  </script>
  <script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.js"></script>
<script>
  let table = new DataTable('#contacts', {
    responsive: true,
    pagingType: 'simple_numbers'
  });
</script>

<script>
    window.onscroll = function(){
    if(document.documentElement.scrollTop > 100){
      document.querySelector('.backtop').classList.add('activeT');
    }else{
      document.querySelector('.backtop').classList.remove('activeT');
    }
  }
</script>
  </body>

</html>