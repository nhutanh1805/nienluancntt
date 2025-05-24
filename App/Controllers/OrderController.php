<?php
namespace App\Controllers;

use App\Models\Order;
use App\Models\Cart;
use Exception;
use App\Models\OrderDetail;

class OrderController extends Controller
{
    
    // Tạo đơn hàng từ giỏ hàng
    public function create(): void
    {
        $userId = $_SESSION['user_id'];  // Lấy ID người dùng từ session
        $address = isset($_POST['address']) ? $_POST['address'] : ''; // Địa chỉ người dùng nhập vào

        if (empty($address)) {
            // Nếu không có địa chỉ, thông báo lỗi
            $this->sendPage('order/create', ['error' => 'Địa chỉ không được để trống']);
            return;
        }

        try {
            // Tạo đơn hàng từ giỏ hàng
            $orderId = Order::createOrder($userId, $address);
            // Chuyển hướng đến trang đơn hàng đã tạo
            redirect("/order/view/{$orderId}");
        } catch (Exception $e) {
            // Nếu có lỗi khi tạo đơn hàng, hiển thị lỗi
            $this->sendPage('order/create', ['error' => $e->getMessage()]);
        }
    }

    // Xem chi tiết đơn hàng
    public function view($orderId): void
    {
        $userId = $_SESSION['user_id'];
    
        // Lấy thông tin đơn hàng từ model Order
        $order = Order::getAllOrders($orderId);
    
        if (empty($order)) {
            // Nếu không tìm thấy đơn hàng, thông báo lỗi
            $this->sendPage('order/view', ['error' => 'Không tìm thấy đơn hàng']);
            return;
        }
    
        // Kiểm tra nếu người dùng không phải chủ đơn hàng
        if ($order[0]['user_id'] != $userId) {
            $this->sendPage('order/view', ['error' => 'Bạn không có quyền xem đơn hàng này']);
            return;
        }
    
        // Lấy chi tiết sản phẩm trong đơn hàng
        $orderItems = OrderDetail::getOrderDetails($orderId);
    
        // Truyền dữ liệu vào view (bao gồm cả thông tin đơn hàng và các chi tiết sản phẩm)
        $this->sendPage('order/view', [
            'order' => $order,
            'orderItems' => $orderItems
        ]);
    }
    
// Xem tất cả đơn hàng (Admin hoặc người có quyền quản trị)
public function indexAll(): void
{
    try {
        // Lấy tất cả đơn hàng từ model Order
        $orders = Order::getAllOrders();
        
        // Hiển thị danh sách tất cả đơn hàng
        $this->sendPage('order/indexAll', ['orders' => $orders]);
    } catch (Exception $e) {
        // Nếu có lỗi khi lấy tất cả đơn hàng, hiển thị lỗi
        $this->sendPage('order/indexAll', ['error' => $e->getMessage()]);
    }
}
    // Xem tất cả đơn hàng của người dùng
    public function index(): void
    {
        $userId = $_SESSION['user_id'];

        // Lấy tất cả đơn hàng của người dùng từ model Order
        $orders = Order::getUserOrders($userId);

        // Hiển thị danh sách đơn hàng
        $this->sendPage('order/index', ['orders' => $orders]);
    }

    // Cập nhật địa chỉ giao hàng cho đơn hàng
    public function updateAddress($orderId): void
    {
        $userId = $_SESSION['user_id'];
        $newAddress = isset($_POST['address']) ? $_POST['address'] : '';

        if (empty($newAddress)) {
            // Nếu địa chỉ mới không có, thông báo lỗi
            $this->sendPage('order/updateAddress', ['error' => 'Địa chỉ không được để trống']);
            return;
        }

        try {
            // Cập nhật địa chỉ giao hàng của đơn hàng
            Order::updateOrderAddress($orderId, $newAddress);
            redirect("/order/view/{$orderId}");
        } catch (Exception $e) {
            // Nếu có lỗi, hiển thị thông báo lỗi
            $this->sendPage('order/updateAddress', ['error' => $e->getMessage()]);
        }
    }

