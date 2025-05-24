<?php $this->layout("layouts/default", ["title" => "Tìm kiếm - " . CONGNGHE]) ?>

<?php $this->start("page") ?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Kết quả tìm kiếm</h1>

    <!-- Hiển thị kết quả tìm kiếm -->
    <?php if (!empty($results)): ?>
        <div class="row">
            <?php foreach ($results as $product): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="<?= !empty($product['img']) ? '/' . htmlspecialchars($product['img'] ?? '') : '/img/default_product.jpg' ?>" 
                             class="card-img-top" 
                             alt="<?= htmlspecialchars($product['name'] ?? 'Sản phẩm không có tên') ?>" 
                             onerror="this.onerror=null; this.src='/img/default_product.jpg';">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($product['name'] ?? 'Sản phẩm không có tên') ?></h5>
                            <p class="card-text"><?= htmlspecialchars($product['description'] ?? 'Mô tả không có sẵn') ?></p>
                            <p class="card-text text-danger"><?= number_format($product['price'], 0, ',', '.') ?> VND</p>

                            <!-- Hiển thị thông tin chi tiết sản phẩm luôn -->
                            <ul>
                                <li><strong>Loại sản phẩm:</strong> <?= htmlspecialchars($product['product_type']) ?></li>
                                <li><strong>CPU / Chipset:</strong> <?= htmlspecialchars($product['cpu']) ?></li>
                                <li><strong>RAM:</strong> <?= htmlspecialchars($product['ram']) ?></li>
                                <li><strong>Bộ nhớ:</strong> <?= htmlspecialchars($product['storage']) ?></li>
                                <li><strong>Pin:</strong> <?= htmlspecialchars($product['battery_capacity']) ?></li>
                                <li><strong>Màn hình:</strong> <?= htmlspecialchars($product['screen_size']) ?> inch</li>
                                <li><strong>Hệ điều hành:</strong> <?= htmlspecialchars($product['os']) ?></li>
                                <!-- <li><strong>Chống nước:</strong> <?= htmlspecialchars($product['water_resistance']) ?></li> -->
                            </ul>

                             <!-- Thêm nút "Mua Hàng" -->
                             <a href="/cart/add/<?= $product['id'] ?>/<?= urlencode($product['name']) ?>" class="btn btn-primary mt-2">
                                <i class="fa-solid fa-cart-plus"></i> Mua Hàng
                            </a>
                            
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php elseif (isset($_GET['query'])): ?>
        <p class="text-center">Không tìm thấy sản phẩm nào phù hợp với từ khóa "<?= htmlspecialchars($_GET['query'] ?? '') ?>".</p>
    <?php endif; ?>
</div>

<?php $this->stop() ?>
