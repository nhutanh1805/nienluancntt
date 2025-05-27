<?php
namespace App\Models;

use PDO;
use Exception;

class Member
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

    // Lấy tất cả thành viên đã đăng ký, thêm trường role, is_banned, banned_until
    public static function getAllMembers(): array
    {
        self::initDb();
        $stmt = self::$db->prepare("SELECT id, name, email, created_at, role, is_banned, banned_until FROM users");
        $stmt->execute();

        $members = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Thêm trường mô tả role để dễ hiển thị (0 = Người dùng, 1 = Quản trị)
        foreach ($members as &$member) {
            $member['role_name'] = ($member['role'] == 1) ? 'Quản trị' : 'Người dùng';
        }

        return $members;
    }

    public static function banUser(int $userId, int $banMinutes): bool
    {
        self::initDb();
        $bannedUntil = date('Y-m-d H:i:s', strtotime("+{$banMinutes} minutes"));
        $sql = "UPDATE users SET is_banned = 1, banned_until = :banned_until WHERE id = :id";
        $stmt = self::$db->prepare($sql);
        return $stmt->execute([':banned_until' => $bannedUntil, ':id' => $userId]);
    }

    // Bạn có thể thêm hàm bỏ ban
    public static function unbanUser(int $userId): bool
{
    self::initDb();
    $sql = "UPDATE users SET is_banned = 0, banned_until = NULL WHERE id = :id";
    $stmt = self::$db->prepare($sql);
    return $stmt->execute([':id' => $userId]);
}

// Kiểm tra xem người dùng có bị ban hay không
    public static function isBanned(int $userId): bool
    {
        self::initDb();
        $stmt = self::$db->prepare("SELECT is_banned, banned_until FROM users WHERE id = :id");
        $stmt->execute([':id' => $userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $user['is_banned']) {
            // Kiểm tra xem thời gian bị ban có hết hạn hay không
            $bannedUntil = strtotime($user['banned_until']);
            if ($bannedUntil > time()) {
                return true; // Người dùng vẫn bị ban
            } else {
                // Nếu thời gian bị ban đã hết, bỏ ban
                self::unbanUser($userId);
                return false;
            }
        }

        return false; // Người dùng không bị ban
    }

}
?>
