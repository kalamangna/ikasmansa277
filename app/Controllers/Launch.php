<?php

namespace App\Controllers;

use App\Models\LaunchModel;
use App\Models\AlumniModel;

class Launch extends BaseController
{
    private $duration = 600; // Durasi dalam detik (10 menit)
    protected $launchModel;
    protected $alumniModel;

    public function __construct()
    {
        $this->launchModel = new LaunchModel();
        $this->alumniModel = new AlumniModel();
    }

    public function index(): string
    {
        $launchData = $this->launchModel->getLaunchData();

        if (!$launchData) {
            return $this->render('launch/notyet');
        }

        $currentTime = time();
        $launchStart = strtotime($launchData->start_time);
        $launchEnd   = $launchStart + $this->duration;

        $data = [
            'referral_code'  => $this->request->getGet('ut'),
            'provinsi'       => $this->alumniModel->get_provinsi(),
            'pekerjaan_list' => $this->alumniModel->get_all_pekerjaan(),
            'kabupaten'      => [],
            'ajax_kabupaten' => true,
        ];

        if ($currentTime >= $launchStart && $currentTime <= $launchEnd) {
            return $this->render('launch/form_pendataan', $data);
        } elseif ($currentTime < $launchStart) {
            return $this->render('launch/notyet', $data);
        } else {
            return $this->render('launch/end', $data);
        }
    }

    public function qr_link()
    {
        $launchData = $this->launchModel->getLaunchData();

        if (!$launchData) {
            return redirect()->to('launch');
        }

        $currentTime = time();
        $launchStart = strtotime($launchData->start_time);
        $launchEnd   = $launchStart + $this->duration;

        if ($currentTime >= $launchStart && $currentTime <= $launchEnd) {
            return $this->render('launch/qr_link');
        } elseif ($currentTime < $launchStart) {
            return $this->render('launch/notyet');
        } else {
            return $this->render('launch/end');
        }
    }

    public function control()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('auth/login');
        }

        if ($this->request->getPost('start_launch')) {
            $startTime = date('Y-m-d H:i:s');
            $this->launchModel->setLaunchData($startTime);
            session()->setFlashdata('success', 'Pendataan telah dimulai!');
            return redirect()->to('launch/qr_link');
        }

        $data = [
            'duration'    => $this->duration,
            'launch_data' => $this->launchModel->getLaunchData()
        ];
        return view('launch/control', $data);
    }

    public function submit()
    {
        session()->setFlashdata('success', 'Data berhasil disimpan!');
        return redirect()->to('launch/qr_link');
    }

    public function check_status()
    {
        $launchData = $this->launchModel->getLaunchData();
        $currentTime = time();
        $launchStart = strtotime($launchData->start_time);

        return $this->response->setJSON([
            'status'   => ($currentTime >= $launchStart) ? 'ready' : 'wait',
            'redirect' => ($currentTime >= $launchStart) ? site_url('launch') : null,
            'time_left' => ($currentTime < $launchStart) ? $launchStart - $currentTime : 0
        ]);
    }

    public function get_remaining_time()
    {
        $launchData = $this->launchModel->getLaunchData();

        if (!$launchData) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Pendataan belum dimulai']);
        }

        $currentTime = time();
        $endTime     = strtotime($launchData->start_time) + $this->duration;
        $remaining   = $endTime - $currentTime;

        return $this->response->setJSON([
            'remaining' => $remaining > 0 ? $remaining : 0,
            'is_active' => $remaining > 0
        ]);
    }
}
