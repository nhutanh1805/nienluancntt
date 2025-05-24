<!-- app/views/comment/add.php -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Bình luận</title>
    <link rel="stylesheet" href="path/to/your/css/styles.css"> <!-- Thêm link CSS nếu cần -->
</head>
<body>
    <h1>Thêm Bình luận Mới</h1>

    <!-- Form thêm bình luận -->
    <form action="/comments/add" method="POST">
        <label for="user_id">Người dùng:</label>
        <input type="number" id="user_id" name="user_id" required><br>

        <label for="content">Nội dung:</label>
        <textarea id="content" name="content" rows="5" cols="50" required></textarea><br>

        <label for="image_link">Link hình ảnh (nếu có):</label>
        <input type="text" id="image_link" name="image_link"><br>

        <label for="rate">Đánh giá (1-5):</label>
        <input type="number" id="rate" name="rate" min="1" max="5"><br>

        <label for="order_id">ID đơn hàng (nếu có):</label>
        <input type="number" id="order_id" name="order_id"><br>

        <button type="submit">Thêm Bình luận</button>
    </form>

    <!-- Link quay lại danh sách bình luận -->
    <br>
    <a href="/comments/<?= $_POST['user_id'] ?? '' ?>">Quay lại danh sách bình luận</a>
</body>
</html>