    // Cập nhật trạng thái đơn hàng
    public function updateStatus($orderId): void
    {
        $userId = $_SESSION['user_id'];
        $status = isset($_POST['status']) ? $_POST['status'] : '';
    
        // Kiểm tra trạng thái hợp lệ
        if (!in_array($status, ['Processing', 'Shipped', 'Delivered', 'Cancelled'])) {
            $this->sendPage('order/view', ['error' => 'Trạng thái không hợp lệ']);
            return;
        }
    
        // Kiểm tra nếu người dùng có quyền cập nhật trạng thái đơn hàng (có thể chỉ admin hoặc người tạo đơn)
        $order = Order::getAllOrders();
        if ($order[0]['user_id'] != $userId) {
            $this->sendPage('order/view', ['error' => 'Bạn không có quyền cập nhật trạng thái của đơn hàng này']);
            return;
        }
    
        try {
            // Cập nhật trạng thái của đơn hàng
            Order::updateOrderStatus($orderId, $status);
    
            // Sau khi cập nhật trạng thái thành công, chuyển hướng lại trang chi tiết đơn hàng
            redirect("/order/view/{$orderId}");
        } catch (Exception $e) {
            // Nếu có lỗi khi cập nhật trạng thái, hiển thị thông báo lỗi
            $this->sendPage('order/view', ['error' => $e->getMessage()]);
        }
    }
    

    // Hủy đơn hàng
    public function cancel($orderId): void
    {
        $userId = $_SESSION['user_id'];

        // Kiểm tra nếu người dùng có quyền hủy đơn hàng (có thể chỉ admin hoặc người tạo đơn)
        $order = Order::getAllOrders();
        if ($order[0]['user_id'] != $userId) {
            $this->sendPage('order/view', ['error' => 'Bạn không có quyền hủy đơn hàng này']);
            return;
        }

        try {
            // Hủy đơn hàng
            Order::cancelOrder($orderId);
            redirect('/order');
        } catch (Exception $e) {
            // Nếu có lỗi, hiển thị thông báo lỗi
            $this->sendPage('order/view', ['error' => $e->getMessage()]);
        }
    }
 // Xóa đơn hàng
 public function delete($orderId): void
 {
     try {
         // Gọi phương thức deleteOrder để xóa đơn hàng khỏi cơ sở dữ liệu
         Order::deleteOrder($orderId);

         // Sau khi xóa thành công, hiển thị thông báo và chuyển hướng người dùng về trang danh sách đơn hàng
         $_SESSION['message'] = 'Đơn hàng đã được xóa thành công!';
         header("Location: /orders");
         exit;
     } catch (Exception $e) {
         // Nếu có lỗi, thông báo lỗi và quay lại trang danh sách đơn hàng
         $_SESSION['error'] = 'Lỗi khi xóa đơn hàng: ' . $e->getMessage();
         header("Location: /orders");
         exit;
     }
 }
// Cập nhật bình luận cho đơn hàng
// Cập nhật bình luận cho đơn hàng
public function updateComment($orderId): void
{
    $userId = $_SESSION['user_id'];  // Lấy ID người dùng từ session
    $comment = isset($_POST['comment']) ? $_POST['comment'] : '';  // Lấy bình luận từ POST

    if (empty($comment)) {
        // Nếu bình luận trống, thông báo lỗi
        $this->sendPage('order/view', ['error' => 'Bình luận không được để trống', 'orderId' => $orderId]);
        return;
    }

    // Kiểm tra xem người dùng có quyền cập nhật bình luận này không
    $order = Order::getAllOrders($orderId);
    if (empty($order) || $order[0]['user_id'] != $userId) {
        $this->sendPage('order/view', ['error' => 'Bạn không có quyền cập nhật bình luận cho đơn hàng này', 'orderId' => $orderId]);
        return;
    }

    try {
        // Cập nhật bình luận cho đơn hàng
        Order::updateOrderComment($orderId, $comment);
        
        // Sau khi cập nhật thành công, chuyển hướng đến trang index của đơn hàng
        redirect("/order/index");  // Chuyển hướng về danh sách đơn hàng thay vì chi tiết
    } catch (Exception $e) {
        // Nếu có lỗi khi cập nhật bình luận, hiển thị thông báo lỗi
        $this->sendPage('order/view', ['error' => $e->getMessage(), 'orderId' => $orderId]);
    }
}



}
?>
