<?php $this->layout("layouts/default", ["title" => "Danh Sách Thành Viên"]) ?>

<?php $this->start("page_specific_css") ?>
<link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<?php $this->stop() ?>

<?php $this->start("page") ?>
<main>
    <div class="container py-4">
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white text-center">
                <h3 class="mb-0"><i class="bi bi-people-fill me-2"></i>Danh sách Thành viên</h3>
            </div>
            <div class="card-body">
                <?php if (!empty($_SESSION['success_message'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-1"></i> <?= htmlspecialchars($_SESSION['success_message']) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['success_message']); ?>
                <?php endif; ?>

                <?php if (!empty($_SESSION['error_message'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-1"></i> <?= htmlspecialchars($_SESSION['error_message']) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['error_message']); ?>
                <?php endif; ?>

                <?php if (empty($members)): ?>
                    <div class="text-center text-muted">Hiện chưa có thành viên nào.</div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table id="memberTable" class="table table-striped table-bordered align-middle">
                            <thead class="table-light text-center">
                                <tr>
                                    <th><i class="bi bi-hash me-1"></i>ID</th>
                                    <th><i class="bi bi-person-fill me-1"></i>Tên đăng nhập</th>
                                    <th><i class="bi bi-envelope-fill me-1"></i>Email</th>
                                    <th><i class="bi bi-calendar-check-fill me-1"></i>Ngày đăng ký</th>
                                    <th><i class="bi bi-person-badge-fill me-1"></i>Vai trò</th>
                                    <th><i class="bi bi-tools me-1"></i>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($members as $member): ?>
                                <tr>
                                    <td class="text-center"><?= htmlspecialchars($member['id'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($member['name'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($member['email'] ?? '') ?></td>
                                    <td class="text-center"><?= htmlspecialchars($member['created_at'] ?? '') ?></td>
                                    <td class="text-center"><?= htmlspecialchars($member['role_name'] ?? '') ?></td>
                                    <td class="text-center">
                                        <a href="/members/view/<?= urlencode($member['id']) ?>" class="btn btn-sm btn-info mb-1">
                                            <i class="bi bi-eye"></i> Xem
                                        </a>

                                        <a href="/members/delete/<?= urlencode($member['id']) ?>" 
                                           class="btn btn-sm btn-danger mb-1"
                                           onclick="return confirm('Bạn có chắc chắn muốn xóa thành viên này?');">
                                           <i class="bi bi-trash"></i> Xóa
                                        </a>

                                        <form action="/member/ban/<?= htmlspecialchars($member['id']) ?>" method="POST" class="d-inline-block mb-1 mt-1">
                                            <div class="input-group input-group-sm">
                                                <input type="number" name="ban_minutes" min="1" placeholder="phút" required class="form-control" style="max-width: 80px;">
                                                <button type="submit" class="btn btn-warning" onclick="return confirm('Cấm người dùng này?')">
                                                    <i class="bi bi-slash-circle"></i> Cấm
                                                </button>
                                            </div>
                                        </form>

                                        <?php
                                        if (!empty($member['is_banned']) && $member['is_banned'] == 1 && !empty($member['banned_until'])):
                                            $now = new DateTime();
                                            $bannedUntil = new DateTime($member['banned_until']);
                                            if ($bannedUntil > $now):
                                                $interval = $now->diff($bannedUntil);
                                                $minutesLeft = ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i;
                                        ?>
                                            <span class="badge bg-danger d-block mt-2" title="Đến <?= htmlspecialchars($member['banned_until']) ?>">
                                                <i class="bi bi-lock-fill"></i> Còn <?= $minutesLeft ?> phút
                                            </span>

                                            <form action="/member/unban/<?= htmlspecialchars($member['id']) ?>" method="POST" class="d-inline-block mt-2">
                                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Bỏ cấm người dùng này?')">
                                                    <i class="bi bi-unlock-fill"></i> Bỏ Cấm
                                                </button>
                                            </form>
                                        <?php endif; endif; ?>
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
                search: "🔍 Tìm kiếm:",
                lengthMenu: "Hiển thị _MENU_ mục",
                info: "Hiển thị _START_ đến _END_ của _TOTAL_ mục",
                infoEmpty: "Không có dữ liệu",
                infoFiltered: "(Lọc từ _MAX_ mục)",
                paginate: {
                    previous: "← Trước",
                    next: "Tiếp →"
                }
            }
        });
    });
</script>
<?php $this->stop() ?>
