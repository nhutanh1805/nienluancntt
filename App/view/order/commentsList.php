<?php $this->layout("layouts/default", ["title" => "Danh sách bình luận đơn hàng"]) ?>

<?php $this->start("page_specific_css") ?>
<link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/datatables.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<style>
    .highlight-comment {
        background-color: #f8f9fa;
        border-left: 4px solid #0d6efd;
        padding: 8px 12px;
        border-radius: 4px;
        font-style: italic;
    }
</style>
<?php $this->stop() ?>

<?php $this->start("page") ?>
<main>
    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white text-center">
                <h3 class="mb-0"><i class="bi bi-chat-dots-fill"></i> Danh sách bình luận đơn hàng</h3>
            </div>
            <div class="card-body">

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <?php if (!empty($comments)): ?>
                    <div class="table-responsive">
                        <table id="commentsTable" class="table table-bordered table-hover align-middle">
                            <thead class="table-light text-center">
                                <tr>
                                    <th>ID Đơn hàng</th>
                                    <th>ID Người dùng</th>
                                    <th>Tên người dùng</th>
                                    <th>Tổng tiền</th>
                                    <th>Bình luận</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($comments as $comment): ?>
                                    <tr>
                                        <td class="text-center text-muted"><?= htmlspecialchars($comment['id']) ?></td>
                                        <td class="text-center"><?= htmlspecialchars($comment['user_id']) ?></td>
                                        <td>
                                            <i class="bi bi-person-circle text-primary"></i>
                                            <?= htmlspecialchars($comment['user_name']) ?>
                                        </td>
                                        <td class="text-end fw-semibold text-success">
                                            <?= number_format($comment['total_amount'], 0, ',', '.') ?> <sup>VNĐ</sup>
                                        </td>
                                        <td>
                                            <div class="highlight-comment">
                                                <?= nl2br(htmlspecialchars($comment['cmt'])) ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info text-center">
                        <i class="bi bi-info-circle-fill"></i> Chưa có bình luận nào được ghi nhận.
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</main>
<?php $this->stop() ?>

<?php $this->start("page_specific_js") ?>
<script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#commentsTable').DataTable({
            responsive: true,
            paging: true,
            searching: true,
            ordering: true,
            lengthMenu: [10, 25, 50],
            order: [[0, 'desc']],
            language: {
                search: "🔍 Tìm kiếm:",
                lengthMenu: "Hiển thị _MENU_ mục",
                info: "Hiển thị _START_ đến _END_ của _TOTAL_ mục",
                infoEmpty: "Không có dữ liệu",
                infoFiltered: "(lọc từ _MAX_ mục)",
                paginate: {
                    previous: "← Trước",
                    next: "Tiếp →"
                }
            }
        });
    });
</script>
<?php $this->stop() ?>
