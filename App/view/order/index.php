<?php $this->layout("layouts/default", ["title" => "Đơn Hàng Của Bạn"]) ?>

<?php $this->start("page_specific_css") ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<?php $this->stop() ?>

<?php $this->start("page") ?>
<main>
    <div class="container py-4">
        <h2 class="text-center mb-4">Đơn Hàng Của Bạn</h2>

        <?php if (empty($orders)): ?>
            <div class="alert alert-info text-center">Bạn chưa có đơn hàng nào. Hãy thử mua sắm ngay!</div>
        <?php else: ?>
            <div class="card shadow-sm">
                <div class="card-body p-3">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered align-middle mb-0">
                            <thead class="table-dark text-center align-middle">
                                <tr>
                                    <th>ID Đơn Hàng</th>
                                    <th>Tổng Tiền</th>
                                    <th>Trạng Thái</th>
                                    <th>Ngày Tạo</th>
                                    <th>Tiến Trình</th>
                                    <th>Thao Tác</th>
                                    <th>Phản Hồi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $order): ?>
                                    <tr id="order_<?= htmlspecialchars($order['id'], ENT_QUOTES) ?>">
                                        <td class="text-center fw-bold"><?= htmlspecialchars($order['id'], ENT_QUOTES) ?></td>
                                        <td class="text-end fw-semibold" style="white-space: nowrap;">
                                            <?= number_format($order['total_amount'] ?? 0, 0, ',', '.') ?> VNĐ
                                        </td>
                                        <td class="text-center">
                                            <?php
                                            switch ($order['status']) {
                                                case 'Processing':
                                                    $badgeClass = 'bg-warning text-dark';
                                                    $statusText = 'Đơn hàng đang xử lý';
                                                    $icon = '<i class="fas fa-cogs" title="Đang xử lý"></i>';
                                                    break;
                                                case 'Shipped':
                                                    $badgeClass = 'bg-primary';
                                                    $statusText = 'Đơn hàng đang giao';
                                                    $icon = '<i class="fas fa-truck" title="Đang giao hàng"></i>';
                                                    break;
                                                case 'Delivered':
                                                    $badgeClass = 'bg-success';
                                                    $statusText = 'Đơn hàng đã giao';
                                                    $icon = '<i class="fas fa-check-circle" title="Đã giao"></i>';
                                                    break;
                                                case 'Cancelled':
                                                    $badgeClass = 'bg-danger';
                                                    $statusText = 'Đơn hàng đã hủy';
                                                    $icon = '<i class="fas fa-times-circle" title="Đã hủy"></i>';
                                                    break;
                                                default:
                                                    $badgeClass = 'bg-secondary';
                                                    $statusText = 'Trạng thái chưa xác định';
                                                    $icon = '<i class="fas fa-question-circle" title="Chưa xác định"></i>';
                                            }
                                            ?>
                                            <span class="badge <?= $badgeClass ?> d-inline-flex align-items-center gap-1 px-3 py-2">
                                                <?= $icon ?> <?= $statusText ?>
                                            </span>
                                        </td>
                                        <td class="text-center" style="white-space: nowrap;">
                                            <?= date('d/m/Y H:i', strtotime($order['created_at'] ?? '')) ?>
                                        </td>
                                        <td style="min-width: 230px;">
                                            <?php
                                            $progress = 0;
                                            $progressBarClass = 'bg-secondary';
                                            switch ($order['status']) {
                                                case 'Processing': $progress = 33; $progressBarClass = 'bg-warning'; break;
                                                case 'Shipped': $progress = 66; $progressBarClass = 'bg-primary'; break;
                                                case 'Delivered': $progress = 100; $progressBarClass = 'bg-success'; break;
                                                case 'Cancelled': $progress = 0; $progressBarClass = 'bg-danger'; break;
                                                default: $progress = 0;
                                            }
                                            ?>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="flex-shrink-0">
                                                    <?= $icon ?>
                                                </div>
                                                <div class="progress flex-grow-1" style="height: 20px;">
                                                    <div class="progress-bar <?= $progressBarClass ?>" role="progressbar" style="width: <?= $progress ?>%;" aria-valuenow="<?= $progress ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle" style="min-width: 130px;">
                                            <?php if ($order['status'] == 'Processing'): ?>
                                                <form action="/order/updateStatus/<?= htmlspecialchars($order['id'], ENT_QUOTES) ?>" method="post" class="d-inline-block w-100">
                                                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                                                    <select name="status" class="form-select form-select-sm" onchange="if(confirm('Bạn có chắc chắn muốn thay đổi trạng thái?')) this.form.submit(); else this.selectedIndex=0;">
                                                        <option value="" disabled selected>Chọn trạng thái</option>
                                                        <option value="Cancelled">Hủy đơn hàng</option>
                                                    </select>
                                                </form>
                                            <?php else: ?>
                                                <button class="btn btn-secondary btn-sm" disabled>Không thể cập nhật</button>
                                            <?php endif; ?>
                                        </td>
                                        <td class="align-middle" style="min-width: 250px;">
                                            <?php if ($order['status'] == 'Delivered'): ?>
                                                <?php if (!empty($order['comment'])): ?>
                                                    <div class="alert alert-info p-2 mb-2" role="alert" style="font-size: 0.9rem;">
                                                        <strong>Bình luận hiện tại:</strong><br>
                                                        <?= nl2br(htmlspecialchars($order['comment'], ENT_QUOTES)) ?>
                                                    </div>
                                                <?php endif; ?>
                                                <form action="/order/comment/<?= htmlspecialchars($order['id'], ENT_QUOTES) ?>" method="post" class="mb-0">
                                                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                                                    <textarea name="comment" rows="3" class="form-control form-control-sm mb-2" placeholder="Nhập bình luận về đơn hàng của bạn..."></textarea>
                                                    <button type="submit" class="btn btn-primary btn-sm w-100">Gửi bình luận</button>
                                                </form>
                                            <?php else: ?>
                                                <span class="text-muted fst-italic">Chỉ phản hồi khi đơn đã giao</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<script>
    // Kích hoạt tooltip Bootstrap 5
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'))
        tooltipTriggerList.map(function (el) {
            return new bootstrap.Tooltip(el)
        })
    });
</script>

<?php $this->stop() ?>
