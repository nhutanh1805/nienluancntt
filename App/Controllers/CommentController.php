<?php
namespace App\Controllers;

use App\Models\Comment;
use Exception;

class CommentController
{
    // Hiển thị tất cả bình luận của người dùng
    public function showComments(int $userId)
    {
        try {
            // Lấy danh sách bình luận của người dùng từ Model
            $comments = Comment::getCommentsByUser($userId);
            // Hiển thị giao diện với dữ liệu bình luận
            require_once 'app/views/comments/index.php'; // View hiển thị bình luận
        } catch (Exception $e) {
            // Nếu có lỗi, hiển thị thông báo lỗi
            echo "Lỗi: " . $e->getMessage();
        }
    }

    // Thêm bình luận mới
    public function addComment()
    {
        try {
            // Kiểm tra nếu yêu cầu là POST (gửi từ form)
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Lấy dữ liệu từ form (POST)
                $userId = $_POST['user_id'];
                $content = $_POST['content'];
                $imageLink = $_POST['image_link'] ?? null;
                $rate = $_POST['rate'] ?? null;
                $orderId = $_POST['order_id'] ?? null;

                // Gọi phương thức thêm bình luận vào cơ sở dữ liệu
                Comment::addComment($userId, $content, $imageLink, $rate, $orderId);

                // Chuyển hướng về trang danh sách bình luận của người dùng
                header("Location: /comments/$userId");
                exit;
            }

            // Nếu là GET, hiển thị form thêm bình luận
            require_once 'app/views/comments/add.php'; // Form thêm bình luận

        } catch (Exception $e) {
            // Nếu có lỗi, hiển thị thông báo lỗi
            echo "Lỗi: " . $e->getMessage();
        }
    }

    // Cập nhật bình luận
    public function updateComment(int $commentId)
    {
        try {
            // Kiểm tra nếu yêu cầu là POST (gửi từ form cập nhật)
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Lấy dữ liệu từ form (POST)
                $content = $_POST['content'];
                $imageLink = $_POST['image_link'] ?? null;
                $rate = $_POST['rate'] ?? null;

                // Gọi phương thức cập nhật bình luận trong cơ sở dữ liệu
                Comment::updateComment($commentId, $content, $imageLink, $rate);

                // Chuyển hướng về trang danh sách bình luận sau khi cập nhật
                header("Location: /comments/{$_POST['user_id']}");
                exit;
            }

            // Nếu là GET, lấy bình luận để điền vào form
            $comment = Comment::getCommentById($commentId);
            if (!$comment) {
                throw new Exception("Bình luận không tồn tại.");
            }

            // Hiển thị form cập nhật bình luận
            require_once 'app/views/comments/edit.php'; // Form cập nhật bình luận

        } catch (Exception $e) {
            // Nếu có lỗi, hiển thị thông báo lỗi
            echo "Lỗi: " . $e->getMessage();
        }
    }

    // Xóa bình luận
    public function deleteComment(int $commentId)
    {
        try {
            // Xóa bình luận trong cơ sở dữ liệu
            $comment = Comment::getCommentById($commentId);
            if (!$comment) {
                throw new Exception("Bình luận không tồn tại.");
            }

            Comment::deleteComment($commentId);

            // Chuyển hướng về trang danh sách bình luận sau khi xóa
            header("Location: /comments/{$comment['user_id']}");
            exit;
        } catch (Exception $e) {
            // Nếu có lỗi, hiển thị thông báo lỗi
            echo "Lỗi: " . $e->getMessage();
        }
    }
}
?>
