<?php
namespace App\Models;

use PDO;
use Exception;

class Comment
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

    // Thêm bình luận vào cơ sở dữ liệu
    public static function addComment(int $userId, string $content, ?string $imageLink, ?int $rate, ?int $orderId): void
    {
        self::initDb();

        // Thêm bình luận vào cơ sở dữ liệu
        $stmt = self::$db->prepare("INSERT INTO comment (user_id, content, image_link, rate, date, order_id) 
                                    VALUES (?, ?, ?, ?, NOW(), ?)");
        $stmt->execute([$userId, $content, $imageLink, $rate, $orderId]);
    }

    // Lấy tất cả bình luận của một người dùng
    public static function getCommentsByUser(int $userId): array
    {
        self::initDb();
        $stmt = self::$db->prepare("SELECT * FROM comment WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy tất cả bình luận của một đơn hàng
    public static function getCommentsByOrder(int $orderId): array
    {
        self::initDb();
        $stmt = self::$db->prepare("SELECT * FROM comment WHERE order_id = ?");
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Cập nhật bình luận
    public static function updateComment(int $commentId, string $content, ?string $imageLink, ?int $rate): void
    {
        self::initDb();
        $stmt = self::$db->prepare("UPDATE comment SET content = ?, image_link = ?, rate = ?, date = NOW() WHERE id = ?");
        $stmt->execute([$content, $imageLink, $rate, $commentId]);
    }

    // Xóa bình luận
    public static function deleteComment(int $commentId): void
    {
        self::initDb();
        $stmt = self::$db->prepare("DELETE FROM comment WHERE id = ?");
        $stmt->execute([$commentId]);
    }
    
    // Lấy bình luận theo ID
    public static function getCommentById(int $commentId): ?array
    {
        self::initDb();
        $stmt = self::$db->prepare("SELECT * FROM comment WHERE id = ?");
        $stmt->execute([$commentId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}
?>
