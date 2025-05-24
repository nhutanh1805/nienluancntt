<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kho hàng</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="path_to_your_css_file.css"> <!-- Thay đổi đường dẫn đến file CSS -->
</head>
<body>
  <div class="container">
    <h1>Danh sách sản phẩm trong kho</h1>
    
    <!-- Hiển thị các sản phẩm trong kho -->
    <div class="row">
      <?php foreach ($products as $product): ?>
        <div class="col-md-3 mb-4">
          <div class="card">
            <img src="<?php echo $product['img']; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['name']); ?>">
            <div class="card-body">
              <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
              <p class="card-text">Giá: <?php echo number_format($product['price'], 0, ',', '.'); ?> VND</p>
              <p class="card-text">Số lượng: <?php echo $product['quantity']; ?></p>
              <a href="/product-detail/<?php echo $product['id']; ?>" class="btn btn-primary">Xem chi tiết</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</body>
</html>
