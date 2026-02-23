<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Login Process
     */
    public function login(): ResponseInterface|string
    {
        if ($this->request->is('post')) {
            $email    = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $user = $this->userModel->checkLogin($email, $password);

            if ($user) {
                // Get full details for session population
                $details = $this->userModel->getUserFullDetails($email);

                $sessionData = [
                    'logged_in'    => true,
                    'user_id'      => $user->id_user,
                    'email'        => $user->email,
                    'role_id'      => $user->role_id,
                    'role'         => $details->role ?? 'member',
                    'id_alumni'    => $details->id_alumni ?? null,
                    'nama_lengkap' => $details->nama_lengkap ?? null,
                    'angkatan'     => $details->angkatan ?? null,
                    'referral'     => $details->referral ?? null,
                    'foto_profil'  => $details->foto_profil ?? null,
                ];

                session()->set($sessionData);

                return redirect()->to('dashboard');
            }

            return $this->render('login_view', [
                'error' => 'Email atau password salah.'
            ]);
        }

        // Render login form
        return $this->render('login_view');
    }

    /**
     * Logout Process
     */
    public function logout(): ResponseInterface
    {
        session()->destroy();
        return redirect()->to('auth/login');
    }
}