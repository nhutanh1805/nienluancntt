<?php
namespace App\Controllers;

use App\Models\ThongKe;

class ThongKeController extends Controller
{
    public function index(): void
    {
        // Lấy dữ liệu lọc từ query string
        $filterType = $_GET['filterType'] ?? 'all';   // all | day | month | year
        $filterValue = $_GET['filterValue'] ?? null;

        // Validate filterValue theo filterType đơn giản
        if ($filterType === 'day' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $filterValue)) {
            $filterValue = null;
        } elseif ($filterType === 'month' && !preg_match('/^\d{4}-\d{2}$/', $filterValue)) {
            $filterValue = null;
        } elseif ($filterType === 'year' && !preg_match('/^\d{4}$/', $filterValue)) {
            $filterValue = null;
        }

        try {
            $totalRevenue = ThongKe::getTotalRevenue($filterType, $filterValue);
            $orderCounts = ThongKe::getOrderCountByStatus($filterType, $filterValue);
            $deliveredOrders = ThongKe::getDeliveredOrders($filterType, $filterValue);

            $this->sendPage('thongke/index', [
                'totalRevenue' => $totalRevenue,
                'orderCounts' => $orderCounts,
                'deliveredOrders' => $deliveredOrders,
                'filterType' => $filterType,
                'filterValue' => $filterValue,
            ]);
        } catch (\Exception $e) {
            $this->sendPage('thongke/index', [
                'error' => $e->getMessage(),
                'filterType' => $filterType,
                'filterValue' => $filterValue,
            ]);
        }
    }
}
