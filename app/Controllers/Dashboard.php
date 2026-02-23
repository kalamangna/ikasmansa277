<?php

namespace App\Controllers;

use App\Models\DashboardModel;

class Dashboard extends BaseController
{
    protected $dashboardModel;

    public function __construct()
    {
        $this->dashboardModel = new DashboardModel();
    }

    public function index($menit_reload = null): string
    {
        $data = [
            'title'                => 'Dashboard Data Alumni',
            'total_angkatan'       => $this->dashboardModel->getTotalAngkatan(),
            'alumni_per_angkatan'  => $this->dashboardModel->getAlumniCountByAngkatan(),
            'alumni_per_jurusan'   => $this->dashboardModel->getAlumniCountByJurusan(),
            'gender_perangkatan'   => $this->dashboardModel->getGenderCountPerAngkatan(),
            'gender_total'         => $this->dashboardModel->getGenderCountTotal(),
            'alumni_per_kabupaten' => $this->dashboardModel->getAlumniPerKabupaten(),
            'alumni_per_pekerjaan' => $this->dashboardModel->getTotalAlumniPerPekerjaan(),
            'alumni_tercepat'      => $this->dashboardModel->getAlumniFaster(),
            'alumni_terbaru'       => $this->dashboardModel->getAlumniRecent(),
            'get_admin_alumni'     => $this->dashboardModel->getAdminAlumni(),
            'get_referred_rank'    => $this->dashboardModel->getReferredRank(),
            'menit_reload'         => $menit_reload
        ];

        return $this->render('dashboard_view', $data);
    }
}
