<?php $this->layout("layouts/default", ["title" => "Thống Kê Sản Phẩm Bán Được"]) ?>

<?php $this->start("page") ?>
<main>
    <div class="container py-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="fa-solid fa-chart-column me-2"></i>Thống Kê Sản Phẩm Bán Được
                </h4>
                <a href="/product" class="btn btn-light btn-sm">
                    <i class="fa-solid fa-box-open me-1"></i>Xem Sản Phẩm
                </a>
            </div>

            <div class="card-body">
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
                <?php elseif (empty($stats)): ?>
                    <div class="alert alert-info text-center">Chưa có dữ liệu bán hàng.</div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover align-middle">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col">Tên Sản Phẩm</th>
                                    <th scope="col">Số Lượng Bán</th>
                                    <th scope="col">Doanh Thu (VNĐ)</th>
                                </tr>
                            </thead>
                            <tbody>
    <?php foreach ($stats as $index => $item): ?>
        <tr>
            <td class="text-center"><?= $index + 1 ?></td>
            <td class="text-start">
                <i class="fa-solid fa-laptop text-primary me-1"></i>

                <?= htmlspecialchars($item['product_name']) ?>
            </td>
            <td class="text-center">
                <span class="badge bg-success">
                    <?= $item['total_quantity_sold'] ?>
                </span>
            </td>
            <td class="text-end fw-semibold text-danger">
                <?= number_format($item['total_revenue'], 0, ',', '.') ?>₫
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>

                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>
<?php $this->stop() ?>
