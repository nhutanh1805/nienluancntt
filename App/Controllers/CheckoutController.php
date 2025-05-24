<?php
namespace App\Controllers;

use App\Models\Cart;
use App\Models\Order;

use Exception;

class CheckoutController extends Controller
{
    // Hiển thị trang thanh toán
    public function index()
    {
        // Lấy userId từ session
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            // Nếu chưa đăng nhập, chuyển hướng về trang đăng nhập
            redirect('/login');
        }

        // Lấy giỏ hàng và tổng tiền từ model Cart
        $cart = Cart::getCart($userId);
        $total = Cart::getTotal($userId);

        // Truyền dữ liệu sang view
        $this->sendPage('checkout/index', [
            'cart' => $cart,
            'total' => $total
        ]);
    }

    // Xử lý thanh toán
    public function process()
    {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!isset($_SESSION['user_id'])) {
            // Nếu chưa đăng nhập, chuyển hướng về trang đăng nhập
            redirect('/login');
        }

        // Lấy thông tin từ form
        $name = $_POST['name'] ?? '';
        $address = $_POST['address'] ?? '';
        $paymentMethod = $_POST['payment_method'] ?? '';
        $cardNumber = $_POST['card_number'] ?? ''; // Chỉ dùng nếu thanh toán online

        // Kiểm tra phương thức thanh toán
        if ($paymentMethod === 'cod') {
            // Xử lý thanh toán khi nhận hàng (COD)
            $this->processCOD($name, $address);
        } elseif ($paymentMethod === 'online') {
            // Chuyển hướng người dùng đến trang giao dịch online
            return $this->redirectToOnlinePayment($cardNumber);
        } else {
            // Nếu không có phương thức thanh toán hợp lệ
            echo "Phương thức thanh toán không hợp lệ.";
            return;
        }

        // Quá trình thanh toán xong, chuyển hướng đến trang cảm ơn
        redirect('/thank-you');
    }

    // Xử lý nhận tiền khi giao hàng (COD)
    private function processCOD($name, $address)
    {
        // Lấy thông tin giỏ hàng
        $userId = $_SESSION['user_id']; // Lấy userId từ session
        $cart = Cart::getCart($userId); // Lấy giỏ hàng của người dùng
        $totalAmount = Cart::getTotal($userId); // Tính tổng tiền đơn hàng
    
        try {
            // Tạo đơn hàng trong cơ sở dữ liệu
            $orderId = Order::createOrder($userId, $address, $totalAmount); // Lưu đơn hàng vào database
    
            // Lặp qua giỏ hàng và cập nhật số lượng kho cho từng sản phẩm
            foreach ($cart as $item) {
                $productId = $item['id']; // Lấy ID sản phẩm
                $quantity = $item['quantity']; // Lấy số lượng sản phẩm trong giỏ
    
                // Debugging: Kiểm tra số lượng sản phẩm trong giỏ
                echo "Sản phẩm ID: $productId, Số lượng trong giỏ: $quantity";
    
                // Cập nhật số lượng kho sau khi mua hàng
                $this->updateInventory($productId, $quantity); // Giảm số lượng kho cho sản phẩm
            }
    
            // Nếu đơn hàng được tạo thành công, xóa giỏ hàng khỏi session
            Cart::clearCart($userId); // Xóa giỏ hàng trong database sau khi thanh toán thành công
    
            // Chuyển hướng đến trang cảm ơn
            redirect('/thank-you');
        } catch (Exception $e) {
            // Xử lý lỗi nếu có
            echo "Lỗi khi thanh toán: " . $e->getMessage();
        }
    }
    

    // Cập nhật số lượng kho khi đã mua
    private function updateInventory($productId, $quantity)
    {
        // Giảm số lượng sản phẩm trong kho sau khi đơn hàng được thanh toán
        Cart::updateStock($productId, $quantity);
    }

    // Chuyển hướng người dùng đến trang giao dịch online
    private function redirectToOnlinePayment($cardNumber)
    {
        // Giả lập chuyển hướng đến một trang thanh toán online (ví dụ PayPal, Stripe)
        // Ở đây bạn chỉ cần chuyển hướng đến một trang thanh toán.
        // Ví dụ chuyển đến một trang thanh toán online (chỉ giả lập).
        return header('Location: /payment-online');
    }

    // Trang cảm ơn sau khi thanh toán thành công
    public function thankYou()
    {
        // Hiển thị trang cảm ơn sau khi thanh toán thành công
        $this->sendPage('checkout/thank-you');
    }
}
