<?php $this->layout("layouts/default", ["title" => "Thống kê Doanh thu"]) ?>

<?php $this->start("page_specific_css") ?>
<link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<style>
    form.filter-form {
        max-width: 480px;
        margin-bottom: 30px;
    }
    /* Làm bảng có hiệu ứng hover rõ nét */
    #revenueTable tbody tr:hover {
        background-color: #f1f7ff;
    }
    /* Căn giữa cột trạng thái và người đặt */
    .text-center-vertical {
        vertical-align: middle !important;
        text-align: center;
    }
</style>
<?php $this->stop() ?>

<?php $this->start("page") ?>
<main>
    <div class="container py-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white text-center">
                <h3 class="mb-0"><i class="bi bi-bar-chart-fill me-2"></i>Thống kê Doanh thu</h3>
            </div>
            <div class="card-body">

                <form class="filter-form row g-3 align-items-end" method="GET" action="/thongke" novalidate>
                    <div class="col-12 col-md-5">
                        <label for="filterType" class="form-label fw-semibold">Lọc theo</label>
                        <select name="filterType" id="filterType" class="form-select" required>
                            <option value="all" <?= ($filterType === 'all') ? 'selected' : '' ?>>Tất cả</option>
                            <option value="day" <?= ($filterType === 'day') ? 'selected' : '' ?>>Ngày</option>
                            <option value="month" <?= ($filterType === 'month') ? 'selected' : '' ?>>Tháng</option>
                            <option value="year" <?= ($filterType === 'year') ? 'selected' : '' ?>>Năm</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-5" id="filterValueContainer">
                        <?php if ($filterType === 'day'): ?>
                            <label for="filterValue" class="form-label visually-hidden">Chọn ngày</label>
                            <input type="date" id="filterValue" name="filterValue" class="form-control" value="<?= htmlspecialchars($filterValue ?? '') ?>" required>
                        <?php elseif ($filterType === 'month'): ?>
                            <label for="filterValue" class="form-label visually-hidden">Chọn tháng</label>
                            <input type="month" id="filterValue" name="filterValue" class="form-control" value="<?= htmlspecialchars($filterValue ?? '') ?>" required>
                        <?php elseif ($filterType === 'year'): ?>
                            <label for="filterValue" class="form-label visually-hidden">Chọn năm</label>
                            <input type="number" id="filterValue" name="filterValue" class="form-control" min="2000" max="2100" step="1" value="<?= htmlspecialchars($filterValue ?? '') ?>" required>
                        <?php else: ?>
                            <input type="hidden" name="filterValue" value="">
                        <?php endif; ?>
                    </div>

                    <div class="col-12 col-md-2 d-grid">
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-funnel-fill me-1"></i> Lọc
                        </button>
                    </div>
                </form>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= htmlspecialchars($error) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
                    </div>
                <?php else: ?>

                    <div class="mb-4 p-4 bg-light rounded-3 border border-success">
                        <h5 class="text-success fw-bold mb-2">
                            <i class="bi bi-currency-dollar me-2"></i>Tổng doanh thu
                        </h5>
                        <p class="fs-3 fw-bold text-success mb-0"><?= number_format($totalRevenue, 0, ',', '.') ?> VNĐ</p>
                    </div>

                    <div class="mb-5">
                        <h5 class="fw-semibold mb-3 text-info">
                            <i class="bi bi-clipboard-data-fill me-2"></i>Trạng thái đơn hàng
                        </h5>
                        <ul class="list-group shadow-sm">
                            <?php foreach ($orderCounts as $item): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?= translateStatusToVietnamese($item['status']) ?>
                                    <span class="badge bg-secondary rounded-pill fs-6"><?= $item['count'] ?> đơn</span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <h5 class="mb-3 text-warning fw-semibold">
                        <i class="bi bi-truck me-2"></i>Danh sách đơn hàng đã giao
                    </h5>
                    <div class="table-responsive shadow-sm rounded">
                        <table id="revenueTable" class="table table-striped table-bordered align-middle table-hover">
                            <thead class="table-light text-center align-middle">
                                <tr>
                                    <th style="width: 5%;">ID</th>
                                    <th style="width: 15%;">Người đặt</th>
                                    <th style="width: 15%;">Tổng tiền</th>
                                    <th style="width: 20%;">Ngày đặt</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($deliveredOrders as $order): ?>
                                    <tr>
                                        <td class="text-center-vertical"><?= $order['id'] ?></td>
                                        <td class="text-center-vertical"><?= $order['user_id'] ?></td>
                                        <td class="text-end text-success fw-semibold"><?= number_format($order['total_amount'], 0, ',', '.') ?> VNĐ</td>
                                        <td class="text-center-vertical"><?= $order['created_at'] ?></td>
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

<script>
    function updateFilterValueInput() {
        const filterType = document.getElementById('filterType').value;
        const container = document.getElementById('filterValueContainer');
        let html = '';
        if (filterType === 'day') {
            html = '<label for="filterValue" class="form-label visually-hidden">Chọn ngày</label><input type="date" id="filterValue" name="filterValue" class="form-control" required>';
        } else if (filterType === 'month') {
            html = '<label for="filterValue" class="form-label visually-hidden">Chọn tháng</label><input type="month" id="filterValue" name="filterValue" class="form-control" required>';
        } else if (filterType === 'year') {
            html = '<label for="filterValue" class="form-label visually-hidden">Chọn năm</label><input type="number" id="filterValue" name="filterValue" class="form-control" min="2000" max="2100" step="1" required>';
        } else {
            html = '<input type="hidden" name="filterValue" value="">';
        }
        container.innerHTML = html;
    }
    document.getElementById('filterType').addEventListener('change', updateFilterValueInput);
</script>

<?php $this->stop() ?>

<?php $this->start("page_specific_js") ?>
<script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#revenueTable').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            lengthMenu: [10, 25, 50, 100],
            language: {
                search: "🔍 Tìm kiếm:",
                lengthMenu: "Hiển thị _MENU_ mục",
                info: "Hiển thị _START_ đến _END_ của _TOTAL_ đơn",
                infoEmpty: "Không có đơn hàng",
                infoFiltered: "(lọc từ _MAX_ đơn)",
                paginate: {
                    previous: "← Trước",
                    next: "Tiếp →"
                }
            }
        });
    });
</script>
<?php $this->stop() ?>

<?php
function translateStatusToVietnamese(string $status): string {
    return match($status) {
        'Delivered' => 'Đã giao',
        'Cancelled' => 'Đã hủy',
        'Processing' => 'Đang xử lý',
        'Shipped' => 'Đang giao hàng',
        default => $status,
    };
}
?>
