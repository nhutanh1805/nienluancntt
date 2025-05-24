<?php $this->layout("layouts/default", ["title" => "Thông Tin Người Dùng"]) ?>

<?php $this->start("page") ?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Thông Tin Người Dùng</h1>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Chào mừng, <?= htmlspecialchars($user['name'] ?? 'Người dùng') ?>!</h5>
                    <p><strong>Tên đăng nhập:</strong> <?= htmlspecialchars($user['name'] ?? 'Chưa có tên') ?></p>
                    <p><strong>Vai trò:</strong> <?= htmlspecialchars($user['role'] ?? 'Chưa xác định') ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($user['email'] ?? 'Chưa có email') ?></p>
                    <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($user['phone'] ?? 'Chưa có số điện thoại') ?></p>
                    <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($user['address'] ?? 'Chưa có địa chỉ') ?></p>
                    <!-- <p><strong>Mật khẩu:</strong> <?= htmlspecialchars($user['password'] ?? 'Chưa có mật khẩu') ?></p> -->
                    <p><strong>Ngày đăng ký:</strong> <?= date('d/m/Y', strtotime($user['created_at'] ?? '')) ?></p>
                    
                    <!-- Cung cấp tùy chọn để cập nhật thông tin người dùng -->
                    <div class="text-center">
                        <a href="/user/update" class="btn btn-primary">Cập nhật thông tin</a>
                        <a href="/user/changepass" class="btn btn-primary">Đổi mật khẩu</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
</div>

<?php $this->stop() ?>
