<?php $this->layout("layouts/default", ["title" => "Cập Nhật Thông Tin Người Dùng"]) ?>

<?php $this->start("page") ?>

<div class="container mt-5">
    <h1 class="text-center mb-4 fw-bold text-primary">Cập Nhật Thông Tin Người Dùng</h1>

    <?php if (isset($message)): ?>
        <div class="alert alert-<?= htmlspecialchars($messageType) ?> alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <!-- Thông tin cũ -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-secondary text-white text-center">
                    <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i> Thông Tin Cũ</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <span><i class="bi bi-person-fill text-primary me-2"></i> Tên</span>
                            <strong><?= htmlspecialchars($user['name']) ?></strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><i class="bi bi-envelope-fill text-primary me-2"></i> Email</span>
                            <strong><?= htmlspecialchars($user['email']) ?></strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><i class="bi bi-telephone-fill text-primary me-2"></i> Số điện thoại</span>
                            <strong><?= htmlspecialchars($user['phone']) ?></strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><i class="bi bi-geo-alt-fill text-primary me-2"></i> Địa chỉ</span>
                            <strong><?= htmlspecialchars($user['address']) ?></strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span><i class="bi bi-calendar-fill text-primary me-2"></i> Ngày đăng ký</span>
                            <strong><?= date('d/m/Y', strtotime($user['created_at'])) ?></strong>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Form cập nhật thông tin -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white text-center">
                    <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i> Cập Nhật Thông Tin Mới</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="/account/update" novalidate>
                        <div class="mb-3 form-floating">
                            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
                            <label for="name">Tên</label>
                        </div>

                        <div class="mb-3 form-floating">
                            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                            <label for="email">Email</label>
                        </div>

                        <div class="mb-3 form-floating">
                            <input type="text" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" required>
                            <label for="phone">Số điện thoại</label>
                        </div>

                        <div class="mb-4 form-floating">
                            <input type="text" class="form-control" id="address" name="address" value="<?= htmlspecialchars($user['address']) ?>" required>
                            <label for="address">Địa chỉ</label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 fw-semibold">
                            <i class="bi bi-check-circle me-2"></i> Cập nhật
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->stop() ?>
