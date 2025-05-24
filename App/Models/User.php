<?php

namespace App\Models;

use PDO;

class User
{
    private PDO $db; // Biến này sẽ lưu trữ kết nối PDO đến cơ sở dữ liệu

    // Các thuộc tính của đối tượng User
    public int $id = -1;       // ID của người dùng
    public string $email;      // Email của người dùng
    public string $name;       // Tên của người dùng
    public string $password;   // Mật khẩu của người dùng (đã mã hóa)
    public string $phone;      // Số điện thoại của người dùng
    public string $address;    // Địa chỉ của người dùng
    public string $role;       // Vai trò của người dùng (ví dụ: admin, user)

    /**
     * Hàm khởi tạo nhận đối tượng PDO để thiết lập kết nối cơ sở dữ liệu.
     *
     * @param PDO $pdo Đối tượng PDO kết nối với cơ sở dữ liệu.
     */
    public function __construct(PDO $pdo)
    {
        $this->db = $pdo;  // Lưu đối tượng PDO vào thuộc tính $db để sử dụng trong các phương thức sau
    }

    /**
     * Tìm một liên hệ (contact) dựa trên ID.
     *
     * @param int $id ID của liên hệ cần tìm.
     * @return Contact|null Trả về đối tượng Contact nếu tìm thấy, ngược lại trả về null.
     */
    public function findContact(int $id): ?Contact
    {
        $contact = new Contact($this->db);  // Tạo đối tượng Contact với kết nối cơ sở dữ liệu
        $contact = $contact->find($id);     // Tìm liên hệ theo ID
        if (isset($contact)) {
            return $contact;  // Nếu tìm thấy liên hệ, trả về đối tượng Contact
        }
        return null;  // Nếu không tìm thấy liên hệ, trả về null
    }

    /**
     * Lấy tất cả các liên hệ (contacts) của người dùng.
     *
     * @return array Mảng các đối tượng Contact.
     */
    public function contacts(): array
    {
        $contact = new Contact($this->db);  // Tạo đối tượng Contact với kết nối cơ sở dữ liệu
        return $contact->contactsForAll($this);  // Trả về tất cả các liên hệ của người dùng
    }

    /**
     * Tìm người dùng theo một cột và giá trị của cột đó (ví dụ: tìm người dùng theo email).
     *
     * @param string $column Cột cần tìm (ví dụ: 'email').
     * @param string $value Giá trị của cột cần tìm.
     * @return User Trả về đối tượng User với dữ liệu đã được gán.
     */
    public function where(string $column, string $value): User
    {
        // Chuẩn bị câu truy vấn SQL
        $statement = $this->db->prepare("SELECT * FROM users WHERE $column = :value");
        $statement->execute(['value' => $value]);  // Gắn giá trị cho tham số :value
        $row = $statement->fetch();  // Lấy dữ liệu người dùng

        // Nếu tìm thấy người dùng, gán giá trị cho các thuộc tính
        if ($row) {
            $this->fillFromDbRow($row);
        }
        return $this;  // Trả về đối tượng User với dữ liệu đã gán
    }

    /**
     * Lưu thông tin người dùng vào cơ sở dữ liệu.
     *
     * @return bool Trả về true nếu lưu thành công, ngược lại false.
     */
    public function save(): bool
    {
        $result = false;

        if ($this->id >= 0) {
            // Cập nhật thông tin người dùng nếu ID đã tồn tại
            $statement = $this->db->prepare(
                'UPDATE users SET email = :email, name = :name, password = :password, phone = :phone, address = :address, updated_at = NOW() WHERE id = :id'
            );
            $result = $statement->execute([
                'id' => $this->id,
                'email' => $this->email,
                'name' => $this->name,
                'password' => $this->password,
                'phone' => $this->phone,
                'address' => $this->address  // Thêm địa chỉ vào câu lệnh cập nhật
            ]);
        } else {
            // Nếu chưa có ID (tạo mới người dùng)
           // Cập nhật phương thức save() để bao gồm trường role
$statement = $this->db->prepare(
    'INSERT INTO users (email, name, password, created_at, updated_at, phone, address, role)
    VALUES (:email, :name, :password, NOW(), NOW(), :phone, :address, :role)'
);

$result = $statement->execute([
    'email' => $this->email,
    'name' => $this->name,
    'password' => $this->password,
    'phone' => $this->phone,
    'address' => $this->address,
    'role' => $this->role ?? 'user'  // Đảm bảo có giá trị cho role, mặc định là 'user'
]);

            
            if ($result) {
                $this->id = $this->db->lastInsertId();  // Lưu lại ID của người dùng mới tạo
            }
        }

        return $result;  // Trả về kết quả thao tác lưu (true/false)
    }

