<?php $this->layout("layouts/default", ["title" => "Cập Nhật Thông Tin Người Dùng"]) ?>

<?php $this->start("page") ?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Cập Nhật Thông Tin Người Dùng</h1>

    <?php if (isset($message)): ?>
        <div class="alert alert-<?= htmlspecialchars($messageType) ?> alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <!-- Thông tin cũ -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Thông Tin Cũ</h5>
                    <p><strong>Tên:</strong> <?= htmlspecialchars($user['name']) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
                    <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($user['phone']) ?></p>
                    <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($user['address']) ?></p>
                    <p><strong>Ngày đăng ký:</strong> <?= date('d/m/Y', strtotime($user['created_at'])) ?></p>
                </div>
            </div>
        </div>

        <!-- Form cập nhật thông tin -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Cập Nhật Thông Tin Mới</h5>

                    <form method="POST" action="/account/update">
                        <div class="form-group d-flex align-items-center mb-3">
                            <label for="name" class="mr-3" style="flex-shrink: 0; width: 100px;">Tên:</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>" required style="flex-grow: 1;">
                        </div>

                        <div class="form-group d-flex align-items-center mb-3">
                            <label for="email" class="mr-3" style="flex-shrink: 0; width: 100px;">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required style="flex-grow: 1;">
                        </div>

                        <div class="form-group d-flex align-items-center mb-3">
                            <label for="phone" class="mr-3" style="flex-shrink: 0; width: 100px;">Số điện thoại:</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" required style="flex-grow: 1;">
                        </div>

                        <div class="form-group d-flex align-items-center mb-3">
                            <label for="address" class="mr-3" style="flex-shrink: 0; width: 100px;">Địa chỉ:</label>
                            <input type="text" class="form-control" id="address" name="address" value="<?= htmlspecialchars($user['address']) ?>" required style="flex-grow: 1;">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->stop() ?>
