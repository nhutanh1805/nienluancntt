<?php
class ProductController {
    private $model; // Biến lưu trữ đối tượng model để truy cập các phương thức trong model

    // Constructor để khởi tạo đối tượng model
    public function __construct($model) {
        $this->model = $model; // Gán đối tượng model vào biến $model
    }

    // Phương thức xử lý yêu cầu tìm kiếm sản phẩm
    public function searchAction($keyword) {
        // Tìm kiếm sản phẩm trong model bằng từ khóa tìm kiếm
        $products = $this->model->search($keyword);

        // Gọi view 'views/search/index.php' và truyền danh sách sản phẩm tìm được vào
        include('views/search/index.php');
    }
}
?>
