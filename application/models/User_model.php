<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function cek_login($email, $password) {
        // Cari user berdasarkan email
        $this->db->where('email', $email);
        $query = $this->db->get('users');

        if($query->num_rows() == 1) {
            $user = $query->row();

            // Verifikasi password (asumsi password sudah di-hash dengan password_hash)
            if (password_verify($password, $user->password_hash)) {
                return $user;
            }
        }
        return false;
    }

    public function update_user($id, $data) {


        $this->db->where('alumni_id', $id);
        return $this->db->update('users', $data);
    }
    

    
}
