<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Profile extends BaseController
{
    public function index()
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }
        $user = user();
        $data = [
            'title' => 'Profile',
            'user'  => $user, 

        ];
        return view('profile/index', $data);   
    }

    public function gantiPassword()
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }
        $user = user();
        $data = [
            'title' => 'Ganti Password',
            'profile'  => $user, 

        ];
        return view('profile/ganti_password', $data);   
    }

    public function updatePassword()
    {
        if (!logged_in()) {
            return redirect()->to('/login');
        }

        $validation = \Config\Services::validation();
        
        $validation->setRules([
            'current_password' => 'required',
            'new_password' => 'required|min_length[8]',
            'confirm_password' => 'required|matches[new_password]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('error', $validation->listErrors());
        }
        

        $user = user();
        $currentPassword = trim($this->request->getVar('current_password')); 
        $newPassword = $this->request->getVar('new_password');
        

        if (!password_verify($currentPassword, $user->password_hash)) {
            return redirect()->back()->with('error', 'Current password is incorrect.');
        }

        // Update the password
        $userModel = new \Myth\Auth\Models\UserModel();
        $user->password_hash = password_hash($newPassword, PASSWORD_DEFAULT); 
        $userModel->save($user);

        return redirect()->to('/dahsboard')->with('success', 'Password successfully updated.');
    }

}
