<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Counter extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Counter_model');
    }

    public function is_logged_in() {
        $is_logged_in = $this -> session -> userdata('is_logged_in');
        if (!isset($is_logged_in) || $is_logged_in != true) {
          header('Location: ' . (base_url("/user/login/")));
            } else {

        if ($this -> session -> userdata('jabatan_atasan_id') != '1000083' OR $this -> session -> userdata('jabatan_id') == '1000083') {
            header('Location: ' . (base_url("/dashboard/larangan")));
            }
        }

  }


public function index() {
    // $this->is_logged_in();
    $selected_year = $this->input->get('tahun') ? $this->input->get('tahun') : date('Y');
    
    $data = array(
        'hidden_counter' => true,
        'total_visits' => $this->Counter_model->get_total_visits(),
        'unique_visits' => $this->Counter_model->get_unique_visits(),
        'daily_stats' => $this->Counter_model->get_daily_stats(),
        'recent_visits' => $this->Counter_model->get_recent_visits(),
        'available_years' => $this->Counter_model->get_available_years(),
        'selected_year' => $selected_year,
        'monthly_stats' => $this->Counter_model->get_monthly_stats($selected_year),
        'os_stats' => $this->Counter_model->get_os_stats($selected_year),
        'browser_stats' => $this->Counter_model->get_browser_stats($selected_year),
        'top_pages' => $this->Counter_model->get_top_pages($selected_year) // Tambah ini
    );
    
    $this->load->view('template/header');
    $this->load->view('counter/dashboard', $data);
    $this->load->view('template/footer');
}
    // Function to track visit (called from footer)


public function track_visit() {
    // Skip tracking if accessing counter dashboard

    $current_uri = $this->input->server('REQUEST_URI');

    // if (strpos($current_uri, 'counter') !== false) {
    //     echo 'SKIP_COUNTER_PAGE';
    //     exit;
    // }

    $ip = $this->input->ip_address();
    $user_agent = $this->input->user_agent();
    $page_visited = $current_uri;
    
    $is_unique_today = $this->Counter_model->is_unique_visit_today($ip);
    
    $data = array(
        'ip_address' => $ip,
        'user_agent' => $user_agent,
        'page_visited' => $page_visited
    );
    

    // print_r($data);die();

    $this->Counter_model->log_visit($data);
    $this->Counter_model->update_daily_counter(date('Y-m-d'), $is_unique_today);
    
    // Return minimal response
    echo 'OK';
    exit;
}

}