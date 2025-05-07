<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // $this->load->model('User_model');
        // $this->load->library('session');
        // $this->load->helper(array('form', 'url'));
    }

    public function login() {
        if($this->input->post()) {
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $user = $this->User_model->cek_login($email, $password);

            if($user) {
                // Simpan data user ke session

                $alumni = $this->Alumni_model->get_alumni($user->alumni_id);

                $this->session->set_userdata('logged_in', 1);
                $this->session->set_userdata('id_alumni', $alumni->id_alumni);
                $this->session->set_userdata('nama_lengkap', $alumni->nama_lengkap);
                $this->session->set_userdata('angkatan', $alumni->angkatan);
                $this->session->set_userdata('referral', $alumni->referral);
                $this->session->set_userdata('user_id', $user->id_user);
                $this->session->set_userdata('email', $user->email);
                $this->session->set_userdata('role_id', $alumni->role_id);
                $this->session->set_userdata('role', $alumni->role);

                redirect('dashboard'); // Ganti dengan halaman setelah login
            } else {
                $data['error'] = "Email atau password salah.";
                $this->load->view('template/header');
                $this->load->view('login_view', $data);
                $this->load->view('template/footer');
            }
        } else {
            $this->load->view('template/header');
            $this->load->view('login_view');
            $this->load->view('template/footer');
        }
    }

    public function logout() {
        $this->session->unset_userdata('logged_in');
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}
