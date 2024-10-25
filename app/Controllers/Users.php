<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Users as ModelsUsers;
use CodeIgniter\HTTP\ResponseInterface;

class Users extends BaseController
{
    public function index()
    {
        $query = new ModelsUsers();
        $users = $query->findAll();

        $data = [
            'title' => 'Data User',
            'users' => $users,
        ];
        return view('users/index', $data);    
    }
}
