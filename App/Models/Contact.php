<?php

namespace App\Models;

use PDO;

class Contact
{
    // Kết nối đến cơ sở dữ liệu
    private PDO $db;

    // Các thuộc tính của sản phẩm
    public int $id = -1; // ID của sản phẩm (mặc định là -1)
    public int $user_id; // ID người dùng sở hữu sản phẩm
    public string $name; // Tên sản phẩm
    public string $img; // Đường dẫn đến ảnh sản phẩm
    public ?string $description; // Mô tả sản phẩm (có thể null)
    public string $price; // Giá bán của sản phẩm
    public string $priceGoc; // Giá gốc của sản phẩm
    public string $created_at; // Thời gian tạo sản phẩm
    public string $updated_at; // Thời gian cập nhật sản phẩm
    public int $product_id = -1; // ID sản phẩm (mặc định là -1)
    public string $product_type = ''; // Loại sản phẩm
    public string $cpu = ''; // Thông tin về CPU của sản phẩm
    public string $ram = ''; // Thông tin về RAM của sản phẩm
    public string $storage = ''; // Thông tin về dung lượng lưu trữ
    public string $battery_capacity = ''; // Thông tin về dung lượng pin
    public string $camera_resolution = ''; // Thông tin về độ phân giải camera
    public string $screen_size = ''; // Kích thước màn hình
    public string $os = ''; // Hệ điều hành của sản phẩm
    public string $band = ''; // Dải tần của sản phẩm
    public string $strap_material = ''; // Chất liệu dây đeo
    public string $water_resistance = ''; // Khả năng chống nước của sản phẩm

    // Khởi tạo đối tượng với kết nối CSDL PDO
    public function __construct(PDO $pdo)
    {
        $this->db = $pdo;
    }
// Thêm phương thức để lấy số lượng tồn kho của sản phẩm từ bảng inventory
public function getStockQuantity(): int
{
    // Truy vấn bảng inventory để lấy quantity_in_stock
    $statement = $this->db->prepare('
        SELECT quantity_in_stock FROM inventory WHERE product_id = :product_id
    ');
    $statement->execute(['product_id' => $this->id]);

    if ($row = $statement->fetch()) {
        return (int) $row['quantity_in_stock'];  // Trả về số lượng tồn kho, mặc định là 0 nếu không tìm thấy
    }

    return 0;  // Nếu không tìm thấy, trả về 0
}

    // Đặt người dùng sở hữu sản phẩm
    public function setUser(User $user): Contact
    {
        $this->user_id = $user->id;
        return $this;
    }

    // Lấy tất cả các sản phẩm của một người dùng
    public function contactsForUser(User $user): array
    {
        $contacts = [];
        $statement = $this->db->prepare('SELECT * FROM product WHERE user_id = :user_id');
        $statement->execute(['user_id' => $user->id]);

        while ($row = $statement->fetch()) {
            $contact = new Contact($this->db);
            $contact->fillFromDbRow($row);
            $contacts[] = $contact;
        }

        return $contacts;
    }

    // Lấy tất cả sản phẩm từ cơ sở dữ liệu
    public function contactsForAll(User $user): array
    {
        $contacts = [];
        $statement = $this->db->prepare('SELECT * FROM product');
        $statement->execute();

        while ($row = $statement->fetch()) {
            $contact = new Contact($this->db);
            $contact->fillFromDbRow($row);
            $contacts[] = $contact;
        }

        return $contacts;
    }

    // Lưu thông tin sản phẩm (cập nhật hoặc thêm mới)
    public function save(): bool
    {
        $result = false;

        if ($this->id >= 0) {
            // Cập nhật thông tin sản phẩm trong bảng 'product'
            $statement = $this->db->prepare(
                'UPDATE product SET name = :name, img = :img, 
                 description = :description, price = :price, priceGoc = :priceGoc, user_id = :user_id, updated_at = NOW() WHERE id = :id'
            );

            $result = $statement->execute([
                'name' => $this->name,
                'img' => $this->img,
                'description' => $this->description,
                'price' => $this->price,
                'priceGoc' => $this->priceGoc,
                'id' => $this->id,
                'user_id' => $this->user_id
            ]);

            // Cập nhật chi tiết sản phẩm trong bảng 'productdetails'
            if ($result) {
                $statementDetails = $this->db->prepare(
                    'UPDATE productdetails SET 
                        product_type =:product_type,
                        cpu = :cpu,
                        ram = :ram,
                        storage = :storage,
                        battery_capacity = :battery_capacity,
                        camera_resolution = :camera_resolution,
                        screen_size = :screen_size,
                        os = :os,
                        band = :band,
                        strap_material = :strap_material,
                        water_resistance = :water_resistance
                    WHERE product_id = :product_id'
                );

                $result = $statementDetails->execute([
                    'product_type' => $this->product_type,
                    'cpu' => $this->cpu,
                    'ram' => $this->ram,
                    'storage' => $this->storage,
                    'battery_capacity' => $this->battery_capacity,
                    'camera_resolution' => $this->camera_resolution,
                    'screen_size' => $this->screen_size,
                    'os' => $this->os,
                    'band' => $this->band,
                    'strap_material' => $this->strap_material,
                    'water_resistance' => $this->water_resistance,
                    'product_id' => $this->id
                ]);
            }
        } else {
            // Thêm mới sản phẩm vào bảng 'product'
            $statement = $this->db->prepare(
                'INSERT INTO product (name, img, description, price, priceGoc, user_id, created_at, updated_at)
                VALUES (:name, :img, :description, :price, :priceGoc, :user_id, NOW(), NOW())'
            );

            $result = $statement->execute([
                'name' => $this->name,
                'img' => $this->img,
                'description' => $this->description,
                'price' => $this->price,
                'priceGoc' => $this->priceGoc,
                'user_id' => $this->user_id
            ]);

            // Nếu thêm mới thành công, lấy id của sản phẩm vừa tạo
            if ($result) {
                $this->id = $this->db->lastInsertId();

                // Thêm chi tiết sản phẩm vào bảng 'productdetails'
                $statementDetails = $this->db->prepare(
                    'INSERT INTO productdetails (
                        product_id, product_type,cpu, ram, storage, battery_capacity, 
                        camera_resolution, screen_size, os, band, strap_material, water_resistance
                    )
                    VALUES (
                        :product_id, :product_type, :cpu, :ram, :storage, :battery_capacity, 
                        :camera_resolution, :screen_size, :os, :band, :strap_material, :water_resistance
                    )'
                );

                $result = $statementDetails->execute([
                    'product_id' => $this->id,
                    'product_type' => $this->product_type,
                    'cpu' => $this->cpu,
                    'ram' => $this->ram,
                    'storage' => $this->storage,
                    'battery_capacity' => $this->battery_capacity,
                    'camera_resolution' => $this->camera_resolution,
                    'screen_size' => $this->screen_size,
                    'os' => $this->os,
                    'band' => $this->band,
                    'strap_material' => $this->strap_material,
                    'water_resistance' => $this->water_resistance
                ]);
            }
        }

        return $result;
    }

