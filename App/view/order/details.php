<?php if (isset($error)): ?>
    <div style="color: red;">
        <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>

<?php if (isset($orderItems) && !empty($orderItems)): ?>
    <div class="order-details">
        <h1>Chi tiết đơn hàng #<?php echo htmlspecialchars($orderItems[0]['order_id']); ?></h1>
        
        <!-- Thông tin đơn hàng -->
        <p><strong>Người mua:</strong> <?php echo htmlspecialchars($orderItems[0]['user_name']); ?></p>
        <p><strong>Địa chỉ giao hàng:</strong> <?php echo htmlspecialchars($orderItems[0]['order_address']); ?></p>
        <p><strong>Trạng thái đơn hàng:</strong> <?php echo htmlspecialchars($orderItems[0]['order_status']); ?></p>
        <p><strong>Ngày tạo đơn hàng:</strong> <?php echo htmlspecialchars($orderItems[0]['order_created_at']); ?></p>
        <p><strong>Ngày cập nhật:</strong> <?php echo htmlspecialchars($orderItems[0]['order_updated_at']); ?></p>

        <!-- Danh sách sản phẩm -->
        <h2>Danh sách sản phẩm trong đơn hàng</h2>
        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>Ảnh sản phẩm</th>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                    <th>Tổng tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orderItems as $detail): ?>
                    <tr>
                        <td>
                            <!-- Hiển thị ảnh sản phẩm -->
                            <img src="<?php echo htmlspecialchars($detail['product_img']); ?>" width="100" alt="Image">
                        </td>
                        <td><?php echo htmlspecialchars($detail['product_name']); ?></td>
                        <td><?php echo htmlspecialchars($detail['quantity']); ?></td>
                        <td><?php echo number_format($detail['product_price'], 2); ?> VNĐ</td>
                        <td><?php echo number_format($detail['total_price'], 2); ?> VNĐ</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Tổng giá trị đơn hàng -->
        <h3>Tổng giá trị đơn hàng: <?php echo number_format(array_sum(array_column($orderItems, 'total_price')), 2); ?> VNĐ</h3>

    </div>
<?php else: ?>
    <p>Không có sản phẩm nào trong đơn hàng này.</p>
<?php endif; ?>

<!-- Thêm CSS để cải thiện giao diện -->
<style>
    .order-details {
        font-family: Arial, sans-serif;
        color: #333;
        margin: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 10px;
        text-align: left;
        border: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
    }

    img {
        max-width: 100px;
        height: auto;
    }

    h1, h2, h3 {
        color: #333;
    }

    .error {
        color: red;
    }
</style>
