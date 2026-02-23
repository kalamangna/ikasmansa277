<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AlumniModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    protected $alumniModel;
    protected $userModel;

    public function __construct()
    {
        $this->alumniModel = new AlumniModel();
        $this->userModel   = new UserModel();
    }

    public function index(): string
    {
        $data = [
            'title' => 'Admin Dashboard',
            'stats' => [
                'total_alumni' => $this->alumniModel->countAllAlumni(),
            ]
        ];
        
        return $this->render('admin/dashboard', $data);
    }
}