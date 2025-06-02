<?php $this->layout("layouts/default", ["title" => "Tìm kiếm - " . CONGNGHE]) ?>

<?php $this->start("page") ?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Kết quả tìm kiếm</h1>

    <?php if (!empty($results)): ?>
        <div class="row gy-4">
            <?php foreach ($results as $product): ?>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm rounded">
                        <img 
                            src="<?= !empty($product['img']) ? '/' . htmlspecialchars($product['img']) : '/img/default_product.jpg' ?>" 
                            class="card-img-top img-fluid" 
                            alt="<?= htmlspecialchars($product['name'] ?? 'Sản phẩm không có tên') ?>" 
                            loading="lazy"
                            onerror="this.onerror=null; this.src='/img/default_product.jpg';"
                            style="object-fit: contain; height: 250px;"
                        >
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($product['name'] ?? 'Sản phẩm không có tên') ?></h5>
                            <p class="card-text flex-grow-1"><?= htmlspecialchars($product['description'] ?? 'Mô tả không có sẵn') ?></p>
                            <p class="text-danger fw-bold fs-5"><?= number_format($product['price'], 0, ',', '.') ?> VND</p>

                            <ul class="list-unstyled small mb-3">
                                <!-- <li><strong>Loại sản phẩm:</strong> <?= htmlspecialchars($product['product_type']) ?></li> -->
                                <li><strong>CPU / Chipset:</strong> <?= htmlspecialchars($product['cpu']) ?></li>
                                <li><strong>RAM:</strong> <?= htmlspecialchars($product['ram']) ?></li>
                                <li><strong>Bộ nhớ:</strong> <?= htmlspecialchars($product['storage']) ?></li>
                                <li><strong>Pin:</strong> <?= htmlspecialchars($product['battery_capacity']) ?></li>
                                <li><strong>Màn hình:</strong> <?= htmlspecialchars($product['screen_size']) ?> inch</li>
                                <li><strong>Hệ điều hành:</strong> <?= htmlspecialchars($product['os']) ?></li>
                            </ul>

                            <a href="/cart/add/<?= $product['id'] ?>/<?= urlencode($product['name']) ?>" class="btn btn-primary mt-auto">
                                <i class="fa-solid fa-cart-plus"></i> Mua Hàng
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php elseif (isset($_GET['query'])): ?>
        <p class="text-center">Không tìm thấy sản phẩm nào phù hợp với từ khóa "<strong><?= htmlspecialchars($_GET['query']) ?></strong>".</p>
    <?php endif; ?>
</div>

<?php $this->stop() ?>