    // Tìm kiếm sản phẩm dựa trên ID
    public function find(int $id): ?Contact
    {
        $statement = $this->db->prepare('
            SELECT p.*, pd.cpu, pd.ram, pd.storage, pd.battery_capacity, pd.camera_resolution, pd.screen_size, pd.os, pd.band, pd.strap_material, pd.water_resistance
            FROM product p
            LEFT JOIN productdetails pd ON p.id = pd.product_id
            WHERE p.id = :id
        ');
        $statement->execute(['id' => $id]);

        if ($row = $statement->fetch()) {
            $this->fillFromDbRow($row);
            return $this;
        }

        return null;
    }

    // Xóa thông tin chi tiết sản phẩm
    public function delete(): bool
    {
        $statement = $this->db->prepare('DELETE FROM productdetails WHERE product_id = :id');
        return $statement->execute(['id' => $this->id]);
    }

    // Xóa sản phẩm khỏi cơ sở dữ liệu
    public function deleteProduct(): bool
    {
        $statement = $this->db->prepare('DELETE FROM product WHERE id = :id');
        return $statement->execute(['id' => $this->id]);
    }

    // Điền dữ liệu vào đối tượng từ một mảng
    public function fill(array $data): Contact
    {
        $this->name = htmlspecialchars(trim($data['name'] ?? ''), ENT_QUOTES);
        $this->description = htmlspecialchars(trim($data['description'] ?? ''), ENT_QUOTES);
        $this->price = htmlspecialchars(trim($data['price'] ?? ''), ENT_QUOTES);
        $this->priceGoc = htmlspecialchars(trim($data['priceGoc'] ?? ''), ENT_QUOTES);
        $this->product_type = htmlspecialchars(trim($data['product_type'] ?? ''), ENT_QUOTES);
        $this->cpu = htmlspecialchars(trim($data['cpu'] ?? ''), ENT_QUOTES);
        $this->ram = htmlspecialchars(trim($data['ram'] ?? ''), ENT_QUOTES);
        $this->storage = htmlspecialchars(trim($data['storage'] ?? ''), ENT_QUOTES);
        $this->battery_capacity = htmlspecialchars(trim($data['battery_capacity'] ?? ''), ENT_QUOTES);
        $this->camera_resolution = htmlspecialchars(trim($data['camera_resolution'] ?? ''), ENT_QUOTES);
        $this->screen_size = htmlspecialchars(trim($data['screen_size'] ?? ''), ENT_QUOTES);
        $this->os = htmlspecialchars(trim($data['os'] ?? ''), ENT_QUOTES);
        $this->band = htmlspecialchars(trim($data['band'] ?? ''), ENT_QUOTES);
        $this->strap_material = htmlspecialchars(trim($data['strap_material'] ?? ''), ENT_QUOTES);
        $this->water_resistance = htmlspecialchars(trim($data['water_resistance'] ?? ''), ENT_QUOTES);
        return $this;
    }

    // Kiểm tra tính hợp lệ của dữ liệu nhập vào
    public function validate(array $data): array
    {
        $errors = [];
        $name = trim($data['name'] ?? '');
        if (!$name) {
            $errors['name'] = 'Invalid name.'; // Tên không hợp lệ
        }

        $description = trim($data['description'] ?? '');
        if (strlen($description) > 255) {
            $errors['description'] = 'Notes must be at most 255 characters.'; // Mô tả dài quá 255 ký tự
        }

        return $errors;
    }

    // Điền dữ liệu vào đối tượng từ hàng dữ liệu trong cơ sở dữ liệu
    private function fillFromDbRow(array $row): Contact
    {
        [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'img' => $this->img,
            'description' => $this->description,
            'price' => $this->price,
            'priceGoc' => $this->priceGoc,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ] = $row;

        // Lấy thông tin chi tiết sản phẩm từ bảng 'productdetails'
        $detailsStatement = $this->db->prepare('
            SELECT * FROM productdetails WHERE product_id = :product_id
        ');
        $detailsStatement->execute(['product_id' => $this->id]);

        if ($details = $detailsStatement->fetch()) {
            $this->cpu = $details['cpu'] ?? '';
            $this->ram = $details['ram'] ?? '';
            $this->storage = $details['storage'] ?? '';
            $this->battery_capacity = $details['battery_capacity'] ?? '';
            $this->camera_resolution = $details['camera_resolution'] ?? '';
            $this->screen_size = $details['screen_size'] ?? '';
            $this->os = $details['os'] ?? '';
            $this->band = $details['band'] ?? '';
            $this->strap_material = $details['strap_material'] ?? '';
            $this->water_resistance = $details['water_resistance'] ?? '';
        }

        return $this;
    }

    // Kiểm tra tính hợp lệ của CSRF token (bảo vệ chống tấn công CSRF)
    private function isCsrfTokenValid(string $token): bool
    {
        return hash_equals($_SESSION['csrf_token'] ?? '', $token);
    }

    // Upload ảnh sản phẩm
    public function uploadImg($file): array
    {
        $errors = [];
        $uploadDir = __DIR__ . '/../../public/img/'; // Đường dẫn đến thư mục lưu

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true); // Tạo thư mục nếu chưa tồn tại
        }

        if (isset($file) && $file['error'] == 0) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

            if (!in_array($file['type'], $allowedTypes)) {
                $errors['img'] = 'Định dạng file không hợp lệ. Vui lòng upload file JPEG, PNG hoặc GIF.';
                return $errors;
            }

            $imgPath = 'img/' . basename($file['name']); // Lưu tên hình ảnh
            $fullPath = $uploadDir . basename($file['name']); // Đường dẫn đầy đủ

            if (move_uploaded_file($file['tmp_name'], $fullPath)) {
                $this->img = $imgPath; // Lưu vào trường img
            } else {
                $errors['img'] = 'Có lỗi xảy ra khi upload file.';
            }
        } else {
            $errors['img'] = 'Vui lòng chọn một file để upload.';
        }

        return $errors;
    }

    // Tìm kiếm sản phẩm hoặc liên hệ dựa trên từ khóa tìm kiếm
    public static function search($userId, $search)
    {
        $sql = "SELECT * FROM contacts WHERE user_id = :user_id AND (name LIKE :search OR description LIKE :search)";
        $stmt = PDO()->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);  // Tìm kiếm với từ khóa trong tên hoặc mô tả
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
