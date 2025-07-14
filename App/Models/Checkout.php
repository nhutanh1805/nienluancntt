<?php
namespace App\Models;

use PDO;
use Exception;

class Checkout
{
    private static ?PDO $db = null;

    // Thiết lập kết nối thủ công nếu cần
    public static function setDb(PDO $pdo): void
    {
        self::$db = $pdo;
    }

    // Tự động khởi tạo nếu chưa có kết nối
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

    // Lưu thông tin người nhận khi thanh toán
    public static function saveInfo(int $userId, string $name, string $address, string $phone): int
    {
        self::initDb();

        $stmt = self::$db->prepare("
            INSERT INTO checkouts (user_id, name, address, phone, created_at)
            VALUES (:user_id, :name, :address, :phone, NOW())
        ");

        $stmt->execute([
            ':user_id' => $userId,
            ':name' => $name,
            ':address' => $address,
            ':phone' => $phone
        ]);

        return (int)self::$db->lastInsertId();
    }

    // (Tuỳ chọn) Lấy thông tin checkout gần nhất của người dùng
    public static function getLastInfo(int $userId): ?array
    {
        self::initDb();

        $stmt = self::$db->prepare("
            SELECT * FROM checkouts
            WHERE user_id = :user_id
            ORDER BY created_at DESC
            LIMIT 1
        ");

        $stmt->execute([':user_id' => $userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ?: null;
    }
}
