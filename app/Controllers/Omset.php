<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Omset as ModelsOmset;
use App\Models\Stock;
use App\Models\Users;
use CodeIgniter\HTTP\ResponseInterface;

class Omset extends BaseController
{
    public function index()
    {
        $query = new ModelsOmset();
        $omset = $query->getProduct();
        $totalOmset = array_sum(array_column($omset, 'omset'));


        $userModel = new Users();
        $petugas = $userModel->getPetugas();

        $data = [
            'title' => 'Laporan Omset',
            'omsets' => $omset,
            'petugas' => $petugas,
            'totalOmset' => $totalOmset,
        ];
        return view('laporan/omset', $data);   
    }

    public function filter()
    {
        $omsetModel = new ModelsOmset();
        $startDate = $this->request->getGet('startDate');
        $endDate = $this->request->getGet('endDate');
        $petugasId = $this->request->getGet('petugasId');
        $type = $this->request->getGet('type');

        $query = $omsetModel->select('date, product_id, quantity, omset, type');

        $query = $omsetModel->select('laporan.*, product.name as product_name')
                                ->join('product', 'product.id = laporan.product_id');

        if ($startDate) {
            $query->where('date >=', $startDate);
        }
        if ($endDate) {
            $query->where('date <=', $endDate);
        }
        if ($petugasId) {
            $query->where('user_id', $petugasId);
        }
        if ($type) {
            $query->where('type', $type);
        }

        $omsets = $query->findAll();

        $totalOmset = array_sum(array_column($omsets, 'omset'));

        return $this->response->setJSON([
            'data' => $omsets,
            'totalOmset' => $totalOmset,
        ]);
    }
}
