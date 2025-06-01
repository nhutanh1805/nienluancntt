<?php $this->layout("layouts/default", ["title" => "Chi Tiết Thành Viên"]) ?>

<?php $this->start("page") ?>
<main>
    <div class="container">
        <h2 class="text-center mb-4">Chi tiết Thành viên</h2>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php else: ?>
            <div class="card mx-auto" style="max-width: 600px;">
                <div class="card-body">
                    <p><i class="bi bi-person-circle me-2"></i><strong>ID:</strong> <?= htmlspecialchars($member['id'] ?? '') ?></p>
                    <p><i class="bi bi-person me-2"></i><strong>Tên đăng nhập:</strong> <?= htmlspecialchars($member['name'] ?? '') ?></p>
                    <p><i class="bi bi-envelope me-2"></i><strong>Email:</strong> <?= htmlspecialchars($member['email'] ?? '') ?></p>
                    <p><i class="bi bi-calendar-check me-2"></i><strong>Ngày đăng ký:</strong> <?= htmlspecialchars($member['created_at'] ?? '') ?></p>
                    <p><i class="bi bi-shield-lock me-2"></i><strong>Vai trò:</strong> <?= htmlspecialchars($member['role_name'] ?? '') ?></p>
                    <p>
                        <i class="bi bi-slash-circle me-2"></i><strong>Trạng thái cấm:</strong> 
                        <?php 
                            if (!empty($member['is_banned']) && $member['is_banned'] == 1 && !empty($member['banned_until'])) {
                                echo "Đang bị cấm đến " . htmlspecialchars($member['banned_until']);
                            } else {
                                echo "Không bị cấm";
                            }
                        ?>
                    </p>
                </div>
            </div>
        <?php endif; ?>

        <a href="/members" class="btn btn-primary mt-4">&larr; Quay lại danh sách thành viên</a>
    </div>
</main>
<?php $this->stop() ?>
