<?php
namespace App\Models;

use PDO;
use Exception;

class OrderDetail
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

    // Thêm chi tiết đơn hàng vào bảng order_details
    public static function addOrderDetail(int $orderId, int $productId, int $quantity, float $price, float $totalPrice): void
    {
        self::initDb();

        // Thêm chi tiết đơn hàng vào bảng order_details
        $stmt = self::$db->prepare("INSERT INTO order_details (order_id, product_id, quantity, price, total_price) 
                                    VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$orderId, $productId, $quantity, $price, $totalPrice]);
    }

    // Lấy chi tiết đơn hàng theo ID đơn hàng
    public static function getOrderDetails(int $orderId): array
{
    self::initDb();

    // Lấy chi tiết đơn hàng bao gồm tên sản phẩm, số lượng, giá và các thông tin khác
    $stmt = self::$db->prepare("SELECT od.*, 
                                          p.name AS product_name, 
                                          p.img AS product_img, 
                                          p.price AS product_price, 
                                          o.address AS order_address,
                                          o.status AS order_status,
                                          u.name AS user_name,
                                          o.created_at AS order_created_at
                                    FROM order_details od 
                                    JOIN product p ON od.product_id = p.id
                                    JOIN orders o ON od.order_id = o.id
                                    JOIN users u ON o.user_id = u.id
                                    WHERE od.order_id = ?");
    $stmt->execute([$orderId]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Trả về tất cả chi tiết sản phẩm trong đơn hàng
}

}
