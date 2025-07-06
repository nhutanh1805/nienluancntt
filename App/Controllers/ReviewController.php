<?php
namespace App\Controllers;

use App\Models\Review;
use Exception;

class ReviewController extends Controller
{
    // Hiển thị tất cả đánh giá của 1 sản phẩm
    public function index(int $productId): void
    {
        try {
            $reviews = Review::getReviewsByProduct($productId);
            $averageRating = Review::getAverageRating($productId);

            $this->sendPage('review/index', [
                'reviews' => $reviews,
                'averageRating' => $averageRating,
                'productId' => $productId
            ]);
        } catch (Exception $e) {
            $this->sendPage('review/index', ['error' => $e->getMessage()]);
        }
    }

    // Thêm đánh giá mới từ form POST
    public function add(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $userId = $_POST['user_id'] ?? null;
    $productId = $_POST['product_id'] ?? null;
    $rating = $_POST['rating'] ?? null;
    $comment = $_POST['comment'] ?? '';

    if (!$userId || !$productId || !$rating) {
        $_SESSION['error_message'] = "Vui lòng điền đầy đủ thông tin đánh giá.";
        header("Location: /product/$productId/reviews");
        exit;
    }

    try {
        $success = \App\Models\Review::addReview(
            (int)$userId,
            (int)$productId,
            (int)$rating,
            trim($comment)
        );

        if ($success) {
            $_SESSION['success_message'] = "Đã gửi đánh giá thành công!";
        } else {
            $_SESSION['error_message'] = "Không thể thêm đánh giá.";
        }

        header("Location: /product/$productId/reviews");
        exit;
    } catch (Exception $e) {
        $_SESSION['error_message'] = "Lỗi khi đánh giá: " . $e->getMessage();
        header("Location: /product/$productId/reviews");
        exit;
    }
}


    // Xem đánh giá gần nhất của user với 1 sản phẩm
    public function viewLatest(int $userId, int $productId): void
    {
        try {
            $review = Review::getLatestReviewByUser($userId, $productId);

            if (!$review) {
                $this->sendPage('review/view', ['error' => 'Chưa có đánh giá nào']);
                return;
            }

            $this->sendPage('review/view', ['review' => $review]);
        } catch (Exception $e) {
            $this->sendPage('review/view', ['error' => $e->getMessage()]);
        }
    }
}
?>
