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
    <source src="/img/VideoNLCNTT.mp4" type="video/mp4">
    Không thấy Video.
  </video>
</div>

    <!-- Phần carousel 6 hãng laptop -->
<div id="customCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
  <!-- Indicators -->
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#customCarousel" data-bs-slide-to="0" class="active" aria-label="Apple"></button>
    <button type="button" data-bs-target="#customCarousel" data-bs-slide-to="1" aria-label="Dell"></button>
    <button type="button" data-bs-target="#customCarousel" data-bs-slide-to="2" aria-label="HP"></button>
    <button type="button" data-bs-target="#customCarousel" data-bs-slide-to="3" aria-label="Asus"></button>
    <button type="button" data-bs-target="#customCarousel" data-bs-slide-to="4" aria-label="Lenovo"></button>
    <button type="button" data-bs-target="#customCarousel" data-bs-slide-to="5" aria-label="MSI"></button>
  </div>

  <div class="carousel-inner">
    <div class="carousel-item active" data-bs-interval="2000">
      <img src="img/Banner1.jpg" class="d-block w-100" alt="Apple">
      <div class="carousel-caption">
        <h5>Apple</h5>
        <p>MacBook sang trọng, hiệu năng mạnh mẽ với chip M-series.</p>
      </div>
    </div>
  
    <div class="carousel-item" data-bs-interval="2000">
      <img src="img/Banner2.jpg" class="d-block w-100" alt="Asus">
      <div class="carousel-caption">
        <h5>Asus</h5>
        <p>Đa dạng dòng sản phẩm từ gaming đến ultrabook.</p>
      </div>
    </div>
    
    <div class="carousel-item" data-bs-interval="2000">
      <img src="img/CarouselLEVONO.jpg" class="d-block w-100" alt="Lenovo">
      <div class="carousel-caption">
        <h5>Lenovo</h5>
        <p>Đáng tin cậy với các dòng ThinkPad và Yoga nổi tiếng.</p>
      </div>
    </div>
    
    <div class="carousel-item" data-bs-interval="2000">
      <img src="img/CarouselMSI.png" class="d-block w-100" alt="MSI">
      <div class="carousel-caption">
        <h5>MSI</h5>
        <p>Siêu phẩm gaming với công nghệ tiên tiến và thiết kế hầm hố.</p>
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

      <!-- Phần khuyến mãi -->
<div class="container mt-4">
  <div class="alert alert-success alert-dismissible fade show d-flex align-items-center promo-ai" role="alert">
    <div class="promo-icon">
      <i class="fa-solid fa-gift fa-3x"></i>
    </div>
    <div class="promo-content">
      <h4 class="alert-heading">🎁 Ưu Đãi Đặc Biệt!</h4>
      <p>
        Cơ hội siêu tiết kiệm! Nhận ngay ưu đãi lên đến <strong>10%</strong> cho tất cả sản phẩm!  
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
        <div class="col-lg-4 col-md-6 mb-4">
  <div class="card border-0 shadow-sm rounded-4 position-relative h-100">

    <!-- Ribbon giảm giá -->
    <?php
      $discount = 100 - intval($contact->price / $contact->priceGoc * 100);
    ?>
    <?php if ($discount > 0): ?>
      <span class="position-absolute top-0 start-0 bg-danger text-white px-3 py-1 rounded-end-bottom small fw-bold z-2">
        -<?= $discount ?>%
      </span>
    <?php endif; ?>

    <!-- Ảnh sản phẩm -->
    <img src="<?= htmlspecialchars($contact->img) ?>" class="card-img-top p-3 rounded-4" alt="<?= htmlspecialchars($contact->name) ?>">

    <!-- Nội dung chính -->
    <div class="card-body text-center d-flex flex-column">
      <!-- Tên sản phẩm -->
      <h5 class="fw-semibold mb-2 text-dark"><?= htmlspecialchars($contact->name) ?></h5>

      <!-- Mô tả -->
      <p class="text-muted small mb-3"><?= htmlspecialchars($contact->description) ?></p>

      <!-- Giá -->
      <div class="mb-3">
        <span class="text-decoration-line-through text-muted me-2 small">
          <?= number_format(htmlspecialchars($contact->priceGoc), 0, ',', '.') ?>₫
        </span>
        <span class="text-danger fw-bold fs-5">
          <?= number_format(htmlspecialchars($contact->price), 0, ',', '.') ?>₫
        </span>
      </div>

      <!-- Nút chức năng -->
      <div class="mt-auto d-flex justify-content-center gap-2">
        <button type="button" class="btn btn-outline-dark btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#productModal-<?= $contact->id ?>">
          <i class="fa-solid fa-circle-info me-1"></i> Chi tiết
        </button>
        <a href="/cart/add/<?= $contact->id ?>/<?= urlencode($contact->name) ?>" class="btn btn-primary btn-sm rounded-pill px-3">
          <i class="fa-solid fa-cart-plus me-1"></i> Mua ngay
        </a>
      </div>
    </div>
  </div>
