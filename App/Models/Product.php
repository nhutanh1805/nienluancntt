<?php
// Kết nối đến cơ sở dữ liệu bằng cách bao gồm tệp db_connect.php, nơi chứa mã kết nối PDO
require_once 'db_connect.php';  // Kết nối đến cơ sở dữ liệu

// Định nghĩa lớp Product, dùng để thao tác với bảng sản phẩm trong cơ sở dữ liệu
class Product {
    private $db;  // Biến lưu trữ kết nối cơ sở dữ liệu

    /**
     * Hàm khởi tạo lớp Product, nhận vào đối tượng PDO để thiết lập kết nối với cơ sở dữ liệu.
     *
     * @param PDO $db Đối tượng PDO dùng để kết nối với cơ sở dữ liệu.
     */
    public function __construct($db) {
        $this->db = $db;  // Lưu kết nối cơ sở dữ liệu vào thuộc tính $db
    }

    /**
     * Tìm sản phẩm theo ID trong cơ sở dữ liệu.
     *
     * @param int $productId ID của sản phẩm cần tìm.
     * @return array|null Thông tin sản phẩm dưới dạng mảng nếu tìm thấy, ngược lại trả về null.
     */
    public function find($productId) {
        // Câu truy vấn SQL để tìm sản phẩm theo ID
        $query = "SELECT * FROM products WHERE id = :productId";
        
        // Chuẩn bị câu truy vấn SQL với PDO
        $stmt = $this->db->prepare($query);
        
        // Gắn giá trị cho tham số :productId trong câu truy vấn SQL (bảo vệ khỏi SQL Injection)
        $stmt->bindValue(':productId', $productId, PDO::PARAM_INT);
        
        // Thực thi câu truy vấn
        $stmt->execute();
        
        // Trả về thông tin sản phẩm dưới dạng mảng kết hợp (kết quả của truy vấn)
        return $stmt->fetch(PDO::FETCH_ASSOC);  // Nếu không có sản phẩm, sẽ trả về null
    }

    /**
     * Tìm kiếm sản phẩm theo từ khóa trong tên sản phẩm.
     *
     * @param string $keyword Từ khóa cần tìm trong tên sản phẩm.
     * @return array Danh sách các sản phẩm có tên chứa từ khóa tìm kiếm.
     */
    public function search($keyword) {
        // Câu truy vấn SQL để tìm sản phẩm có tên chứa từ khóa
        $query = "SELECT * FROM products WHERE name LIKE :keyword";
        
        // Chuẩn bị và thực thi câu truy vấn SQL
        $stmt = $this->db->prepare($query);
        
        // Gắn giá trị cho tham số :keyword (tìm kiếm với dấu '%' ở đầu và cuối từ khóa)
        $stmt->bindValue(':keyword', '%' . $keyword . '%');
        
        // Thực thi câu truy vấn
        $stmt->execute();
        
        // Trả về danh sách các sản phẩm tìm được dưới dạng mảng kết hợp
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy tất cả sản phẩm từ cơ sở dữ liệu.
     *
     * @return array Danh sách tất cả sản phẩm.
     */
    public function getAll() {
        // Câu truy vấn SQL để lấy tất cả sản phẩm
        $query = "SELECT * FROM products";
        
        // Chuẩn bị và thực thi câu truy vấn SQL
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        // Trả về danh sách tất cả sản phẩm dưới dạng mảng kết hợp
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
