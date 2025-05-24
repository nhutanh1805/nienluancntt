<?php $this->layout("layouts/default", ["title" => "Thanh Toán"]) ?>

<?php $this->start("page") ?>
<main>
    <div class="container">
        <h2 class="text-center">Thông tin thanh toán</h2>

        <!-- Hiển thị giỏ hàng -->
        <h3 class="text-center">Giỏ hàng của bạn</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                    <th>Tổng</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart as $productId => $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td><?= number_format($item['price'], 0, ',', '.') ?> VNĐ</td>
                        <td><?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> VNĐ</td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3" class="text-right"><strong>Tổng tiền:</strong></td>
                    <td><strong><?= number_format($total, 0, ',', '.') ?> VNĐ</strong></td>
                </tr>
            </tbody>
        </table>

        <!-- Form thanh toán -->
        <form action="/checkout/process" method="post">
            <div class="form-group">
                <label for="name">Họ và tên</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="address">Địa chỉ</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>

            <div class="form-group">
                <label for="payment_method">Phương thức thanh toán</label>
                <select class="form-control" id="payment_method" name="payment_method" required>
                    <option value="cod">Thanh toán khi nhận hàng</option>
                    <!-- <option value="credit_card">Thẻ tín dụng</option>
                    <option value="paypal">PayPal</option>
                    <option value="bank_transfer">Chuyển khoản ngân hàng</option> -->
                </select>
            </div>

            <div class="form-group" id="card_number_group" style="display: none;">
                <label for="card_number">Số thẻ tín dụng</label>
                <input type="text" class="form-control" id="card_number" name="card_number" placeholder="Nhập số thẻ tín dụng" />
            </div>

            <button type="submit" class="btn btn-success">Thanh toán</button>
        </form>
    </div>
</main>

<script>
    // Hiển thị/ẩn trường số thẻ tín dụng dựa trên phương thức thanh toán
    document.getElementById('payment_method').addEventListener('change', function () {
        var cardNumberGroup = document.getElementById('card_number_group');
        if (this.value === 'credit_card') {
            cardNumberGroup.style.display = 'block'; // Hiển thị trường số thẻ tín dụng
        } else {
            cardNumberGroup.style.display = 'none'; // Ẩn trường số thẻ tín dụng
        }
    });
</script>

<?php $this->stop() ?>
