<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách bình luận</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">

    <h1>Bình luận của bạn</h1>

    <a href="/comments/add" class="btn btn-primary mb-3">Thêm bình luận mới</a>

    <?php if (empty($comments)): ?>
        <p>Chưa có bình luận nào.</p>
    <?php else: ?>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Địa chỉ</th>
                    <th>Nội dung</th>
                    <th>Ảnh</th>
                    <th>Đánh giá</th>
                    <th>Ngày tạo</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($comments as $c): ?>
                    <tr>
                        <td><?= htmlspecialchars($c['order_id']) ?></td>
                        <td><?= htmlspecialchars($c['address']) ?></td>
                        <td><?= nl2br(htmlspecialchars($c['content'])) ?></td>
                        <td>
                            <?php if (!empty($c['image_link'])): ?>
                                <img src="<?= htmlspecialchars($c['image_link']) ?>" alt="Ảnh bình luận" style="max-width:100px; max-height:80px;">
                            <?php else: ?>
                                Không có
                            <?php endif; ?>
                        </td>
                        <td><?= $c['rate'] !== null ? htmlspecialchars($c['rate']) . '/5' : 'Chưa đánh giá' ?></td>
                        <td><?= htmlspecialchars($c['created_at']) ?></td>
                        <td>
                            <a href="/comments/edit/<?= $c['id'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                            <a href="/comments/delete/<?= $c['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn chắc chắn muốn xóa bình luận này?')">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

</body>
</html>
