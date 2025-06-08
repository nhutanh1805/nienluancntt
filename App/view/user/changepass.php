<?php $this->layout("layouts/default", ["title" => "Thay Đổi Mật Khẩu"]) ?>

<?php $this->start("page") ?>

<div class="container mt-5">
    <h1 class="text-center mb-4 fw-bold text-primary">Thay Đổi Mật Khẩu</h1>

    <?php if (isset($message)): ?>
        <div class="alert alert-<?= htmlspecialchars($messageType) ?> alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <form method="POST" action="/user/changepass" novalidate>
                        <!-- Mật khẩu hiện tại -->
                        <div class="mb-3 form-floating position-relative">
                            <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Mật khẩu hiện tại" required>
                            <label for="current_password">Mật khẩu hiện tại</label>
                            <button type="button" class="btn btn-sm btn-outline-secondary position-absolute top-50 end-0 translate-middle-y me-2" 
                                onclick="togglePasswordVisibility('current_password', this)" tabindex="-1" aria-label="Hiển thị mật khẩu">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>

                        <!-- Mật khẩu mới -->
                        <div class="mb-3 form-floating position-relative">
                            <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Mật khẩu mới" required>
                            <label for="new_password">Mật khẩu mới</label>
                            <button type="button" class="btn btn-sm btn-outline-secondary position-absolute top-50 end-0 translate-middle-y me-2" 
                                onclick="togglePasswordVisibility('new_password', this)" tabindex="-1" aria-label="Hiển thị mật khẩu mới">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>

                        <!-- Xác nhận mật khẩu mới -->
                        <div class="mb-4 form-floating position-relative">
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Xác nhận mật khẩu mới" required>
                            <label for="confirm_password">Xác nhận mật khẩu mới</label>
                            <button type="button" class="btn btn-sm btn-outline-secondary position-absolute top-50 end-0 translate-middle-y me-2" 
                                onclick="togglePasswordVisibility('confirm_password', this)" tabindex="-1" aria-label="Hiển thị xác nhận mật khẩu">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 fw-semibold">
                            <i class="bi bi-lock-fill me-2"></i> Lưu thay đổi
                        </button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="/" class="btn btn-secondary w-100">Trở về trang chủ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePasswordVisibility(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon = btn.querySelector('i');
    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        input.type = "password";
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
}
</script>

<?php $this->stop() ?>
