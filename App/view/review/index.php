<?php $this->layout("layouts/default", ["title" => "Đánh Giá Sản Phẩm"]) ?>

<?php $this->start("page_specific_css") ?>
<link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<?php $this->stop() ?>

<?php $this->start("page") ?>
<main>
    <div class="container py-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white text-center">
                <h3 class="mb-0"><i class="bi bi-star-fill"></i> Đánh Giá Sản Phẩm</h3>
            </div>
            <div class="card-body">

                <!-- Hiển thị trung bình số sao -->
                <?php if (isset($averageRating)): ?>
                    <div class="mb-4 text-center">
                        <h5>Đánh giá trung bình: 
                            <span class="text-warning"><?= number_format($averageRating, 1) ?> ★</span>
                        </h5>
                    </div>
                <?php endif; ?>

                <!-- THÔNG BÁO -->
                <?php if (!empty($_SESSION['success_message'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-1"></i> <?= htmlspecialchars($_SESSION['success_message']) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['success_message']); ?>
                <?php endif; ?>

                <?php if (!empty($_SESSION['error_message'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-1"></i> <?= htmlspecialchars($_SESSION['error_message']) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['error_message']); ?>
                <?php endif; ?>

                <!-- FORM GỬI ĐÁNH GIÁ -->
                <form action="/reviews/add" method="POST" class="mb-5">
                    <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?? 1 ?>">
                    <input type="hidden" name="product_id" value="<?= $productId ?>">

                    <div class="mb-3">
                        <label class="form-label"><strong><i class="bi bi-star-half me-1"></i>Chọn số sao:</strong></label><br>
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="rating" id="rating<?= $i ?>" value="<?= $i ?>" required>
                                <label class="form-check-label" for="rating<?= $i ?>">
                                    <?= str_repeat("★", $i) ?> (<?= $i ?>)
                                </label>
                            </div>
                        <?php endfor; ?>
                    </div>

                    <div class="mb-3">
                        <label for="comment" class="form-label"><strong><i class="bi bi-chat-left-dots-fill me-1"></i>Nhận xét:</strong></label>
                        <textarea class="form-control" name="comment" id="comment" rows="4" placeholder="Viết cảm nghĩ của bạn về sản phẩm..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary rounded-pill">
                        <i class="bi bi-send-fill me-1"></i> Gửi đánh giá
                    </button>
                </form>

                <!-- DANH SÁCH ĐÁNH GIÁ -->
                <?php if (empty($reviews)): ?>
                    <div class="text-center text-muted py-3">
                        <h5>Chưa có đánh giá nào cho sản phẩm này <i class="bi bi-emoji-frown text-warning"></i></h5>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle" id="reviewTable">
                            <thead class="table-light text-center">
                                <tr>
                                    <th><i class="bi bi-person-circle"></i> Người dùng</th>
                                    <th><i class="bi bi-star-fill"></i> Số sao</th>
                                    <th><i class="bi bi-chat-left-text"></i> Nhận xét</th>
                                    <th><i class="bi bi-clock-history"></i> Thời gian</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($reviews as $review): ?>
                                    <tr>
                                        <td class="text-center"><?= htmlspecialchars($review['user_name'] ?? 'Ẩn danh') ?></td>
                                        <td class="text-center text-warning fw-bold"><?= str_repeat("★", $review['rating']) ?></td>
                                        <td><?= nl2br(htmlspecialchars($review['comment'])) ?></td>
                                        <td class="text-center"><?= date('d/m/Y H:i', strtotime($review['created_at'])) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</main>
<?php $this->stop() ?>

<?php $this->start("page_specific_js") ?>
<script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#reviewTable').DataTable({
            paging: true,
            ordering: true,
            searching: false,
            language: {
                lengthMenu: "Hiển thị _MENU_ đánh giá",
                info: "Hiển thị _START_ đến _END_ của _TOTAL_ đánh giá",
                infoEmpty: "Không có đánh giá nào",
                paginate: {
                    previous: "← Trước",
                    next: "Tiếp →"
                }
            }
        });
    });
</script>
<?php $this->stop() ?>
