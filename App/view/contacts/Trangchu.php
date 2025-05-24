<?php $this->layout("layouts/default", ["title" => CONGNGHE]) ?>

<?php $this->start("page_specific_css") ?>
<link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.css" rel="stylesheet">
<style>
  .category-list {
    transition: all 0.5s ease-in-out;
  }

  .category-toggle {
    cursor: pointer;
    transition: all 0.3s;
  }

  .category-toggle:hover {
    color: #007bff;
  }

  /* Hiệu ứng ẩn/hiện */
  .category-collapse {
    display: none;
  }

  .category-collapse.show {
    display: block;
  }

  /* Phần tin tức nổi bật */
  #newsList {
    margin-top: 10px;
  }

  .list-group-item h6 a {
    font-size: 1rem;
    font-weight: 600;
  }

  .list-group-item p {
    font-size: 0.875rem;
    color: #6c757d;
  }


  .promo-ai {
    background: linear-gradient(90deg, #b3e5fc, #81d4fa); 
    color: #01579b; 
    border-radius: 12px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 15px;
    animation: pulseGlow 1.5s infinite alternate;
  }

  .promo-icon {
    background: rgba(255, 255, 255, 0.2);
    padding: 15px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: floatIcon 3s ease-in-out infinite;
  }

  .promo-content h4 {
    font-size: 1.5rem;
    font-weight: bold;
    text-transform: uppercase;
  }

  .promo-content p {
    font-size: 1rem;
  }

  .btn-outline-light {
    border: 2px solid white;
    transition: all 0.3s ease;
  }

  .btn-outline-light:hover {
    background: white;
    color: #ff4b2b;
  }

  @keyframes pulseGlow {
    0% { box-shadow: 0 0 10px rgba(255, 255, 255, 0.2); }
    100% { box-shadow: 0 0 20px rgba(255, 255, 255, 0.6); }
  }

  @keyframes floatIcon {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-5px); }
  }
  #customCarousel {
  height: 400px; 
  overflow: hidden; 
}

#customCarousel .carousel-item img {
  object-fit: cover; 
  height: 100%;
}
.video-container video {
  max-height: 350px; 
  object-fit: cover; 
}

</style>
<?php $this->stop() ?>

<?php $this->start("page") ?>

<!-- Phần nội dung chính -->
<main>
  <div class="container-fluid mt-1">

    <!-- Hiển thị thông báo lỗi nếu có -->
    <?php if (!empty($_SESSION['error_message'])): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($_SESSION['error_message'], ENT_QUOTES, 'UTF-8') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['success_message'])): ?>
      <div class="alert alert alert-success alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($_SESSION['success_message'], ENT_QUOTES, 'UTF-8') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <!-- Phần Video -->
    <div class="video-container">
  <video class="responsive-video" autoplay muted loop>
    <source src="/img/videotrailer.mp4" type="video/mp4">
    Không thấy Video.
  </video>
</div>

    <!-- Phần carousel -->
    <div id="customCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
  <!-- Indicators -->
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#customCarousel" data-bs-slide-to="0" class="active" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#customCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#customCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    <button type="button" data-bs-target="#customCarousel" data-bs-slide-to="3" aria-label="Slide 4"></button>
  </div>

  <div class="carousel-inner">
    <div class="carousel-item active" data-bs-interval="2000"> <!-- Mỗi hình chuyển động 2 giây -->
      <img src="img/Carousel1.png" class="d-block w-100" alt="iPhone 16 Pro">
      <div class="carousel-caption">
        <h5>MSI Gaming</h5>
        <p>Siêu phẩm với công nghệ AI và camera nâng cấp.</p>
      </div>
    </div>
    
    <div class="carousel-item" data-bs-interval="2000">
      <img src="img/Carousel2.jpg" class="d-block w-100" alt="Asus Zenbook Pro">
      <div class="carousel-caption">
        <h5>Iphone thế hệ mới</h5>
        <p>Mỏng nhẹ, hiệu năng mạnh mẽ dành cho sáng tạo.</p>
      </div>
    </div>
    
    <div class="carousel-item" data-bs-interval="2000">
      <img src="img/Carousel3.jpg" class="d-block w-100" alt="Galaxy Watch">
      <div class="carousel-caption">
        <h5>Tablet</h5>
        <p></p>
      </div>
    </div>
    
    <div class="carousel-item" data-bs-interval="2000">
      <img src="img/Carousel4.jpg" class="d-block w-100" alt="Khuyến mãi mùa hè">
      <div class="carousel-caption">
        <h5>Watch</h5>
        <p></p>
      </div>
    </div>
  </div>

  <!-- Nút điều hướng -->
  <button class="carousel-control-prev" type="button" data-bs-target="#customCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#customCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>


    <div class="row">

      <!-- Phần khuyến mãi cao cấp -->
