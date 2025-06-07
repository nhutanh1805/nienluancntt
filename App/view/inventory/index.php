<?php $this->layout("layouts/default", ["title" => "Danh Sách Sản Phẩm"]) ?>

<?php $this->start("page_specific_css") ?>
<link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.css" rel="stylesheet">
<?php $this->stop() ?>

<?php $this->start("page") ?>
<main>
    <div class="container">
        <h2 class="text-center mb-4 text-primary fw-bold">📦 Kho Hàng</h2>

        <!-- Thông báo -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
            </div>
        <?php elseif (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
            </div>
        <?php endif; ?>

        <?php if (empty($products)): ?>
            <div class="text-center text-muted">
                <p>Chưa có sản phẩm nào trong kho.</p>
                <a href="/product" class="btn btn-lg btn-warning px-4 py-2 text-white shadow-sm">➕ Thêm sản phẩm</a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center" id="productTable">
                    <thead class="table-light">
                        <tr>
                            <th>Tên sản phẩm</th>
                            <th>Ảnh</th>
                            <th>Giá bán</th>
                            <th>Số lượng</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?= htmlspecialchars($product['name'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                <td>
                                    <?php if (!empty($product['img']) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $product['img'])): ?>
                                        <img src="<?= htmlspecialchars($product['img'], ENT_QUOTES, 'UTF-8') ?>"
                                             alt="<?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>"
                                             class="img-thumbnail rounded"
                                             style="width: 80px; height: 80px; object-fit: cover;">
                                    <?php else: ?>
                                        <span class="text-muted">Không có ảnh</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= number_format($product['price'], 0, ',', '.') ?> ₫</td>
                                <td><?= $product['quantity_in_stock'] ?? 0 ?> sản phẩm</td>
                                <td>
                                    <form action="/inventory/remove/<?= htmlspecialchars($product['id'], ENT_QUOTES, 'UTF-8') ?>" method="POST" onsubmit="return confirm('Bạn chắc chắn muốn xóa sản phẩm này?');" class="d-inline-block mb-2">
                                        <button type="submit" class="btn btn-sm btn-danger">🗑 Xóa</button>
                                    </form>

                                    <form action="/inventory/updateStock/<?= htmlspecialchars($product['id'], ENT_QUOTES, 'UTF-8') ?>" method="POST" class="d-inline-block">
                                        <div class="input-group input-group-sm">
                                            <input type="number" name="quantity" class="form-control" value="<?= htmlspecialchars($product['quantity_in_stock'] ?? 0, ENT_QUOTES, 'UTF-8') ?>" min="0" required>
                                            <button type="submit" class="btn btn-primary">📦 Cập nhật</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</main>
<?php $this->stop() ?>

<?php $this->start("page_specific_js") ?>
<script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#productTable').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            lengthMenu: [10, 25, 50, 100],
            language: {
                search: "🔍 Tìm kiếm:",
                lengthMenu: "Hiển thị _MENU_ mục",
                info: "Hiển thị _START_ đến _END_ của _TOTAL_ mục",
                infoEmpty: "Không có dữ liệu",
                infoFiltered: "(lọc từ _MAX_ mục)",
                paginate: {
                    previous: "⬅ Trước",
                    next: "Tiếp ➡"
                }
            }
        });
    });
</script>
<?php $this->stop() ?>
