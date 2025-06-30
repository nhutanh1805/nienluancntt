<?php
namespace App\Controllers;

use App\Models\Message;

class ChatController extends Controller
{
    public function index(): void
    {
        $userId = $_SESSION['user_id'] ?? null;
        $currentUserName = $_SESSION['user_name'] ?? null; // giả sử bạn lưu tên user trong session

        if (!$userId) {
            redirect('/login');
            return;
        }

        $messages = Message::getAllMessages();

        $this->sendPage('chat/index', [
            'messages' => $messages,
            'userId' => $userId,
            'currentUser' => $userId,   // truyền userId để so sánh
        ]);
    }

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

    // Xử lý thu hồi tin nhắn POST
    public function revoke(): void
    {
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            redirect('/login');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message_id'])) {
            $messageId = (int) $_POST['message_id'];

            if ($messageId <= 0) {
                $_SESSION['error'] = 'ID tin nhắn không hợp lệ.';
                redirect('/chat');
                return;
            }

            $success = Message::revokeMessage($messageId, $userId);

            if ($success) {
                $_SESSION['success'] = 'Thu hồi tin nhắn thành công.';
            } else {
                $_SESSION['error'] = 'Không thể thu hồi tin nhắn (có thể không phải tin nhắn của bạn).';
            }

            redirect('/chat');
        } else {
            redirect('/chat');
        }
    }
}
