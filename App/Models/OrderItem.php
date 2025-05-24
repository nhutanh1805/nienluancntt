<?php
namespace App\Models;

use PDO;
use Exception;

class OrderItem
{
    private static ?PDO $db = null;

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
    // Thêm sản phẩm vào bảng `order_items`
    public static function addOrderItem(int $orderId, int $productId, int $quantity, float $price, float $totalPrice): void
    {
        self::initDb();

        // Thêm sản phẩm vào bảng `order_items`
        $stmt = self::$db->prepare("INSERT INTO order_items (order_id, product_id, quantity, price, total_price) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$orderId, $productId, $quantity, $price, $totalPrice]);
    }
}
