<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qr_code_model extends CI_Model {

    // public function insert_qr_code($data) {
    //     return $this->db->insert('qr_codes', $data);
    // }

    public function get_all_qr_codes() {
        return $this->db->get('qr_codes')->result();
    }

	// public function get_by_content($content) {
	//     return $this->db->get_where('qr_codes', ['content' => $content])->row();
	// }





public function get_by_content($content) {
    return $this->db->get_where('qr_codes', ['content' => $content])->row();
}

public function insert_qr_code($data) {
    return $this->db->insert('qr_codes', $data);
}

}


