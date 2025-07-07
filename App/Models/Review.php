<?php
namespace App\Models;

use PDO;
use Exception;

class Review
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

    // Thêm đánh giá mới
    public static function addReview(int $userId, int $productId, int $rating, string $comment = ''): bool
    {
        self::initDb();

        $sql = "INSERT INTO reviews (user_id, product_id, rating, comment) 
                VALUES (:user_id, :product_id, :rating, :comment)";
        $stmt = self::$db->prepare($sql);

        return $stmt->execute([
            ':user_id' => $userId,
            ':product_id' => $productId,
            ':rating' => $rating,
            ':comment' => $comment
        ]);
    }

    // Lấy tất cả đánh giá theo sản phẩm
    public static function getReviewsByProduct(int $productId): array
    {
        self::initDb();

        $sql = "SELECT r.*, u.name AS user_name 
                FROM reviews r 
                JOIN users u ON r.user_id = u.id 
                WHERE r.product_id = :product_id 
                ORDER BY r.created_at DESC";
        $stmt = self::$db->prepare($sql);
        $stmt->execute([':product_id' => $productId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy đánh giá gần nhất của user với sản phẩm
    public static function getLatestReviewByUser(int $userId, int $productId): ?array
    {
        self::initDb();

        $sql = "SELECT * FROM reviews 
                WHERE user_id = :user_id AND product_id = :product_id 
                ORDER BY created_at DESC LIMIT 1";
        $stmt = self::$db->prepare($sql);
        $stmt->execute([
            ':user_id' => $userId,
            ':product_id' => $productId
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    // Lấy trung bình số sao của sản phẩm
   public static function getAverageRating(int $productId): float
{
    self::initDb();

    $sql = "SELECT AVG(rating) FROM reviews WHERE product_id = :product_id";
    $stmt = self::$db->prepare($sql);
    $stmt->execute([':product_id' => $productId]);

    $avg = $stmt->fetchColumn();

    return $avg !== null ? round((float)$avg, 1) : 0.0;
}


// Lấy tổng số lượng đánh giá của sản phẩm
public static function getTotalReviews(int $productId): int
{
    self::initDb();

    $sql = "SELECT COUNT(*) FROM reviews WHERE product_id = :product_id";
    $stmt = self::$db->prepare($sql);
    $stmt->execute([':product_id' => $productId]);

    return (int)$stmt->fetchColumn();
}


}
?>
