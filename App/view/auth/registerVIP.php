<?php $this->layout("layouts/default", ["title" => "Đăng Ký Thành Viên VIP"]) ?>

<?php $this->start("page") ?>
<div class="container">
  <div class="row">
    <div class="col-md-8 offset-md-2">

      <div class="card mt-3">
        <div class="card-header fw-bold text-uppercase">Đăng Ký Thành Viên VIP</div>
        <div class="card-body bg-body-tertiary">

          <form method="POST" action="/registerVIP">
            <div class="mb-3 row">
              <label for="firstName" class="offset-md-2 col-md-3 col-form-label">Họ</label>
              <div class="col-md-5">
                <input id="firstName" type="text" class="form-control <?= isset($errors['firstName']) ? 'is-invalid' : '' ?>" name="firstName" value="<?= isset($old['firstName']) ? $this->e($old['firstName']) : '' ?>" required autofocus>
                <?php if (isset($errors['firstName'])) : ?>
                  <span class="invalid-feedback">
                    <strong><?= $this->e($errors['firstName']) ?></strong>
                  </span>
                <?php endif ?>
              </div>
            </div>

            <div class="mb-3 row">
              <label for="lastName" class="offset-md-2 col-md-3 col-form-label">Tên</label>
              <div class="col-md-5">
                <input id="lastName" type="text" class="form-control <?= isset($errors['lastName']) ? 'is-invalid' : '' ?>" name="lastName" value="<?= isset($old['lastName']) ? $this->e($old['lastName']) : '' ?>" required>
                <?php if (isset($errors['lastName'])) : ?>
                  <span class="invalid-feedback">
                    <strong><?= $this->e($errors['lastName']) ?></strong>
                  </span>
                <?php endif ?>
              </div>
            </div>

            <div class="mb-3 row">
              <label for="email" class="offset-md-2 col-md-3 col-form-label">Địa chỉ Email</label>
              <div class="col-md-5">
                <input id="email" type="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" name="email" value="<?= isset($old['email']) ? $this->e($old['email']) : '' ?>" required>
                <?php if (isset($errors['email'])) : ?>
                  <span class="invalid-feedback">
                    <strong><?= $this->e($errors['email']) ?></strong>
                  </span>
                <?php endif ?>
              </div>
            </div>

            <div class="mb-3 row">
              <label for="password" class="offset-md-2 col-md-3 col-form-label">Mật khẩu</label>
              <div class="col-md-5">
                <input id="password" type="password" class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" name="password" required>
                <?php if (isset($errors['password'])) : ?>
                  <span class="invalid-feedback">
                    <strong><?= $this->e($errors['password']) ?></strong>
                  </span>
                <?php endif ?>
              </div>
            </div>

            <div class="mb-3 row">
              <label for="password_confirmation" class="offset-md-2 col-md-3 col-form-label">Xác nhận mật khẩu</label>
              <div class="col-md-5">
                <input id="password_confirmation" type="password" class="form-control <?= isset($errors['password_confirmation']) ? 'is-invalid' : '' ?>" name="password_confirmation" required>
                <?php if (isset($errors['password_confirmation'])) : ?>
                  <span class="invalid-feedback">
                    <strong><?= $this->e($errors['password_confirmation']) ?></strong>
                  </span>
                <?php endif ?>
              </div>
            </div>

            <div class="mb-3 row">
              <label for="vipCode" class="offset-md-2 col-md-3 col-form-label">Mã VIP (nếu có)</label>
              <div class="col-md-5">
                <input id="vipCode" type="text" class="form-control" name="vipCode" value="<?= isset($old['vipCode']) ? $this->e($old['vipCode']) : '' ?>">
              </div>
            </div>

            <div class="mb-3 row">
              <label for="birthDate" class="offset-md-2 col-md-3 col-form-label">Ngày sinh</label>
              <div class="col-md-5">
                <input id="birthDate" type="date" class="form-control" name="birthDate" required>
              </div>
            </div>

            <div class="mb-3 row">
              <label for="membershipPlan" class="offset-md-2 col-md-3 col-form-label">Gói thành viên</label>
              <div class="col-md-5">
                <select id="membershipPlan" name="membershipPlan" class="form-select" required>
                  <option value="" disabled selected>Chọn gói</option>
                  <option value="basic">Gói Cơ Bản</option>
                  <option value="premium">Gói Cao Cấp</option>
                  <option value="vip">Gói VIP</option>
                </select>
              </div>
            </div>

            <div class="mb-3 row">
              <div class="col-md-5 offset-md-5">
                <button type="submit" class="btn btn-primary">
                  Đăng Ký
                </button>
              </div>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>
<?php $this->stop() ?>

<?php
// Xử lý khi form được gửi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    $old = $_POST;

    // Mảng chứa mã VIP hợp lệ
    $validVIPCodes = ['VIP123', 'VIP456', 'VIP789']; // Các mã VIP hợp lệ

    if (empty($old['firstName'])) {
        $errors['firstName'] = "Họ không được để trống.";
    }
    if (empty($old['lastName'])) {
        $errors['lastName'] = "Tên không được để trống.";
    }
    if (empty($old['email'])) {
        $errors['email'] = "Email không được để trống.";
    } elseif (!filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Email không hợp lệ.";
    }
    if (empty($old['password'])) {
        $errors['password'] = "Mật khẩu không được để trống.";
    }
    if ($old['password'] !== $old['password_confirmation']) {
        $errors['password_confirmation'] = "Mật khẩu xác nhận không khớp.";
    }

    if (!empty($old['vipCode']) && !in_array($old['vipCode'], $validVIPCodes)) {
        $errors['vipCode'] = "Mã VIP không hợp lệ.";
    } elseif (!empty($old['vipCode']) && in_array($old['vipCode'], $validVIPCodes)) {
        $old['membershipPlan'] = 'vip';
    }

    if (empty($errors)) {
        $firstName = $old['firstName'];
        $lastName = $old['lastName'];
        $email = $old['email'];
        $password = password_hash($old['password'], PASSWORD_DEFAULT);
        $vipCode = $old['vipCode'];
        $birthDate = $old['birthDate'];
        $membershipPlan = $old['membershipPlan'];

        // Xử lý lưu thông tin đăng ký, có thể lưu vào cơ sở dữ liệu ở đây

        echo "Đăng ký thành công!";
    }
}
?>
