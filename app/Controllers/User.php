<?php

namespace App\Controllers;

use App\Models\UserModel;

class User extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function update(int $id)
    {
        $rules = [
            'email' => 'required|valid_email',
        ];

        if ($this->request->getPost('password')) {
            $rules['password']         = 'min_length[6]';
            $rules['password_confirm'] = 'matches[password]';
        }

        if (!$this->validate($rules)) {
            $data = [
                'user'  => $this->userModel->getUserByEmail(session()->get('email')), // Assuming current user or lookup by ID
                'title' => 'Edit User'
            ];
            return $this->render('user_edit', $data);
        }

        $updateData = [
            'email' => $this->request->getPost('email'),
        ];

        if ($this->request->getPost('password')) {
            $updateData['password_hash'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        if (session()->get('role') === 'admin') {
            $updateData['role_id'] = $this->request->getPost('role_id');
        }

        $this->userModel->updateUser($id, $updateData);
        session()->setFlashdata('success', 'Data user berhasil diperbarui.');
        
        return redirect()->to('user/edit/' . $id);
    }
}
