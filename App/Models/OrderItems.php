<?php
namespace App\Models;

use PDO;
use Exception;

class OrderItems
{
    private static ?PDO $db = null;

    // Kết nối cơ sở dữ liệu (dùng PDO)
    public static function setDb(PDO $pdo): void
    {
        self::$db = $pdo;
    }

    // Khởi tạo kết nối DB nếu chưa có
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

    // Thêm đơn hàng mới vào bảng orders
    public static function addOrder(int $userId, string $address, float $totalAmount): int
    {
        self::initDb();

        try {
            // Thêm đơn hàng vào bảng orders
            $stmt = self::$db->prepare("INSERT INTO orders (user_id, address, total_amount, status, created_at, updated_at) 
                                        VALUES (:user_id, :address, :total_amount, :status, NOW(), NOW())");

            $status = 'Pending';  // Trạng thái đơn hàng mặc định là 'Pending'

            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':address', $address, PDO::PARAM_STR);
            $stmt->bindParam(':total_amount', $totalAmount, PDO::PARAM_STR);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);

            $stmt->execute();

            // Trả về ID của đơn hàng mới được thêm
            return self::$db->lastInsertId();
        } catch (Exception $e) {
            throw new Exception("Lỗi khi thêm đơn hàng: " . $e->getMessage());
        }
    }

    // Thêm chi tiết sản phẩm vào đơn hàng
    public static function addOrderItem(int $orderId, int $productId, int $quantity, float $price, float $totalPrice): void
    {
        self::initDb();

        try {
            // Thêm chi tiết sản phẩm vào bảng order_details
            $stmt = self::$db->prepare("INSERT INTO order_details (order_id, product_id, quantity, price, total_price) 
                                        VALUES (:order_id, :product_id, :quantity, :price, :total_price)");

            $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $stmt->bindParam(':price', $price, PDO::PARAM_STR);
            $stmt->bindParam(':total_price', $totalPrice, PDO::PARAM_STR);

            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception("Lỗi khi thêm chi tiết sản phẩm: " . $e->getMessage());
        }
    }

    // Lấy chi tiết đơn hàng theo ID đơn hàng
    public static function getOrderItems(int $orderId): array
    {
        self::initDb();

        try {
            // Lấy chi tiết đơn hàng từ các bảng orders, order_details, product, users
            $stmt = self::$db->prepare("SELECT 
                                            o.id AS order_id, 
                                            o.user_id, 
                                            o.address, 
                                            o.total_amount, 
                                            o.status, 
                                            o.created_at AS order_created_at, 
                                            o.updated_at AS order_updated_at,
                                            u.name AS user_name, 
                                            od.product_id, 
                                            p.name AS product_name, 
                                            od.quantity, 
                                            od.price, 
                                            od.total_price,
                                            p.img AS product_img
                                        FROM orders o
                                        JOIN order_details od ON o.id = od.order_id
                                        JOIN product p ON od.product_id = p.id
                                        JOIN users u ON o.user_id = u.id
                                        WHERE o.id = ?");

            $stmt->execute([$orderId]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Trả về tất cả chi tiết sản phẩm trong đơn hàng
        } catch (Exception $e) {
            throw new Exception("Lỗi khi lấy chi tiết đơn hàng: " . $e->getMessage());
        }
    }

    // Lấy tất cả đơn hàng của một user
    public static function getOrdersByUser(int $userId): array
    {
        self::initDb();

        try {
            // Lấy tất cả đơn hàng của một user
            $stmt = self::$db->prepare("SELECT 
                                            o.id AS order_id, 
                                            o.user_id, 
                                            o.address, 
                                            o.total_amount, 
                                            o.status, 
                                            o.created_at AS order_created_at, 
                                            o.updated_at AS order_updated_at
                                        FROM orders o
                                        WHERE o.user_id = :user_id");
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Trả về tất cả đơn hàng của user
        } catch (Exception $e) {
            throw new Exception("Lỗi khi lấy đơn hàng của người dùng: " . $e->getMessage());
        }
    }

    // Cập nhật tổng tiền của đơn hàng
    public static function updateTotalAmount(int $orderId): void
    {
        self::initDb();

        try {
            // Lấy tổng tiền từ bảng order_details
            $stmt = self::$db->prepare("SELECT SUM(total_price) AS total_amount FROM order_details WHERE order_id = ?");
            $stmt->execute([$orderId]);

            $totalAmount = $stmt->fetchColumn();

            // Cập nhật lại tổng tiền cho đơn hàng
            $stmt = self::$db->prepare("UPDATE orders SET total_amount = ? WHERE id = ?");
            $stmt->execute([$totalAmount, $orderId]);
        } catch (Exception $e) {
            throw new Exception("Lỗi khi cập nhật tổng tiền cho đơn hàng: " . $e->getMessage());
        }
    }
}
?>
