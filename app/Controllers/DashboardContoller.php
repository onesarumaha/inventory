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
        $salesData = $model->getSalesByUser();

        $labels = array_column($salesData, 'username'); 
        $omset = array_column($salesData, 'total_sales'); 

        return $this->respond([
            'labels' => $labels,
            'omset'  => $omset,
        ]);
    }


    public function getTopProduct()
    {
        $bulan = $this->request->getVar('month') ?? date('m'); 
        $tahun = $this->request->getVar('year') ?? date('Y');  
        

        $model = new Laporan();
        
        $topProducts = $model->getTopProducts($bulan, $tahun);

        $productNames = [];
        $productSales = [];
        foreach ($topProducts as $product) {
            $productNames[] = $product['product_name']; 
            $productSales[] = (int) $product['total_sold']; 
        }

        return $this->response->setJSON([
            'productNames' => $productNames,
            'productSales' => $productSales,
        ]);
    }
    
}
