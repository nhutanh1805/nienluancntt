<?php
namespace App\Controllers;

use App\Models\Cart;
use PDO;
class CartController extends Controller
{
    // Thêm sản phẩm vào giỏ hàng
    public function add($productId): void
{
    $userId = $_SESSION['user_id']; // Lấy ID người dùng từ session
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

    // Kiểm tra số lượng sản phẩm trong kho
    $stmt = Cart::getDb()->prepare("SELECT quantity_in_stock FROM inventory WHERE product_id = ?");
    $stmt->execute([$productId]);
    $inventory = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$inventory || $inventory['quantity_in_stock'] < $quantity) {
        // Nếu không đủ số lượng trong kho, thông báo lỗi và không thêm vào giỏ hàng
        echo "Số lượng sản phẩm trong kho không đủ.";
        return;
    }

    // Lưu giỏ hàng vào cơ sở dữ liệu
    Cart::addToCart($userId, (int)$productId, $quantity);

    redirect('/cart');
}


    // Xóa sản phẩm khỏi giỏ hàng
    public function remove($productId): void
{
    $userId = $_SESSION['user_id'];

    // Kiểm tra nếu sản phẩm tồn tại trong giỏ hàng trước khi xóa
    $stmt = Cart::getDb()->prepare("SELECT id FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$userId, $productId]);
    $existingItem = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$existingItem) {
        echo "Sản phẩm không có trong giỏ hàng.";
        return;
    }

    Cart::removeFromCart($userId, (int)$productId);

    redirect('/cart');
}


    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public function update($productId): void
{
    $userId = $_SESSION['user_id'];
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

    // Kiểm tra số lượng sản phẩm trong kho
    $stmt = Cart::getDb()->prepare("SELECT quantity_in_stock FROM inventory WHERE product_id = ?");
    $stmt->execute([$productId]);
    $inventory = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$inventory || $inventory['quantity_in_stock'] < $quantity) {
        // Nếu số lượng yêu cầu lớn hơn số lượng trong kho, thông báo lỗi
        echo "Số lượng sản phẩm trong kho không đủ.";
        return;
    }

    if ($quantity < 1) {
        $quantity = 1; // Đảm bảo số lượng ít nhất là 1
    }

    Cart::updateQuantity($userId, (int)$productId, $quantity);

    redirect('/cart');
}

    // Hiển thị giỏ hàng
    public function index(): void
    {
        $userId = $_SESSION['user_id'];
        $cart  = Cart::getCart($userId);
        $total = Cart::getTotal($userId);
        $this->sendPage('cart/index', [
            'cart'  => $cart,
            'total' => $total
        ]);
    }
}
