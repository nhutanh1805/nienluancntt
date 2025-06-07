<?php
namespace App\Controllers;

use App\Models\OrderDetail;
use Exception;

class OrderDetailsController extends Controller
{
    // Xem chi tiết đơn hàng
    public function view($orderId): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->sendPage('order/view', ['error' => 'Bạn cần đăng nhập để xem chi tiết đơn hàng']);
            return;
        }

        $userId = $_SESSION['user_id'];

        try {
            $orderItems = OrderDetail::getOrderDetails($orderId);

            if (empty($orderItems)) {
                $this->sendPage('order/view', ['error' => 'Không tìm thấy đơn hàng hoặc sản phẩm']);
                return;
            }

            // Kiểm tra quyền truy cập đơn hàng (phải đúng user_id)
            if ($orderItems[0]['user_id'] != $userId) {
                $this->sendPage('order/view', ['error' => 'Bạn không có quyền xem đơn hàng này']);
                return;
            }

            // Hiển thị chi tiết đơn hàng
            $this->sendPage('order/view', ['orderItems' => $orderItems]);

        } catch (Exception $e) {
            $this->sendPage('order/view', ['error' => 'Lỗi khi lấy chi tiết đơn hàng: ' . $e->getMessage()]);
        }
    }
}
