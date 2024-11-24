<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Laporan;
use App\Models\Pemasukan as ModelsPemasukan;
use App\Models\Product;
use App\Models\Supplier;
use CodeIgniter\HTTP\ResponseInterface;

class Pemasukan extends BaseController
{
    protected $session;

    public function __construct()
    {
        $this->session = \Config\Services::session();
    }


    public function index()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('pengadaan_barang')
                      ->select('pengadaan_barang.*, product.name as nama_product, supplier.name as nama_supplier')
                      ->join('product', 'pengadaan_barang.product_id = product.id', 'left')
                      ->join('supplier', 'pengadaan_barang.supplier_id = supplier.id', 'left');
        
        $userRole = session()->get('role'); 
        $userId = session()->get('id'); 

        if ($userRole === 'owner') {
            $builder->where('pengadaan_barang.status', 2);
        } elseif ($userRole === 'petugas') {
            $builder->where('pengadaan_barang.user_id', $userId); 
        }
        $builder->orderBy('pengadaan_barang.id', 'DESC');
        
        $pemasukan = $builder->get()->getResultArray();
        $data = [
            'title' => 'Data Pemasukan',
            'pemasukans' => $pemasukan,
        ];
        
        return view('pemasukan/index', $data);
    }
    
    


    public function create()
    {

        $supplierModel = new Supplier();
        $suppliers = $supplierModel->findAll();

        $productModel = new Product();
        $products = $productModel->findAll();

        $data = [
            'title' => 'Create Pemasukan',
            'supplier' => $suppliers,
            'product' => $products
        ];

        return view('pemasukan/form', $data);
    }

    public function store()
    {
        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'product_id' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            // 'upload' => 'uploaded[upload]|max_size[upload,2048]|ext_in[upload,pdf,doc,docx,jpg,jpeg,png]'
        ]);
    
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

    
        $fileName = null; 
        $file = $this->request->getFile('upload');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $filePath = FCPATH . 'uploads'; 

            $fileName = $file->getRandomName();
            if (!$file->move($filePath, $fileName)) {
                log_message('error', 'Failed to move uploaded file: ' . $file->getErrorString());
            }
        } else {
            log_message('error', 'Invalid file upload: ' . $file->getErrorString());
        }
    
        $data = [
            'product_id' => $this->request->getPost('product_id'),
            'price' => $this->request->getPost('price'),
            'status' => '0',
            'quantity' => $this->request->getPost('quantity'),
            'date' => date('Y-m-d H:s:i'),
            'supplier_id' => $this->request->getPost('supplier_id'),
            'customer_id' => $this->request->getPost('customer_id'),
            'user_id' => $this->request->getPost('user_id'),
            'upload' => isset($fileName) ? $fileName : null,  
        ];
    
        $pemasukanModel = new ModelsPemasukan();
        $insertedId = $pemasukanModel->insert($data); 

        if ($insertedId) {
            $dataLaporan = [
                'product_id' => $this->request->getPost('product_id'),
                'parant_id' => $insertedId, 
                'quantity' => $this->request->getPost('quantity'),
                'date' => date('Y-m-d H:s:i'),
                'type' => 'in', 
                'user_id' => $this->request->getPost('user_id'),
                'omset' => $this->request->getPost('price') * $this->request->getPost('quantity'),
                'from' => 'pengadaan-barang',
            ];

            $laporan = new Laporan();
            $laporan->insert($dataLaporan);

            return redirect()->to('/pemasukan')->with('message', 'Data berhasil disimpan ');
        } else {
            return redirect()->back()->withInput()->with('errors', ['error' => 'Failed to save data to pemasukan.']);
        }

    }

    public function edit($id)
    {
        $pemasukanModel = new ModelsPemasukan();
        $pemasukan = $pemasukanModel->find($id);

        if (!$pemasukan) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('product not found');
        }

        $supplierModel = new Supplier();
        $suppliers = $supplierModel->findAll();

        $productModel = new Product();
        $products = $productModel->findAll();

        $data = [
            'title' => 'Update Pemasukan',
            'pemasukan' => $pemasukan,
            'supplier' => $suppliers,
            'product' => $products
        ];

        return view('pemasukan/form', $data); 
    }

    public function update($id)
    {
        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'product_id' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'upload' => 'uploaded[upload]|max_size[upload,2048]|ext_in[upload,pdf,doc,docx,jpg,jpeg,png]'
        ]);
        
        // if (!$validation->withRequest($this->request)->run()) {
        //     return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        // }
    
        $pemasukanModel = new ModelsPemasukan();
        $existingData = $pemasukanModel->find($id);
    
        if (!$existingData) {
            return redirect()->back()->with('errors', ['error' => 'Data not found.']);
        }
    
        $fileName = $existingData['upload']; 
        $file = $this->request->getFile('upload');
    
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $filePath = FCPATH . 'uploads'; 
    
            $fileName = $file->getRandomName();
            if (!$file->move($filePath, $fileName)) {
                log_message('error', 'Failed to move uploaded file: ' . $file->getErrorString());
            }
        } elseif (!$file) {
            $fileName = $existingData['upload'];
        } else {
            log_message('error', 'Invalid file upload: ' . $file->getErrorString());
        }
    
        $data = [
            'product_id' => $this->request->getPost('product_id'),
            'price' => $this->request->getPost('price'),
            'quantity' => $this->request->getPost('quantity'),
            'date' => $this->request->getPost('date'),
            'supplier_id' => $this->request->getPost('supplier_id'),
            'customer_id' => $this->request->getPost('customer_id'),
            'user_id' => $this->request->getPost('user_id'),
            'upload' => $fileName,  
        ];
    
        log_message('debug', 'Data to update: ' . json_encode($data));
        
        if ($pemasukanModel->update($id, $data)) {
            $dataLaporan = [
                'product_id' => $this->request->getPost('product_id'),
                'parant_id' => $id,
                'quantity' => $this->request->getPost('quantity'),
                'user_id' => $this->request->getPost('user_id'),
                'from' => 'pengadaan-barang',
            ];
    
            $laporanModel = new Laporan();
            
            $laporanModel->where('parant_id', $id)->set($dataLaporan)->update();
    
            return redirect()->to('/pemasukan')->with('message', 'Data berhasil diupdate ');
        } else {
            return redirect()->back()->withInput()->with('errors', ['error' => 'Failed to update data in pemasukan.']);
        }
    }
    


    public function download($filename)
    {
        $filePath = FCPATH . 'uploads/' . $filename;

        if (file_exists($filePath)) {
            return $this->response->download($filePath, null)->setFileName($filename);
        } else {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }
    }

    public function delete($id)
    {
        $pemasukanModel = new ModelsPemasukan();
        $laporanModel = new Laporan();
        $existingData = $pemasukanModel->find($id);
    
        if (!$existingData) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Pemasukan tidak ditemukan.'
            ]);
        }
    
        $filePath = FCPATH . 'uploads/' . $existingData['upload'];
    
        try {
            if ($pemasukanModel->delete($id)) {
                if (file_exists($filePath)) {
                    unlink($filePath);
                }

                $laporanModel->where('parant_id', $id)->delete();

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Berhasil hapus data pemasukan.'
                ]);
            } else {
                throw new \Exception('Gagal menghapus data pemasukan.');
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    

    public function approveAdmin($id)
    {
        $pemasukanModel = new ModelsPemasukan();
        $existingData = $pemasukanModel->find($id);
    
        if ($existingData) {
            $dataToUpdate = ['status' => '1']; 
    
            if ($pemasukanModel->update($id, $dataToUpdate)) {
                return $this->response->setJSON(['success' => true]);
            } else {
                return $this->response->setJSON(['success' => false]);
            }
        } else {
            return $this->response->setJSON(['success' => false]);
        }
    }

    public function approveOwner($id)
    {
        $pemasukanModel = new ModelsPemasukan();
        $existingData = $pemasukanModel->find($id);
    
        if ($existingData) {
            $dataToUpdate = ['status' => '2']; 
    
            if ($pemasukanModel->update($id, $dataToUpdate)) {
                return $this->response->setJSON(['success' => true]);
            } else {
                return $this->response->setJSON(['success' => false]);
            }
        } else {
            return $this->response->setJSON(['success' => false]);
        }
    }
    

    public function saveQuantityReal()
    {
        $id = $this->request->getPost('id');
        $quantity = $this->request->getPost('quantity_real');

        if (empty($id) || empty($quantity)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'ID atau Quantity tidak boleh kosong.'
            ]);
        }

        $pemasukanModel = new ModelsPemasukan();
        $productModel = new Product(); 
        $laporanModel = new Laporan(); 

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $update = $pemasukanModel->update($id, ['quantity_real' => $quantity, 'status' => '3']);

            if (!$update) {
                throw new \Exception('Gagal menyimpan Quantity Real.');
            }

            $pemasukan = $pemasukanModel->find($id);
            $productId = $pemasukan['product_id']; 

            $product = $productModel->find($productId);
            if (!$product) {
                throw new \Exception('Produk tidak ditemukan.');
            }

            $newStock = $product['stock'] + $quantity;
            $productUpdateData = [
                'stock' => $newStock,
            ];

            $productUpdate = $productModel->update($productId, $productUpdateData);
            if (!$productUpdate) {
                throw new \Exception('Gagal memperbarui stok produk.');
            }

            $laporanUpdate = $db->table('laporan')
                ->where('parant_id', $id)
                ->update(['quantity' => $quantity]);

            if (!$laporanUpdate) {
                throw new \Exception('Gagal memperbarui quantity di tabel laporan.');
            }

            $db->transCommit();

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Cek quantity real berhasil.'
            ]);
        } catch (\Exception $e) {
            $db->transRollback();

            return $this->response->setJSON([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }




}
