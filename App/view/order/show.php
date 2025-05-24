<?php $this->layout("layouts/default", ["title" => "Chi tiết Đơn Hàng"]) ?>

<?php $this->start("page_specific_css") ?>
<link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.css" rel="stylesheet">
<?php $this->stop() ?>

<?php $this->start("page") ?>
<main>
    <div class="container">
        <h2 class="text-center">Chi Tiết Đơn Hàng</h2>

        <?php if ($order === null): ?>
            <p class="text-center text-danger">Đơn hàng không tồn tại hoặc bạn không có quyền truy cập.</p>
        <?php else: ?>
            <div class="row mb-4">
                <div class="col-md-6">
                    <p><strong>ID Đơn Hàng:</strong> <?= htmlspecialchars($order['id'], ENT_QUOTES, 'UTF-8') ?></p>
                    <p><strong>Ngày Tạo:</strong> <?= htmlspecialchars($order['created_at'], ENT_QUOTES, 'UTF-8') ?></p>
                    <p><strong>Tổng Tiền:</strong> <?= number_format($order['total_amount'], 0, ',', '.') ?> VNĐ</p>
                </div>
                <div class="col-md-6 text-md-right">
                    <p><strong>Trạng Thái Đơn Hàng:</strong> <span class="badge bg-success">Đã Thanh Toán</span></p>
                </div>
            </div>

            <h3>Chi Tiết Sản Phẩm</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Tên Sản Phẩm</th>
                        <th>Ảnh</th>
                        <th>Số Lượng</th>
                        <th>Giá</th>
                        <th>Tổng Giá</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orderDetails as $detail): ?>
                        <tr>
                            <td><?= htmlspecialchars($detail['product_name'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td>
                                <img src="<?= htmlspecialchars($detail['img'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($detail['product_name'], ENT_QUOTES, 'UTF-8') ?>" style="max-width:100px;">
                            </td>
                            <td><?= htmlspecialchars($detail['quantity'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= number_format($detail['price'], 0, ',', '.') ?> VNĐ</td>
                            <td><?= number_format($detail['total_price'], 0, ',', '.') ?> VNĐ</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="text-center">
                <a href="/order/list" class="btn btn-info">Quay lại danh sách đơn hàng</a>
                <a href="/checkout" class="btn btn-success">Tiến hành thanh toán khác</a>
            </div>
        <?php endif; ?>
    </div>
</main>
<?php $this->stop() ?>

<?php $this->start("page_specific_js") ?>
<script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.js"></script>
<?php $this->stop() ?>
