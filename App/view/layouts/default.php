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

 <!-- Demo chatbot -->
<style>
  #chatbot-toggle {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: #0d6efd;
    color: white;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    font-size: 28px;
    border: none;
    cursor: pointer;
    z-index: 1001;
  }

  #chatbot-box {
    position: fixed;
    bottom: 90px;
    right: 20px;
    width: 300px;
    height: 400px;
    background: white;
    border: 1px solid #ccc;
    border-radius: 12px;
    display: none;
    flex-direction: column;
    z-index: 1000;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
  }

  #chatbot-header {
    background: #0d6efd;
    color: white;
    padding: 10px;
    border-radius: 12px 12px 0 0;
  }

  #chatbot-messages {
    flex: 1;
    padding: 10px;
    overflow-y: auto;
    font-size: 14px;
  }

  #chatbot-input-area {
    padding: 10px;
    border-top: 1px solid #ddd;
    display: flex;
    gap: 5px;
  }

  #chatbot-input {
    flex: 1;
    padding: 5px;
  }

  .chatbot-message {
    margin-bottom: 8px;
  }

  .chatbot-message.user {
    text-align: right;
    color: #0d6efd;
  }

  .chatbot-message.bot {
    text-align: left;
    color: #333;
  }
</style>

<button id="chatbot-toggle">💬</button>

<div id="chatbot-box">
  <div id="chatbot-header">🤖 Chat với bot</div>
  <div id="chatbot-messages"></div>
  <div id="chatbot-input-area">
    <input type="text" id="chatbot-input" placeholder="Nhập tin nhắn..." />
    <button id="chatbot-send">Gửi</button>
  </div>
</div>

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
    <button type="submit" class="btn btn-success ms-2 d-lg-flex px-4 py-2 rounded-end shadow-lg transition-all">
      <i class="fas fa-search"></i>
    </button>
  </form>
</div>



        <!-- Phần các biểu tượng và menu dropdown -->
<div class="col-md-3 d-flex justify-content-center justify-content-md-end align-items-center">
  <div class="d-flex align-items-center">

    <!-- Giỏ hàng -->
    <a class="text-reset ms-3 position-relative" href="/cart" title="Giỏ hàng">
      <i class="fas fa-shopping-cart fa-lg"></i>
      <span class="badge rounded-pill bg-danger position-absolute top-0 start-100 translate-middle p-1">1</span>
    </a>

    <!-- Đơn hàng -->
    <a class="text-reset ms-3" href="/orders/index" title="Đơn hàng">
      <i class="fas fa-box fa-lg"></i>
    </a>

    <!-- Hướng dẫn mua hàng -->
<div class="dropdown ms-3" title="Hướng dẫn mua hàng">
  <a
    class="nav-link dropdown-toggle text-dark p-0"
    href="#"
    role="button"
    id="guideDropdown"
    data-bs-toggle="dropdown"
    aria-expanded="false"
    style="font-size: 1.25rem;"
  >
    <i class="fas fa-book"></i>
  </a>
  <div
    class="dropdown-menu dropdown-menu-end shadow-lg rounded-4 p-4"
    aria-labelledby="guideDropdown"
    style="min-width: 350px; background: #fff; border: 1px solid #ddd;"
  >
    <h6 class="dropdown-header fw-bold mb-3 text-primary border-bottom pb-2">
      Hướng Dẫn Mua Hàng
    </h6>
    <table class="table table-sm table-borderless mb-0">
      <tbody>
        <tr>
          <td class="fw-bold text-secondary" style="width: 40px;">1</td>
          <td>Chọn sản phẩm bạn muốn mua.</td>
        </tr>
        <tr>
          <td class="fw-bold text-secondary">2</td>
          <td>Thêm sản phẩm vào giỏ hàng.</td>
        </tr>
        <tr>
          <td class="fw-bold text-secondary">3</td>
          <td>Kiểm tra giỏ hàng cập nhật số lượng và tiến hành thanh toán.</td>
        </tr>
        <tr>
          <td class="fw-bold text-secondary">4</td>
          <td>Truy cập đơn hàng để xem trạng thái đơn hàng.</td>
        </tr>
        <tr>
          <td class="fw-bold text-secondary">5</td>
          <td>Chờ nhận hàng và thanh toán nếu cần.</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

    <!-- Ngôn ngữ -->
    <div class="dropdown ms-3" title="Ngôn ngữ">
      <a class="nav-link dropdown-toggle text-dark p-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fa-solid fa-language fa-lg"></i>
      </a>
      <ul class="dropdown-menu shadow-lg rounded-3">
        <li><a class="dropdown-item" href="#">English</a></li>
        <li><a class="dropdown-item" href="#">Polski</a></li>
        <li><a class="dropdown-item" href="#">中文</a></li>
        <li><a class="dropdown-item" href="#">日本語</a></li>
        <li><a class="dropdown-item" href="#">Deutsch</a></li>
        <li><a class="dropdown-item" href="#">Français</a></li>
        <li><a class="dropdown-item" href="#">Español</a></li>
        <li><a class="dropdown-item" href="#">Русский</a></li>
        <li><a class="dropdown-item" href="#">Português</a></li>
      </ul>
    </div>

    <!-- Thông báo -->
    <div class="dropdown ms-3" title="Thông báo mới">
      <a class="nav-link dropdown-toggle text-dark p-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
          <h6 class="text-uppercase mb-4 font-weight-bold" style="color:#e94560;">THƯƠNG HIỆU</h6>
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
  Khám Phá Thêm
