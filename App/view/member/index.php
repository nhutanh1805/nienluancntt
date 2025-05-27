<?php $this->layout("layouts/default", ["title" => "Danh Sách Thành Viên"]) ?>

<?php $this->start("page_specific_css") ?>
<link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.css" rel="stylesheet">
<?php $this->stop() ?>

<?php $this->start("page") ?>
<main>
    <div class="container">
        <h2 class="text-center mb-4">Danh sách Thành viên</h2>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <?php if (empty($members)): ?>
            <p class="text-center text-muted">Hiện chưa có thành viên nào.</p>
        <?php else: ?>
            <table id="memberTable" class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Tên đăng nhập</th>
                        <th>Email</th>
                        <th>Ngày đăng ký</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($members as $member): ?>
                    <tr>
                        <td><?= htmlspecialchars($member['id'] ?? '') ?></td>
                        <td><?= htmlspecialchars($member['name'] ?? '') ?></td>
                        <td><?= htmlspecialchars($member['email'] ?? '') ?></td>
                        <td><?= htmlspecialchars($member['created_at'] ?? '') ?></td>
                        <td>
                            <a href="/member/view/<?= urlencode($member['id'] ?? '') ?>" class="btn btn-sm btn-info">Xem</a>
                            <a href="/member/delete/<?= urlencode($member['id'] ?? '') ?>" 
                               class="btn btn-sm btn-danger" 
                               onclick="return confirm('Bạn có chắc chắn muốn xóa thành viên này?');">
                               Xóa
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</main>
<?php $this->stop() ?>

<?php $this->start("page_specific_js") ?>
<script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#memberTable').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            lengthMenu: [10, 25, 50, 100],
            language: {
                search: "Tìm kiếm:",
                lengthMenu: "Hiển thị _MENU_ mục",
                info: "Hiển thị _START_ đến _END_ của _TOTAL_ mục",
                infoEmpty: "Không có dữ liệu",
                infoFiltered: "(Lọc từ _MAX_ mục)",
                paginate: {
                    previous: "Trước",
                    next: "Tiếp"
                }
            }
        });
    });
</script>
<?php $this->stop() ?>
