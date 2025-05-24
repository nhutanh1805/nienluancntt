<?php $this->layout("layouts/default", ["title" => "Giỏ Hàng"]) ?>

<?php $this->start("page_specific_css") ?>
<link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.css" rel="stylesheet">
<?php $this->stop() ?>

<?php $this->start("page") ?>
<main>
    <div class="container">
        <h2 class="text-center">Giỏ Hàng</h2>

        <?php if (empty($cart)): ?>
            <p class="text-center">
                Giỏ hàng của bạn đang trống. <span class="font-weight-bold text-danger">Đừng bỏ lỡ cơ hội!</span> Khám phá ngay những <span class="font-weight-bold text-success">sản phẩm hot nhất</span> và <span class="font-weight-bold text-info">thêm vào giỏ hàng của bạn</span> để nhận <span class="font-weight-bold text-primary">ưu đãi đặc biệt</span>!
                <br>
                <a href="/product" class="btn btn-lg btn-warning mt-3 px-4 py-2 text-white shadow-sm hover-shadow-lg">Mua sắm ngay</a>
            </p>
        <?php else: ?>
            <table class="table">
                <thead>
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
                            <td><?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td>
                                <img src="<?= htmlspecialchars($item['img'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?>" style="max-width:150px;">
                            </td>
                            <td>
                                <form action="/cart/update/<?= $item['id'] ?>" method="POST">
                                    <input type="number" name="quantity" value="<?= htmlspecialchars($item['quantity'], ENT_QUOTES, 'UTF-8') ?>" min="1" required>
                                    <button type="submit" class="btn btn-sm btn-primary">Cập nhật</button>
                                </form>
                            </td>
                            <td><?= number_format($item['price'], 0, ',', '.') ?> VNĐ</td>
                            <td><?= number_format($item['total_price'], 0, ',', '.') ?> VNĐ</td>
                            <td>
                                <form action="/cart/remove/<?= $item['id'] ?>" method="POST" onsubmit="return confirm('Bạn chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?');">
                                    <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="4" class="text-right"><strong>Tổng tiền:</strong></td>
                        <td><strong><?= number_format($total, 0, ',', '.') ?> VNĐ</strong></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>

            <a href="/checkout" class="btn btn-success">Thanh toán</a>
        <?php endif; ?>
    </div>
</main>
<?php $this->stop() ?>

<?php $this->start("page_specific_js") ?>
<script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.js"></script>
<?php $this->stop() ?>
