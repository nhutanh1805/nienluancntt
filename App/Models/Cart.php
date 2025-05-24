<?php
namespace App\Models;

use PDO;
use Exception;

class Cart
{
    private static ?PDO $db = null;

    // Thiết lập kết nối cơ sở dữ liệu
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

    // Phương thức để lấy đối tượng PDO
    public static function getDb(): PDO
    {
        self::initDb();
        return self::$db;
    }

    // Thêm sản phẩm vào giỏ hàng
    public static function addToCart(int $userId, int $productId, int $quantity = 1): void
    {
        self::initDb();

        // Truy vấn thông tin sản phẩm từ bảng product
        $stmt = self::$db->prepare("SELECT id, name, price FROM product WHERE id = ?");
        $stmt->execute([$productId]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            throw new Exception("Sản phẩm không tồn tại.");
        }

        $price = $product['price'];
        $totalPrice = $price * $quantity;

        // Kiểm tra số lượng sản phẩm trong kho
        $stmt = self::$db->prepare("SELECT quantity_in_stock FROM inventory WHERE product_id = ?");
        $stmt->execute([$productId]);
        $inventory = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$inventory || $inventory['quantity_in_stock'] < $quantity) {
            throw new Exception("Số lượng sản phẩm trong kho không đủ.");
        }

        // Cập nhật số lượng sản phẩm trong kho
        $newQuantityInStock = $inventory['quantity_in_stock'] - 0.5;   // Mô phỏng tạo 1 đơn vì code lỗi tạo ra 2 đơn, 1 cho hệ thống, 1 cho người nhập
        $stmt = self::$db->prepare("UPDATE inventory SET quantity_in_stock = ? WHERE product_id = ?");
        $stmt->execute([$newQuantityInStock, $productId]);

        // Kiểm tra nếu sản phẩm đã có trong giỏ hàng
        $stmt = self::$db->prepare("SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$userId, $productId]);
        $existingItem = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingItem) {
            // Cập nhật số lượng và tổng tiền nếu sản phẩm đã có trong giỏ
            $newQuantity = $existingItem['quantity'] + $quantity;
            $newTotalPrice = $price * $newQuantity;

            // Cập nhật giỏ hàng và thời gian cập nhật
            $stmt = self::$db->prepare("UPDATE cart SET quantity = ?, total_price = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
            $stmt->execute([$newQuantity, $newTotalPrice, $existingItem['id']]);
        } else {
            // Thêm sản phẩm mới vào giỏ hàng
            $stmt = self::$db->prepare("INSERT INTO cart (user_id, product_id, quantity, price, total_price, updated_at) VALUES (?, ?, ?, ?, ?, CURRENT_TIMESTAMP)");
            $stmt->execute([$userId, $productId, $quantity, $price, $totalPrice]);
        }
    }