</h6>
<ul class="list-unstyled small">
  <li class="mb-2 mx-auto mt-3">
    <a href="/blog" class="text-light text-decoration-none d-flex align-items-center">
      <i class="fas fa-newspaper me-2"></i> Tin Tức Công Nghệ Mới
    </a>
  </li>
  <li class="mb-2 mx-auto mt-3">
    <a href="/reviews" class="text-light text-decoration-none d-flex align-items-center">
      <i class="fas fa-star me-2"></i> Đánh Giá Chuyên Gia
    </a>
  </li>


  </li>
  <li class="mb-2 mx-auto mt-3">
    <a href="/deals" class="text-light text-decoration-none d-flex align-items-center">
      <i class="fas fa-tags me-2"></i> Khuyến Mãi & Ưu Đãi
    </a>
  </li>
</ul>

        </div>

        <hr class="w-100 clearfix d-md-none" />

        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
          <h6 class="text-uppercase mb-4 font-weight-bold" style="color:#e94560;">LIÊN HỆ</h6>
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


 <!-- Demo chatbot -->

<script>
  document.getElementById('toggle-guide').addEventListener('click', function() {
    const guideTable = document.getElementById('guide-table');
    if (guideTable.style.display === 'none' || guideTable.style.display === '') {
      guideTable.style.display = 'block';
    } else {
      guideTable.style.display = 'none';
    }
  });