<div class="container mt-4">
  <div class="alert alert-success alert-dismissible fade show d-flex align-items-center promo-ai" role="alert">
    <div class="promo-icon">
      <i class="fa-solid fa-gift fa-3x"></i>
    </div>
    <div class="promo-content">
      <h4 class="alert-heading">🎁 Ưu Đãi Đặc Biệt!</h4>
      <p>
        Cơ hội siêu tiết kiệm! Nhận ngay ưu đãi lên đến <strong>99%</strong> cho tất cả sản phẩm!  
        <br> Mua sắm ngay kẻo lỡ! 🚀🔥
      </p>
      <a href="/product" class="btn btn-outline-light">Tận Hưởng Ngay</a>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
</div>


      <!-- Thanh danh mục -->
<div class="col-lg-9 col-12">
  <div id="laptops" class="brand row m-1">
    <h3 class="col-6 text-center text-dark mt-2">
      <i class="fa-solid fa-star text-warning"></i> SẢN PHẨM NỔI BẬT
    </h3>
    <div class="col-6 text-end mt-1">
    <a href="/product" class="float-end text-dark text-decoration-none fw-bold d-flex align-items-center gap-2">
  <span>Xem thêm</span>
  <i class="fa-solid fa-angles-right"></i>
</a>

    </div>
    <div class="row ms-1">
      <?php foreach ($contacts as $contact): ?>
        <div class="col-lg-4 col-sm-6 mb-3">
          <div class="card border shadow-sm">
            <img src="<?= htmlspecialchars($contact->img) ?>" class="card-img-top p-2" alt="<?= htmlspecialchars($contact->name) ?>">
            <div class="card-body text-center">
              <div class="d-flex justify-content-center gap-2 mb-2">
                <span class="badge bg-secondary text-decoration-line-through">
                  <?= number_format(htmlspecialchars($contact->priceGoc), 0, ',', '.') ?> VNĐ
                </span>
                <span class="badge bg-danger">
                  <?= number_format(htmlspecialchars($contact->price), 0, ',', '.') ?> VNĐ
                </span>
              </div>
              <h5 class="card-title"> <?= htmlspecialchars($contact->name) ?> </h5>
              <p class="card-text"> <?= htmlspecialchars($contact->description) ?> </p>
            </div>
            <div class="card-footer text-center">
              <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#productModal-<?= $contact->id ?>">
                <i class="fa-solid fa-circle-info"></i> Chi tiết
              </button>
              <a href="/cart/add/<?= $contact->id ?>/<?= urlencode($contact->name) ?>" class="btn btn-primary">
                <i class="fa-solid fa-cart-plus"></i> Mua Hàng
              </a>
            </div>
          </div>
        </div>

        <!-- Modal thông tin chi tiết sản phẩm -->
        <div class="modal fade" id="productModal-<?= $contact->id ?>" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header bg-light border-bottom">
                <h5 class="modal-title" id="productModalLabel">Thông Tin Sản Phẩm: <?= htmlspecialchars($contact->name) ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item"><strong>CPU:</strong> <?= htmlspecialchars($contact->cpu) ?></li>
                  <li class="list-group-item"><strong>RAM:</strong> <?= htmlspecialchars($contact->ram) ?></li>
                  <li class="list-group-item"><strong>Bộ nhớ:</strong> <?= htmlspecialchars($contact->storage) ?></li>
                  <li class="list-group-item"><strong>Dung lượng PIN:</strong> <?= htmlspecialchars($contact->battery_capacity) ?></li>
                  <li class="list-group-item"><strong>CAMERA:</strong> <?= htmlspecialchars($contact->camera_resolution) ?></li>
                  <li class="list-group-item"><strong>Màn hình:</strong> <?= htmlspecialchars($contact->screen_size) ?> inch</li>
                  <li class="list-group-item"><strong>Hệ điều hành:</strong> <?= htmlspecialchars($contact->os) ?></li>
                  <li class="list-group-item"><strong>Chất liệu dây đeo:</strong> <?= htmlspecialchars($contact->strap_material) ?></li>
                  <li class="list-group-item"><strong>Chống nước:</strong> <?= htmlspecialchars($contact->water_resistance) ?></li>
                </ul>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>


      <!-- Thanh danh mục chuyển sang bên phải và có thể toggle -->
