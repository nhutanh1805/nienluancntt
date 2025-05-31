<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once __DIR__ . '/../bootstrap.php';

define('CONGNGHE', 'LapStore - Cửa hàng Laptop');

session_start();

$router = new \Bramus\Router\Router();

// Auth routes
$router->post('/logout', '\App\Controllers\Auth\LoginController@destroy');
$router->get('/register', '\App\Controllers\Auth\RegisterController@create');
$router->post('/register', '\\App\Controllers\Auth\RegisterController@store');
$router->get('/login', '\App\Controllers\Auth\LoginController@create');
$router->post('/login', '\App\Controllers\Auth\LoginController@store');
$router->get('/loginFP', '\App\Controllers\Auth\LoginController@createFP');
$router->post('/loginFP', '\App\Controllers\Auth\LoginController@storeFP');

// Auth routes (Đăng ký VIP)
$router->get('/registerVIP', '\App\Controllers\Auth\RegisterVIPController@create'); 
$router->post('/registerVIP', '\App\Controllers\Auth\RegisterVIPController@store'); 

// Contact routes
$router->get('/', '\App\Controllers\HomeController@index');
$router->get('/home', '\App\Controllers\HomeController@index');
$router->get('/homeAmin', '\App\Controllers\HomeController@indexAmin');
$router->get('/product', '\App\Controllers\HomeController@sanpham');
$router->get('/contacts/create','\App\Controllers\HomeController@create');
$router->post('/contacts', '\App\Controllers\HomeController@store');
$router->get('/contacts/edit/(\d+)','\App\Controllers\HomeController@edit');
$router->post('/contacts/(\d+)','\App\Controllers\HomeController@update');
$router->post('/contacts/delete/(\d+)','\App\Controllers\HomeController@destroy');
$router->set404('\App\Controllers\Controller@sendNotFound');

// Cart routes
use App\Controllers\CartController;

// Hiển thị giỏ hàng
$router->get('/cart', function() {
    $cartController = new CartController();
    $cartController->index();  
});

// Thêm sản phẩm vào giỏ hàng
$router->get('/cart/add/{productId}', function($productId) {
    $cartController = new CartController();
    $cartController->add($productId);  
});

// Cập nhật số lượng sản phẩm trong giỏ hàng
$router->post('/cart/update/{productId}', function($productId) {
    $quantity = $_POST['quantity'] ?? 1; 
    $cartController = new CartController();
    $cartController->update($productId, $quantity);  
});

// Xóa sản phẩm khỏi giỏ hàng
$router->post('/cart/remove/{productId}', function($productId) {
    $cartController = new CartController();
    $cartController->remove($productId);  
});

// Checkout routes
use App\Controllers\CheckoutController;

// Hiển thị trang thanh toán
$router->get('/checkout', function() {
    $checkoutController = new CheckoutController();
    $checkoutController->index();  
});

// Xử lý thanh toán (giao dịch online hoặc nhận tiền khi giao hàng)
$router->post('/checkout/process', function() {
    $checkoutController = new CheckoutController();
    $checkoutController->process();  
});

// Trang cảm ơn sau khi thanh toán thành công
$router->get('/thank-you', function() {
    $checkoutController = new CheckoutController();
    $checkoutController->thankYou();  
});

// Search routes
$router->get('/search', '\App\Controllers\SearchController@index');

// Router để xử lý trang thông tin người dùng
$router->get('/account', '\App\Controllers\UserController@user');

// Router để xử lý trang sửa thông tin người dùng
$router->get('/user/update', '\App\Controllers\UserController@updateUser');
// POST request để xử lý việc cập nhật thông tin
$router->post('/account/update', '\App\Controllers\UserController@updateUser');
// Router để xử lý trang thay đổi mật khẩu
$router->get('/user/changepass', '\App\Controllers\UserController@changePassword');
// POST request để xử lý việc thay đổi mật khẩu
$router->post('/user/changepass', '\App\Controllers\UserController@changePassword');

// Order routes
use App\Controllers\OrderController;

// Hiển thị danh sách tất cả đơn hàng 
$router->get('/orders', function() {
    $orderController = new OrderController();
    $orderController->indexAll();
});

// Hiển thị chi tiết đơn hàng
$router->get('/order/view/{orderId}', function($orderId) {
    $orderController = new OrderController();
    $orderController->view($orderId);  
});

// Hủy đơn hàng
$router->post('/order/cancel/{orderId}', function($orderId) {
    $orderController = new OrderController();
    $orderController->cancel($orderId);  
});

