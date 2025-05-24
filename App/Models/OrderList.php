<?php
namespace App\Models;

use PDO;
use Exception;

class OrderList
{
    private static ?PDO $db = null;

    // Thiết lập kết nối DB
    public static function setDb(PDO $pdo): void
    {
        self::$db = $pdo;
    }

    // Khởi tạo DB nếu chưa có kết nối
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

    // Lấy tất cả đơn hàng
    public static function getAllOrders(): array
    {
        self::initDb();

        $stmt = self::$db->prepare("SELECT * FROM orders");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
