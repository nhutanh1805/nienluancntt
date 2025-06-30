<?php
namespace App\Models;

use PDO;
use Exception;

class Message
{
    private static ?PDO $db = null;

    public static function setDb(PDO $pdo): void
    {
        self::$db = $pdo;
    }

    private static function initDb(): void
    {
        if (self::$db === null) {
            $dsn = "mysql:host=localhost;dbname=lapstore;charset=utf8mb4";
            $username = "root";
            $password = "123456";
            try {
                self::$db = new PDO($dsn, $username, $password);
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (Exception $e) {
                throw new Exception("Không thể kết nối database: " . $e->getMessage());
            }
        }
    }

    // Gửi tin nhắn chung
    public static function sendMessage(int $senderId, string $message): void
    {
        self::initDb();
        $message = trim($message);
        if ($message === '') {
            throw new Exception("Nội dung tin nhắn không được để trống.");
        }
        $stmt = self::$db->prepare("INSERT INTO messages (sender_id, message, sent_at) VALUES (?, ?, CURRENT_TIMESTAMP)");
        $stmt->execute([$senderId, $message]);
    }

    // Lấy tất cả tin nhắn chat chung, theo thời gian tăng dần
    public static function getAllMessages(): array
    {
        self::initDb();
        $stmt = self::$db->prepare("
            SELECT m.*, u.name AS sender_name 
            FROM messages m 
            JOIN users u ON m.sender_id = u.id 
            ORDER BY m.sent_at ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thu hồi tin nhắn theo id và sender_id (chỉ được thu hồi tin nhắn của chính mình)
    public static function revokeMessage(int $messageId, int $senderId): bool
    {
        self::initDb();
        $stmt = self::$db->prepare("DELETE FROM messages WHERE id = ? AND sender_id = ?");
        $stmt->execute([$messageId, $senderId]);
        return $stmt->rowCount() > 0; // true nếu xóa được, false nếu không
    }
}
