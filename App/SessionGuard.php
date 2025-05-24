<?php

namespace App;

use App\Models\User;

class SessionGuard
{
  protected $user;

  public function login(User $user, array $credentials)
  {
      $verified = password_verify($credentials['password'], $user->password);
      if ($verified) {
          $_SESSION['user_id'] = $user->id;
          $_SESSION['user_role'] = $user->role; // Lưu role vào session
      }
      return $verified;
  }
  
  public function loginFP(User $user, array $credentials)
  {
      $verified = password_verify($credentials['phone'], $user->phone);
      if ($verified) {
          $_SESSION['user_id'] = $user->id;
          $_SESSION['user_role'] = $user->role; // Lưu role vào session
      }
      return $verified;
  }

  public function user()
  {
    if (!$this->user && $this->isUserLoggedIn()) {
      $this->user = (new User(PDO()))->where('id', $_SESSION['user_id']);
    }
    return $this->user;
  }

  
  public function isAdmin()
  {

      return  $_SESSION['user_role']=== '1';
  }
  

  public function logout()
  {
      $this->user = null;
      session_unset();
      session_destroy();
  }
  

  public function isUserLoggedIn()
  {
    return isset($_SESSION['user_id']);
  }

  
}
