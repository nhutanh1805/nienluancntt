<?php
namespace App\Models;

use PDO;
use Exception;

class Order
{
    private static ?PDO $db = null;

    public static function setDb(PDO $pdo): void
    {
        self::$db = $pdo;
    }

    private static function initDb(): void
    {
        if (self::$db === null) {
            $dsn = "mysql:host=localhost;dbname=nienluancoso;charset=utf8";
            $username = "root";
            $password = "123456";
            try {
                self::$db = new PDO($dsn, $username, $password);
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (Exception $e) {
                throw new Exception("Không thể kết nối đến database: " . $e->getMessage());
            }
        }
    }

    // Tạo đơn hàng mới
    public static function createOrder(int $userId, string $address): int
    {
        self::initDb();
        // Tính tổng tiền từ giỏ hàng
        $totalAmount = Cart::getTotal($userId);
    
        if ($totalAmount <= 0) {
            throw new Exception("Giỏ hàng của bạn không có sản phẩm.");
        }
    
        // Thêm đơn hàng vào bảng orders
        $stmt = self::$db->prepare("INSERT INTO orders (user_id, address, total_amount, status, created_at) 
                                    VALUES (?, ?, ?, 'Processing', CURRENT_TIMESTAMP)");
        $stmt->execute([$userId, $address, $totalAmount]);
    
        // Lấy ID của đơn hàng vừa tạo
        $orderId = self::$db->lastInsertId();
    
        // Lấy giỏ hàng của người dùng
        $cartItems = Cart::getCart($userId);  // Sử dụng phương thức getCart() của Cart model
    
        foreach ($cartItems as $item) {
            // Thêm chi tiết vào bảng order_details
            $stmt = self::$db->prepare("INSERT INTO order_details (order_id, product_id, quantity, price, total_price) 
                                        VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([ 
                $orderId, 
                $item['id'],  // product_id
                $item['quantity'],  // quantity
                $item['price'],  // price
                $item['total_price']  // total_price
            ]);
        }
    
        // Xóa giỏ hàng sau khi tạo đơn hàng
        Cart::clearCart($userId);

        return $orderId;
    }

    // Lấy thông tin đơn hàng


 // Lấy tất cả đơn hàng
 public static function getAllOrders(): array
 {
     self::initDb();
     
     // Lấy tất cả đơn hàng từ bảng orders
     $stmt = self::$db->prepare("SELECT * FROM orders");
     $stmt->execute();

     return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Trả về tất cả các đơn hàng
 }
 
    // Lấy tất cả đơn hàng của người dùng
    public static function getUserOrders(int $userId): array
    {
        self::initDb();
        $stmt = self::$db->prepare("SELECT o.id, o.address, o.total_amount, o.status, o.created_at, o.updated_at 
                                    FROM orders o
                                    WHERE o.user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Cập nhật địa chỉ của đơn hàng
    public static function updateOrderAddress(int $orderId, string $newAddress): void
    {
        self::initDb();
        $stmt = self::$db->prepare("UPDATE orders SET address = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
        $stmt->execute([$newAddress, $orderId]);
    }

    // Cập nhật trạng thái đơn hàng (ví dụ: đang xử lý, đã giao hàng, v.v.)
    public static function updateOrderStatus(int $orderId, string $status, int $userId = null): void
{
    self::initDb();

    // Cập nhật trạng thái của đơn hàng
    $stmt = self::$db->prepare("UPDATE orders SET status = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
    $stmt->execute([$status, $orderId]);
}



    // Hủy đơn hàng
    public static function cancelOrder(int $orderId): void
    {
        self::initDb();
        // Hủy đơn hàng, có thể cập nhật trạng thái thay vì xóa trực tiếp
        $stmt = self::$db->prepare("UPDATE orders SET status = 'Cancelled', updated_at = CURRENT_TIMESTAMP WHERE id = ?");
        $stmt->execute([$orderId]);
    }
    // Trong Order model
    public static function deleteOrder(int $orderId): void
    {
        self::initDb();
    
        // Xóa tất cả các chi tiết của đơn hàng trước khi xóa đơn hàng
        $stmt = self::$db->prepare("DELETE FROM order_details WHERE order_id = ?");
        $stmt->execute([$orderId]);
    
        // Sau đó xóa đơn hàng chính
        $stmt = self::$db->prepare("DELETE FROM orders WHERE id = ?");
        $stmt->execute([$orderId]);
    }
     // Cập nhật bình luận cho đơn hàng
public static function updateOrderComment(int $orderId, string $comment): void
{
    self::initDb();
    
    // Cập nhật bình luận vào cột `cmt` của bảng `orders`
    $stmt = self::$db->prepare("UPDATE orders SET cmt = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
    $stmt->execute([$comment, $orderId]);
}

}
?>
