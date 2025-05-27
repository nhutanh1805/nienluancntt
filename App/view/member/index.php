<?php $this->layout("layouts/default", ["title" => "Danh Sách Thành Viên"]) ?>

<?php $this->start("page_specific_css") ?>
<link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.css" rel="stylesheet">
<?php $this->stop() ?>

<?php $this->start("page") ?>
<main>
    <div class="container">
        <h2 class="text-center mb-4">Danh sách Thành viên</h2>

        <?php if (!empty($_SESSION['success_message'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['success_message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <?php if (!empty($_SESSION['error_message'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['error_message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['error_message']); ?>
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
                        <th>Vai trò</th>
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
                        <td><?= htmlspecialchars($member['role_name'] ?? '') ?></td>
                        <td>
                            <a href="/member/view/<?= urlencode($member['id'] ?? '') ?>" class="btn btn-sm btn-info">Xem</a>
                            <a href="/member/delete/<?= urlencode($member['id'] ?? '') ?>" 
                               class="btn btn-sm btn-danger" 
                               onclick="return confirm('Bạn có chắc chắn muốn xóa thành viên này?');">
                               Xóa
                            </a>

                            <!-- Form Ban -->
                            <form action="/member/ban/<?= htmlspecialchars($member['id']) ?>" method="POST" class="d-inline-block ms-2" style="vertical-align: middle;">
                                <input type="number" name="ban_minutes" min="1" placeholder="Phút cấm" required style="width: 80px;" class="form-control form-control-sm d-inline-block" />
                                <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Bạn có chắc chắn muốn cấm người dùng này?')">Ban</button>
                            </form>

                            <?php
                            // Hiển thị thời gian còn lại khi bị ban
                            if (!empty($member['is_banned']) && $member['is_banned'] == 1 && !empty($member['banned_until'])):
                                $now = new DateTime();
                                $bannedUntil = new DateTime($member['banned_until']);
                                if ($bannedUntil > $now):
                                    $interval = $now->diff($bannedUntil);
                                    $minutesLeft = ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i;
                            ?>
                                <span class="badge bg-danger ms-2" title="Cấm đến <?= htmlspecialchars($member['banned_until']) ?>">
                                    Bị cấm còn <?= $minutesLeft ?> phút
                                </span>

                                <!-- Form Bỏ Ban -->
                                <form action="/member/unban/<?= htmlspecialchars($member['id']) ?>" method="POST" class="d-inline-block ms-2" style="vertical-align: middle;">
                                    <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Bạn có chắc chắn muốn bỏ cấm người dùng này?')">Bỏ Ban</button>
                                </form>

                            <?php
                                endif;
                            endif;
                            ?>
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
