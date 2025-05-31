<?php $this->layout("layouts/default", ["title" => "Danh sách bình luận đơn hàng"]) ?>

<?php $this->start("page_specific_css") ?>
<link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.css" rel="stylesheet">
<?php $this->stop() ?>

<?php $this->start("page") ?>
<main>
    <div class="container mt-4">
        <h2 class="text-center mb-4">Danh sách bình luận đơn hàng</h2>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if (!empty($comments)): ?>
            <table id="commentsTable" class="table table-bordered table-striped table-hover">
                <thead class="thead-dark">
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
            <td><?= htmlspecialchars($comment['id']) ?></td>
            <td><?= htmlspecialchars($comment['user_id']) ?></td>
            <td><?= htmlspecialchars($comment['user_name']) ?></td>
            <td><?= number_format($comment['total_amount'], 0, ',', '.') ?> VNĐ</td>
            <td><?= nl2br(htmlspecialchars($comment['cmt'])) ?></td>
        </tr>
    <?php endforeach; ?>
</tbody>
            </table>
        <?php else: ?>
            <p class="text-center">Chưa có bình luận nào.</p>
        <?php endif; ?>
    </div>
</main>
<?php $this->stop() ?>

<?php $this->start("page_specific_js") ?>
<script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#commentsTable').DataTable({
            responsive: true,
            paging: true,
            searching: true,
            ordering: true,
            language: {
                search: "Tìm kiếm:",
                lengthMenu: "Hiển thị _MENU_ mục",
                info: "Hiển thị _START_ đến _END_ của _TOTAL_ mục",
                paginate: {
                    first: "Đầu",
                    last: "Cuối",
                    next: "Tiếp",
                    previous: "Trước"
                }
            }
        });
    });
</script>
<?php $this->stop() ?>
