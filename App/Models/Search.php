<?php
namespace App\Models;

use PDO;

class Search
{
    private PDO $db;

    public function __construct(PDO $pdo)
    {
        $this->db = $pdo;
    }

    public function searchProducts(string $query): array
    {
        // Cập nhật câu lệnh SQL để JOIN với bảng `productdetails`
        $stmt = $this->db->prepare('
            SELECT p.id, p.name, p.img, p.description, p.price, 
                   pd.product_type, pd.cpu, pd.ram, pd.storage, 
                   pd.battery_capacity, pd.camera_resolution, 
                   pd.screen_size, pd.os, pd.band, pd.strap_material, pd.water_resistance
            FROM product p
            LEFT JOIN productdetails pd ON p.id = pd.product_id
            WHERE p.name LIKE :query OR p.description LIKE :query
            LIMIT 10
        ');

        // Gắn giá trị vào tham số `query` trong câu lệnh SQL
        $stmt->bindValue(':query', '%' . $query . '%');
        $stmt->execute();

        // Trả về kết quả dưới dạng mảng
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
