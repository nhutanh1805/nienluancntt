<?php

namespace App\Controllers\Auth;

use App\Models\User;
use App\Controllers\Controller;

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
    $user = (new User(PDO()))->where('email', $user_credentials['email']);
    if (!$user) {
      // Người dùng không tồn tại...
      $errors['email'] = 'Invalid email or password.';
    } else if (AUTHGUARD()->login($user, $user_credentials)) {
      // Đăng nhập thành công...
      $_SESSION['success_message'] = 'Đăng nhập thành công';
      redirect('/home');
    } else {
      // Sai mật khẩu...
      $_SESSION['error_message'] = 'Mật khẩu hoặc Email không đúng.';
      $errors['password'] = 'Invalid email or password.';
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
