<?php $this->layout("layouts/default", ["title" => CONGNGHE]) ?>

<?php $this->start("page_specific_css") ?>
<link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.css" rel="stylesheet">
<style>
  .category-list {
  top: 100%; 
  left: 0;
  z-index: 1050; 
  display: none; 
}


.category-list.show {
  display: block !important;
}

</style>
<?php $this->stop() ?>

<?php $this->start("page") ?>

<!-- Nội dung chính -->
<main>
  <div class="container">
    <div class="text-center">
      <h2 style="color: rgb(3, 41, 119);" class="font-weight-bold">SẢN PHẨM</h2>
    </div>

    <!-- DANH MỤC & PHÂN LOẠI -->
<div class="row mb-3">
  <!-- DANH MỤC -->
  <div class="col-md-6 position-relative">
    <div class="bg-white shadow-sm rounded p-3">
      <h5 class="category-toggle d-flex align-items-center justify-content-between" data-bs-toggle="collapse" data-bs-target="#categoryList">
        <span><i class="fa-solid fa-list me-2"></i> DANH MỤC</span>
        <i class="fa-solid fa-caret-down"></i>
      </h5>
      <div id="categoryList" class="category-list collapse position-absolute bg-white w-100 shadow p-2 rounded"> 
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
  </div>

  <!-- PHÂN LOẠI -->
  <div class="col-md-6 position-relative">
    <div class="bg-white shadow-sm rounded p-3">
      <h5 class="category-toggle d-flex align-items-center justify-content-between" data-bs-toggle="collapse" data-bs-target="#filterList">
        <span><i class="fa-solid fa-filter me-2"></i> PHÂN LOẠI</span>
        <i class="fa-solid fa-caret-down"></i>
      </h5>
      <div id="filterList" class="category-list collapse position-absolute bg-white w-100 shadow p-2 rounded">
        <div class="list-group">
          <a href="?filter=price_asc" class="list-group-item list-group-item-action">
            <i class="fa-solid fa-sort-amount-up me-2"></i> Giá thấp đến cao
          </a>
          <a href="?filter=price_desc" class="list-group-item list-group-item-action">
            <i class="fa-solid fa-sort-amount-down me-2"></i> Giá cao đến thấp
          </a>
          <a href="?filter=newest" class="list-group-item list-group-item-action">
            <i class="fa-solid fa-calendar-plus me-2"></i> Mới nhất
          </a>
          <a href="?filter=popular" class="list-group-item list-group-item-action">
            <i class="fa-solid fa-fire me-2"></i> Bán chạy nhất
          </a>
        </div>
      </div>
    </div>
  </div>
</div>


   <div class="col-12">
  <div id="laptops" class="brand row m-1">
    <div class="row ms-1 mt-3">
      <?php foreach ($contacts as $contact): ?>
        <div class="col-lg-3 col-sm-6 mb-3">
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
              <h5 class="card-title"><?= htmlspecialchars($contact->name) ?></h5>
              <p class="card-text"><?= htmlspecialchars($contact->description) ?></p>
            </div>

            <div class="card-footer text-center">
              <!-- Số lượng còn lại với badge và thanh tiến trình -->
              <?php
              // Lấy số lượng tồn kho
              $quantityInStock = $contact->getStockQuantity();
              ?>
              <p class="stock-quantity mb-2">
                <strong>Số lượng còn lại:</strong>
                <span class="badge <?php echo ($quantityInStock <= 5) ? 'bg-danger' : 'bg-success'; ?>">
                  <?= htmlspecialchars($quantityInStock) ?> sản phẩm
                </span>
              </p>

              <!-- Thanh tiến trình -->
              <div class="progress mb-2" style="height: 25px;">
                <div class="progress-bar" role="progressbar" style="width: <?= ($quantityInStock > 0 ? min(100, ($quantityInStock / 100) * 100) : 0) ?>%" aria-valuenow="<?= $quantityInStock ?>" aria-valuemin="0" aria-valuemax="100">
                  <?= $quantityInStock ?> sản phẩm còn
                </div>
              </div>

              <button type="button" class="btn btn-outline-secondary mt-2" data-bs-toggle="modal" data-bs-target="#productModal-<?= $contact->id ?>">
                <i class="fa-solid fa-circle-info"></i> Chi tiết
              </button>
              <a href="/cart/add/<?= $contact->id ?>/<?= urlencode($contact->name) ?>" class="btn btn-primary mt-2">
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
                  <li class="list-group-item"><strong>CPU/Chipset:</strong> <?= htmlspecialchars($contact->cpu) ?></li>
                  <li class="list-group-item"><strong>RAM:</strong> <?= htmlspecialchars($contact->ram) ?></li>
                  <li class="list-group-item"><strong>ROM:</strong> <?= htmlspecialchars($contact->storage) ?></li>
                  <li class="list-group-item"><strong>Dung lượng PIN / Sạc:</strong> <?= htmlspecialchars($contact->battery_capacity) ?></li>
                  <li class="list-group-item"><strong>Camera:</strong> <?= htmlspecialchars($contact->camera_resolution) ?></li>
                  <li class="list-group-item"><strong>Màn hình:</strong> <?= htmlspecialchars($contact->screen_size) ?> inch</li>
                  <li class="list-group-item"><strong>Hệ điều hành:</strong> <?= htmlspecialchars($contact->os) ?></li>
                  <li class="list-group-item"><strong>Băng tần:</strong> <?= htmlspecialchars($contact->band) ?></li>
                  <li class="list-group-item"><strong>Chất liệu/ Khả năng:</strong> <?= htmlspecialchars($contact->strap_material) ?></li>
                  <!-- <li class="list-group-item"><strong>Chống nước, bụi:</strong> <?= htmlspecialchars($contact->water_resistance) ?></li> -->
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

    <!-- Phân trang -->
    <nav aria-label="Page navigation example">
      <ul class="pagination justify-content-center">
        <li class="page-item disabled">
          <a class="page-link">Previous</a>
        </li>
        <li class="page-item active"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item">
          <a class="page-link" href="#">Next</a>
        </li>
      </ul>
    </nav>

  </div>
</main>

<?php $this->stop() ?>

<?php $this->start("page_specific_js") ?>
<script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.js"></script>
<script>
  let table = new DataTable('#contacts', {
    responsive: true,
    pagingType: 'simple_numbers'
  });
</script>
<?php $this->stop() ?>
