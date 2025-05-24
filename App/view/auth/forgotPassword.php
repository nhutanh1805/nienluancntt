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
        <form action="/loginFP" method="POST" class="row g-3 w-75 m-auto">
            <h1 class="text-center">QUÊN MẬT KHẨU</h1>
            <div class="col-md-12 col-sm-12">
                <input placeholder="Địa chỉ Email" id="email" type="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" name="email" value="<?= isset($old['email']) ? $this->e($old['email']) : '' ?>" required autofocus>
                <?php if (isset($errors['email'])) : ?>
                    <span class="invalid-feedback">
                        <strong><?= $this->e($errors['email']) ?></strong>
                    </span>
                <?php endif ?>
            </div>
            <div class="col-md-12 col-sm-12">
                <input placeholder="SĐT" id="phone" type="text" class="form-control <?= isset($errors['phone']) ? 'is-invalid' : '' ?>" name="phone" required>

                <?php if (isset($errors['phone'])) : ?>
                    <span class="invalid-feedback">
                        <strong><?= $this->e($errors['phone']) ?></strong>
                    </span>
                <?php endif ?>
            </div>

            <button style="font-weight: bold;" type="submit" class="btn btn-success" name="DangNhapFP">Đăng Nhập</button>
            <div class="col-12 text">
                <p>Chưa có tài khoản? <a href="/register">Đăng Ký</a></p>
            </div>
    </div>
    </form>
    </div>
    </div>
</main>
<?php $this->stop() ?>