<div class="col-lg-3 col-12">
  <div class="m-0 bg-white shadow-sm rounded">
    <h5 class="p-3 mt-1 category-toggle d-flex align-items-center justify-content-between" data-bs-toggle="collapse" data-bs-target="#categoryList">
      <span><i class="fa-solid fa-list me-2"></i>DANH MỤC</span>
      <i class="fa-solid fa-caret-down"></i>
    </h5>
    <div id="categoryList" class="category-list category-collapse">
      <div class="list-group">
        <a href="#laptops" class="list-group-item list-group-item-action d-flex align-items-center">
          <i class="fa-solid fa-laptop me-2"></i> Laptop
        </a>
        <a href="#phones" class="list-group-item list-group-item-action d-flex align-items-center">
          <i class="fa-solid fa-mobile-alt me-2"></i> Điện Thoại
        </a>
        <a href="#tablets" class="list-group-item list-group-item-action d-flex align-items-center">
          <i class="fa-solid fa-tablet-alt me-2"></i> Máy Tính Bảng
        </a>
        <a href="#watches" class="list-group-item list-group-item-action d-flex align-items-center">
          <i class="fa-solid fa-clock me-2"></i> Đồng Hồ
        </a>
      </div>
    </div>
  </div>
               <!-- Phần Tin Tức Nổi Bật -->
<div class="m-0 bg-white mt-4 p-3 shadow-sm rounded">
  <h5 class="category-toggle d-flex align-items-center justify-content-between" data-bs-toggle="collapse" data-bs-target="#newsList">
    <span><i class="fa-solid fa-newspaper me-2"></i> TIN TỨC NỔI BẬT</span>
    <i class="fa-solid fa-caret-down"></i>
  </h5>
  <div id="newsList" class="category-list category-collapse">
    <ul class="list-group">
      <li class="list-group-item d-flex">
        <i class="fa-solid fa-microchip text-primary me-2"></i>
        <div>
          <h6><a href="https://vnexpress.net/microsoft-cong-bo-dot-pha-moi-ve-chip-luong-tu-4851705.html" class="text-decoration-none">Microsoft công bố đột phá mới về chip lượng tử</a></h6>
          <p class="text-muted">Microsoft giới thiệu Majorana 1, mẫu chip mới giúp máy tính lượng tử tiến gần hơn đến thực tiễn.</p>
        </div>
      </li>
      <li class="list-group-item d-flex">
        <i class="fa-solid fa-robot text-success me-2"></i>
        <div>
          <h6><a href="https://vnexpress.net/ung-dung-thay-quan-ao-bang-ai-gay-sot-tai-viet-nam-4851675.html" class="text-decoration-none">Ứng dụng thay quần áo bằng AI gây sốt tại Việt Nam</a></h6>
          <p class="text-muted">Beautycam sử dụng AI ghép trang phục, tạo ra ảnh độc đáo nhưng cũng tiềm ẩn nguy cơ về tin giả.</p>
        </div>
      </li>
      <li class="list-group-item d-flex">
        <i class="fa-solid fa-mobile-screen text-danger me-2"></i>
        <div>
          <h6><a href="https://vnexpress.net/iphone-16e-trinh-lang-gia-tu-17-trieu-dong-4851660.html" class="text-decoration-none">iPhone 16e trình làng, giá từ 17 triệu đồng</a></h6>
          <p class="text-muted">Apple ra mắt iPhone 16e với giá cả phải chăng, trang bị modem di động tự thiết kế.</p>
        </div>
      </li>
    </ul>
    <div class="text-end mt-2">
      <a href="https://vnexpress.net/cong-nghe" class="text-decoration-none fw-bold"><i class="fa-solid fa-arrow-right"></i> Xem thêm tin tức</a>
    </div>
  </div>
</div>



       
</main>

<a class="backtop position-fixed text-center rounded-circle text-muted active" href="#"> <i class="bi bi-house-door"></i></a>

<?php $this->stop() ?>

<?php $this->start("page_specific_js") ?>
<script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.js"></script>

<script>
  // Mã JavaScript để toggle (ẩn/hiện) phần danh mục
  const categoryToggle = document.querySelector('.category-toggle');
  const categoryList = document.querySelector('#categoryList');

  categoryToggle.addEventListener('click', function() {
    categoryList.classList.toggle('show');
    const icon = categoryToggle.querySelector('i');
    icon.classList.toggle('fa-caret-up');
    icon.classList.toggle('fa-caret-down');
  });

  
</script>
<?php $this->stop() ?>
