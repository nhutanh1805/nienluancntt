<?php
namespace App\Controllers;

use App\Models\Message;
use PDO;

class ChatController extends Controller
{
    // Hiển thị trang chat và lấy tất cả tin nhắn chung
    public function index(): void
    {
        // Kiểm tra user đã đăng nhập
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            redirect('/login');
            return;
        }

        // Lấy tất cả tin nhắn chat chung
        $messages = Message::getAllMessages();

        // Gửi dữ liệu sang view chat/index.php
        $this->sendPage('chat/index', [
            'messages' => $messages,
            'userId' => $userId
        ]);
    }

    // Xử lý gửi tin nhắn POST
    public function send(): void
    {
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            redirect('/login');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
            $messageText = trim($_POST['message']);

            if ($messageText === '') {
                // Có thể lưu lỗi vào session hoặc trả về view với lỗi
                $_SESSION['error'] = 'Nội dung tin nhắn không được để trống.';
                redirect('/chat');
                return;
            }

            try {
                Message::sendMessage($userId, $messageText);
                redirect('/chat');
            } catch (\Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                redirect('/chat');
            }
        } else {
            redirect('/chat');
        }
    }
}
