<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Customer;
use App\Models\Transaksi as ModelsTransaksi;
use CodeIgniter\HTTP\ResponseInterface;

class Transaksi extends BaseController
{
    public function index()
    {
        $query = new ModelsTransaksi();
        $pengeluaran = $query->orderBy('id', 'DESC')->findAll();

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

        $data = [
            'title' => 'Create Pengeluaran',
            'customer' => $customers
        ];

        return view('pengeluaran/form', $data);
    }
}
