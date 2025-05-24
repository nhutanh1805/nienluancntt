<?php
namespace App\Controllers;

use App\Models\Inventory;

class InventoryController extends Controller
{
    // Hiển thị danh sách tất cả sản phẩm (kèm theo số lượng tồn kho)
    public function index(): void
    {
        // Lấy tất cả sản phẩm từ bảng product và số lượng tồn kho từ bảng inventory
        $products = Inventory::getAllProducts();  
        $this->sendPage('inventory/index', [
            'products' => $products
        ]);
    }

    // Thêm sản phẩm mới vào bảng product
    public function add(): void
    {
        // Lấy dữ liệu từ form
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $img = isset($_POST['img']) ? $_POST['img'] : '';
        $description = isset($_POST['description']) ? $_POST['description'] : '';
        $price = isset($_POST['price']) ? (float)$_POST['price'] : 0;
        $priceGoc = isset($_POST['priceGoc']) ? (float)$_POST['priceGoc'] : 0;

        // Kiểm tra thông tin sản phẩm
        if ($name && $price > 0) {
            // Thêm sản phẩm vào bảng product
            Inventory::addProduct($name, $img, $description, $price, $priceGoc);
        }

        // Điều hướng lại đến trang danh sách sản phẩm
        redirect('/inventory');
    }

    // Cập nhật thông tin sản phẩm trong bảng product
    public function update($productId): void
    {
        // Lấy dữ liệu từ form
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $img = isset($_POST['img']) ? $_POST['img'] : '';
        $description = isset($_POST['description']) ? $_POST['description'] : '';
        $price = isset($_POST['price']) ? (float)$_POST['price'] : 0;
        $priceGoc = isset($_POST['priceGoc']) ? (float)$_POST['priceGoc'] : 0;

        // Kiểm tra thông tin sản phẩm
        if ($name && $price > 0) {
            // Cập nhật thông tin sản phẩm trong bảng product
            Inventory::updateProduct($productId, $name, $img, $description, $price, $priceGoc);
        }

        // Điều hướng lại đến trang danh sách sản phẩm
        redirect('/inventory');
    }

    // Xóa sản phẩm khỏi bảng product
    public function remove($productId): void
    {
        // Xóa sản phẩm khỏi bảng product
        Inventory::removeProduct((int)$productId);

        // Điều hướng lại đến trang danh sách sản phẩm
        redirect('/inventory');
    }

    // Cập nhật số lượng tồn kho cho sản phẩm
    public function updateStock($productId): void
    {
        // Lấy số lượng từ form
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;

        // Kiểm tra số lượng hợp lệ
        if ($quantity >= 0) {
            // Cập nhật số lượng tồn kho cho sản phẩm
            Inventory::updateStock((int)$productId, $quantity);
        }

        // Điều hướng lại đến trang danh sách sản phẩm
        redirect('/inventory');
    }

    // Thêm số lượng sản phẩm vào kho
    public function addStock($productId): void
    {
        // Lấy số lượng từ form
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;

        // Kiểm tra số lượng hợp lệ
        if ($quantity > 0) {
            // Thêm số lượng sản phẩm vào kho
            Inventory::addToInventory((int)$productId, $quantity);
        }

        // Điều hướng lại đến trang danh sách sản phẩm
        redirect('/inventory');
    }
}
?>
