<?php

namespace App\Controllers;

use App\Controllers\BaseController;
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
            'upload' => 'uploaded[upload]|max_size[upload,2048]|ext_in[upload,pdf,doc,docx,jpg,jpeg,png]'
        ]);
    
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

    
        $fileName = null; 
        $file = $this->request->getFile('upload');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // $filePath = WRITEPATH . 'uploads';
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
            'quantity' => $this->request->getPost('quantity'),
            'date' => $this->request->getPost('date'),
            'supplier_id' => $this->request->getPost('supplier_id'),
            'customer_id' => $this->request->getPost('customer_id'),
            'user_id' => $this->request->getPost('user_id'),
            'upload' => isset($fileName) ? $fileName : null,  
        ];
    
        log_message('debug', 'Data to insert: ' . json_encode($data));
    
        $pemasukanModel = new ModelsPemasukan();
        if ($pemasukanModel->insert($data)) {
            return redirect()->to('/pemasukan')->with('message', 'Data berhasil disimpan.');
        } else {
            return redirect()->back()->withInput()->with('errors', ['error' => 'Failed to save data.']);
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
    
        // Handle file upload
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
            return redirect()->to('/pemasukan')->with('message', 'Data berhasil diupdate.');
        } else {
            return redirect()->back()->withInput()->with('errors', ['error' => 'Failed to update data.']);
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
            $dataToUpdate = ['status' => 1]; 
    
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
        $productModel = new Product();
    
        $existingData = $pemasukanModel->find($id);
    
        if (!$existingData) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Pemasukan tidak ditemukan.'
            ]);
        }
    
        $dataToUpdate = [
            'status' => 2, 
        ];
    
        $db = \Config\Database::connect();
        $db->transBegin();
    
        try {
            if (!$pemasukanModel->update($id, $dataToUpdate)) {
                throw new \Exception('Gagal mengupdate status pemasukan.');
            }
    
            $productId = $existingData['product_id'];
            $quantityToAdd = $existingData['quantity']; 
    
            $product = $productModel->find($productId);
            if (!$product) {
                throw new \Exception('Produk tidak ditemukan.');
            }
    
            $newStock = $product['stock'] + $quantityToAdd;
            $productUpdateData = [
                'stock' => $newStock,
            ];
    
            if (!$productModel->update($productId, $productUpdateData)) {
                throw new \Exception('Gagal mengupdate stok produk.');
            }
    
            $db->transCommit();
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Berhasil approve data pemasukan dan stock berhasil diperbarui.'
            ]);
    
        } catch (\Exception $e) {
            $db->transRollback();
            return $this->response->setJSON([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    

    
    
    

    

}
