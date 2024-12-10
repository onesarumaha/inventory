<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Customer;
use App\Models\Laporan;
use App\Models\Product;
use App\Models\Transaksi as ModelsTransaksi;
use App\Models\TransaksiItem as  ModelsTransaksiItem;
use CodeIgniter\HTTP\ResponseInterface;

class Transaksi extends BaseController
{
    public function index()
    {
        $transaksiModel = new ModelsTransaksi();
        $pengeluaran = $transaksiModel->getCustomer();

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
        $productModel = new Product();
        $laporanModel = new Laporan(); // Tambahkan model Laporan
    
        try {
            $dataTransaksi = [
                'customer_id' => $this->request->getPost('customer_id'),
                'date' => date('Y-m-d H:s:i'),
                'no_transaksi' => 0,
                'total_price' => 0,
                'user_id' => $this->request->getPost('user_id'),
            ];
    
            if (!$transaksiModel->insert($dataTransaksi)) {
                throw new \Exception("Failed to insert main transaction.");
            }
            $transactionId = $transaksiModel->getInsertID();
    
            if (!$transactionId) {
                throw new \Exception("Failed to retrieve transaction ID after insertion.");
            }
    
            $transaksiModel->update($transactionId, ['no_transaksi' => $transactionId]);
    
            $productIds = $this->request->getPost('product_id');
            $prices = $this->request->getPost('price');
            $quantities = $this->request->getPost('quantity');
    
            if (empty($productIds) || empty($prices) || empty($quantities)) {
                throw new \Exception("terjadi kesalahan.");
            }
    
            $totalPrice = 0;
            foreach ($productIds as $index => $productId) {
                $product = $productModel->find($productId);
    
                if (!$product) {
                    throw new \Exception("Product tidak ditemukan.");
                }
    
                $stock = $product['stock'];
                $quantity = intval($quantities[$index]);
    
                if ($quantity > $stock) {
                    throw new \Exception("Quantity product tidak mencukupi.");
                }
    
                $cleanedPrice = str_replace(['Rp.', ','], '', $prices[$index]);
                $cleanedPrice = floatval($cleanedPrice);
                $itemTotal = $cleanedPrice * $quantity;
                
                date_default_timezone_set('Asia/Jakarta');

                $dataTransaksiItem = [
                    'transaksi_id' => $transactionId,
                    'product_id' => $productId,
                    'price' => $cleanedPrice,
                    'quantity' => $quantity,
                    'total' => $itemTotal,
                    'user_id' => $this->request->getPost('user_id'),
                    'date' => date('Y-m-d H:s:i'),
                ];
    
                if (!$transaksiItemModel->insert($dataTransaksiItem)) {
                    throw new \Exception("Failed to insert transaction item for product ID {$productId}.");
                }
    
                $totalPrice += $itemTotal;
    
                $productModel->update($productId, ['stock' => $stock - $quantity]);
    
                $dataLaporan = [
                    'parant_id' => $transactionId, 
                    'date' => date('Y-m-d H:s:i'),
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'omset' => $itemTotal, 
                    'user_id' => $this->request->getPost('user_id'),
                    'type' => 'out',
                    'from' => 'pengeluaran',

                ];
    
                if (!$laporanModel->insert($dataLaporan)) {
                    throw new \Exception("Failed to insert laporan for product ID {$productId}.");
                }
            }
    
            $transaksiModel->update($transactionId, ['total_price' => $totalPrice]);
    
            return redirect()->to('/pengeluaran')->with('message', 'Pengeluaran Berhasil.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    

    public function edit($id)
    {
        $transaksiModel = new ModelsTransaksi();
        $transaksiItemModel = new ModelsTransaksiItem(); 
        $productModel = new Product(); 
        $customerModel = new Customer();
        
        $transaksi = $transaksiModel->find($id);
        if (!$transaksi) {
            return redirect()->to('/pengeluaran')->with('error', 'Transaksi tidak ditemukan.');
        }
        
        $transaksiItems = $transaksiItemModel->where('transaksi_id', $id)->findAll();
    
        $customers = $customerModel->findAll();
        $products = $productModel->findAll();
        
        $data = [
            'title' => 'Edit Pengeluaran',
            'transaksi' => $transaksi, 
            'transaksiItems' => $transaksiItems, 
            'customer' => $customers,
            'product' => $products
        ];
        
        return view('pengeluaran/edit', $data);
    }
    
    
    

    public function update($id)
    {
        $transaksiModel = new ModelsTransaksi();
        $transaksiItemModel = new ModelsTransaksiItem();
        $productModel = new Product();
        $laporanModel = new Laporan();
    
        try {
            $transaksi = $transaksiModel->find($id);
            if (!$transaksi) {
                throw new \Exception("Transaksi tidak ditemukan.");
            }
    
            $dataTransaksi = [
                'customer_id' => $this->request->getPost('customer_id'),
                'date' => date('Y-m-d H:s:i'),
                'user_id' => $this->request->getPost('user_id'),
            ];
    
            if (!$transaksiModel->update($id, $dataTransaksi)) {
                throw new \Exception("Failed to update main transaction.");
            }
    
            if (!$transaksiItemModel->where('transaksi_id', $id)->delete()) {
                throw new \Exception("Failed to delete old transaction items.");
            }
    
            $productIds = $this->request->getPost('product_id');
            $prices = $this->request->getPost('price');
            $quantities = $this->request->getPost('quantity');
    
            if (empty($productIds) || empty($prices) || empty($quantities)) {
                throw new \Exception("Terjadi kesalahan. Data produk, harga, atau quantity kosong.");
            }
    
            $totalPrice = 0;
            foreach ($productIds as $index => $productId) {
                $product = $productModel->find($productId);
    
                if (!$product) {
                    throw new \Exception("Product tidak ditemukan.");
                }
    
                $stock = $product['stock'];
                $quantity = intval($quantities[$index]);
    
                if ($quantity > $stock) {
                    throw new \Exception("Quantity product tidak mencukupi.");
                }
    
                $cleanedPrice = str_replace(['Rp.', ','], '', $prices[$index]);
                $cleanedPrice = floatval($cleanedPrice);
                $itemTotal = $cleanedPrice * $quantity;
    
                $dataTransaksiItem = [
                    'transaksi_id' => $id,
                    'product_id' => $productId,
                    'price' => $cleanedPrice,
                    'quantity' => $quantity,
                    'total' => $itemTotal,
                    'user_id' => $this->request->getPost('user_id'),
                    'date' => date('Y-m-d H:s:i'),
                ];
    
                if (!$transaksiItemModel->insert($dataTransaksiItem)) {
                    throw new \Exception("Failed to insert transaction item for product ID {$productId}.");
                }
    
                $totalPrice += $itemTotal;
    
                $productModel->update($productId, ['stock' => $stock - $quantity]);
    
                $dataLaporan = [
                    'parant_id' => $id, 
                    'date' => date('Y-m-d H:s:i'),
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'omset' => $itemTotal, 
                    'user_id' => $this->request->getPost('user_id'),
                    'type' => 'out',
                    'from' => 'pengeluaran',
                ];
    
                if (!$laporanModel->insert($dataLaporan)) {
                    throw new \Exception("Failed to insert laporan for product ID {$productId}.");
                }
            }
    
            $transaksiModel->update($id, ['total_price' => $totalPrice]);
    
            return redirect()->to('/pengeluaran')->with('message', 'Pengeluaran berhasil update.');
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

    public function view($id)
    {
        $transaksiModel = new \App\Models\Transaksi();
        $transaksiItemModel = new \App\Models\TransaksiItem();
    
        $transaksi = $transaksiModel->getWithProduct($id);
    
        if (!$transaksi) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Transaksi dengan ID $id tidak ditemukan.");
        }
    
        $transaksiItems = $transaksiItemModel->getItemsWithProduct($id);
    
        $data = [
            'title' => 'Detail Pengeluaran',
            'transaksi' => $transaksi,
            'transaksiItems' => $transaksiItems,
        ];
    
        return view('pengeluaran/view', $data);
    }

    public function delete($id)
    {
        $transaksiModel = new ModelsTransaksi();
        $transaksiItemModel = new ModelsTransaksiItem();
        $productModel = new Product();
        $laporanModel = new Laporan();
    
        try {
            $transaksi = $transaksiModel->find($id);
            if (!$transaksi) {
                throw new \Exception("Transaksi tidak ditemukan.");
            }
    
            $transaksiItems = $transaksiItemModel->where('transaksi_id', $id)->findAll();
    
            if (empty($transaksiItems)) {
                throw new \Exception("Tidak ada item transaksi untuk dihapus.");
            }
    
            foreach ($transaksiItems as $item) {
                $product = $productModel->find($item['product_id']);
                
                if (!$product) {
                    throw new \Exception("Product dengan ID {$item['product_id']} tidak ditemukan.");
                }
    
                $updatedStock = $product['stock'] + $item['quantity'];
                if (!$productModel->update($item['product_id'], ['stock' => $updatedStock])) {
                    throw new \Exception("Gagal mengembalikan stok untuk product ID {$item['product_id']}.");
                }
    
                if (!$laporanModel->where('parant_id', $id)->where('product_id', $item['product_id'])->delete()) {
                    throw new \Exception("Gagal menghapus laporan untuk product ID {$item['product_id']}.");
                }
            }
    
            if (!$transaksiItemModel->where('transaksi_id', $id)->delete()) {
                throw new \Exception("Gagal menghapus item transaksi.");
            }
    
            if (!$transaksiModel->delete($id)) {
                throw new \Exception("Gagal menghapus transaksi.");
            }
    
            return redirect()->to('/pengeluaran')->with('message', 'Transaksi berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    
    
    
    




}
