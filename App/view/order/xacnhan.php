<!-- views/user/order/confirm.php -->

<h1>Xác nhận đơn hàng</h1>

<p>Cảm ơn bạn đã thanh toán đơn hàng của chúng tôi. Dưới đây là chi tiết đơn hàng của bạn:</p>

<table border="1">
    <thead>
        <tr>
            <th>Sản Phẩm</th>
            <th>Số Lượng</th>
            <th>Giá</th>
            <th>Tổng Tiền</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orderItems as $item): ?>
        <tr>
            <td><?= htmlspecialchars($item['product_name']) ?></td>
            <td><?= htmlspecialchars($item['quantity']) ?></td>
            <td><?= number_format($item['price'], 2) ?> VND</td>
            <td><?= number_format($item['total_price'], 2) ?> VND</td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<p>Tổng số tiền: <?= number_format($totalPrice, 2) ?> VND</p>

<a href="/orders">Trở lại danh sách đơn hàng</a>
