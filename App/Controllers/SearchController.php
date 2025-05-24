<?php

namespace App\Controllers;

use App\Models\Search;

class SearchController extends Controller
{
    // Phương thức hiển thị trang kết quả tìm kiếm
    public function index()
    {
        // Lấy giá trị tìm kiếm từ URL bằng phương thức GET
        $query = isset($_GET['query']) ? $_GET['query'] : '';  // Kiểm tra nếu có 'query' trong URL

        $results = [];  // Khởi tạo mảng kết quả tìm kiếm rỗng

        // Nếu có từ khóa tìm kiếm (query không rỗng)
        if ($query) {
            // Tạo đối tượng Search từ model Search và thực hiện tìm kiếm sản phẩm
            $search = new Search(PDO());
            $results = $search->searchProducts($query);  // Gọi phương thức searchProducts() trong model
        }

        // Gửi kết quả tìm kiếm đến view search/index và truyền dữ liệu vào view
        $this->sendPage('search/index', [
            'results' => $results,  // Dữ liệu kết quả tìm kiếm
            'query' => $query  // Từ khóa tìm kiếm để hiển thị lại trong form tìm kiếm
        ]);
    }
}
