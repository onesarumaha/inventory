<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Transaksi as ModelsTransaksi;
use App\Models\TransaksiItem as  ModelsTransaksiItem;
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

    public function store()
    {
        $transaksiModel = new ModelsTransaksi();
        $transaksiItemModel = new ModelsTransaksiItem(); 
    
        try {
            $dataTransaksi = [
                'customer_id' => $this->request->getPost('customer_id'),
                'date' => date('Y-m-d'),
                'no_transaksi' => 2,
                'total_price' => 1212,
                'user_id' => $this->request->getPost('user_id'),
            ];
    
            if (!$transaksiModel->insert($dataTransaksi)) {
                throw new \Exception("Failed to insert main transaction.");
            }
            $transactionId = $transaksiModel->getInsertID();

    
            if (!$transactionId) {
                throw new \Exception("Failed to retrieve transaction ID after insertion.");
            }
    
            $productIds = $this->request->getPost('product_id');
            $prices = $this->request->getPost('price');
            $quantities = $this->request->getPost('quantity');
    
            if (empty($productIds) || empty($prices) || empty($quantities)) {
                throw new \Exception("Product details are missing.");
            }
    
            foreach ($productIds as $index => $productId) {
                $cleanedPrice = str_replace(['Rp.', ','], '', $prices[$index]);
                $cleanedPrice = floatval($cleanedPrice);
    
                $dataTransaksiItem = [
                    'transaksi_id' => $transactionId,
                    'product_id' => $productId,
                    'price' => $cleanedPrice,
                    'quantity' => $quantities[$index],
                    'total' => $cleanedPrice * $quantities[$index],
                    'user_id' => $this->request->getPost('user_id'),
                    'date' => date('Y-m-d'),
                ];
    
                if (!$transaksiItemModel->insert($dataTransaksiItem)) {
                    throw new \Exception("Failed to insert transaction item for product ID {$productId}.");
                }
            }
    
            return redirect()->to('/pengeluaran')->with('message', 'Pengeluaran Berhasil .');
    
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
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
