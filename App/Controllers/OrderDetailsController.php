<?php
namespace App\Controllers;

use App\Models\OrderDetail;
use Exception;

class OrderDetailsController extends Controller
{
    // Xem chi tiết đơn hàng
    public function view($orderId): void
    {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!isset($_SESSION['user_id'])) {
            $this->sendPage('order/view', ['error' => 'Bạn cần đăng nhập để xem chi tiết đơn hàng']);
            return;
        }

        // Lấy ID người dùng từ session
        $userId = $_SESSION['user_id'];

        try {
            // Lấy thông tin chi tiết đơn hàng từ OrderDetail model
            $orderItems = OrderDetail::getOrderDetails($orderId); // Lấy tất cả các sản phẩm trong đơn hàng

            if (empty($orderItems)) {
                // Nếu không có sản phẩm trong đơn hàng, thông báo lỗi
                $this->sendPage('order/view', ['error' => 'Không tìm thấy đơn hàng hoặc sản phẩm']);
                return;
            }

            // Kiểm tra nếu người dùng không phải chủ đơn hàng
            if ($orderItems[0]['user_name'] != $userId) {
                $this->sendPage('order/view', ['error' => 'Bạn không có quyền xem đơn hàng này']);
                return;
            }

            // Truyền dữ liệu vào view nếu có thông tin đơn hàng và quyền truy cập hợp lệ
            $this->sendPage('order/view', ['orderItems' => $orderItems]);

        } catch (Exception $e) {
            // Nếu có lỗi khi lấy dữ liệu, hiển thị thông báo lỗi
            $this->sendPage('order/view', ['error' => 'Lỗi khi lấy chi tiết đơn hàng: ' . $e->getMessage()]);
        }
    }
}
