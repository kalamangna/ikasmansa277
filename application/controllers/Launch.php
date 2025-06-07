<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Launch extends CI_Controller {
    
    private $duration = 600; // Durasi dalam detik (10 menit)
    
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('launch_model');
    }
    
    public function index() {
        $sesi = $this->session->userdata();
        $launch_data = $this->launch_model->get_launch_data();
        // print_r($sesi);die();

        if(!$launch_data) {
            // redirect('launch/control');
            $this->load->view('template/header');
            $this->load->view('launch/notyet');
            $this->load->view('template/footer');            
        } else {
            $current_time = time();
            $launch_start = strtotime($launch_data->start_time);
            $launch_end = $launch_start + $this->duration;

            $data['referral_code'] = $referral_code = $this->input->get('ut');
            $data['provinsi'] = $this->Alumni_model->get_provinsi();
            $data['pekerjaan_list'] = $this->Alumni_model->get_pekerjaan_grouped();

            $data['kabupaten'] = [];
            $data['ajax_kabupaten'] = true;

            if ($current_time >= $launch_start && $current_time <= $launch_end) {
                $this->load->view('template/header');
                $this->load->view('launch/form_pendataan',$data);
                $this->load->view('template/footer');              
            } 
            elseif ($current_time < $launch_start) {
                $this->load->view('template/header');
                $this->load->view('launch/notyet');
                $this->load->view('template/footer');              }
            else {
                $this->load->view('template/header');
                $this->load->view('launch/end');
                $this->load->view('template/footer');            
            }
        }
    }
    
    public function qr_link() {
        $sesi = $this->session->userdata();
        $launch_data = $this->launch_model->get_launch_data();
        // print_r($sesi);die();

        if(!$launch_data) {
            redirect('launch');
        } else {
            $current_time = time();
            $launch_start = strtotime($launch_data->start_time);
            $launch_end = $launch_start + $this->duration;
            
            if ($current_time >= $launch_start && $current_time <= $launch_end) {
                $this->load->view('template/header');
                $this->load->view('launch/qr_link');
                $this->load->view('template/footer');            
            } 
            elseif ($current_time < $launch_start) {
                $this->load->view('template/header');
                $this->load->view('launch/notyet');
                $this->load->view('template/footer');              }
            else {
                $this->load->view('template/header');
                $this->load->view('launch/end');
                $this->load->view('template/footer');            
            }
        }
    }
    
    public function notyet() {

    }
 
    public function control() {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login'); // arahkan ke halaman login jika belum login
        }        
        // Jika tombol start ditekan
        // print_r($this->input->post());die();
        if($this->input->post('start_launch')) {
            $start_time = date('Y-m-d H:i:s');

            $this->launch_model->set_launch_data($start_time);
            
            $this->session->set_flashdata('success', 'Pendataan telah dimulai!');
            redirect('launch/qr_link');
        }
        
        $data['duration'] = $this->duration;
        $data['launch_data'] = $this->launch_model->get_launch_data();
        $this->load->view('launch/control', $data);
    }
    
    public function submit() {
        // Proses form submission
        $this->session->set_flashdata('success', 'Data berhasil disimpan!');
        redirect('launch/qr_link');
    }
    
    public function check_status() {
        $launch_data = $this->launch_model->get_launch_data();
        $current_time = time();
        $launch_start = strtotime($launch_data->start_time);
        
        header('Content-Type: application/json');
        if ($current_time >= $launch_start) {
            echo json_encode([
                'status' => 'ready', 
                'redirect' => site_url('launch')
            ]);
        } else {
            echo json_encode([
                'status' => 'wait', 
                'time_left' => $launch_start - $current_time
            ]);
        }
    }
    
    private function _show_waiting_page($time_left) {
        $data['time_left'] = $time_left;
        $this->load->view('launch/waiting', $data);
    }
public function get_remaining_time() {
    $launch_data = $this->launch_model->get_launch_data();
    
    if(!$launch_data) {
        show_error('Pendataan belum dimulai', 400);
    }
    
    $current_time = time();
    $end_time = strtotime($launch_data->start_time) + $this->duration;
    $remaining = $end_time - $current_time;
    
    header('Content-Type: application/json');
    echo json_encode([
        'remaining' => $remaining > 0 ? $remaining : 0,
        'is_active' => $remaining > 0
    ]);
}

}