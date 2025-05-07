<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pages extends CI_Controller {
    public function __construct() {
        parent::__construct();
        // $this->load->model('Page_model');
    }

    public function index($slug = 'home') {
        $data['page'] = $this->Page_model->get_page_by_slug($slug);
        // print_r($data); die();
        if (empty($data['page'])) {
            show_404();
        }

        $data['title'] = $data['page']['title'];

        $this->load->view('template/header', $data);
        $this->load->view('page_view', $data);
        $this->load->view('template/footer', $data);
    }
}