</script>
<script>
  const toggleBtn = document.getElementById('chatbot-toggle');
  const chatbotBox = document.getElementById('chatbot-box');
  const sendBtn = document.getElementById('chatbot-send');
  const input = document.getElementById('chatbot-input');
  const messages = document.getElementById('chatbot-messages');

  toggleBtn.addEventListener('click', () => {
    chatbotBox.style.display = chatbotBox.style.display === 'flex' ? 'none' : 'flex';
  });

  sendBtn.addEventListener('click', sendMessage);
  input.addEventListener('keydown', (e) => {
    if (e.key === 'Enter') sendMessage();
  });

  function sendMessage() {
    const text = input.value.trim();
    if (text === '') return;

    addMessage(text, 'user');
    input.value = '';

    // Giả lập bot trả lời
    setTimeout(() => {
      const response = getBotResponse(text);
      addMessage(response, 'bot');
    }, 500);
  }

  function addMessage(text, sender) {
    const div = document.createElement('div');
    div.className = 'chatbot-message ' + sender;
    div.textContent = text;
    messages.appendChild(div);
    messages.scrollTop = messages.scrollHeight;
  }

  function getBotResponse(input) {
  input = input.toLowerCase();

  const contains = (keywords) => keywords.some(keyword => input.includes(keyword));

  if (contains(['mở cửa', 'giờ mở', 'giờ làm việc'])) {
    return 'Shop mở cửa từ 8h sáng đến 9h tối mỗi ngày nha!';
  }

  if (contains(['giao hàng', 'ship', 'vận chuyển', 'chuyển hàng'])) {
    return 'Bọn mình giao hàng toàn quốc, nhận trong 1-3 ngày á!';
  }

  if (contains(['bảo hành', 'lỗi', 'hỏng', 'bị hư'])) {
    return 'Sản phẩm được bảo hành chính hãng 12 tháng nhen bạn!';
  }

  if (contains(['đổi', 'trả', 'hoàn hàng', 'đổi sản phẩm'])) {
    return 'Bạn được đổi trả trong vòng 7 ngày nếu sản phẩm lỗi do nhà sản xuất nha!';
  }

  if (contains(['thanh toán', 'trả tiền', 'chuyển khoản', 'vnpay', 'momo'])) {
    return 'Bạn có thể thanh toán qua VNPAY, Momo, thẻ ngân hàng hoặc khi nhận hàng nha!';
  }

  if (contains(['liên hệ', 'số điện thoại', 'hotline', 'gọi điện'])) {
    return 'Bạn gọi hotline 0823737258 hoặc inbox fanpage để được hỗ trợ liền tay nha!';
  }

  if (contains(['khuyến mãi', 'giảm giá', 'sale', 'ưu đãi', 'mã giảm'])) {
    return 'Hiện đang có chương trình giảm 10% cho đơn trên 10 triệu nha, nhanh tay kẻo lỡ!';
  }

  if (contains(['alo', 'hi', 'chào', 'hello', 'yo', 'ê'])) {
    return 'Chào bạn 👋 Có gì cần tụi mình hỗ trợ hông nè?';
  }

  if (contains(['sản phẩm', 'laptop', 'máy tính', 'máy', 'thiết bị'])) {
    return 'Bọn mình có nhiều mẫu laptop từ Dell, Asus, Lenovo, Macbook... bạn tìm dòng nào nè?';
  }

  if (contains(['bao lâu', 'mất bao lâu', 'khi nào nhận', 'thời gian giao'])) {
    return 'Thường bạn sẽ nhận hàng trong 1-3 ngày tuỳ khu vực đó nha!';
  }

  if (contains(['còn hàng', 'có sẵn', 'hết hàng'])) {
    return 'Bạn ơi, mẫu đó còn hàng nha, bạn đặt luôn kẻo hết á!';
  }

  if (contains(['trả góp', 'mua góp', 'trả dần'])) {
    return 'Shop hỗ trợ trả góp qua thẻ tín dụng, thủ tục đơn giản cực luôn!';
  }

  if (contains(['pin', 'dung lượng pin', 'thời lượng pin'])) {
    return 'Laptop tụi mình bán đều có pin dùng từ 5-8 tiếng tuỳ dòng nha!';
  }

  if (contains(['cấu hình', 'cpu', 'ram', 'ổ cứng'])) {
    return 'Bạn cần laptop làm việc hay chơi game? Tụi mình có cấu hình từ i3 đến i9 luôn!';
  }

  if (contains(['giá', 'bao nhiêu tiền', 'mắc không', 'đắt'])) {
    return 'Tụi mình có giá từ 5 triệu tới 70 triệu, tuỳ dòng, bạn muốn dòng nào mình tư vấn nha!';
  }

  if (contains(['cài win', 'cài phần mềm', 'office'])) {
    return 'Tụi mình có hỗ trợ cài đặt Win bản quyền và phần mềm cơ bản nha!';
  }

  if (contains(['bán phụ kiện', 'chuột', 'tai nghe', 'balo'])) {
    return 'Tụi mình có bán phụ kiện luôn như chuột, tai nghe, balo chính hãng xịn sò nha!';
  }

  if (contains(['shop ở đâu', 'địa chỉ', 'cửa hàng'])) {
    return 'Bọn mình ở 123 Nguyễn Văn ABC, Q.1, TP.HCM, bạn ghé chơi nha!';
  }

  if (contains(['thời gian làm việc', 'giờ làm việc', 'làm việc mấy giờ'])) {
    return 'Shop mở cửa từ 8h sáng đến 9h tối mỗi ngày nha!';
  }

  if (contains(['hàng chính hãng', 'auth', 'chính hãng'])) {
    return 'Tất cả sản phẩm bên mình đều là hàng chính hãng, có hoá đơn và bảo hành đầy đủ nha!';
  }

  if (contains(['laptop gaming', 'chơi game', 'game'])) {
    return 'Tụi mình có các dòng gaming như Asus TUF, Dell G15, Acer Nitro cực chiến luôn!';
  }

  if (contains(['laptop văn phòng', 'học tập', 'làm việc'])) {
    return 'Mấy dòng nhẹ như Dell Vostro, Asus Vivobook, Lenovo Ideapad xài học tập là siêu ổn nha!';
  }

  if (contains(['macbook', 'apple'])) {
    return 'Tụi mình có đủ loại Macbook từ Air đến Pro nha, bạn cần chip M1, M2 hay M3 nè?';
  }

  if (contains(['sinh viên', 'ưu đãi sinh viên'])) {
    return 'Sinh viên được giảm thêm 5% và tặng combo phụ kiện nha bạn!';
  }

  if (contains(['trễ', 'chậm', 'chưa nhận', 'không thấy hàng'])) {
    return 'Bạn ơi, để mình kiểm tra đơn của bạn nha! Inbox page hoặc gọi hotline giúp mình nhen.';
  }

  if (contains(['hướng dẫn đặt hàng', 'đặt như thế nào', 'mua hàng'])) {
    return 'Bạn chỉ cần chọn sản phẩm, bấm “Thêm vào giỏ” và điền thông tin là tụi mình giao tận nhà!';
  }

  if (contains(['giỏ hàng', 'thanh toán giỏ'])) {
    return 'Bạn vào giỏ hàng ở góc phải màn hình để kiểm tra và thanh toán nha!';
  }

  if (contains(['lỗi web', 'không vào được'])) {
    return 'Bạn thử load lại trang hoặc chuyển sang trình duyệt khác giùm mình nhen!';
  }

  if (contains(['đắt nhất', 'mắc nhất'])) {
    return 'Hiện tại shop có MSI Creator Z16P B12UGST i7 (050VN) là đắt nhất với 72 củ khoai ạ!';
  }

  if (contains(['hóa đơn', 'xuất hóa đơn', 'hóa đơn đỏ'])) {
  return 'Có nhen! Tụi mình hỗ trợ xuất hóa đơn VAT cho công ty luôn!';
}

 if (contains(['MSI', 'msi', 'em ét ai'])) {
  return 'Bạn muốn hỏi gì về dòng máy MSI hiện đang có trên shop dạ!';
}

if (contains(['DELL', 'dell', 'đeo'])) {
  return 'Shop mình có dòng máy DELL nè hỏi gì!';
}

if (contains(['chi nhánh', 'ở đâu', 'chi nhánh shop ở đâu'])) {
  return 'Hiện tại shop chưa có chi nhánh chính thức mà chỉ có hoạt động trên website thôi nha!';
}

if (contains(['macbook air m1'])) {
  return 'Macbook Air M1 bên mình có giá từ 18tr, pin trâu, học tập văn phòng siêu mượt nha!';
}

if (contains(['macbook air m2'])) {
  return 'Macbook Air M2 là dòng mới, mỏng nhẹ và mạnh hơn M1. Bạn muốn bản 8GB hay 16GB RAM nè?';
}

if (contains(['macbook pro m3'])) {
  return 'Macbook Pro M3 là dòng cao cấp cho dân đồ hoạ, cấu hình cực mạnh luôn đó bạn!';
}

if (contains(['dell inspiron'])) {
  return 'Dell Inspiron phù hợp làm việc, học tập và độ bền tốt. Bên mình đang sale 15% nhen!';
}

if (contains(['dell g15', 'dell gaming'])) {
  return 'Dell G15 là laptop gaming mạnh mẽ, card rời RTX chạy game mượt khỏi chê nha!';
}

if (contains(['asus tuf'])) {
  return 'Asus TUF Gaming có thiết kế chiến, card rời mạnh, phù hợp game thủ bạn nha!';
}

if (contains(['asus vivobook'])) {
  return 'Asus Vivobook bên mình có dòng chạy chip i5 Gen 13, thiết kế đẹp, nhẹ và pin trâu!';
}

if (contains(['lenovo ideapad'])) {
  return 'Lenovo IdeaPad là dòng quốc dân cho sinh viên học online, giá chỉ từ 9 triệu nha!';
}

if (contains(['lenovo legion'])) {
  return 'Legion là dòng cao cấp chơi game cực đỉnh của Lenovo, cấu hình i7 + RTX siêu mượt luôn!';
}

if (contains(['hp pavilion'])) {
  return 'HP Pavilion có thiết kế đẹp, màn hình Full HD sắc nét và gõ phím siêu thích nha!';
}

if (contains(['msi modern'])) {
  return 'MSI Modern dòng nhẹ mỏng, pin tốt cho dân văn phòng. Giá từ 12 triệu bạn nhé!';
}

if (contains(['có hỗ trợ kỹ thuật', 'bị lỗi cần sửa', 'sửa laptop'])) {
  return 'Bên mình có đội kỹ thuật hỗ trợ kiểm tra máy miễn phí tại cửa hàng nha!';
}

if (contains(['thay pin', 'sửa màn hình', 'nâng cấp ổ cứng', 'nâng ram'])) {
  return 'Tụi mình có dịch vụ thay pin, nâng RAM, SSD chính hãng luôn nha!';
}

if (contains(['dán màn hình', 'dán bảo vệ'])) {
  return 'Có nha! Dán màn hình chống trầy chỉ từ 100k, bạn mang máy tới shop nha!';
}

if (contains(['giảm thêm không', 'còn giảm nữa không', 'mặc cả'])) {
  return 'Tụi mình đang có giá tốt nhất thị trường rồi á, có mã giảm thêm 5% cho đơn đầu tiên nha!';
}

if (contains(['giao COD không', 'trả tiền khi nhận'])) {
  return 'Có nha! Bạn có thể kiểm tra hàng rồi mới thanh toán tại nhà, gọi COD siêu tiện!';
}

if (contains(['ship ngoại tỉnh', 'vận chuyển tỉnh'])) {
  return 'Bên mình ship toàn quốc qua GHN, GHTK, J&T tùy khu vực nha!';
}

if (contains(['giá sinh viên', 'học sinh', 'giảm cho sinh viên'])) {
  return 'Sinh viên được giảm 5% và tặng kèm chuột + balo nha, nhớ chụp thẻ sinh viên gửi tụi mình!';
}

if (contains(['giá doanh nghiệp', 'mua số lượng'])) {
  return 'Mua số lượng 3 máy trở lên sẽ được báo giá ưu đãi riêng và xuất hoá đơn VAT luôn nha!';
}

if (contains(['chạy được autocad không', 'dùng để design', 'render'])) {
  return 'Bạn nên chọn máy chip i7/i9, RAM 16GB, card rời để dùng AutoCAD, Adobe, render cho mượt nha!';
}

if (contains(['bảo hành ở đâu', 'trung tâm bảo hành'])) {
  return 'Tụi mình bảo hành tại các TTBH chính hãng như Apple, Dell, Asus... có địa chỉ cụ thể nha!';
}

if (contains(['làm sao kiểm tra bảo hành'])) {
  return 'Bạn chỉ cần cung cấp số seri máy hoặc gọi hotline tụi mình check giúp bạn nha!';
}

if (contains(['bị rơi vỡ', 'nước vào', 'bị cháy'])) {
  return 'Rơi vỡ hay nước vào không nằm trong bảo hành ạ, nhưng tụi mình hỗ trợ sửa giá ưu đãi nha!';
}

if (contains(['cổng hdmi', 'cổng usb', 'cổng kết nối'])) {
  return 'Đa số laptop hiện nay đều có USB 3.0, HDMI, jack tai nghe. Nếu bạn cần loại đặc biệt như Thunderbolt thì tụi mình sẽ check kỹ giúp nha!';
}

if (contains(['kết nối wifi', 'wifi yếu', 'mạng chậm'])) {
  return 'Bạn thử khởi động lại modem, nếu vẫn yếu thì có thể do driver. Mang máy đến shop tụi mình hỗ trợ kiểm tra nha!';
}

if (contains(['webcam', 'camera', 'camera laptop'])) {
  return 'Các dòng văn phòng, học online đều có webcam HD. Một số dòng gaming sẽ không có sẵn, cần camera rời nha!';
}

if (contains(['sạc bao lâu đầy', 'sạc pin', 'pin sạc'])) {
  return 'Laptop sạc đầy trong khoảng 1.5-2 tiếng, có hỗ trợ sạc nhanh tùy dòng nha!';
}

if (contains(['sạc có bị chai', 'chai pin', 'bảo vệ pin'])) {
  return 'Bạn nên rút sạc khi pin đầy và không dùng máy khi sạc lâu ngày để bảo vệ pin nha!';
}

if (contains(['dùng không cắm sạc được không'])) {
  return 'Được nha, pin laptop hiện đại dùng ổn tầm 5-8 tiếng không cần sạc luôn!';
}

if (contains(['laptop cho kế toán', 'chạy phần mềm kế toán'])) {
  return 'Bạn nên dùng máy chip i5, RAM 8GB là chạy mượt MISA, FAST, Excel rồi nhen!';
}

if (contains(['laptop học lập trình', 'lập trình viên', 'code'])) {
  return 'Lập trình nên chọn i5/i7, RAM từ 8GB trở lên và màn hình Full HD chống chói để đỡ mỏi mắt nha!';
}

if (contains(['laptop chạy đồ hoạ', 'photoshop', 'illustrator', 'premiere'])) {
  return 'Bạn cần chọn máy có card rời, RAM từ 16GB, ổ SSD để render nhanh, ví dụ Macbook Pro M2 hoặc Asus Vivobook Pro nha!';
}

if (contains(['màn hình', 'kích thước màn', 'full hd', '4k'])) {
  return 'Shop có các dòng 14", 15.6" và cả 16", độ phân giải Full HD, một số mẫu đồ hoạ có 2K/4K luôn nha!';
}

if (contains(['màn hình cảm ứng', 'touchscreen'])) {
  return 'Một số mẫu như HP Envy hoặc Dell XPS có màn hình cảm ứng, giá từ 22tr trở lên nha!';
}

if (contains(['màn hình đẹp', 'màu chuẩn', 'màn hình đồ hoạ'])) {
  return 'Bạn nên chọn màn IPS, độ phủ màu cao như 100% sRGB, có trên dòng Macbook hoặc Dell XPS nha!';
}

if (contains(['intel core i3'])) {
  return 'Core i3 phù hợp làm việc nhẹ nhàng, học tập online, giá mềm từ 6 triệu nha!';
}

if (contains(['core i5 gen 12', 'i5 12th'])) {
  return 'Core i5 Gen 12 hiệu năng mạnh, phù hợp cả học lẫn làm, bên mình đang có nhiều mẫu hot sale nè!';
}



if (contains(['ram 8gb', 'ram 16gb', 'ram nâng được không'])) {
  return 'Phần lớn máy RAM 8GB dùng ổn, bạn có thể nâng lên 16GB tùy dòng – tụi mình hỗ trợ nâng luôn!';
}

if (contains(['ssd 256', 'ssd 512', 'hdd'])) {
  return 'SSD 256GB đủ dùng cơ bản, 512GB thoải mái lưu trữ. Nếu bạn thích máy chạy mượt thì ưu tiên SSD nha!';
}

if (contains(['ok', 'oke' , 'cảm ơn', 'thanks'])) {
  return 'Nếu còn bất kỳ câu hỏi gì cứ hỏi mình nha!';
}
  // Nếu không khớp câu nào phía trên
  const responses = [

    "Mình là chatbot dễ thương mà còn hơi ngố, nói lại giúp mình nhen 🥺"

  ];
  return responses[Math.floor(Math.random() * responses.length)];
}


</script>
<script src="https://app.tudongchat.com/js/chatbox.js"></script>
<script>
  const tudong_chatbox = new TuDongChat('uFIWR2wnXDR_wxghp4t_l')
  tudong_chatbox.initial()
</script>

  </body>

</html>