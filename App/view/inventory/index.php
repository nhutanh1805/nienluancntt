<?php $this->layout("layouts/default", ["title" => "Danh Sách Sản Phẩm"]) ?>

<?php $this->start("page_specific_css") ?>
<link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.css" rel="stylesheet">
<?php $this->stop() ?>

<?php $this->start("page") ?>
<main>
    <div class="container">
        <h2 class="text-center">Kho Hàng</h2>

        <!-- Thông báo khi thành công hoặc có lỗi -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?= $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php elseif (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <?php if (empty($products)): ?>
            <p class="text-center">
                Chưa có sản phẩm trong danh sách. <span class="font-weight-bold text-danger">Hãy thêm sản phẩm mới vào kho</span> để bắt đầu bán hàng!
                <br>
                <a href="/product" class="btn btn-lg btn-warning mt-3 px-4 py-2 text-white shadow-sm hover-shadow-lg">Quản lý sản phẩm</a>
            </p>
        <?php else: ?>
            <table class="table" id="productTable">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Ảnh</th>
                        <th>Giá</th>
                        <th>Số lượng trong kho</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?= htmlspecialchars($product['name'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                            <td>
                                <!-- Kiểm tra nếu có ảnh tồn tại -->
                                <?php if (!empty($product['img']) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $product['img'])): ?>
                                    <img src="<?= htmlspecialchars($product['img'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>" style="max-width:150px;">
                                <?php else: ?>
                                    <p class="text-muted">Ảnh không có sẵn</p>
                                <?php endif; ?>
                            </td>
                            <td><?= number_format($product['price'], 0, ',', '.') ?> VNĐ</td>
                            <td>
                                <!-- Hiển thị số lượng tồn kho từ bảng inventory -->
                                <?= $product['quantity_in_stock'] ?? 0 ?> sản phẩm
                            </td>
                            <td>
                                <!-- Form để xóa sản phẩm -->
                                <form action="/inventory/remove/<?= htmlspecialchars($product['id'] ?? '', ENT_QUOTES, 'UTF-8') ?>" method="POST" onsubmit="return confirm('Bạn chắc chắn muốn xóa sản phẩm này khỏi danh sách?');">
                                    <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                </form>

                                <!-- Form để cập nhật số lượng tồn kho -->
                                <form action="/inventory/updateStock/<?= htmlspecialchars($product['id'] ?? '', ENT_QUOTES, 'UTF-8') ?>" method="POST" style="margin-top: 10px;">
                                    <div class="input-group">
                                        <input type="number" name="quantity" class="form-control" value="<?= htmlspecialchars($product['quantity_in_stock'] ?? 0, ENT_QUOTES, 'UTF-8') ?>" min="0" required>
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-sm btn-primary">Cập nhật</button>
                                        </div>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</main>
<?php $this->stop() ?>

<?php $this->start("page_specific_js") ?>
<script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#productTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "lengthMenu": [10, 25, 50, 100],
            "language": {
                "search": "Tìm kiếm:",
                "lengthMenu": "Hiển thị _MENU_ mục",
                "info": "Hiển thị _START_ đến _END_ của _TOTAL_ mục",
                "infoEmpty": "Không có dữ liệu",
                "infoFiltered": "(Lọc từ _MAX_ mục)",
                "paginate": {
                    "previous": "Trước",
                    "next": "Tiếp"
                }
            }
        });
    });
</script>
<?php $this->stop() ?>
