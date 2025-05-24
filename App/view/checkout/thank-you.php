<?php $this->layout("layouts/default", ["title" => "Cảm ơn"]) ?>

<?php $this->start("page") ?>
<main>
    <div class="container py-5">
        <h2 class="text-center text-success font-weight-bold">Cảm ơn bạn đã mua hàng tại <?= CONGNGHE ?>!</h2>
        <p class="text-center lead">Đơn hàng của bạn đã được xử lý thành công. Chúng tôi sẽ liên hệ với bạn sớm nhất có thể.</p>
        <p class="text-center">Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ với chúng tôi qua email hoặc điện thoại.</p>

        <div class="text-center mt-4">
            <a href="/home" class="btn btn-primary btn-lg px-4 py-2">Quay lại trang chủ</a>
            <a href="/product" class="btn btn-warning btn-lg px-4 py-2 ml-3">Mua sản phẩm khác</a>
        </div>
    </div>
</main>
<?php $this->stop() ?>
