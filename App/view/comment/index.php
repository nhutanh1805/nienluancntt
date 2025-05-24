<!-- app/views/comment/index.php -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách Bình luận</title>
    <link rel="stylesheet" href="path/to/your/css/styles.css"> <!-- Thêm link CSS nếu cần -->
</head>
<body>
    <h1>Danh sách Bình luận của Bạn</h1>

    <!-- Link thêm bình luận mới -->
    <a href="/comments/add" class="btn btn-primary">Thêm Bình luận</a>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Nội dung</th>
                <th>Ảnh</th>
                <th>Đánh giá</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($comments)): ?>
                <?php foreach ($comments as $comment): ?>
                    <tr>
                        <td><?= htmlspecialchars($comment['content']) ?></td>
                        <td><img src="<?= htmlspecialchars($comment['image_link']) ?>" alt="image" width="100" height="auto"></td>
                        <td><?= $comment['rate'] ?></td>
                        <td><?= date('d-m-Y H:i', strtotime($comment['date'])) ?></td>
                        <td>
                            <!-- Cập nhật và xóa bình luận -->
                            <a href="/comments/edit/<?= $comment['id'] ?>">Cập nhật</a> |
                            <a href="/comments/delete/<?= $comment['id'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa bình luận này?')">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Không có bình luận nào.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
