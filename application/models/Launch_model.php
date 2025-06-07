<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Launch_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function get_launch_data() {
        $query = $this->db->get('launch_settings');
        return $query->num_rows() > 0 ? $query->row() : false;
    }
    
    public function set_launch_data($start_time) {
        $data = array('start_time' => $start_time);
        
        if($this->db->count_all('launch_settings') > 0) {
            $this->db->update('launch_settings', $data);
        } else {
            $this->db->insert('launch_settings', $data);
        }
        
        return $this->db->affected_rows();
    }
    
    public function reset_launch() {
        $this->db->empty_table('launch_settings');
        return $this->db->affected_rows();
    }
}