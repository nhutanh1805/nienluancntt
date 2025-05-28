<?php

namespace App\Controllers\Auth;

use App\Models\User;
use App\Controllers\Controller;
use App\Models\Member;
class LoginController extends Controller
{
  public function create()
  {
    if (AUTHGUARD()->isUserLoggedIn()) {
      redirect('/');
    }

    $data = [
      'messages' => session_get_once('messages'),
      'old' => $this->getSavedFormValues(),
      'errors' => session_get_once('errors')
    ];

    $this->sendPage('auth/login', $data);
  }

  public function createFP()
  {
    if (AUTHGUARD()->isUserLoggedIn()) {
      redirect('/');
    }

    $data = [
      'messages' => session_get_once('messages'),
      'old' => $this->getSavedFormValues(),
      'errors' => session_get_once('errors')
    ];

    $this->sendPage('auth/forgotPassword', $data);
  }

  public function store()
{
    $user_credentials = $this->filterUserCredentials($_POST);

    $errors = [];
    
    // Truy vấn người dùng từ email
    $user = (new User(PDO()))->where('email', $user_credentials['email']);
    
    if (!$user) {
        // Người dùng không tồn tại...
        $errors['email'] = 'Email hoặc mật khẩu không hợp lệ.';
    } else {
        // Kiểm tra xem người dùng có bị ban không
        if (Member::isBanned($user->id)) {
            // Nếu người dùng bị ban, không cho phép đăng nhập, không cần hiển thị thời gian
            $errors['email'] = 'Tài khoản của bạn đã bị cấm. Vui lòng liên hệ với quản trị viên.';
            // Lưu giá trị form trừ password để giữ lại input email
            $this->saveFormValues($_POST, ['password']);
            redirect('/login', ['errors' => $errors]);
            return; // Dừng lại nếu người dùng bị ban
        }

        // Nếu không bị ban, tiếp tục kiểm tra đăng nhập
        if (AUTHGUARD()->login($user, $user_credentials)) {
            // Đăng nhập thành công...
            $_SESSION['success_message'] = 'Đăng nhập thành công';
            redirect('/home');
            return;
        } else {
            // Sai mật khẩu...
            $errors['email'] = 'Email hoặc mật khẩu không hợp lệ.';
        }
    }

    // Đăng nhập không thành công: lưu giá trị trong form, trừ password
    $this->saveFormValues($_POST, ['password']);
    redirect('/login', ['errors' => $errors]);
}


  public function storeFP()
  {
    $user_credentials = $this->filterUserCredentialsFP($_POST);

    $errors = [];
    $user = (new User(PDO()))->where('email', $user_credentials['email']);
    if (!$user) {
      // Người dùng không tồn tại...
      $errors['email'] = 'Invalid email or password.';
    } else if (AUTHGUARD()->loginFP($user, $user_credentials)) {
      // Đăng nhập thành công...
      $_SESSION['success_message'] = 'Đăng nhập thành công';
      redirect('/home');
    } else {
      // Sai mật khẩu...
      $_SESSION['success_message'] = 'Mật khẩu không đúng.';
      $errors['phone'] = 'Invalid email or password.';
    }

    // Đăng nhập không thành công: lưu giá trị trong form, trừ password
    $this->saveFormValues($_POST, ['phone']);
    redirect('/login', ['errors' => $errors]);
  }

  public function destroy()
  {
    AUTHGUARD()->logout();
    redirect('/login');
  }

  protected function filterUserCredentials(array $data)
  {
    return [
      'email' => filter_var($data['email'], FILTER_VALIDATE_EMAIL),
      'password' => $data['password'] ?? null
    ];
  }

  protected function filterUserCredentialsFP(array $data)
  {
    return [
      'email' => filter_var($data['email'], FILTER_VALIDATE_EMAIL),
      'phone' => $data['phone'] ?? null
    ];
  }
}
