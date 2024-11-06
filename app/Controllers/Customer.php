<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Customer as ModelsCustomer;
use CodeIgniter\HTTP\ResponseInterface;

class Customer extends BaseController
{
    public function index()
    {
        {
            $query = new ModelsCustomer();
            $customer = $query->orderBy('id', 'DESC')->findAll();
    
            $data = [
                'title' => 'Data Customer',
                'customers' => $customer,
            ];
            return view('customer/index', $data);    
        }
    }

    public function create()
    {
        $data = [
            'title' => 'Create Customer'
        ];

        return view('customer/form', $data);
    }

    public function store()
    {
        $rules = [
            'name' => 'required|min_length[3]|max_length[50]',
            'email' => 'required|valid_email',
            'address' => 'required|min_length[5]|max_length[255]',
        ];
    
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $customerModel = new ModelsCustomer();
        $customerModel->save([
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'address' => $this->request->getPost('address'),
        ]);

        return redirect()->to('/customer')->with('message', 'Customer successfully created.');
    
    }

    public function edit($id)
    {
        $customerModel = new ModelsCustomer();
        $customer = $customerModel->find($id);

        if (!$customer) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('customer not found');
        }

        $data = [
            'title' => 'Update Customer',
            'customer' => $customer
        ];

        return view('customer/form', $data); 
    }

    public function update($id)
    {
        $customerModel = new ModelsCustomer();
        $customer = $customerModel->find($id);
    
        if (!$customer) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('customer not found');
        }
    
        $rules = [
            'name' => 'required|min_length[3]|max_length[50]',
            'email' => 'required|valid_email',
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
    
        $customerModel->update($id, $data);
    
        return redirect()->to('/customer')->with('message', 'Customer successfully updated.');
    }

    public function delete($id)
    {
        $model = new ModelsCustomer();
    
        try {
            if ($model->delete($id)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Customer deleted successfully.'
                ]);
            } else {
                throw new \Exception('Failed to delete customer.');
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

}
