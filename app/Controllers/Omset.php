<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Omset as ModelsOmset;
use CodeIgniter\HTTP\ResponseInterface;

class Omset extends BaseController
{
    public function index()
    {
        $query = new ModelsOmset();
        $omset = $query->orderBy('id', 'DESC')->findAll();

        $data = [
            'title' => 'Laporan Omset',
            'omsets' => $omset,
        ];
        return view('laporan/omset', $data);   
    }
}