    /**
     * Điền dữ liệu vào đối tượng User từ mảng.
     *
     * @param array $data Mảng chứa dữ liệu cần điền vào.
     * @return User Trả về đối tượng User với dữ liệu đã điền.
     */
    public function fill(array $data): User
    {
        $this->email = $data['email'];
        $this->name = $data['name'];
        $this->password = password_hash($data['password'], PASSWORD_DEFAULT);  // Mã hóa mật khẩu
        $this->phone = $data['phone'];  // Không mã hóa số điện thoại
        $this->address = $data['address'];  // Điền địa chỉ
        return $this;
    }

    /**
     * Điền dữ liệu vào đối tượng User từ mảng dữ liệu được lấy từ cơ sở dữ liệu.
     *
     * @param array $row Mảng chứa dữ liệu từ cơ sở dữ liệu.
     */
    private function fillFromDbRow(array $row)
    {
        $this->id = $row['id'];
        $this->email = $row['email'];
        $this->name = $row['name'];
        $this->password = $row['password'];
        $this->phone = $row['phone'];
        $this->address = $row['address'];  // Điền địa chỉ từ cơ sở dữ liệu
        $this->role = $row['role'];
    }

    /**
     * Kiểm tra xem email đã được sử dụng hay chưa trong cơ sở dữ liệu.
     *
     * @param string $email Địa chỉ email cần kiểm tra.
     * @return bool Trả về true nếu email đã tồn tại, false nếu chưa.
     */
    private function isEmailInUse(string $email): bool
    {
        $statement = $this->db->prepare('SELECT count(*) FROM users WHERE email = :email');
        $statement->execute(['email' => $email]);
        return $statement->fetchColumn() > 0;  // Nếu có ít nhất 1 bản ghi, trả về true
    }

    /**
     * Kiểm tra xem số điện thoại đã được sử dụng hay chưa trong cơ sở dữ liệu.
     *
     * @param string $phone Số điện thoại cần kiểm tra.
     * @return bool Trả về true nếu số điện thoại đã tồn tại, false nếu chưa.
     */
    private function isPhoneInUse(string $phone): bool
    {
        $statement = $this->db->prepare('SELECT count(*) FROM users WHERE phone = :phone');
        $statement->execute(['phone' => $phone]);
        return $statement->fetchColumn() > 0;  // Nếu có ít nhất 1 bản ghi, trả về true
    }

    /**
     * Xác thực dữ liệu của người dùng (email, mật khẩu, số điện thoại, địa chỉ).
     *
     * @param array $data Mảng chứa dữ liệu của người dùng cần xác thực.
     * @return array Mảng chứa các lỗi nếu có, nếu không sẽ là mảng rỗng.
     */
    public function validate(array $data): array
    {
        $errors = [];

        // Kiểm tra email
        if (!$data['email']) {
            $errors['email'] = 'Email không hợp lệ.';
        } elseif ($this->isEmailInUse($data['email'])) {
            $errors['email'] = 'Email đã được sử dụng.';
        }

        // Kiểm tra mật khẩu
        if (strlen($data['password']) < 6) {
            $errors['password'] = 'Mật khẩu phải ít nhất 6 ký tự.';
        } elseif ($data['password'] != $data['password_confirmation']) {
            $errors['password'] = 'Mật khẩu xác nhận không khớp.';
        }

        // Kiểm tra số điện thoại
        $validPhone = preg_match('/^(03|05|07|08|09|01[2|6|8|9])+([0-9]{8})\b$/', $data['phone'] ?? '');
        if (!$validPhone) {
            $errors['phone'] = 'Số điện thoại không hợp lệ.';
        } elseif ($this->isPhoneInUse($data['phone'])) {
            $errors['phone'] = 'Số điện thoại đã được sử dụng.';
        }

        // Kiểm tra địa chỉ
        if (empty($data['address'])) {
            $errors['address'] = 'Địa chỉ không được để trống.';
        }

        return $errors;  // Trả về mảng các lỗi
    }
}
