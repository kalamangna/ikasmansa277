<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends CI_Controller {
    public function __construct() {
        parent::__construct();
        // $this->load->model('Page_model');
    }

	public function update($id) {
	    $this->load->library('form_validation');
	    $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
	    if ($this->input->post('password')) {
	        $this->form_validation->set_rules('password', 'Password', 'min_length[6]');
	        $this->form_validation->set_rules('password_confirm', 'Konfirmasi Password', 'matches[password]');
	    }

	    if ($this->form_validation->run() == FALSE) {
	        // Load form edit dengan error validasi
	        $data['user'] = $this->User_model->get_user($id);
	        $this->load->view('template/header');
	        $this->load->view('user_edit', $data);
	        $this->load->view('template/footer');
	    } else {
	        $update_data = [
	            'email' => $this->input->post('email'),
	        ];

	        if ($this->input->post('password')) {
	            $update_data['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
	        }

	        // Jika user adalah admin, update role juga
	        if ($this->session->userdata('role') == 'admin') {
	            $update_data['role'] = $this->input->post('role');
	        }

        $this->User_model->update_user($id, $update_data);
        $this->session->set_flashdata('success', 'Data user berhasil diperbarui.');
        redirect('user/edit/'.$id);
    }
}

}