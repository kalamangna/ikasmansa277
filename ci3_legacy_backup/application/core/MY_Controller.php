<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Base Controller
 */
class MY_Controller extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper(['url', 'form', 'security']);
        $this->load->library(['session', 'form_validation']);
        $this->load->model('User_model');
    }

    protected function render($view, $data = []) {
        $this->load->view('template/layout', array_merge($data, ['content' => $this->load->view($view, $data, TRUE)]));
    }
}

/**
 * Public Controller (Accessible by everyone)
 */
class Public_Controller extends MY_Controller {
    public function __construct() {
        parent::__construct();
    }
}

/**
 * Auth Controller (For Login/Register pages if needed)
 */
class Auth_Controller extends MY_Controller {
    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }
    }
}

/**
 * Private Controller (Requires Login)
 */
class Private_Controller extends MY_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }
}

/**
 * Admin Controller (Requires Admin Role)
 */
class Admin_Controller extends Private_Controller {
    public function __construct() {
        parent::__construct();
        // Check if user has admin role (assuming role_id 1 is Super Admin, 2 is Admin)
        $role = $this->session->userdata('role');
        if (!in_array($role, ['admin', 'admin_angkatan', 'super_admin'])) { // Adjust roles based on your logic
            show_error('You do not have permission to access this page.', 403, 'Forbidden');
        }
    }
}
