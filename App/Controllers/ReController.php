<?php

namespace App\Controllers;

use App\Models\Contact;

class ReController extends Controller
{
    // Constructor để kiểm tra trạng thái đăng nhập của người dùng
    public function __construct()
    {
        // Kiểm tra nếu người dùng chưa đăng nhập, chuyển hướng về trang đăng nhập
        if (!AUTHGUARD()->isUserLoggedIn()) {
            // Gửi thông báo thành công đăng ký và chuyển hướng đến trang đăng nhập
            $messages = ['success' => 'Đăng ký thành công!'];
            redirect('/login', ['messages' => $messages]);
        }

        // Gọi constructor của lớp cha (Controller)
        parent::__construct();
    }

    // Hiển thị trang danh sách liên hệ (contacts)
    public function index()
    {
        $this->sendPage('contacts/index', [
            'contacts' => AUTHGUARD()->user()?->contacts() ?? []  // Lấy danh sách liên hệ của người dùng
        ]);
    }

    // Hiển thị trang tạo mới liên hệ
    public function create()
    {
        $this->sendPage('contacts/create', [
            'errors' => session_get_once('errors'), // Lấy các lỗi từ session
            'old' => $this->getSavedFormValues()  // Lấy dữ liệu form đã lưu
        ]);
    }

    // Lưu thông tin liên hệ mới
    public function store()
    {
        // Lọc và vệ sinh dữ liệu từ form
        $data = $this->filterContactData($_POST);

        // Tạo đối tượng Contact mới và validate dữ liệu
        $newContact = new Contact(PDO());
        $model_errors = $newContact->validate($data);

        // Kiểm tra nếu không có lỗi validation
        if (empty($model_errors)) {
            // Lưu thông tin liên hệ vào cơ sở dữ liệu
            $newContact->fill($data)
                ->setUser(AUTHGUARD()->user())  // Gán người dùng
                ->save();

            // Thông báo thành công và chuyển hướng về trang chính
            $_SESSION['message'] = 'Thêm contact thành công!';
            redirect('/');
        }

        // Nếu có lỗi, lưu lại thông tin form và lỗi vào session
        $this->saveFormValues($_POST);
        redirect('/contacts/create', ['errors' => $model_errors]);
    }

    // Lọc và vệ sinh dữ liệu đầu vào từ form
    protected function filterContactData(array $data)
    {
        return [
            'name' => $data['name'] ?? '',
            'phone' => $data['phone'] ?? '',
            'notes' => $data['notes'] ?? ''
        ];
    }

    // Hiển thị trang chỉnh sửa thông tin liên hệ
    public function edit($contactId)
    {
        // Tìm thông tin liên hệ từ ID
        $contact = AUTHGUARD()->user()->findContact($contactId);
        if (!$contact) {
            $this->sendNotFound();  // Nếu không tìm thấy liên hệ, trả về trang lỗi 404
        }

        // Lấy các giá trị form đã lưu (nếu có)
        $form_values = $this->getSavedFormValues();
        $data = [
            'errors' => session_get_once('errors'),  // Các lỗi từ session
            'contact' => (!empty($form_values)) ? 
                array_merge($form_values, ['id' => $contact->id]) : 
                (array) $contact  // Dữ liệu liên hệ để hiển thị
        ];

        // Gửi dữ liệu sang view chỉnh sửa
        $this->sendPage('contacts/edit', $data);
    }

    // Cập nhật thông tin liên hệ
    public function update($contactId)
    {
        // Tìm thông tin liên hệ từ ID
        $contact = AUTHGUARD()->user()->findContact($contactId);
        if (!$contact) {
            $this->sendNotFound();  // Nếu không tìm thấy liên hệ, trả về trang lỗi 404
        }

        // Lọc và vệ sinh dữ liệu đầu vào từ form
        $data = $this->filterContactData($_POST);

        // Validate dữ liệu
        $model_errors = $contact->validate($data);

        // Nếu không có lỗi, cập nhật thông tin liên hệ
        if (empty($model_errors)) {
            $contact->fill($data);
            $contact->save();

            // Thông báo thành công và chuyển hướng về trang chính
            $_SESSION['message'] = 'Cập nhật contact thành công!';
            redirect('/');
        }

        // Nếu có lỗi, lưu lại thông tin form và lỗi vào session
        $this->saveFormValues($_POST);
        redirect('/contacts/edit/' . $contactId, [
            'errors' => $model_errors
        ]);
    }

    // Xóa liên hệ
    public function destroy($contactId)
    {
        // Tìm thông tin liên hệ từ ID
        $contact = AUTHGUARD()->user()->findContact($contactId);
        if (!$contact) {
            $this->sendNotFound();  // Nếu không tìm thấy liên hệ, trả về trang lỗi 404
        }

        // Xóa liên hệ khỏi cơ sở dữ liệu
        $contact->delete();

        // Thông báo thành công và chuyển hướng về trang chính
        $_SESSION['message'] = 'Xóa contact thành công!';
        redirect('/');
    }
}
?>
