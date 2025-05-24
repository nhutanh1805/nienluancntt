<?php
// Hiển thị thông báo nếu có lỗi hoặc thông báo thành công
if (isset($error)) {
    echo "<div style='color: red;'>" . htmlspecialchars($error) . "</div>";
} elseif (isset($success)) {
    echo "<div style='color: green;'>" . htmlspecialchars($success) . "</div>";
} else {
    echo "<div>Không có thông báo.</div>";
}
?>

<!-- Bạn có thể thêm một số liên kết để điều hướng người dùng -->
<a href="/orders">Quay lại danh sách đơn hàng</a>
