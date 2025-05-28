<?php $this->layout("layouts/default", ["title" => CONGNGHE]) ?>

<?php $this->start("page") ?>

<main>
  <?php if (!empty($messages)): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <?= $this->e($messages['success']) ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif; ?>

  <div class="container text-center mt-5 bg-light rounded w-50">

    <!-- Hiển thị lỗi email (bao gồm lỗi do bị ban) -->
    <?php if (!empty($errors['email'])): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= $this->e($errors['email']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>

    <form action="/login" method="POST" class="row g-3 w-75 m-auto">
      <h1 class="text-center">ĐĂNG NHẬP</h1>

      <div class="col-md-12 col-sm-12">
        <div class="input-group">
          <div class="input-group-text"><i class="bi bi-envelope"></i></div>
          <input 
            placeholder="Địa chỉ Email" 
            id="email" 
            type="email" 
            class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" 
            name="email" 
            value="<?= isset($old['email']) ? $this->e($old['email']) : '' ?>" 
            required 
            autofocus>
        </div>
        <?php if (isset($errors['email'])) : ?>
          <span class="invalid-feedback">
            <strong><?= $this->e($errors['email']) ?></strong>
          </span>
        <?php endif ?>
      </div>

      <div class="col-md-12 col-sm-12">
        <div class="input-group">
          <div class="input-group-text"><i class="bi bi-lock"></i></div>
          <input 
            placeholder="Mật khẩu" 
            id="password" 
            type="password" 
            class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" 
            name="password" 
            required>
          <!-- Thêm biểu tượng con mắt -->
          <button type="button" id="togglePassword" class="input-group-text"><i class="bi bi-eye"></i></button>
        </div>
        <?php if (isset($errors['password'])) : ?>
          <span class="invalid-feedback">
            <strong><?= $this->e($errors['password']) ?></strong>
          </span>
        <?php endif ?>
      </div>

      <button style="font-weight: bold;" type="submit" class="btn btn-success" name="DangNhap">Đăng Nhập</button>

      <div class="col-12 text mt-3">
        <p>Chưa có tài khoản? <a href="/register">Đăng Ký</a></p>
        <p>Quên mật khẩu? <a href="/loginFP">Lấy lại mật khẩu</a></p>
      </div>
    </form>
  </div>
</main>

<!-- Thêm script để chuyển đổi giữa password và text -->
<script>
  document.getElementById('togglePassword').addEventListener('click', function () {
    const passwordField = document.getElementById('password');
    const passwordType = passwordField.type === 'password' ? 'text' : 'password';
    passwordField.type = passwordType;
    
    // Thay đổi biểu tượng con mắt
    const icon = this.querySelector('i');
    if (passwordType === 'password') {
      icon.classList.remove('bi-eye-slash');
      icon.classList.add('bi-eye');
    } else {
      icon.classList.remove('bi-eye');
      icon.classList.add('bi-eye-slash');
    }
  });
</script>

<?php $this->stop() ?>
