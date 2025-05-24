<?php $this->layout("layouts/default", ["title" => "Thay Đổi Mật Khẩu"]) ?>

<?php $this->start("page") ?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Thay Đổi Mật Khẩu</h1>

    <!-- Thông báo -->
    <?php if (isset($message)): ?>
        <div class="alert alert-<?php echo $messageType; ?>" role="alert">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="/user/changepass">
                        <!-- Mật khẩu hiện tại -->
                        <div class="form-group d-flex align-items-center mb-3">
                            <label for="current_password" class="mr-3" style="flex-shrink: 0; width: 120px;">Mật khẩu</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required style="flex-grow: 1;">
                            <span class="input-group-text" onclick="togglePasswordVisibility('current_password')">
                                <i class="fas fa-eye"></i> <!-- Biểu tượng mắt -->
                            </span>
                        </div>
                        
                        <!-- Mật khẩu mới -->
                        <div class="form-group d-flex align-items-center mb-3">
                            <label for="new_password" class="mr-3" style="flex-shrink: 0; width: 120px;">Mật khẩu mới</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required style="flex-grow: 1;">
                            <span class="input-group-text" onclick="togglePasswordVisibility('new_password')">
                                <i class="fas fa-eye"></i> <!-- Biểu tượng mắt -->
                            </span>
                        </div>
                        
                        <!-- Xác nhận mật khẩu mới -->
                        <div class="form-group d-flex align-items-center mb-3">
                            <label for="confirm_password" class="mr-3" style="flex-shrink: 0; width: 120px;">Xác nhận</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required style="flex-grow: 1;">
                            <span class="input-group-text" onclick="togglePasswordVisibility('confirm_password')">
                                <i class="fas fa-eye"></i> <!-- Biểu tượng mắt -->
                            </span>
                        </div>
                        
                        <!-- Nút Lưu thay đổi -->
                        <button type="submit" class="btn btn-primary w-100">Lưu thay đổi</button>
                    </form>
                    
                    <!-- Nút "Trở về trang chủ" -->
                    <div class="text-center mt-3">
                        <a href="/" class="btn btn-secondary w-100">Trở về trang chủ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript để thay đổi hiển thị mật khẩu -->
<script>
    function togglePasswordVisibility(inputId) {
        var inputField = document.getElementById(inputId);
        var currentType = inputField.getAttribute("type");

        if (currentType === "password") {
            inputField.setAttribute("type", "text");
        } else {
            inputField.setAttribute("type", "password");
        }
    }
</script>

<?php $this->stop() ?>
