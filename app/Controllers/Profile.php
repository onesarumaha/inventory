<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Users;
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
        
        if (!$this->validate($validation->getRules())) {
            return redirect()->back()->withInput()->with('error', 'Please check your input fields.');
        }

        $userModel = new Users();
        $user = $userModel->find(session()->get('id'));
        
        if (!password_verify($this->request->getPost('current_password'), $user['password_hash'])) {
            return redirect()->back()->with('error', 'Current password is incorrect.');
        }

        $newPasswordHash = password_hash($this->request->getPost('new_password'), PASSWORD_DEFAULT);

        $userModel->update(session()->get('id'), ['password_hash' => $newPasswordHash]);

        return redirect()->to('/profile')->with('success', 'Password updated successfully.');

    }

    public function updatePhoto()
    {
        if ($this->request->isAJAX()) {
            $response = ['success' => false, 'message' => ''];
    
            $userId = session()->get('id');
    
            if (!$userId) {
                $response['message'] = 'ID pengguna tidak ditemukan. Pastikan Anda sudah login.';
                return $this->response->setJSON($response);
            }
    
            $file = $this->request->getFile('photos');
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                if (!in_array($file->getExtension(), $allowedExtensions)) {
                    $response['message'] = 'File yang diunggah harus berupa JPG, JPEG, PNG, atau GIF.';
                } else {
                    $newName = $file->getRandomName();
    
                    $userModel = new Users();
                    $user = $userModel->find($userId);
                    $oldPhoto = $user['photos'];
    
                    if ($file->move(WRITEPATH . '../public/uploads/', $newName)) {
                        if ($oldPhoto && file_exists(WRITEPATH . '../public/uploads/' . $oldPhoto)) {
                            unlink(WRITEPATH . '../public/uploads/' . $oldPhoto);
                        }
                        $userModel->update($userId, ['photos' => $newName]);
    
                        $response['success'] = true;
                        $response['message'] = 'Foto berhasil diperbarui.';
                        $response['photos'] = $newName;
                    } else {
                        $response['message'] = 'Gagal memindahkan file yang diunggah.';
                    }
                }
            } else {
                $response['message'] = 'Tidak ada file yang diunggah atau file tidak valid.';
            }
    
            return $this->response->setJSON($response);
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Halaman tidak ditemukan');
        }
    }
    

}
