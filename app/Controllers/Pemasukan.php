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
        $query = new ModelsPemasukan();
        $pemasukan = $query->orderBy('id', 'DESC')->findAll();

        $data = [
            'title' => 'Data pemasukan',
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
            $filePath = WRITEPATH . 'uploads';
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


    public function download($filename)
    {
        $filePath = WRITEPATH . 'uploads/' . $filename;

        if (file_exists($filePath)) {
            return $this->response->download($filePath, null)->setFileName($filename);
        } else {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }
    }
    

    

}
