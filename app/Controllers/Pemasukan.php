<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Pemasukan as ModelsPemasukan;
use App\Models\Supplier;
use CodeIgniter\HTTP\ResponseInterface;

class Pemasukan extends BaseController
{
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
        $customers = $supplierModel->findAll();

        $data = [
            'title' => 'Create Pemasukan',
            'customer' => $customers
        ];

        return view('pemasukan/form', $data);
    }
}
