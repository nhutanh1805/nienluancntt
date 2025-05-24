<?php

namespace App\Controllers\Auth;

use App\Models\User;
use App\Controllers\Controller;

class RegisterVIPController extends Controller
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

        $this->sendPage('auth/registerVIP', $data);
    }

    public function store()
    {
        $this->saveFormValues($_POST, ['password', 'password_confirmation']);

        $data = $this->filterUserData($_POST);

        $newUser = new User(PDO());
        $model_errors = $newUser->validate($data);

        if ($data['password'] !== $data['password_confirmation']) {
            $model_errors['password_confirmation'] = 'Mật khẩu xác nhận không khớp.';
        }

        if (empty($model_errors)) {
            $newUser->fill($data)->save();

            $messages = ['success' => 'Tài khoản VIP đã được tạo thành công.'];
            redirect('/login', ['messages' => $messages]);
        }

        redirect('/registerVIP', ['errors' => $model_errors, 'old' => $data]);
    }

    protected function filterUserData(array $data)
    {
        return [
            'firstName' => $data['firstName'] ?? null,
            'lastName' => $data['lastName'] ?? null,
            'email' => filter_var($data['email'], FILTER_VALIDATE_EMAIL),
            'password' => $data['password'] ?? null,
            'vipCode' => $data['vipCode'] ?? null,
            'birthDate' => $data['birthDate'] ?? null,
            'membershipPlan' => $data['membershipPlan'] ?? null,
            'specialBenefits' => isset($data['specialBenefits']) ? implode(', ', $data['specialBenefits']) : null,
            'newsletterCheck' => isset($data['newsletterCheck']) ? 1 : 0,
        ];
    }
}
