<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm bình luận</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">

    <h1>Thêm bình luận mới</h1>

    <form method="POST" action="/comments/add">
        <div class="mb-3">
            <label for="user_id" class="form-label">User ID</label>
            <input type="number" class="form-control" id="user_id" name="user_id" required>
        </div>
        <div class="mb-3">
            <label for="order_id" class="form-label">Order ID</label>
            <input type="number" class="form-control" id="order_id" name="order_id" required>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Nội dung bình luận</label>
            <textarea class="form-control" id="content" name="content" rows="4" required></textarea>
        </div>
        <div class="mb-3">
            <label for="image_link" class="form-label">Link ảnh (nếu có)</label>
            <input type="url" class="form-control" id="image_link" name="image_link">
        </div>
        <div class="mb-3">
            <label for="rate" class="form-label">Đánh giá (1-5)</label>
            <input type="number" class="form-control" id="rate" name="rate" min="1" max="5">
        </div>

        <button type="submit" class="btn btn-primary">Gửi bình luận</button>
        <a href="/comments/<?= htmlspecialchars($_POST['user_id'] ?? '') ?>" class="btn btn-secondary">Quay lại</a>
    </form>

</body>
</html>
