<?php $this->layout("layouts/default", ["title" => "Chi Tiết Đơn Hàng"]) ?>

<?php $this->start("page_specific_css") ?>
<link href="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.css" rel="stylesheet">
<?php $this->stop() ?>

<?php $this->start("page") ?>
<main>
    <div class="container py-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0"><i class="bi bi-receipt-cutoff"></i> Chi tiết Đơn hàng #<?= htmlspecialchars($orderItems[0]['order_id'] ?? 'Chưa có ID') ?></h4>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <p><strong>Người nhận:</strong> <?= htmlspecialchars($orderItems[0]['checkout_name'] ?? 'Không rõ') ?></p>
                    <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($orderItems[0]['checkout_phone'] ?? 'Chưa có') ?></p>
                    <p><strong>Địa chỉ giao hàng:</strong> <?= htmlspecialchars($orderItems[0]['checkout_address'] ?? 'Chưa có địa chỉ') ?></p>
                </div>

                <h5 class="mb-3"><i class="bi bi-box-seam"></i> Sản phẩm trong đơn hàng</h5>

                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-light text-center">
                            <tr>
                                <th>Tên sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Giá</th>
                                <th>Tổng tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $totalAmount = 0; ?>
                            <?php if (!empty($orderItems)): ?>
                                <?php foreach ($orderItems as $item): ?>
                                    <?php 
                                        $qty = $item['quantity'] ?? 0;
                                        $price = $item['price'] ?? 0;
                                        $subtotal = $qty * $price;
                                        $totalAmount += $subtotal;
                                    ?>
                                    <tr>
                                        <td><?= htmlspecialchars($item['product_name'] ?? 'Không có tên sản phẩm') ?></td>
                                        <td class="text-center"><?= $qty ?></td>
                                        <td class="text-end"><?= number_format($price, 0, ',', '.') ?> VND</td>
                                        <td class="text-end"><?= number_format($subtotal, 0, ',', '.') ?> VND</td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Không có sản phẩm nào trong đơn hàng này.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr class="table-info">
                                <td colspan="3" class="text-end"><strong>Tổng cộng:</strong></td>
                                <td class="text-end"><strong><?= number_format($totalAmount, 0, ',', '.') ?> VND</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
<?php $this->stop() ?>

<?php $this->start("page_specific_js") ?>
<script src="https://cdn.datatables.net/v/dt/jq-3.7.0/dt-2.0.8/r-3.0.2/sp-2.3.1/datatables.min.js"></script>
<?php $this->stop() ?>
