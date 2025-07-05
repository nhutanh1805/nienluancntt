<?php
namespace App\Models;

use PDO;
use Exception;

class ThongKe
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
                throw new Exception("Không thể kết nối CSDL: " . $e->getMessage());
            }
        }
    }

    public static function getTotalRevenue(string $filterType = 'all', ?string $filterValue = null): float
    {
        self::initDb();

        $sql = "SELECT SUM(total_amount) AS revenue FROM orders WHERE status = 'Delivered'";
        $params = [];

        if ($filterType === 'day' && $filterValue) {
            $sql .= " AND DATE(created_at) = ?";
            $params[] = $filterValue;
        } elseif ($filterType === 'month' && $filterValue) {
            $sql .= " AND DATE_FORMAT(created_at, '%Y-%m') = ?";
            $params[] = $filterValue;
        } elseif ($filterType === 'year' && $filterValue) {
            $sql .= " AND DATE_FORMAT(created_at, '%Y') = ?";
            $params[] = $filterValue;
        }

        $stmt = self::$db->prepare($sql);
        $stmt->execute($params);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (float) ($result['revenue'] ?? 0);
    }

    public static function getOrderCountByStatus(string $filterType = 'all', ?string $filterValue = null): array
    {
        self::initDb();

        $sql = "SELECT status, COUNT(*) as count FROM orders";
        $params = [];

        if ($filterType === 'day' && $filterValue) {
            $sql .= " WHERE DATE(created_at) = ?";
            $params[] = $filterValue;
        } elseif ($filterType === 'month' && $filterValue) {
            $sql .= " WHERE DATE_FORMAT(created_at, '%Y-%m') = ?";
            $params[] = $filterValue;
        } elseif ($filterType === 'year' && $filterValue) {
            $sql .= " WHERE DATE_FORMAT(created_at, '%Y') = ?";
            $params[] = $filterValue;
        }

        $sql .= " GROUP BY status";

        $stmt = self::$db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getDeliveredOrders(string $filterType = 'all', ?string $filterValue = null): array
    {
        self::initDb();

        $sql = "SELECT orders.*, users.name AS user_name 
                FROM orders 
                JOIN users ON orders.user_id = users.id 
                WHERE orders.status = 'Delivered'";
        
        $params = [];

        if ($filterType === 'day' && $filterValue) {
            $sql .= " AND DATE(orders.created_at) = ?";
            $params[] = $filterValue;
        } elseif ($filterType === 'month' && $filterValue) {
            $sql .= " AND DATE_FORMAT(orders.created_at, '%Y-%m') = ?";
            $params[] = $filterValue;
        } elseif ($filterType === 'year' && $filterValue) {
            $sql .= " AND DATE_FORMAT(orders.created_at, '%Y') = ?";
            $params[] = $filterValue;
        }

        $sql .= " ORDER BY orders.created_at DESC";

        $stmt = self::$db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
