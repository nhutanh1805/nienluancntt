<?php
namespace App\Controllers;

use App\Models\OrderList;
use Exception;

class OrderListController
{
    // Phương thức gửi dữ liệu đến view
    private function sendPage(string $view, array $data = []): void
    {
        // Tách các phần tử mảng thành các biến để view có thể sử dụng
        extract($data);

        // Đảm bảo rằng bạn đã có thư mục views và view tương ứng
        $viewPath = __DIR__ . "/../../views/{$view}.php"; // Đường dẫn đến view

        // Kiểm tra nếu file view tồn tại
        if (file_exists($viewPath)) {
            // Gồm file view vào mà không cần sử dụng include trực tiếp
            require $viewPath;
        } else {
            throw new Exception("View {$view} không tồn tại!");
        }
    }

    // Lấy tất cả đơn hàng và hiển thị
    public function listOrders()
    {
        try {
            // Lấy tất cả đơn hàng từ model
            $orders = OrderList::getAllOrders();  // Giả sử phương thức này đã trả về danh sách đơn hàng

            // Gửi dữ liệu qua view 'order/list' với mảng dữ liệu
            $this->sendPage('order/list', [
                'orders' => $orders  // Truyền dữ liệu đơn hàng vào view
            ]);
        } catch (Exception $e) {
            echo "Có lỗi xảy ra: " . $e->getMessage();
        }
    }
}
?>