// Cập nhật trạng thái đơn hàng
$router->post('/order/updateStatus/{orderId}', function($orderId) {
    $status = $_POST['status'] ?? '';  
    if (empty($status)) {
        // Nếu trạng thái không được cung cấp, trả về lỗi hoặc chuyển hướng
        return redirect("/order/view/{$orderId}");  
    }
    $orderController = new OrderController();
    $orderController->updateStatus($orderId);  
});
// Route xóa đơn hàng
$router->get('/order/delete/{orderId}', function($orderId) {
    $orderController = new OrderController();
    $orderController->delete($orderId);  
});

// Cập nhật route để hiển thị chi tiết đơn hàng
$router->get('/order/details/(:num)', 'OrderDetailsController@view');

$router->post('/order/updateStatus/[i:orderId]', 'OrderController@updateStatus');

// Hiển thị tất cả đơn hàng của người dùng
$router->get('/orders/index', function() {
    $orderController = new OrderController();
    $orderController->index(); 
});
// Route để cập nhật bình luận cho đơn hàng
$router->post('/order/updateComment/{orderId}', function($orderId) {
    $orderController = new OrderController();
    $orderController->updateComment($orderId); 
});
$router->post('/order/comment/{orderId}', function($orderId) {
    $orderController = new OrderController();
    $orderController->updateComment($orderId);  
});
$router->get('/order/index', function() {
    $orderController = new OrderController();
    $orderController->index();  
});

// Hiển thị tất cả comment của đơn hàng (admin hoặc người có quyền)
$router->get('/orders/comments', function() {
    $orderController = new OrderController();
    $orderController->showAllComments();
});



use App\Controllers\InventoryController;

// Hiển thị danh sách sản phẩm
$router->get('/inventory', function() {
    $inventoryController = new InventoryController();
    $inventoryController->index();  
});

// Thêm sản phẩm mới vào kho
$router->post('/inventory/add', function() {
    $inventoryController = new InventoryController();
    $inventoryController->add();  
});

// Cập nhật thông tin sản phẩm
$router->post('/inventory/update/{productId}', function($productId) {
    $inventoryController = new InventoryController();
    $inventoryController->update($productId);  
});

// Xóa sản phẩm khỏi danh sách (sản phẩm không có trong kho)
$router->post('/inventory/remove/{productId}', function($productId) {
    $inventoryController = new InventoryController();
    $inventoryController->remove($productId);  
});

// Cập nhật số lượng tồn kho cho sản phẩm
$router->post('/inventory/updateStock/{productId}', function($productId) {
    $inventoryController = new InventoryController();
    $inventoryController->updateStock($productId);  
});

// Thêm số lượng sản phẩm vào kho
$router->post('/inventory/addStock/{productId}', function($productId) {
    $inventoryController = new InventoryController();
    $inventoryController->addStock($productId);  
});

// Member routes
use App\Controllers\MemberController;

// Hiển thị danh sách tất cả thành viên
$router->get('/members', function() {
    $memberController = new MemberController();
    $memberController->index();  
});

// Hiển thị chi tiết thành viên
$router->get('/member/view/{id}', function($id) {
    $memberController = new MemberController();
    $memberController->view($id);  
});

// Xóa thành viên
$router->get('/member/delete/{id}', function($id) {
    $memberController = new MemberController();
    $memberController->delete($id);  
});

// // Tạo mới thành viên (form)
// $router->get('/member/create', function() {
//     $memberController = new MemberController();
//     $memberController->createForm();  // Hiển thị form tạo thành viên
// });

// // Xử lý tạo mới thành viên (submit form)
// $router->post('/member/create', function() {
//     $memberController = new MemberController();
//     $memberController->create();  // Tạo mới thành viên
// });

// // Cập nhật thông tin thành viên (form)
// $router->get('/member/edit/{id}', function($id) {
//     $memberController = new MemberController();
//     $memberController->editForm($id);  // Hiển thị form chỉnh sửa thành viên
// });

// // Xử lý cập nhật thành viên (submit form)
// $router->post('/member/edit/{id}', function($id) {
//     $memberController = new MemberController();
//     $memberController->update($id);  // Cập nhật thành viên
// });

// Route hiển thị danh sách thành viên
$router->get('/member/index', function() {
    $controller = new MemberController();
    $controller->index();
});

// Route xử lý ban thành viên (POST)
$router->post('/member/ban/{memberId}', function($memberId) {
    $controller = new MemberController();
    $controller->ban((int)$memberId);
});

// Route POST xử lý bỏ ban thành viên
$router->post('/member/unban/(\d+)', function($memberId) {
    // Khởi tạo controller và gọi method unban
    $controller = new \App\Controllers\MemberController();
    $controller->unban((int)$memberId);
});

// Run the router
$router->run();
