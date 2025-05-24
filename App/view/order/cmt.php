<!-- Hiển thị bình luận nếu có -->
<?php if (isset($_SESSION['comments'][$order['id']])): ?>
    <h4>Bình luận:</h4>
    <ul>
        <?php foreach ($_SESSION['comments'][$order['id']] as $comment): ?>
            <li>
                <strong>User #<?= $comment['user_id'] ?>:</strong> <?= htmlspecialchars($comment['comment']) ?>
                <br>
                <small>Được gửi vào <?= $comment['created_at'] ?></small>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<!-- Hiển thị trường nhập bình luận nếu trạng thái là "Delivered" -->
<?php if ($order['status'] == 'Delivered'): ?>
    <form action="/order/comment/<?= $order['id'] ?>" method="post">
        <div class="mb-3">
            <label for="comment" class="form-label">Bình luận của bạn</label>
            <textarea name="comment" id="comment" class="form-control" rows="3" placeholder="Nhập bình luận về đơn hàng của bạn..."></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Gửi bình luận</button>
    </form>
<?php endif; ?>
