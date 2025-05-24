<?php

namespace App\Controllers\Auth;

use App\Models\User;
use App\Controllers\Controller;

class RegisterController extends Controller
{
  public function __construct()
  {
    if (AUTHGUARD()->isUserLoggedIn()) {
      redirect('/home');
    }

    parent::__construct();
  }

  public function create()
  {
    $data = [
      'old' => $this->getSavedFormValues(),
      'errors' => session_get_once('errors')
    ];

    $this->sendPage('auth/register', $data);
  }

  public function store()
  {
    // Lưu giá trị form đã nhập (trừ password và password_confirmation)
    $this->saveFormValues($_POST, ['password', 'password_confirmation']);

    // Lọc và chuẩn bị dữ liệu
    $data = $this->filterUserData($_POST);

    // Khởi tạo mô hình người dùng
    $newUser = new User(PDO());
    $model_errors = $newUser->validate($data);

    if (empty($model_errors)) {
      // Điền dữ liệu và lưu vào cơ sở dữ liệu
      $newUser->fill($data)->save();

      $messages = ['success' => 'Đăng ký thành công. Vui lòng đăng nhập bằng tài khoản của bạn!'];
      redirect('/login', ['messages' => $messages]);
    }

    // Dữ liệu không hợp lệ, chuyển hướng về trang đăng ký và hiển thị lỗi
    redirect('/register', ['errors' => $model_errors]);
  }

  protected function filterUserData(array $data)
  {
    return [
      'name' => $data['name'] ?? null,
      'email' => filter_var($data['email'], FILTER_VALIDATE_EMAIL),
      'password' => $data['password'] ?? null,
      'password_confirmation' => $data['password_confirmation'] ?? null,
      'phone' => $data['phone'] ?? null,
      'address' => $data['address'] ?? null 
    ];
  }
}
