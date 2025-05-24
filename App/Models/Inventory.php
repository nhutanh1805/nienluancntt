<?php
namespace App\Models;

use PDO;
use Exception;

class Inventory
{
    private static ?PDO $db = null;

    // Thiết lập kết nối DB
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

    // Lấy tất cả sản phẩm kết hợp với số lượng tồn kho từ bảng product và inventory
    public static function getAllProducts(): array
    {
        self::initDb();
        $stmt = self::$db->prepare(
            "SELECT p.id, p.name, p.img, p.price, p.priceGoc, i.quantity_in_stock, p.created_at, p.updated_at 
             FROM product p 
             LEFT JOIN inventory i ON p.id = i.product_id"
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm sản phẩm vào bảng product
    public static function addProduct(string $name, string $img, string $description, float $price, float $priceGoc): void
    {
        self::initDb();
        $stmt = self::$db->prepare("INSERT INTO product (name, img, description, price, priceGoc) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $img, $description, $price, $priceGoc]);
    }

    // Cập nhật thông tin sản phẩm trong bảng product
    public static function updateProduct(int $productId, string $name, string $img, string $description, float $price, float $priceGoc): void
    {
        self::initDb();
        $stmt = self::$db->prepare("UPDATE product SET name = ?, img = ?, description = ?, price = ?, priceGoc = ? WHERE id = ?");
        $stmt->execute([$name, $img, $description, $price, $priceGoc, $productId]);
    }

    // Xóa sản phẩm khỏi bảng product
    public static function removeProduct(int $productId): void
    {
        self::initDb();
        $stmt = self::$db->prepare("DELETE FROM product WHERE id = ?");
        $stmt->execute([$productId]);
    }

    // Lấy thông tin một sản phẩm theo product_id từ bảng product kết hợp với số lượng tồn kho từ bảng inventory
    public static function getProduct(int $productId): ?array
    {
        self::initDb();
        $stmt = self::$db->prepare(
            "SELECT p.id, p.name, p.img, p.price, p.priceGoc, i.quantity_in_stock, p.description, p.created_at, p.updated_at
             FROM product p
             LEFT JOIN inventory i ON p.id = i.product_id
             WHERE p.id = ?"
        );
        $stmt->execute([$productId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm sản phẩm vào kho (bảng inventory)
    public static function addToInventory(int $productId, int $quantity): void
    {
        self::initDb();

        // Kiểm tra xem sản phẩm đã có trong kho chưa
        $stmt = self::$db->prepare("SELECT id, quantity_in_stock FROM inventory WHERE product_id = ?");
        $stmt->execute([$productId]);
        $existingProduct = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingProduct) {
            // Nếu sản phẩm đã có trong kho, cập nhật số lượng
            $newQuantity = $existingProduct['quantity_in_stock'] + $quantity;
            $stmt = self::$db->prepare("UPDATE inventory SET quantity_in_stock = ? WHERE product_id = ?");
            $stmt->execute([$newQuantity, $productId]);
        } else {
            // Nếu sản phẩm chưa có trong kho, thêm sản phẩm vào kho
            $stmt = self::$db->prepare("INSERT INTO inventory (product_id, quantity_in_stock) VALUES (?, ?)");
            $stmt->execute([$productId, $quantity]);
        }
    }

    // Cập nhật số lượng tồn kho cho sản phẩm
    // Thêm phương thức cập nhật số lượng vào InventoryController
// Cập nhật số lượng tồn kho cho sản phẩm
public static function updateStock(int $productId, int $quantity): void
{
    self::initDb();
    $stmt = self::$db->prepare("UPDATE inventory SET quantity_in_stock = ? WHERE product_id = ?");
    $stmt->execute([$quantity, $productId]);
}


    // Xóa sản phẩm khỏi kho (bảng inventory)
    public static function removeFromInventory(int $productId): void
    {
        self::initDb();
        $stmt = self::$db->prepare("DELETE FROM inventory WHERE product_id = ?");
        $stmt->execute([$productId]);
    }
}
?>
