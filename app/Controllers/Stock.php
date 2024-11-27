<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Stock as ModelsStock;
use App\Models\Users;
use CodeIgniter\HTTP\ResponseInterface;

class Stock extends BaseController
{
    public function index()
    {
        $user = user(); 
        $role = $user->role; 
    
        if (!is_array($role)) {
            $role = [$role];
        }
    
        $query = new ModelsStock();
    
        if (in_array('petugas', $role)) {
            $stock = $query->getProductByPetugas($user->id);
        } else {
            $stock = $query->getProduct();
    
        }
    
        $userModel = new Users();
        $petugas = $userModel->getPetugas();
    
        $data = [
            'title' => 'Laporan Stock Barang',
            'stocks' => $stock,
            'petugas' => $petugas,
        ];
    
        return view('laporan/stock', $data);    
    }

    public function filter()
    {
        if ($this->request->isAJAX()) {
            $stockModel = new ModelsStock();
            $startDate = $this->request->getGet('startDate');
            $endDate = $this->request->getGet('endDate');
            $petugasId = $this->request->getGet('petugasId');
            $type = $this->request->getGet('type');
    
            $query = $stockModel->select('laporan.*, product.name as product_name')
                                ->join('product', 'product.id = laporan.product_id')
                                ->where('type', $type)
                                ->where('date >=', $startDate)
                                ->where('date <=', $endDate);
    
            if (!empty($petugasId) && $petugasId !== 'Pilih Petugas') {
                $query->where('user_id', $petugasId);
            }
    
            $filteredStocks = $query->findAll();
    
            return $this->response->setJSON($filteredStocks);
        }
    }
    


}
