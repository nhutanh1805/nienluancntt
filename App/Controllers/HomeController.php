<?php

namespace App\Controllers;

use App\Models\Contact;
use App\Models\User;

class HomeController extends Controller
{
    // Khởi tạo controller, kiểm tra xem người dùng đã đăng nhập chưa
    public function __construct()
    {
        // Kiểm tra nếu người dùng chưa đăng nhập thì chuyển hướng đến trang đăng nhập
        if (!AUTHGUARD()->isUserLoggedIn()) {
            redirect('/login');
        }

        // Gọi constructor của lớp cha (Controller)
        parent::__construct();
    }

    // Phương thức tìm kiếm liên hệ (contacts) từ query string
    public function indexsearch()
    {
        $search = $_GET['search'] ?? ''; // Lấy từ query string
        // Tìm kiếm liên hệ của người dùng
        $contacts = AUTHGUARD()->user()?->contacts($search) ?? [];

        // Gửi dữ liệu sang view Trangchu
        $this->sendPage('contacts/Trangchu', [
            'contacts' => $contacts,
            'search' => $search,
        ]);
    }

    // Tìm kiếm sản phẩm
    public function sanphamsearch()
    {
        $search = $_GET['search'] ?? ''; // Lấy từ query string
        // Tìm kiếm sản phẩm của người dùng
        $contacts = AUTHGUARD()->user()?->contacts($search) ?? [];

        // Gửi dữ liệu sang view Sanpham
        $this->sendPage('contacts/Sanpham', [
            'contacts' => $contacts,
            'search' => $search,
        ]);
    }

    // Hiển thị trang chủ cho người dùng
    public function index()
    {
        // Gửi thông tin liên hệ của người dùng sang view Trangchu
        $this->sendPage('contacts/Trangchu', [
            'contacts' => AUTHGUARD()->user()?->contacts() ?? []
        ]);
    }

    // Hiển thị trang admin (nếu người dùng có quyền admin)
    public function indexAmin()
    {
        // Kiểm tra xem người dùng có phải admin không
        if (AUTHGUARD()->isAdmin()) {
            // Nếu là admin, hiển thị trang admin
            $this->sendPage('contacts/TrangchuAmin', [
                'contacts' => AUTHGUARD()->user()?->contacts() ?? []
            ]);
        } else {
            // Nếu không phải admin, hiển thị thông báo lỗi và chuyển hướng về trang chính
            $_SESSION['error_message'] = 'Không đủ thẩm quyền. Chuyển lại trang chủ.';
            redirect('/home');  // Chuyển hướng về trang chính
        }
    }

    // Hiển thị danh sách sản phẩm
    public function sanpham()
    {
        $this->sendPage('contacts/Sanpham', [
            'contacts' => AUTHGUARD()->user()?->contacts() ?? []
        ]);
    }

    // Hiển thị trang tạo sản phẩm (chỉ dành cho admin)
    public function create()
    {
        if (AUTHGUARD()->isAdmin()) {
            // Nếu là admin, hiển thị trang tạo sản phẩm
            error_log("Create contact page is being called.");
            $this->sendPage('contacts/Themsanpham', [
                'errors' => session_get_once('errors'),
                'old' => $this->getSavedFormValues()  // Lấy dữ liệu form đã lưu
            ]);
        } else {
            // Nếu không phải admin, chuyển hướng về trang chính và hiển thị thông báo lỗi
            $_SESSION['error_message'] = 'Không đủ thẩm quyền. Đã chuyển lại trang chủ';
            redirect('/home');
        }
    }

    // Lưu thông tin sản phẩm mới
    public function store()
    {
        $data = $this->filterContactData($_POST);  // Lọc dữ liệu từ form
        $newContact = new Contact(PDO()); // Tạo đối tượng Contact mới
        $model_errors = $newContact->validate($data);  // Validate dữ liệu

        if (empty($model_errors)) {
            // Nếu không có lỗi validate, tiếp tục upload ảnh và lưu sản phẩm
            $upload_errors = $newContact->uploadImg($_FILES['img']);
            if (!empty($upload_errors)) {
                $model_errors = array_merge($model_errors, $upload_errors);
            }

            if (empty($model_errors)) {
                // Nếu không có lỗi upload, lưu sản phẩm vào cơ sở dữ liệu
                $newContact->fill($data)
                    ->setUser(AUTHGUARD()->user())
                    ->save();
                $_SESSION['success_message'] = 'Thêm mới thành công';
                redirect('/homeAmin');
            }
        }
        // Nếu có lỗi, chuyển hướng lại và hiển thị lỗi
        redirect('/contacts/add', ['errors' => $model_errors]);
    }

