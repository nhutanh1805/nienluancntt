<?php if (isset($error)): ?>
    <div class="error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<h2>Cập nhật trạng thái đơn hàng</h2>

<form action="/order/updateStatus/<?= $order[0]['id'] ?>" method="POST">
    <label for="status">Trạng thái:</label>
    <select name="status" id="status">
        <option value="Đang xử lý" <?= ($order[0]['status'] == 'Đang xử lý') ? 'selected' : '' ?>>Đang xử lý</option>
        <option value="Đang giao" <?= ($order[0]['status'] == 'Đang giao') ? 'selected' : '' ?>>Đang giao</option>
        <option value="Đã giao hàng" <?= ($order[0]['status'] == 'Đã giao hàng') ? 'selected' : '' ?>>Đã giao hàng</option>
        <option value="Đã hủy" <?= ($order[0]['status'] == 'Đã hủy') ? 'selected' : '' ?>>Đã hủy</option>
    </select>
    <button type="submit">Cập nhật trạng thái</button>
</form>

<a href="/order/view/<?= $order[0]['id'] ?>">Trở lại</a>
