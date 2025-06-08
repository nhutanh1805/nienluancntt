<?php $this->layout("layouts/default", ["title" => "Chi Tiết Thành Viên"]) ?>

<?php $this->start("page") ?>
<main>
    <div class="container py-4">
        <h2 class="text-center mb-4"><i class="bi bi-person-lines-fill"></i> Chi tiết Thành viên</h2>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger text-center" role="alert">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php else: ?>
            <div class="card shadow-sm mx-auto" style="max-width: 600px;">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0"><i class="bi bi-info-circle-fill me-2"></i>Thông tin thành viên</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-5 fw-bold"><i class="bi bi-person-circle me-2"></i>ID:</div>
                        <div class="col-7"><?= htmlspecialchars($member['id'] ?? '') ?></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-bold"><i class="bi bi-person me-2"></i>Tên đăng nhập:</div>
                        <div class="col-7"><?= htmlspecialchars($member['name'] ?? '') ?></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-bold"><i class="bi bi-envelope me-2"></i>Email:</div>
                        <div class="col-7"><?= htmlspecialchars($member['email'] ?? '') ?></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-bold"><i class="bi bi-calendar-check me-2"></i>Ngày đăng ký:</div>
                        <div class="col-7"><?= htmlspecialchars($member['created_at'] ?? '') ?></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-bold"><i class="bi bi-shield-lock me-2"></i>Vai trò:</div>
                        <div class="col-7"><?= htmlspecialchars($member['role_name'] ?? '') ?></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-bold"><i class="bi bi-slash-circle me-2"></i>Trạng thái cấm:</div>
                        <div class="col-7">
                            <?php 
                                if (!empty($member['is_banned']) && $member['is_banned'] == 1 && !empty($member['banned_until'])) {
                                    echo '<span class="text-danger">Đang bị cấm đến <strong>' . htmlspecialchars($member['banned_until']) . '</strong></span>';
                                } else {
                                    echo '<span class="text-success">Không bị cấm</span>';
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="text-center mt-4">
            <a href="/members" class="btn btn-outline-primary"><i class="bi bi-arrow-left"></i> Quay lại danh sách thành viên</a>
        </div>
    </div>
</main>
<?php $this->stop() ?>
