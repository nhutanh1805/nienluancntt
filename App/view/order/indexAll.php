<?php $this->layout("layouts/default", ["title" => "Danh Sách Đơn Hàng"]) ?>

<?php $this->start("page") ?>
<main>
    <div class="container">
        <h2 class="text-center">Danh Sách Đơn Hàng</h2>

        <?php if (empty($orders)): ?>
            <p class="text-center">Bạn chưa có đơn hàng nào. Hãy thử mua sắm ngay!</p>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID Đơn Hàng</th>
                        <th>ID Người Dùng</th>
                        <th>Tổng Tiền</th>
                        <th>Trạng Thái</th>
                        <th>Ngày Tạo</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr id="order_<?= $order['id'] ?>">
                            <td><?= htmlspecialchars($order['id'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($order['user_id'], ENT_QUOTES, 'UTF-8') ?></td> <!-- Hiển thị ID Người Dùng -->
                            
                            <td>
                                <?php
                                // Hiển thị tổng tiền với định dạng VNĐ
                                $totalAmount = $order['total_amount'] ?? 0;
                                echo number_format($totalAmount, 0, ',', '.') . ' VNĐ';
                                ?>
                            </td>
                            <td id="status_<?= $order['id'] ?>">
                                <?php
                                // Hiển thị trạng thái đơn hàng
                                switch ($order['status']) {
                                    case 'Processing':
                                        echo '<span class="badge bg-warning">Đơn hàng đang được xử lý</span>';
                                        break;
                                    case 'Shipped':
                                        echo '<span class="badge bg-primary">Đơn hàng đang được giao</span>';
                                        break;
                                    case 'Delivered':
                                        echo '<span class="badge bg-success">Đơn hàng đã giao</span>';
                                        break;
                                    case 'Cancelled':
                                        echo '<span class="badge bg-danger">Đơn hàng đã hủy</span>';
                                        break;
                                    default:
                                        echo '<span class="badge bg-secondary">Trạng thái chưa xác định</span>';
                                        break;
                                }
                                ?>
                            </td>
                            <td><?= htmlspecialchars($order['created_at'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td>
                                <a href="/order/view/<?= $order['id'] ?>" class="btn btn-info">Chi tiết</a>
                                
                                <!-- Xóa đơn hàng ở mọi trạng thái -->
                                <a href="/order/delete/<?= $order['id'] ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?')">Xóa</a>

                                <!-- Cập nhật trạng thái đơn hàng, chỉ cho phép cập nhật khi đơn hàng không phải là 'Delivered' hoặc 'Cancelled' -->
                                <?php if ($order['status'] != 'Delivered' && $order['status'] != 'Cancelled'): ?>
                                    <form action="/order/updateStatus/<?= $order['id'] ?>" method="post" class="status-form" style="display:inline;">
                                        <label for="status_<?= $order['id'] ?>" class="form-label">Trạng thái:</label>
                                        <select name="status" id="status_select_<?= $order['id'] ?>" class="form-select" onchange="this.form.submit()">
                                            <option value="Processing" <?= $order['status'] == 'Processing' ? 'selected' : '' ?>>Đang xử lý</option>
                                            <option value="Shipped" <?= $order['status'] == 'Shipped' ? 'selected' : '' ?>>Đang giao hàng</option>
                                            <option value="Delivered" <?= $order['status'] == 'Delivered' ? 'selected' : '' ?>>Đã giao</option>
                                            <option value="Cancelled" <?= $order['status'] == 'Cancelled' ? 'selected' : '' ?>>Đã hủy</option>
                                        </select>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</main>
<?php $this->stop() ?>
