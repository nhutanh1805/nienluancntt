<?php $this->layout("layouts/default", ["title" => "Thanh Toán Online"]) ?>

<?php $this->start("page") ?>
<main>
    <div class="container">
        <h2 class="text-center">Thanh Toán Online</h2>

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

        <!-- Form thanh toán thẻ tín dụng -->
        <form action="/checkout/process-online-payment" method="post">
            <div class="form-group">
                <label for="card_number">Số thẻ tín dụng</label>
                <input type="text" class="form-control" id="card_number" name="card_number" required placeholder="Nhập số thẻ tín dụng" />
            </div>

            <div class="form-group">
                <label for="expiry_date">Ngày hết hạn</label>
                <input type="text" class="form-control" id="expiry_date" name="expiry_date" required placeholder="MM/YY" />
            </div>

            <div class="form-group">
                <label for="cvv">Mã CVV</label>
                <input type="text" class="form-control" id="cvv" name="cvv" required placeholder="Nhập mã CVV" />
            </div>

            <button type="submit" class="btn btn-success">Thanh toán</button>
        </form>
    </div>
</main>
<?php $this->stop() ?>
