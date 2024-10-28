<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Supplier as ModelsSupplier;
use CodeIgniter\HTTP\ResponseInterface;

class Supplier extends BaseController
{
    public function index()
    {
        $query = new ModelsSupplier();
        $supplier = $query->orderBy('id', 'DESC')->findAll();

        $data = [
            'title' => 'Data Supplier',
            'suppliers' => $supplier,
        ];
        return view('supplier/index', $data);    
    }

    public function create()
    {
        $data = [
            'title' => 'Create Supplier'
        ];

        return view('supplier/form', $data);
    }

    public function store()
    {
        $rules = [
            'name' => 'required|min_length[3]|max_length[50]',
            'email' => 'required|valid_email',
            'phone' => 'required|numeric',
            'address' => 'required|min_length[5]|max_length[255]',
        ];
    
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $supplierModel = new ModelsSupplier();
        $supplierModel->save([
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
        ]);

        return redirect()->to('/supplier')->with('message', 'Supplier successfully created.');
    
    }

    public function edit($id)
    {
        $supplierModel = new ModelsSupplier();
        $supplier = $supplierModel->find($id);

        if (!$supplier) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('supplier not found');
        }

        $data = [
            'title' => 'Update Supplier',
            'supplier' => $supplier
        ];

        return view('supplier/form', $data); 
    }

    public function update($id)
    {
        $supplierModel = new ModelsSupplier();
        $supplier = $supplierModel->find($id);
    
        if (!$supplier) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Supplier not found');
        }
    
        $rules = [
            'name' => 'required|min_length[3]|max_length[50]',
            'email' => 'required|valid_email',
            'phone' => 'required|numeric',
            'address' => 'required|min_length[5]|max_length[255]',
        ];
    
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
    
        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
        ];
    
        $supplierModel->update($id, $data);
    
        return redirect()->to('/supplier')->with('message', 'Supplier successfully updated.');
    }

    public function delete($id)
    {
        $supplierModel = new ModelsSupplier();
        if ($supplierModel->delete($id)) {
            return redirect()->to('/supplier')->with('message', 'Supplier deleted successfully.');
        } else {
            return redirect()->to('/supplier')->with('error', 'Failed to delete supplier.');
        }
    }
    
    

    


}