</div>


        <!-- Modal thông tin chi tiết sản phẩm -->
<div class="modal fade" id="productModal-<?= $contact->id ?>" tabindex="-1" aria-labelledby="productModalLabel-<?= $contact->id ?>" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content rounded-4 shadow-lg overflow-hidden">

      <!-- Header -->
      <div class="modal-header bg-dark text-white border-0">
        <h5 class="modal-title" id="productModalLabel-<?= $contact->id ?>">
          <i class="fa-solid fa-circle-info me-2"></i>Thông Tin Sản Phẩm
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Body -->
      <div class="modal-body p-4 bg-light">
        <div class="row">
          <!-- Hình ảnh -->
          <div class="col-md-5 text-center mb-3 mb-md-0">
            <img src="<?= htmlspecialchars($contact->img) ?>" alt="<?= htmlspecialchars($contact->name) ?>" class="img-fluid rounded-4 shadow-sm">
          </div>

          <!-- Thông tin chi tiết -->
          <div class="col-md-7">
            <h4 class="fw-bold mb-3"><?= htmlspecialchars($contact->name) ?></h4>

            <div class="mb-3">
              <span class="text-muted text-decoration-line-through me-2">
                <?= number_format($contact->priceGoc, 0, ',', '.') ?>₫
              </span>
              <span class="text-danger fw-bold fs-4">
                <?= number_format($contact->price, 0, ',', '.') ?>₫
              </span>
            </div>

            <ul class="list-group list-group-flush mb-4">
              <li class="list-group-item bg-light"><strong>CPU/Chipset:</strong> <?= htmlspecialchars($contact->cpu) ?></li>
              <li class="list-group-item bg-light"><strong>RAM:</strong> <?= htmlspecialchars($contact->ram) ?></li>
              <li class="list-group-item bg-light"><strong>Bộ nhớ:</strong> <?= htmlspecialchars($contact->storage) ?></li>
              <li class="list-group-item bg-light"><strong>PIN/Sạc:</strong> <?= htmlspecialchars($contact->battery_capacity) ?></li>
              <li class="list-group-item bg-light"><strong>Camera:</strong> <?= htmlspecialchars($contact->camera_resolution) ?></li>
              <li class="list-group-item bg-light"><strong>Màn hình:</strong> <?= htmlspecialchars($contact->screen_size) ?> inch</li>
              <li class="list-group-item bg-light"><strong>Hệ điều hành:</strong> <?= htmlspecialchars($contact->os) ?></li>
              <li class="list-group-item bg-light"><strong>Chất liệu:</strong> <?= htmlspecialchars($contact->strap_material) ?></li>
            </ul>

            <!-- Nút hành động -->
            <div class="d-flex gap-2">
              <a href="/cart/add/<?= $contact->id ?>/<?= urlencode($contact->name) ?>" class="btn btn-primary rounded-pill px-4">
                <i class="fa-solid fa-cart-plus me-1"></i> Thêm vào giỏ
              </a>
              <button class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                <i class="fa-solid fa-xmark me-1"></i> Đóng
              </button>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

      <?php endforeach; ?>
    </div>
  </div>
</div>

      <!-- Thanh danh mục chuyển sang bên phải và có thể toggle -->