    // Lọc và vệ sinh dữ liệu từ form nhập vào
    protected function filterContactData(array $data)
    {
        return [
            'name' => $this->e($data['name'] ?? ''),
            'img' => $this->e($data['img'] ?? ''),
            'description' => $this->e($data['description'] ?? ''),
            'price' => $this->e($data['price'] ?? ''),
            'priceGoc' => $this->e($data['priceGoc'] ?? ''),
            'product_type' => $this->e($data['product_type'] ?? ''),
            'cpu' => $this->e($data['cpu'] ?? ''),
            'ram' => $this->e($data['ram'] ?? ''),
            'storage' => $this->e($data['storage'] ?? ''),
            'battery_capacity' => $this->e($data['battery_capacity'] ?? ''),
            'camera_resolution' => $this->e($data['camera_resolution'] ?? ''),
            'screen_size' => $this->e($data['screen_size'] ?? ''),
            'os' => $this->e($data['os'] ?? ''),
            'band' => $this->e($data['band'] ?? ''),
            'strap_material' => $this->e($data['strap_material'] ?? '')
        ];
    }

    // Chỉnh sửa thông tin sản phẩm
    public function edit($contactId)
    {
        // Lấy thông tin sản phẩm từ ID
        $contact = AUTHGUARD()->user()->findContact($contactId);
        if (!$contact) {
            $this->sendNotFound();  // Nếu không tìm thấy sản phẩm, trả về trang lỗi 404
        }
        $form_values = $this->getSavedFormValues();  // Lấy dữ liệu form đã lưu
        $data = [
            'errors' => session_get_once('errors'),
            'contact' => (!empty($form_values)) ? 
                array_merge($form_values, ['id' => $contact->id]) : 
                (array) $contact
        ];
        $this->sendPage('contacts/edit', $data);  // Gửi dữ liệu sang view chỉnh sửa
    }

    // Cập nhật thông tin sản phẩm
    public function update($contactId)
    {
        $contact = AUTHGUARD()->user()->findContact($contactId);
        if (!$contact) {
            $this->sendNotFound();  // Nếu không tìm thấy sản phẩm, trả về trang lỗi 404
        }
        if ($this->isCsrfTokenValid($_POST['csrf_token'] ?? '')) {
            $_SESSION['errors'][] = 'Invalid CSRF token.';  // Kiểm tra CSRF token
            redirect('/contacts/edit/' . $contactId);
        }
        $data = $this->filterContactData($_POST);  // Lọc dữ liệu từ form
        $model_errors = $contact->validate($data);  // Validate dữ liệu

        if (empty($model_errors)) {
            // Nếu không có lỗi, upload ảnh và lưu thay đổi
            $upload_errors = $contact->uploadImg($_FILES['img']);
            if (!empty($upload_errors)) {
                $model_errors = array_merge($model_errors, $upload_errors);
            }
            $contact->fill($data);
            $contact->save();
            $_SESSION['success_message'] = 'Cập nhật thành công';
            redirect('/homeAmin');
        }
        // Nếu có lỗi, lưu form và hiển thị lại lỗi
        $this->saveFormValues($_POST);
        redirect('/contacts/edit/' . $contactId, [
            'errors' => $model_errors
        ]);
    }

    // Xóa sản phẩm
    public function destroy($contactId)
    {
        $contact = AUTHGUARD()->user()->findContact($contactId);
        if (!$contact) {
            $this->sendNotFound();  // Nếu không tìm thấy sản phẩm, trả về trang lỗi 404
        }
        // Xóa sản phẩm và thông tin liên quan
        $contact->delete();
        $contact->deleteProduct();
        $_SESSION['error_message'] = 'Xóa thành công';
        redirect('/homeAmin');
    }

    // Hàm giúp mã hóa (escape) các ký tự đặc biệt trong dữ liệu
    protected function e($message)
    {
        return htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
    }

    // Kiểm tra tính hợp lệ của CSRF token
    protected function isCsrfTokenValid($token)
    {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
}
