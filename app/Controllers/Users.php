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

    public function edit($id)
    {
        $userModel = new ModelsUsers();
        $users = $userModel->find($id);

        if (!$users) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('user not found');
        }

        $data = [
            'title' => 'Update User',
            'users' => $users
        ];

        return view('users/form', $data); 
    }


    public function update($id)
    {
        $userModel = new ModelsUsers();
        $users = $userModel->find($id);

        if (!$users) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('User not found');
        }

        $rules = [
            'username' => 'required|min_length[3]|max_length[50]',
            'email' => 'required|valid_email',
            'active' => 'required',
            'role' => 'required',
        ];

        if ($this->request->getPost('password_hash')) {
            $rules['password_hash'] = 'required|min_length[8]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'active' => $this->request->getPost('active'),
            'role' => $this->request->getPost('role'),
        ];

        if ($password = $this->request->getPost('password_hash')) {
            $data['password_hash'] = password_hash($password, PASSWORD_DEFAULT);
        }

        if ($userModel->update($id, $data)) {
            return redirect()->to('/users')->with('message', 'User successfully updated.');
        } else {
            return redirect()->back()->withInput()->with('errors', 'Failed to update user.');
        }
    }


    public function delete($id)
    {
        $usersModel = new ModelsUsers();
        if ($usersModel->delete($id)) {
            return redirect()->to('/users')->with('message', 'users deleted successfully.');
        } else {
            return redirect()->to('/users')->with('error', 'Failed to delete users.');
        }
    }
}
