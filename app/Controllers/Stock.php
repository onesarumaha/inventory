<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Stock as ModelsStock;
use CodeIgniter\HTTP\ResponseInterface;

class Stock extends BaseController
{
    public function index()
    {
        $query = new ModelsStock();
        $stock = $query->getProduct();

        $data = [
            'title' => 'Laporan Stock Barang',
            'stocks' => $stock,
        ];
        return view('laporan/stock', $data);    
    }
}
