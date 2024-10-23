<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardContoller extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard',
        ];
        return view('layout/header', $data)
        . view('layout/sidebar')
        . view('layout/topbar')
        . view('dashboard/index')
        . view('layout/footer');    
    }
    
}
