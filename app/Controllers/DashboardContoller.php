<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Laporan;
use App\Models\Product;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardContoller extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $product = new Product();
        $products = $product->findAll();

        $minStock = array_filter($products, function ($product) {
            return $product['stock'] <= 5;
        });

        $data = [
            'title' => 'Dashboard',
            'products' => $products,
            'minStock' => $minStock 
        ];
        return view('dashboard/index', $data);    
    }

    public function getSalesData()
    {
        $model = new Laporan();

        // Ambil data penjualan per user
        $salesData = $model->getSalesByUser();

        // Format data untuk Chart.js
        $labels = array_column($salesData, 'username'); // Nama user
        $omset = array_column($salesData, 'total_sales'); // Omset

        return $this->respond([
            'labels' => $labels,
            'omset'  => $omset,
        ]);
    }
    
}
