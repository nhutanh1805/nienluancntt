<?php
namespace App\Controllers;

use App\Models\Member;
use Exception;

class MemberController extends Controller
{
    // Hiển thị danh sách tất cả thành viên
    public function index(): void
    {
        try {
            $members = Member::getAllMembers();
            $this->sendPage('member/index', ['members' => $members]);
        } catch (Exception $e) {
            $this->sendPage('member/index', ['error' => $e->getMessage()]);
        }
    }

    // Hiển thị chi tiết 1 thành viên theo ID
    public function view(int $memberId): void
    {
        try {
            $members = Member::getAllMembers(); // Tạm: model chưa có getById, nên lấy tất cả rồi lọc
            $member = null;
            foreach ($members as $m) {
                if ($m['id'] == $memberId) {
                    $member = $m;
                    break;
                }
            }

            if (!$member) {
                $this->sendPage('member/view', ['error' => 'Không tìm thấy thành viên']);
                return;
            }

            $this->sendPage('member/view', ['member' => $member]);
        } catch (Exception $e) {
            $this->sendPage('member/view', ['error' => $e->getMessage()]);
        }
    }

    // Xóa thành viên theo ID
    public function delete(int $memberId): void
    {
        try {
            // Thêm hàm delete vào model Member nếu muốn
            // Member::deleteMember($memberId);

            // Hiện tại chưa có hàm xóa, chỉ demo redirect
            $_SESSION['message'] = "Thành viên với ID $memberId đã được xóa (giả lập).";
            header('Location: /member/index');
            exit;
        } catch (Exception $e) {
            $this->sendPage('member/index', ['error' => $e->getMessage()]);
        }
    }

    // Ban thành viên theo ID trong khoảng thời gian (phút)
    public function ban(int $memberId): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $banMinutes = $_POST['ban_minutes'] ?? 0;
        $banMinutes = (int)$banMinutes;

        if ($banMinutes <= 0) {
            $_SESSION['error_message'] = "Thời gian cấm phải lớn hơn 0 phút.";
            header("Location: /member/index");
            exit;
        }

        try {
            $result = Member::banUser($memberId, $banMinutes);

            if ($result) {
                $_SESSION['success_message'] = "Đã cấm thành viên #$memberId trong $banMinutes phút.";
            } else {
                $_SESSION['error_message'] = "Cấm thành viên thất bại.";
            }

            header("Location: /member/index");
            exit;
        } catch (Exception $e) {
            $this->sendPage('member/index', ['error' => $e->getMessage()]);
        }
    }
    public function unban(int $memberId): void
{
    session_start();

    try {
        $result = Member::unbanUser($memberId);

        if ($result) {
            $_SESSION['success_message'] = "Đã bỏ ban thành viên #$memberId.";
        } else {
            $_SESSION['error_message'] = "Bỏ ban thành viên thất bại.";
        }

        header("Location: /member/index");
        exit;
    } catch (Exception $e) {
        $this->sendPage('member/index', ['error' => $e->getMessage()]);
    }
}

}
?>
