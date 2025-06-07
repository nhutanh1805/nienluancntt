<?php $this->layout("layouts/default", ["title" => "Danh Sách Đơn Hàng"]) ?>

<?php $this->start("page") ?>
<main>
    <div class="container py-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white text-center">
                <h3 class="mb-0"><i class="bi bi-card-list"></i> Danh Sách Đơn Hàng</h3>
            </div>
            <div class="card-body">
                <?php if (empty($orders)): ?>
                    <div class="alert alert-info text-center">
                        <i class="bi bi-cart-x"></i> Bạn chưa có đơn hàng nào. Hãy thử mua sắm ngay!
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle table-hover">
                            <thead class="table-dark text-center">
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
                                        <td class="text-center"><?= htmlspecialchars($order['id']) ?></td>
                                        <td class="text-center"><?= htmlspecialchars($order['user_id']) ?></td>
                                        <td class="text-end text-success fw-bold">
                                            <?= number_format($order['total_amount'] ?? 0, 0, ',', '.') ?> VNĐ
                                        </td>
                                        <td class="text-center" id="status_<?= $order['id'] ?>">
                                            <?php
                                            switch ($order['status']) {
                                                case 'Processing':
                                                    echo '<span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split"></i> Đang xử lý</span>';
                                                    break;
                                                case 'Shipped':
                                                    echo '<span class="badge bg-primary"><i class="bi bi-truck"></i> Đang giao</span>';
                                                    break;
                                                case 'Delivered':
                                                    echo '<span class="badge bg-success"><i class="bi bi-check-circle"></i> Đã giao</span>';
                                                    break;
                                                case 'Cancelled':
                                                    echo '<span class="badge bg-danger"><i class="bi bi-x-circle"></i> Đã hủy</span>';
                                                    break;
                                                default:
                                                    echo '<span class="badge bg-secondary">Chưa rõ</span>';
                                                    break;
                                            }
                                            ?>
                                        </td>
                                        <td class="text-center"><?= htmlspecialchars($order['created_at']) ?></td>
                                        <td class="text-center">
                                            <a href="/order/view/<?= $order['id'] ?>" class="btn btn-sm btn-info mb-1">
                                                <i class="bi bi-eye"></i> Chi tiết
                                            </a>
                                            <a href="/order/delete/<?= $order['id'] ?>" class="btn btn-sm btn-danger mb-1"
                                               onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?')">
                                                <i class="bi bi-trash"></i> Xóa
                                            </a>

                                            <?php if ($order['status'] != 'Delivered' && $order['status'] != 'Cancelled'): ?>
                                                <form action="/order/updateStatus/<?= $order['id'] ?>" method="post" class="d-inline">
                                                    <select name="status" class="form-select form-select-sm d-inline w-auto" onchange="this.form.submit()">
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
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>
<?php $this->stop() ?>
