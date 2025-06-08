<?php $this->layout("layouts/default", ["title" => "Thông Tin Người Dùng"]) ?>

<?php $this->start("page") ?>

<div class="container mt-5">
    <h1 class="text-center mb-4 fw-bold text-primary">Thông Tin Người Dùng</h1>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">
                        <i class="bi bi-person-circle me-2"></i>
                        Chào mừng, <?= htmlspecialchars($user['name'] ?? 'Người dùng') ?>!
                    </h4>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-person-badge me-2 text-primary"></i> Tên đăng nhập</span>
                            <strong><?= htmlspecialchars($user['name'] ?? 'Chưa có tên') ?></strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-shield-lock me-2 text-primary"></i> Vai trò</span>
                            <strong><?= htmlspecialchars($user['role'] ?? 'Chưa xác định') ?></strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-envelope me-2 text-primary"></i> Email</span>
                            <strong><?= htmlspecialchars($user['email'] ?? 'Chưa có email') ?></strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-telephone me-2 text-primary"></i> Số điện thoại</span>
                            <strong><?= htmlspecialchars($user['phone'] ?? 'Chưa có số điện thoại') ?></strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-geo-alt me-2 text-primary"></i> Địa chỉ</span>
                            <strong><?= htmlspecialchars($user['address'] ?? 'Chưa có địa chỉ') ?></strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-calendar-check me-2 text-primary"></i> Ngày đăng ký</span>
                            <strong><?= !empty($user['created_at']) ? date('d/m/Y', strtotime($user['created_at'])) : 'Chưa rõ' ?></strong>
                        </li>
                    </ul>
                    
                    <div class="d-flex justify-content-center mt-4 gap-3">
                        <a href="/user/update" class="btn btn-outline-primary px-4">
                            <i class="bi bi-pencil-square me-1"></i> Cập nhật thông tin
                        </a>
                        <a href="/user/changepass" class="btn btn-outline-secondary px-4">
                            <i class="bi bi-key me-1"></i> Đổi mật khẩu
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->stop() ?>
