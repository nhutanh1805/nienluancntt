<?php $this->layout("layouts/default", ["title" => "Danh Sách Đơn Hàng"]) ?>

<?php $this->start("page") ?>
<main>
    <div class="container py-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white text-center">
                <h3 class="mb-0"><i class="bi bi-card-list"></i> Danh Sách Đơn Hàng</h3>
            </div>
            <div class="card-body">

                <!-- Form lọc đơn hàng -->
                <form method="get" action="/order/filter" class="row g-3 mb-4">
                    <div class="col-md-3">
                        <label for="filterType" class="form-label">Loại lọc</label>
                        <select name="filterType" id="filterType" class="form-select">
                            <option value="all" <?= ($_GET['filterType'] ?? '') == 'all' ? 'selected' : '' ?>>Tất cả</option>
                            <option value="day" <?= ($_GET['filterType'] ?? '') == 'day' ? 'selected' : '' ?>>Theo ngày</option>
                            <option value="month" <?= ($_GET['filterType'] ?? '') == 'month' ? 'selected' : '' ?>>Theo tháng</option>
                            <option value="year" <?= ($_GET['filterType'] ?? '') == 'year' ? 'selected' : '' ?>>Theo năm</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="filterValue" class="form-label">Giá trị lọc</label>
                        <input type="text" class="form-control" name="filterValue" id="filterValue" 
                            placeholder="VD: 2025-07-18 hoặc 2025-07 hoặc 2025" 
                            value="<?= htmlspecialchars($_GET['filterValue'] ?? '') ?>">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-filter"></i> Lọc
                        </button>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <a href="/order/index" class="btn btn-secondary w-100">
                            <i class="bi bi-arrow-counterclockwise"></i> Reset
                        </a>
                    </div>
                </form>

                <?php if (empty($orders)): ?>
                    <div class="alert alert-info text-center">
                        <i class="bi bi-cart-x"></i> Không có đơn hàng phù hợp với tiêu chí lọc.
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle table-hover">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th>Mã Đơn Hàng</th>
                                    <th>Mã Người Dùng</th>
                                    <th>Tên Người Dùng</th> 
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
                                        <td class="text-center"><?= htmlspecialchars($order['name']) ?></td>
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

                    <!-- Nút về đầu trang -->
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center mt-3">
                            <li class="page-item active">
                                <a class="page-link" href="#" onclick="window.scrollTo({ top: 0, behavior: 'smooth' })">
                                    <i class="bi bi-arrow-up-circle"></i> Về đầu trang
                                </a>
                            </li>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>
<?php $this->stop() ?>
