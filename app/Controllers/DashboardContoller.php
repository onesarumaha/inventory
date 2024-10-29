<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Product;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardContoller extends BaseController
{
    public function index()
    {
        $product = new Product();
        $products = $product->findAll();

        $minStock = array_filter($products, function ($product) {
            return $product['stock'] <= 10;
        });

        $data = [
            'title' => 'Dashboard',
            'products' => $products,
            'minStock' => $minStock 
        ];
        return view('dashboard/index', $data);    
    }
    
}