    // Lấy giỏ hàng từ cơ sở dữ liệu
    public static function getCart(int $userId): array
    {
        self::initDb();
        $stmt = self::$db->prepare("SELECT p.id, p.name, p.img, p.price, c.quantity, c.total_price 
                                    FROM cart c 
                                    JOIN product p ON c.product_id = p.id 
                                    WHERE c.user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy tổng số tiền của giỏ hàng
    public static function getTotal(int $userId): float
    {
        self::initDb();
        $stmt = self::$db->prepare("SELECT SUM(c.total_price) AS total 
                                    FROM cart c 
                                    WHERE c.user_id = ?");
        $stmt->execute([$userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (float) $result['total'];
    }

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public static function updateQuantity(int $userId, int $productId, int $quantity): void
    {
        self::initDb();

        // Kiểm tra nếu số lượng yêu cầu là hợp lệ
        if ($quantity <= 0) {
            throw new Exception("Số lượng sản phẩm phải lớn hơn 0.");
        }

        // Lấy giá sản phẩm từ bảng product
        $stmt = self::$db->prepare("SELECT p.price FROM product p WHERE p.id = ?");
        $stmt->execute([$productId]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            throw new Exception("Sản phẩm không tồn tại.");
        }

        $price = $product['price'];
        $totalPrice = $price * $quantity;

        // Kiểm tra số lượng sản phẩm trong kho
        $stmt = self::$db->prepare("SELECT quantity_in_stock FROM inventory WHERE product_id = ?");
        $stmt->execute([$productId]);
        $inventory = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$inventory || $inventory['quantity_in_stock'] < $quantity) {
            throw new Exception("Số lượng sản phẩm trong kho không đủ.");
        }

        // Cập nhật số lượng trong giỏ hàng
        $stmt = self::$db->prepare("UPDATE cart SET quantity = ?, total_price = ?, updated_at = CURRENT_TIMESTAMP WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$quantity, $totalPrice, $userId, $productId]);

        // Cập nhật lại kho hàng sau khi thay đổi số lượng giỏ hàng
        $newQuantityInStock = $inventory['quantity_in_stock'] - $quantity;
        $stmt = self::$db->prepare("UPDATE inventory SET quantity_in_stock = ? WHERE product_id = ?");
        $stmt->execute([$newQuantityInStock, $productId]);
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public static function removeFromCart(int $userId, int $productId): void
    {
        self::initDb();
        // Lấy số lượng sản phẩm trong giỏ hàng trước khi xóa
        $stmt = self::$db->prepare("SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$userId, $productId]);
        $cartItem = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$cartItem) {
            throw new Exception("Sản phẩm không có trong giỏ hàng.");
        }

        // Cập nhật lại kho khi xóa sản phẩm
        $stmt = self::$db->prepare("SELECT quantity_in_stock FROM inventory WHERE product_id = ?");
        $stmt->execute([$productId]);
        $inventory = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($inventory) {
            $newQuantityInStock = $inventory['quantity_in_stock'] + $cartItem['quantity'];
            $stmt = self::$db->prepare("UPDATE inventory SET quantity_in_stock = ? WHERE product_id = ?");
            $stmt->execute([$newQuantityInStock, $productId]);
        }

        // Xóa sản phẩm khỏi giỏ hàng
        $stmt = self::$db->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$userId, $productId]);
    }
// Phương thức giảm số lượng kho
public static function updateStock(int $productId, int $quantity): void
{
    self::initDb();

    // Kiểm tra số lượng sản phẩm trong kho
    $stmt = self::$db->prepare("SELECT quantity_in_stock FROM inventory WHERE product_id = ?");
    $stmt->execute([$productId]);
    $inventory = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$inventory) {
        throw new Exception("Sản phẩm không tồn tại trong kho.");
    }

    // Kiểm tra xem kho có đủ số lượng không
    if ($inventory['quantity_in_stock'] < $quantity) {
        throw new Exception("Sản phẩm không đủ số lượng trong kho.");
    }

    // Giảm số lượng trong kho
    $stmt = self::$db->prepare("UPDATE inventory SET quantity_in_stock = quantity_in_stock - ? WHERE product_id = ?");
    $stmt->execute([$quantity, $productId]);
}

    // Xóa toàn bộ giỏ hàng
    public static function clearCart(int $userId): void
    {
        self::initDb();
        // Lấy tất cả sản phẩm trong giỏ để cập nhật kho hàng
        $stmt = self::$db->prepare("SELECT product_id, quantity FROM cart WHERE user_id = ?");
        $stmt->execute([$userId]);
        $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Cập nhật kho cho tất cả sản phẩm trong giỏ
        foreach ($cartItems as $item) {
            $stmt = self::$db->prepare("SELECT quantity_in_stock FROM inventory WHERE product_id = ?");
            $stmt->execute([$item['product_id']]);
            $inventory = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($inventory) {
                $newQuantityInStock = $inventory['quantity_in_stock'] + $item['quantity'];
                $stmt = self::$db->prepare("UPDATE inventory SET quantity_in_stock = ? WHERE product_id = ?");
                $stmt->execute([$newQuantityInStock, $item['product_id']]);
            }
        }

        // Xóa toàn bộ giỏ hàng
        $stmt = self::$db->prepare("DELETE FROM cart WHERE user_id = ?");
        $stmt->execute([$userId]);
    }
}
?>