<div class="col-lg-3 col-12 position-relative">
  <div class="m-0 bg-white shadow-sm rounded p-3">
    <h5 class="category-toggle d-flex align-items-center justify-content-between" data-bs-toggle="collapse" data-bs-target="#categoryList">
      <span><i class="fa-solid fa-list me-2"></i>CHỌN THEO HÃNG LAPTOP</span>
      <i class="fa-solid fa-caret-down"></i>
    </h5>
    <div id="categoryList" class="category-list collapse position-absolute bg-white w-100 shadow p-2 rounded" style="z-index: 1000;">
      <div class="list-group">
        <a href="#apple" class="list-group-item list-group-item-action d-flex align-items-center">
          <img src="img/LogoMac.jpg" alt="Apple" style="width:20px; height:20px; margin-right:8px;">
          Apple
        </a>
        <a href="#dell" class="list-group-item list-group-item-action d-flex align-items-center">
          <img src="img/LogoDell.jpg" alt="Dell" style="width:20px; height:20px; margin-right:8px;">
          Dell
        </a>
        <a href="#hp" class="list-group-item list-group-item-action d-flex align-items-center">
          <img src="img/LogoHP.png" alt="HP" style="width:20px; height:20px; margin-right:8px;">
          HP
        </a>
        <a href="#asus" class="list-group-item list-group-item-action d-flex align-items-center">
          <img src="img/LogoASUS.jpg" alt="Asus" style="width:20px; height:20px; margin-right:8px;">
          Asus
        </a>
        <a href="#lenovo" class="list-group-item list-group-item-action d-flex align-items-center">
          <img src="img/LogoLEVONO.jpg" alt="Lenovo" style="width:20px; height:20px; margin-right:8px;">
          Lenovo
        </a>
        <a href="#msi" class="list-group-item list-group-item-action d-flex align-items-center">
          <img src="img/LogoMSI.jpg" alt="MSI" style="width:20px; height:20px; margin-right:8px;">
          MSI
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
        <i class="fa-solid fa-laptop text-primary me-2"></i>
        <div>
          <h6><a href="https://vnexpress.net/macbook-air-m4-ra-mat-mong-nhe-hieu-nang-cao-4848302.html" class="text-decoration-none">MacBook Air M4 ra mắt: Mỏng nhẹ, hiệu năng vượt trội</a></h6>
          <p class="text-muted">Apple trình làng MacBook Air M4 với chip M4 mới, pin 18 giờ, cải tiến hiệu suất đa nhiệm.</p>
        </div>
      </li>
      <li class="list-group-item d-flex">
        <i class="fa-solid fa-bolt text-warning me-2"></i>
        <div>
          <h6><a href="https://vnexpress.net/dell-xps-moi-voi-man-hinh-oled-ra-mat-4845292.html" class="text-decoration-none">Dell XPS mới với màn hình OLED 3K</a></h6>
          <p class="text-muted">Dell XPS 2025 trang bị màn hình OLED, viền siêu mỏng và chip Intel Core Ultra mới nhất.</p>
        </div>
      </li>
      <li class="list-group-item d-flex">
        <i class="fa-solid fa-microchip text-success me-2"></i>
        <div>
          <h6><a href="https://vnexpress.net/laptop-cho-game-thu-2025-trang-bi-ai-cao-cap-4851123.html" class="text-decoration-none">Laptop gaming 2025 tích hợp AI cao cấp</a></h6>
          <p class="text-muted">Nhiều mẫu laptop chơi game tích hợp AI giúp tăng hiệu năng và tối ưu hoá đồ hoạ trong thời gian thực.</p>
        </div>
      </li>
      <li class="list-group-item d-flex">
        <i class="fa-solid fa-feather-pointed text-danger me-2"></i>
        <div>
          <h6><a href="https://vnexpress.net/asus-ra-mat-laptop-sieu-nhe-zenbook-s16-4851450.html" class="text-decoration-none">Asus giới thiệu Zenbook S16: Mỏng nhẹ chỉ 1,1 kg</a></h6>
          <p class="text-muted">Asus Zenbook S16 sở hữu khung magie siêu nhẹ, vi xử lý AMD Ryzen AI, pin 14 giờ.</p>
        </div>
      </li>
      <li class="list-group-item d-flex">
        <i class="fa-solid fa-network-wired text-info me-2"></i>
        <div>
          <h6><a href="https://vnexpress.net/hp-trinh-lang-dong-elitebook-moi-nhieu-tinh-nang-bao-mat-4850950.html" class="text-decoration-none">HP EliteBook mới ra mắt với tính năng bảo mật cao</a></h6>
          <p class="text-muted">HP công bố dòng EliteBook 2025 với camera AI, nhận diện gương mặt và mã hoá bảo mật doanh nghiệp.</p>
        </div>
      </li>
      <li class="list-group-item d-flex">
        <i class="fa-solid fa-fire text-danger me-2"></i>
        <div>
          <h6><a href="https://vnexpress.net/msi-ra-mat-laptop-gaming-dong-gt77-titan-4849338.html" class="text-decoration-none">MSI GT77 Titan – Laptop gaming mạnh mẽ nhất</a></h6>
          <p class="text-muted">MSI GT77 trang bị card RTX 4090, RAM 64GB, tản nhiệt kép và màn hình 4K mini LED.</p>
        </div>
      </li>
    </ul>
    <div class="text-end mt-2">
      <a href="https://vnexpress.net/so-hoa/san-pham" class="text-decoration-none fw-bold">
        <i class="fa-solid fa-arrow-right"></i> Xem thêm tin tức laptop
      </a>
    </div>
  </div>
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
