<?php
namespace App\Models;

class Warehouse
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Phương thức lấy thông tin sản phẩm
    public function getAllProducts()
    {
        $sql = "SELECT p.id, p.name, p.img, p.price, i.quantity 
                FROM products p
                JOIN inventory i ON p.id = i.product_id";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
?>
