<?php
namespace App\Controllers;

use App\Models\Warehouse;

class WarehouseController
{
    private $warehouseModel;

    public function __construct($pdo)
    {
        // Khởi tạo đối tượng Warehouse Model
        $this->warehouseModel = new Warehouse($pdo);
    }

    // Hàm hiển thị danh sách sản phẩm trong kho
    public function index()
    {
        // Lấy tất cả sản phẩm từ kho
        $products = $this->warehouseModel->getAllProducts();
        
        // Gọi view để hiển thị thông tin
        require_once 'app/views/warehouse_list.php';
    }
}
?>
