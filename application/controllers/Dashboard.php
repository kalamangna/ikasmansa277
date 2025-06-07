<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Dashboard_model');
    }

    public function index($menit_reload = null) {
        $data['title'] = 'Dashboard Data Alumni';
        $data['total_alumni'] = $this->Dashboard_model->getTotalAlumni();
        $data['total_angkatan'] = $this->Dashboard_model->get_total_angkatan();
        $data['alumni_per_angkatan'] = $this->Dashboard_model->getAlumniCountByAngkatan();
        $data['alumni_per_jurusan'] = $this->Dashboard_model->getAlumniCountByJurusan();
        $data['gender_perangkatan'] = $this->Dashboard_model->get_gender_count_per_angkatan();
        $data['gender_total'] = $this->Dashboard_model->get_gender_count_total();
        $data['alumni_per_kabupaten'] = $this->Dashboard_model->get_alumni_per_kabupaten();
        $data['alumni_per_pekerjaan'] = $this->Dashboard_model->get_total_alumni_per_pekerjaan();
        $data['alumni_tercepat'] = $this->Dashboard_model->get_alumni_faster();
        $data['get_referred_rank'] = $this->Dashboard_model->get_referred_rank();


        $data['menit_reload'] = $menit_reload;

        $this->load->view('template/header', $data);
        $this->load->view('dashboard_view', $data);
        $this->load->view('template/footer', $data);
    }
}