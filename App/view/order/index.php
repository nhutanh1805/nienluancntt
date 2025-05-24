<?php $this->layout("layouts/default", ["title" => "Đơn Hàng Của Bạn"]) ?>

<?php $this->start("page") ?>
<main>
    <div class="container">
        <h2 class="text-center">Đơn Hàng Của Bạn</h2>

        <?php if (empty($orders)): ?>
            <p class="text-center">Bạn chưa có đơn hàng nào. Hãy thử mua sắm ngay!</p>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID Đơn Hàng</th>
                        <th>Tổng Tiền</th>
                        <th>Trạng Thái</th>
                        <th>Ngày Tạo</th>
                        <th>Tiến Trình</th>
                        <th>Thao Tác</th>
                        <th>Phản Hồi</th> <!-- Cột phản hồi -->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr id="order_<?= $order['id'] ?>">
                            <td><?= htmlspecialchars($order['id'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td>
                                <?php
                                $totalAmount = $order['total_amount'] ?? 0;
                                echo number_format($totalAmount, 0, ',', '.') . ' VNĐ';
                                ?>
                            </td>
                            <td id="status_<?= $order['id'] ?>">
                                <?php
                                switch ($order['status']) {
                                    case 'Processing':
                                        echo '<span class="badge bg-warning">Đơn hàng đang được xử lý</span>';
                                        break;
                                    case 'Shipped':
                                        echo '<span class="badge bg-primary">Đơn hàng đang được giao</span>';
                                        break;
                                    case 'Delivered':
                                        echo '<span class="badge bg-success">Đơn hàng đã giao</span>';
                                        break;
                                    case 'Cancelled':
                                        echo '<span class="badge bg-danger">Đơn hàng đã hủy</span>';
                                        break;
                                    default:
                                        echo '<span class="badge bg-secondary">Trạng thái chưa xác định</span>';
                                        break;
                                }
                                ?>
                            </td>
                            <td><?= htmlspecialchars($order['created_at'], ENT_QUOTES, 'UTF-8') ?></td>

                            <!-- Tiến trình -->
                            <td>
                                <?php
                                $progress = 0;
                                $icon = '';
                                $progressBarClass = 'bg-secondary'; // Mặc định là màu xám (cho trường hợp không xác định)

                                switch ($order['status']) {
                                    case 'Processing':
                                        $progress = 33;
                                        $icon = '<i class="fas fa-cogs"></i> Đang xử lý';
                                        $progressBarClass = 'bg-warning'; // Màu vàng cho tiến trình đang xử lý
                                        break;
                                    case 'Shipped':
                                        $progress = 66;
                                        $icon = '<i class="fas fa-truck"></i> Đang giao hàng';
                                        $progressBarClass = 'bg-primary'; // Màu xanh dương cho đang giao hàng
                                        break;
                                    case 'Delivered':
                                        $progress = 100;
                                        $icon = '<i class="fas fa-check-circle"></i> Đã giao';
                                        $progressBarClass = 'bg-success'; // Màu xanh lá cho đã giao
                                        break;
                                    case 'Cancelled':
                                        $progress = 0;
                                        $icon = '<i class="fas fa-times-circle"></i> Đã hủy';
                                        $progressBarClass = 'bg-danger'; // Màu đỏ cho đã hủy
                                        break;
                                    default:
                                        $progress = 0;
                                        $icon = '<i class="fas fa-question-circle"></i> Chưa xác định';
                                        break;
                                }
                                ?>
                                <div class="d-flex align-items-center">
                                    <div class="me-3"><?= $icon ?></div>
                                    <!-- Tiến trình sử dụng Bootstrap -->
                                    <div class="progress" style="width: 100%; height: 20px;">
                                        <div class="progress-bar <?= $progressBarClass ?>" role="progressbar" style="width: <?= $progress ?>%;" aria-valuenow="<?= $progress ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </td>

                            <!-- Cập nhật trạng thái đơn hàng -->
                            <td>
                                <?php if ($order['status'] == 'Processing'): ?>
                                    <form action="/order/updateStatus/<?= $order['id'] ?>" method="post" class="status-form" style="display:inline;">
                                        <label for="status_<?= $order['id'] ?>" class="form-label">Cập nhật trạng thái:</label>
                                        <select name="status" id="status_select_<?= $order['id'] ?>" class="form-select" onchange="this.form.submit()">
                                        <option value="Cancelled" <?= $order['status'] == 'Cancelled' ? 'selected' : '' ?>>Hủy đơn?</option>
                                        <option value="Cancelled" <?= $order['status'] == 'Cancelled' ? 'selected' : '' ?>>Xác nhận hủy</option>
                                        </select>
                                    </form>
                    
                                <?php endif; ?>
                            </td>

                            <!-- Thao tác -->
                            <td>
                                <a href="/order/view/<?= $order['id'] ?>" class="btn btn-info">Chi tiết</a>
                            </td>

                            <!-- Phản hồi -->
                            <td>
                                <?php if ($order['status'] == 'Delivered'): ?>
                                    <!-- Hiển thị bình luận hiện tại nếu có -->
                                    <?php if (!empty($order['comment'])): ?>
                                        <div class="alert alert-info">
                                            <strong>Bình luận hiện tại:</strong><br>
                                            <?= nl2br(htmlspecialchars($order['comment'], ENT_QUOTES, 'UTF-8')) ?>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Form nhập bình luận -->
                                    <form action="/order/comment/<?= $order['id'] ?>" method="post">
                                        <div class="mb-3">
                                            <label for="comment" class="form-label">Bình luận của bạn</label>
                                            <textarea name="comment" id="comment_<?= $order['id'] ?>" class="form-control" rows="3" placeholder="Nhập bình luận về đơn hàng của bạn..."></textarea>
                                        </div>

                                        <!-- Gợi ý bình luận -->
                                        <div class="comment-suggestions">
                                            <h6>Gợi ý bình luận:</h6>
                                            <ul class="list-unstyled">
                                                <li><button type="button" class="btn btn-link suggestion-btn" onclick="insertSuggestion('Sản phẩm rất tuyệt vời, tôi sẽ mua thêm lần sau!')">Sản phẩm rất tuyệt vời, tôi sẽ mua thêm lần sau!</button></li>
                                                <li><button type="button" class="btn btn-link suggestion-btn" onclick="insertSuggestion('Dịch vụ giao hàng rất nhanh, tôi rất hài lòng!')">Dịch vụ giao hàng rất nhanh, tôi rất hài lòng!</button></li>
                                                <li><button type="button" class="btn btn-link suggestion-btn" onclick="insertSuggestion('Sản phẩm bị lỗi, tôi muốn đổi trả.')">Sản phẩm bị lỗi, tôi muốn đổi trả.</button></li>
                                                <li><button type="button" class="btn btn-link suggestion-btn" onclick="insertSuggestion('Cảm ơn shop, lần sau tôi sẽ tiếp tục mua hàng!')">Cảm ơn shop, lần sau tôi sẽ tiếp tục mua hàng!</button></li>
                                            </ul>
                                        </div>

                                        <!-- Nút gửi bình luận -->
                                        <button type="submit" class="btn btn-primary">Gửi bình luận</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</main>

<script>
    // Hàm để chèn gợi ý vào trường nhập bình luận
    function insertSuggestion(suggestion) {
        var commentBox = document.querySelector('[id^="comment_"]');
        commentBox.value = suggestion;
    }
</script>

<?php $this->stop() ?>
