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
            $dsn = "mysql:host=localhost;dbname=lapstore;charset=utf8";
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
    
        // Cập nhật bảng checkouts để gắn order_id với checkout mới nhất của user
$stmt = self::$db->prepare("UPDATE checkouts SET order_id = ? WHERE user_id = ? ORDER BY id DESC LIMIT 1");
$stmt->execute([$orderId, $userId]);

        // Lấy giỏ hàng của người dùng
        $cartItems = Cart::getCart($userId);  
    
        foreach ($cartItems as $item) {
            // Thêm chi tiết vào bảng order_details
            $stmt = self::$db->prepare("INSERT INTO order_details (order_id, product_id, quantity, price, total_price) 
                                        VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([ 
                $orderId, 
                $item['id'],  
                $item['quantity'],  
                $item['price'], 
                $item['total_price']  
            ]);
        }
    
        // Xóa giỏ hàng sau khi tạo đơn hàng
        Cart::clearCart($userId);

        return $orderId;
    }



// Lấy tất cả đơn hàng kèm tên người dùng
public static function getAllOrders(): array
{
    self::initDb();

    $stmt = self::$db->prepare("
        SELECT o.id, o.user_id, o.address, o.total_amount, o.status, o.created_at, o.updated_at, u.name
        FROM orders o
        JOIN users u ON o.user_id = u.id
    ");
    
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

 
 // Lấy tất cả đơn hàng của một người dùng, kèm tên người dùng
public static function getUserOrders(int $userId): array
{
    self::initDb();
    
    $stmt = self::$db->prepare("
        SELECT o.id, o.user_id, o.address, o.total_amount, o.status, o.created_at, o.updated_at, u.name
        FROM orders o
        JOIN users u ON o.user_id = u.id
        WHERE o.user_id = ?
    ");

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

    // Lấy tất cả sản phẩm trong đơn hàng
    $stmt = self::$db->prepare("SELECT product_id, quantity FROM order_details WHERE order_id = ?");
    $stmt->execute([$orderId]);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Cộng lại số lượng vào inventory
    foreach ($items as $item) {
        $stmt = self::$db->prepare("UPDATE inventory SET quantity_in_stock = quantity_in_stock + ? WHERE product_id = ?");
        $stmt->execute([$item['quantity'], $item['product_id']]);
    }

    // Cập nhật trạng thái đơn hàng là Cancelled
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

public static function getAllComments(): array
{
    self::initDb();
    $stmt = self::$db->prepare("
        SELECT o.id, o.user_id, u.name AS user_name, o.cmt, o.total_amount
        FROM orders o
        INNER JOIN users u ON o.user_id = u.id
        WHERE o.cmt IS NOT NULL AND TRIM(o.cmt) != ''
    ");
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC); 
}


// Lấy thống kê số lượng sản phẩm đã bán ra
public static function getProductSalesStats(): array
{
    self::initDb();

    $stmt = self::$db->prepare("
        SELECT 
            p.id AS product_id,
            p.name AS product_name,
            SUM(od.quantity) AS total_quantity_sold,
            SUM(od.total_price) AS total_revenue
        FROM order_details od
        JOIN orders o ON od.order_id = o.id
        JOIN product p ON od.product_id = p.id
        WHERE o.status != 'Cancelled'
        GROUP BY p.id, p.name
        ORDER BY total_quantity_sold DESC
    ");

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public static function filterOrdersByDate(string $filterType = 'all', ?string $filterValue = null): array
{
    self::initDb();

    $sql = "
        SELECT o.id, o.user_id, o.address, o.total_amount, o.status, o.created_at, o.updated_at, u.name
        FROM orders o
        JOIN users u ON o.user_id = u.id
        WHERE 1 = 1
    ";

    $params = [];

    if ($filterType === 'day' && $filterValue) {
        $sql .= " AND DATE(o.created_at) = ?";
        $params[] = $filterValue;
    } elseif ($filterType === 'month' && $filterValue) {
        $sql .= " AND DATE_FORMAT(o.created_at, '%Y-%m') = ?";
        $params[] = $filterValue;
    } elseif ($filterType === 'year' && $filterValue) {
        $sql .= " AND DATE_FORMAT(o.created_at, '%Y') = ?";
        $params[] = $filterValue;
    }

    $sql .= " ORDER BY o.created_at DESC";

    $stmt = self::$db->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


}
?>
