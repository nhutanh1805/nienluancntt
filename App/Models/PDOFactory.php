<?php

// Đặt tên không gian (namespace) cho lớp PDOFactory, giúp phân loại và tổ chức mã nguồn
namespace App\Models;

// Sử dụng lớp PDO từ PHP để làm việc với cơ sở dữ liệu MySQL
use PDO;

class PDOFactory
{
    /**
     * Phương thức này dùng để tạo kết nối với cơ sở dữ liệu MySQL sử dụng PDO.
     *
     * @param array $config Mảng cấu hình kết nối cơ sở dữ liệu, gồm các giá trị:
     *                     - 'dbhost': địa chỉ máy chủ MySQL (ví dụ: localhost).
     *                     - 'dbname': tên cơ sở dữ liệu muốn kết nối.
     *                     - 'dbuser': tên người dùng MySQL.
     *                     - 'dbpass': mật khẩu của người dùng MySQL.
     *
     * @return PDO Trả về đối tượng PDO để thực hiện các thao tác với cơ sở dữ liệu.
     */
    public function create(array $config): PDO
    {
        // Dùng cú pháp array destructuring để lấy các giá trị từ mảng cấu hình
        [
            'dbhost' => $dbhost,   // Địa chỉ máy chủ MySQL (ví dụ: 'localhost')
            'dbname' => $dbname,   // Tên cơ sở dữ liệu
            'dbuser' => $dbuser,   // Tên người dùng MySQL
            'dbpass' => $dbpass    // Mật khẩu người dùng MySQL
        ] = $config; // Phân hủy mảng cấu hình thành các biến riêng biệt

        // Tạo chuỗi DSN (Data Source Name) cho PDO để kết nối đến MySQL.
        // DSN bao gồm: 
        // - 'mysql:host=' chỉ định máy chủ cơ sở dữ liệu
        // - 'dbname=' chỉ định tên cơ sở dữ liệu
        // - 'charset=utf8mb4' giúp đảm bảo rằng ứng dụng sử dụng bộ mã hóa ký tự UTF-8.
        $dsn = "mysql:host={$dbhost};dbname={$dbname};charset=utf8mb4";

        // Tạo và trả về đối tượng PDO sử dụng DSN, tên người dùng và mật khẩu.
        // PDO sẽ sử dụng các thông tin này để thiết lập kết nối đến cơ sở dữ liệu.
        return new PDO($dsn, $dbuser, $dbpass);
    }
}
