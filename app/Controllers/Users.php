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

    public function delete($id)
    {
        $usersModel = new ModelsUsers();
        if ($usersModel->delete($id)) {
            return redirect()->to('/users')->with('success', 'users deleted successfully.');
        } else {
            return redirect()->to('/users')->with('error', 'Failed to delete users.');
        }
    }
}
