<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Product as ModelsProduct;
use CodeIgniter\HTTP\ResponseInterface;

class Product extends BaseController
{
    public function index()
    {
        {
            $query = new ModelsProduct();
            $product = $query->orderBy('id', 'DESC')->findAll();
    
            $data = [
                'title' => 'Data Product',
                'products' => $product,
            ];
            return view('product/index', $data);    
        }
    }

    public function create()
    {
        $data = [
            'title' => 'Create Product'
        ];

        return view('product/form', $data);
    }

    public function store()
    {
        $rules = [
            'name' => 'required|min_length[3]|max_length[50]',
            'sku' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'description' => 'required|min_length[5]|max_length[255]',
        ];
    
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $productModel = new ModelsProduct();
        $productModel->save([
            'name' => $this->request->getPost('name'),
            'sku' => $this->request->getPost('sku'),
            'price' => $this->request->getPost('price'),
            'stock' => $this->request->getPost('stock'),
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to('/product')->with('message', 'Product successfully created.');
    
    }

    public function edit($id)
    {
        $productModel = new ModelsProduct();
        $product = $productModel->find($id);

        if (!$product) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('product not found');
        }

        $data = [
            'title' => 'Update Product',
            'product' => $product
        ];

        return view('product/form', $data); 
    }

    public function update($id)
    {
        $productModel = new ModelsProduct();
        $product = $productModel->find($id);
    
        if (!$product) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Product not found');
        }
    
        $rules = [
            'name' => 'required|min_length[3]|max_length[50]',
            'sku' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'description' => 'required|min_length[5]|max_length[255]',
        ];
    
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
    
        $data = [
            'name' => $this->request->getPost('name'),
            'sku' => $this->request->getPost('sku'),
            'price' => $this->request->getPost('price'),
            'stock' => $this->request->getPost('stock'),
            'description' => $this->request->getPost('description'),
        ];
    
        $productModel->update($id, $data);
    
        return redirect()->to('/product')->with('message', 'Product successfully updated.');
    }

    public function delete($id)
    {
        $productModel = new ModelsProduct();
        if ($productModel->delete($id)) {
            return redirect()->to('/product')->with('messageDelete', 'Product deleted successfully.');
        } else {
            return redirect()->to('/product')->with('error', 'Failed to delete product.');
        }
    }

}
