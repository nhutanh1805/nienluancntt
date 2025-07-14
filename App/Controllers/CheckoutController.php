<?php
namespace App\Controllers;

date_default_timezone_set('Asia/Ho_Chi_Minh');

use App\Models\Cart;
use App\Models\Order;
use App\Models\Checkout;

use Exception;

class CheckoutController extends Controller
{
    // Hiển thị trang thanh toán
    public function index()
    {
        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            redirect('/login');
        }

        $cart = Cart::getCart($userId);
        $total = Cart::getTotal($userId);

        $this->sendPage('checkout/index', [
            'cart' => $cart,
            'total' => $total
        ]);
    }

    // Xử lý thanh toán
    public function process()
    {
        if (!isset($_SESSION['user_id'])) {
            redirect('/login');
        }

        $userId = $_SESSION['user_id'];
        $name = $_POST['name'] ?? '';
        $address = $_POST['address'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $paymentMethod = $_POST['payment_method'] ?? '';

        if ($paymentMethod === 'cod') {
            $this->processCOD($userId, $name, $address, $phone);
        } elseif ($paymentMethod === 'vnpay') {
            return $this->redirectToVnpay($name, $address, $phone);
        } else {
            echo "Phương thức thanh toán không hợp lệ.";
            return;
        }
    }

    // Xử lý thanh toán COD
    private function processCOD($userId, $name, $address, $phone)
    {
        $cart = Cart::getCart($userId);
        $totalAmount = Cart::getTotal($userId);

        try {
            // Lưu thông tin người nhận
            Checkout::saveInfo($userId, $name, $address, $phone);

            // Tạo đơn hàng
            $orderId = Order::createOrder($userId, $address, $totalAmount);

            // Cập nhật tồn kho
            foreach ($cart as $item) {
                $this->updateInventory($item['id'], $item['quantity']);
            }

            // Xóa giỏ hàng
            Cart::clearCart($userId);

            redirect('/thank-you');
        } catch (Exception $e) {
            echo "Lỗi khi thanh toán: " . $e->getMessage();
        }
    }

    // Cập nhật tồn kho
    private function updateInventory($productId, $quantity)
    {
        Cart::updateStock($productId, $quantity);
    }

    // Chuyển hướng sang VNPAY
    private function redirectToVnpay($name, $address, $phone)
    {
        $userId = $_SESSION['user_id'];
        $cart = Cart::getCart($userId);
        $totalAmount = Cart::getTotal($userId);

        // Lưu thông tin người nhận vào bảng checkouts
        Checkout::saveInfo($userId, $name, $address, $phone);

        // Lưu session tạm
        $_SESSION['pending_order'] = [
            'user_id' => $userId,
            'name' => $name,
            'address' => $address,
            'phone' => $phone,
            'total' => $totalAmount
        ];

        $config = require_once __DIR__ . '/../../public/partials/vnpay_config.php';

        $vnp_TxnRef = time();
        $vnp_OrderInfo = 'Thanh toán đơn hàng qua VNPAY';
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $totalAmount * 100;
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

    // Trang cảm ơn
    public function thankYou()
    {
        $this->sendPage('checkout/thank-you');
    }

    // Xử lý phản hồi từ VNPAY
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
