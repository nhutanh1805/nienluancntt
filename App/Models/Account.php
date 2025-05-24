<?php
namespace App\Models;

class Account
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Phương thức lấy thông tin người dùng từ ID
    public function getUserById($userId)
    {
        $stmt = $this->pdo->prepare("SELECT id, name, email, password, created_at, phone, address, role FROM users WHERE id = :id");
        $stmt->bindParam(':id', $userId, \PDO::PARAM_INT);
        $stmt->execute();

        // Lấy kết quả người dùng và trả về (mảng hoặc false nếu không tìm thấy)
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        // Nếu người dùng tồn tại và có trường role, xử lý role
        if ($user) {
            $user['role'] = $user['role'] == 1 ? 'Người quản trị' : 'Khách hàng';
        }

        return $user;
    }

    // Phương thức kiểm tra và làm sạch dữ liệu người dùng
    private function validateUserData($name, $email, $phone, $address)
    {
        // Kiểm tra và làm sạch các thông tin
        $name = trim($name);
        $email = trim($email);
        $phone = trim($phone);
        $address = trim($address);

        // Kiểm tra nếu các trường này không rỗng
        if (empty($name) || empty($email) || empty($phone) || empty($address)) {
            return false;  // Nếu bất kỳ trường nào rỗng thì không hợp lệ
        }

        // Kiểm tra email hợp lệ
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        // Kiểm tra số điện thoại (có thể điều chỉnh theo yêu cầu)
        if (!preg_match('/^\d{10,15}$/', $phone)) {
            return false;
        }

        return [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'address' => $address
        ];
    }

    // Phương thức cập nhật thông tin người dùng
    public function updateUser($userId, $name, $email, $phone, $address)
    {
        // Validate dữ liệu trước khi cập nhật
        $validatedData = $this->validateUserData($name, $email, $phone, $address);
        
        if ($validatedData === false) {
            return false;  // Nếu dữ liệu không hợp lệ
        }

        // Thực hiện cập nhật thông tin vào cơ sở dữ liệu
        $stmt = $this->pdo->prepare(
            "UPDATE users 
             SET name = :name, email = :email, phone = :phone, address = :address 
             WHERE id = :id"
        );

        $stmt->bindParam(':id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':name', $validatedData['name'], \PDO::PARAM_STR);
        $stmt->bindParam(':email', $validatedData['email'], \PDO::PARAM_STR);
        $stmt->bindParam(':phone', $validatedData['phone'], \PDO::PARAM_STR);
        $stmt->bindParam(':address', $validatedData['address'], \PDO::PARAM_STR);

        // Thực thi câu lệnh và kiểm tra kết quả
        if ($stmt->execute()) {
            return true;  // Cập nhật thành công
        } else {
            return false;  // Lỗi trong quá trình cập nhật
        }
    }

    // Phương thức thay đổi mật khẩu
    public function changePassword($userId, $currentPassword, $newPassword)
    {
        // Kiểm tra mật khẩu mới hợp lệ (tối thiểu 8 ký tự)
        if (strlen($newPassword) < 6) {
            return ['status' => false, 'message' => 'Mật khẩu mới phải có ít nhất 6 ký tự.'];
        }

        // Lấy mật khẩu hiện tại của người dùng từ cơ sở dữ liệu
        $stmt = $this->pdo->prepare("SELECT password FROM users WHERE id = :id");
        $stmt->bindParam(':id', $userId, \PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$user) {
            return ['status' => false, 'message' => 'Người dùng không tồn tại.'];
        }

        // Kiểm tra mật khẩu hiện tại có đúng không (so sánh mật khẩu đã mã hóa)
        if (!password_verify($currentPassword, $user['password'])) {
            return ['status' => false, 'message' => 'Mật khẩu hiện tại không đúng.'];
        }

        // Mã hóa mật khẩu mới
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        // Cập nhật mật khẩu mới vào cơ sở dữ liệu
        $stmt = $this->pdo->prepare("UPDATE users SET password = :password WHERE id = :id");
        $stmt->bindParam(':id', $userId, \PDO::PARAM_INT);
        $stmt->bindParam(':password', $hashedPassword, \PDO::PARAM_STR);

        if ($stmt->execute()) {
            return ['status' => true, 'message' => 'Đổi mật khẩu thành công.'];
        } else {
            return ['status' => false, 'message' => 'Có lỗi xảy ra khi đổi mật khẩu.'];
        }
    }
}

?>
