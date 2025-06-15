<?php $this->layout("layouts/default", ["title" => "Giỏ Hàng"]) ?>

<?php $this->start("page_specific_css") ?>
<link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<?php $this->stop() ?>

<?php $this->start("page") ?>
<main>
    <div class="container py-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white text-center">
                <h3 class="mb-0"><i class="bi bi-cart-fill"></i> Giỏ Hàng Của Bạn</h3>
            </div>
            <div class="card-body">
                <?php if (empty($cart)): ?>
                    <div class="text-center text-muted py-4">
                        <h5 class="mb-3">Giỏ hàng của bạn đang trống <i class="bi bi-emoji-frown text-warning"></i></h5>
                        <p>
                            Đừng bỏ lỡ các <span class="fw-bold text-success">ưu đãi cực hot</span>! Khám phá ngay các sản phẩm đang giảm giá.
                        </p>
                        <a href="/product" class="btn btn-warning btn-lg px-4 shadow-sm text-white">
                            <i class="bi bi-bag-plus-fill"></i> Mua sắm ngay
                        </a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light text-center">
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Ảnh</th>
                                    <th>Số lượng</th>
                                    <th>Giá</th>
                                    <th>Tổng</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cart as $item): ?>
                                    <tr>
                                        <td class="fw-bold"><?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?></td>
                                        <td class="text-center">
                                            <img src="<?= htmlspecialchars($item['img'], ENT_QUOTES, 'UTF-8') ?>" 
                                                 alt="<?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?>" 
                                                 class="img-thumbnail" style="max-width: 100px;">
                                        </td>
                                        <td class="text-center">
                                            <form action="/cart/update/<?= $item['id'] ?>" method="POST" class="d-flex justify-content-center align-items-center gap-1">
                                                <input type="number" name="quantity" value="<?= htmlspecialchars($item['quantity'], ENT_QUOTES, 'UTF-8') ?>" 
                                                       min="1" required class="form-control form-control-sm" style="width: 70px;">
                                                <button type="submit" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-arrow-repeat"></i>
                                                </button>
                                            </form>
                                        </td>
                                        <td class="text-end"><?= number_format($item['price'], 0, ',', '.') ?> VNĐ</td>
                                        <td class="text-end"><?= number_format($item['total_price'], 0, ',', '.') ?> VNĐ</td>
                                        <td class="text-center">
                                            <form action="/cart/remove/<?= $item['id'] ?>" method="POST" onsubmit="return confirm('Bạn chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?');">
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash-fill"></i> Xóa
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr class="table-info fw-bold">
                                    <td colspan="4" class="text-end">Tổng tiền:</td>
                                    <td class="text-end text-primary"><?= number_format($total, 0, ',', '.') ?> VNĐ</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-end mt-3">
                        <a href="/checkout" class="btn btn-success btn-lg shadow">
                            <i class="bi bi-credit-card-fill"></i> Thanh Toán
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>
<?php $this->stop() ?>

<?php $this->start("page_specific_js") ?>
<script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.js"></script>
<?php $this->stop() ?>
