<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Transaksi as ModelsTransaksi;
use CodeIgniter\HTTP\ResponseInterface;

class Transaksi extends BaseController
{
    public function index()
    {
        $query = new ModelsTransaksi();
        $pengeluaran = $query->orderBy('id', 'DESC')->findAll();

        $data = [
            'title' => 'Data Pengeluaran',
            'pengeluarans' => $pengeluaran,
        ];
        return view('pengeluaran/index', $data);    
    }

    public function create()
    {
        $customerModel = new Customer();
        $customers = $customerModel->findAll();

        $productModel = new Product();
        $products = $productModel->findAll();


        $data = [
            'title' => 'Create Pengeluaran',
            'customer' => $customers,
            'product' => $products
        ];

        return view('pengeluaran/form', $data);
    }

    public function getProductDetails($productId): ResponseInterface
    {
        $productModel = new Product();
        $product = $productModel->find($productId);

        if ($product) {
            return $this->response->setJSON([
                'success' => true,
                'price' => $product['price'],
                'stock' => $product['stock'],
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Product not found'
        ]);
    }




}
