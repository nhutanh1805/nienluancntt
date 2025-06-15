<?php
namespace App\Controllers;
date_default_timezone_set('Asia/Ho_Chi_Minh');

use App\Models\Cart;
use App\Models\Order;

use Exception;

class CheckoutController extends Controller
{
    // Hiển thị trang thanh toán
    public function index()
    {

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
        redirect('/thank-you');

    } elseif ($paymentMethod === 'vnpay') {
        // Chuyển hướng người dùng đến trang thanh toán VNPAY
        return $this->redirectToVnpay($name, $address);

    } else {
        // Nếu không có phương thức thanh toán hợp lệ
        echo "Phương thức thanh toán không hợp lệ.";
        return;
    }
}


    // Xử lý nhận tiền khi giao hàng (COD)
    private function processCOD($name, $address)
    {
        // Lấy thông tin giỏ hàng
        $userId = $_SESSION['user_id']; 
        $cart = Cart::getCart($userId); 
        $totalAmount = Cart::getTotal($userId);
    
        try {
            // Tạo đơn hàng trong cơ sở dữ liệu
            $orderId = Order::createOrder($userId, $address, $totalAmount); 
    
            // Lặp qua giỏ hàng và cập nhật số lượng kho cho từng sản phẩm
            foreach ($cart as $item) {
                $productId = $item['id']; 
                $quantity = $item['quantity']; 
    
                // Debugging: Kiểm tra số lượng sản phẩm trong giỏ
                echo "Sản phẩm ID: $productId, Số lượng trong giỏ: $quantity";
    
                // Cập nhật số lượng kho sau khi mua hàng
                $this->updateInventory($productId, $quantity); 
            }
    
            // Nếu đơn hàng được tạo thành công, xóa giỏ hàng khỏi session
            Cart::clearCart($userId); 
    
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
    private function redirectToVnpay($name, $address)
{
    $userId = $_SESSION['user_id'];
    $cart = Cart::getCart($userId);
    $totalAmount = Cart::getTotal($userId);

    // Lưu thông tin tạm để xử lý sau thanh toán
    $_SESSION['pending_order'] = [
        'user_id' => $userId,
        'name' => $name,
        'address' => $address,
        'total' => $totalAmount,
    ];

    // ✅ Load file config từ partials
   $config = require_once __DIR__ . '/../../public/partials/vnpay_config.php';



    $vnp_TxnRef = time(); // Mã đơn hàng duy nhất
    $vnp_OrderInfo = 'Thanh toán đơn hàng qua VNPAY';
    $vnp_OrderType = 'billpayment';
    $vnp_Amount = $totalAmount * 100; // Đơn vị của VNPAY là VND * 100
    $vnp_Locale = 'vn';
    $vnp_BankCode = '';
    $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
    $vnp_ReturnUrl = $config['vnp_ReturnUrl'];

    $inputData = [
        "vnp_Version" => "2.1.0",
        "vnp_TmnCode" => $config['vnp_TmnCode'],
        "vnp_Amount" => $vnp_Amount,
        "vnp_Command" => "pay",
        "vnp_CreateDate" => date('YmdHis'),
        "vnp_CurrCode" => "VND",
        "vnp_IpAddr" => $vnp_IpAddr,
        "vnp_Locale" => $vnp_Locale,
        "vnp_OrderInfo" => $vnp_OrderInfo,
        "vnp_OrderType" => $vnp_OrderType,
        "vnp_ReturnUrl" => $vnp_ReturnUrl,
        "vnp_TxnRef" => $vnp_TxnRef
    ];

    ksort($inputData);
    $query = "";
    $i = 0;
    $hashdata = "";

    foreach ($inputData as $key => $value) {
        if ($i == 1) {
            $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
        } else {
            $hashdata .= urlencode($key) . "=" . urlencode($value);
            $i = 1;
        }
        $query .= urlencode($key) . "=" . urlencode($value) . '&';
    }

    $vnp_Url = $config['vnp_Url'] . "?" . $query;
    $vnpSecureHash = hash_hmac('sha512', $hashdata, $config['vnp_HashSecret']);
    $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;

    header('Location: ' . $vnp_Url);
    exit;
}

public function vnpayReturn()
{
     $config = require_once __DIR__ . '/../../public/partials/vnpay_config.php';


    $vnp_SecureHash = $_GET['vnp_SecureHash'];
    $inputData = [];

    foreach ($_GET as $key => $value) {
        if (substr($key, 0, 4) == "vnp_") {
            $inputData[$key] = $value;
        }
    }

    unset($inputData['vnp_SecureHash']);
    ksort($inputData);
    $hashData = "";
    $i = 0;
    foreach ($inputData as $key => $value) {
        if ($i == 1) {
            $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
        } else {
            $hashData .= urlencode($key) . "=" . urlencode($value);
            $i = 1;
        }
    }

    $secureHash = hash_hmac('sha512', $hashData, $config['vnp_HashSecret']);

    if ($secureHash === $vnp_SecureHash) {
        if ($_GET['vnp_ResponseCode'] === '00') {
            // Thanh toán thành công
            $order = $_SESSION['pending_order'];
            $orderId = Order::createOrder($order['user_id'], $order['address'], $order['total']);
            foreach (Cart::getCart($order['user_id']) as $item) {
                $this->updateInventory($item['id'], $item['quantity']);
            }
            Cart::clearCart($order['user_id']);
            unset($_SESSION['pending_order']);

            redirect('/thank-you');
        } else {
            echo "<h3>Thanh toán thất bại. Mã lỗi: " . htmlspecialchars($_GET['vnp_ResponseCode']) . "</h3>";
        }
    } else {
        echo "<h3>Xác thực không hợp lệ. Giao dịch không được chấp nhận.</h3>";
    }
}


}
