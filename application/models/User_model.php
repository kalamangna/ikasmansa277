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
    

public function insert_user($data) {
    // Skip jika email kosong
    if (empty($data['email'])) {
        return true;
    }
    
    // Cek duplikat email
    $exists = $this->db->get_where('users', ['email' => $data['email']])->row();
    if ($exists) {
        return false;
    }
    
    return $this->db->insert('users', $data);
}


    
    public function get_user($email) {

        // $alumni = $this->db->get_where('alumni', ['id_alumni' => $id])->row();


        // if ($alumni && empty($alumni->referral)) {
        //     // Generate kode referral baru
        //     $referral_code = $this->generateReferralCode($alumni->id_alumni);
        //     // Update kolom referral di database
        //     $this->db->where('id_alumni', $alumni->id_alumni);
        //     $this->db->update('alumni', ['referral' => $referral_code]);
        //     // Update objek alumni agar kode referral terbaru tersedia
        //     $alumni->referral = $referral_code;
        // }

        $this->db->select('users.*, roles.nama_role as role');
        $this->db->join('roles', 'roles.id_role = users.role_id', 'left');
        $this->db->from('users');
        $this->db->where('users.email', $email);
        return $this->db->get()->row();
    }   
    public function get_user_all($email) {

        // $alumni = $this->db->get_where('alumni', ['id_alumni' => $id])->row();


        // if ($alumni && empty($alumni->referral)) {
        //     // Generate kode referral baru
        //     $referral_code = $this->generateReferralCode($alumni->id_alumni);
        //     // Update kolom referral di database
        //     $this->db->where('id_alumni', $alumni->id_alumni);
        //     $this->db->update('alumni', ['referral' => $referral_code]);
        //     // Update objek alumni agar kode referral terbaru tersedia
        //     $alumni->referral = $referral_code;
        // }

        $this->db->select('users.*, roles.nama_role as role, alumni.*, pendidikan.angkatan, pendidikan.jurusan, pekerjaan.nama_perusahaan, pekerjaan.id_pekerjaan, ref_pekerjaan.id_ref_pekerjaan, pekerjaan.jabatan, ref_pekerjaan.nama_pekerjaan, pekerjaan.alamat_kantor, keterangan_tambahan.bergabung_komunitas, keterangan_tambahan.partisipasi_kegiatan, keterangan_tambahan.saran_masukan, provinsi.nama_provinsi as provinsi, kabupaten.nama_kabupaten as kabupaten');
        $this->db->from('users');
        $this->db->join('roles', 'roles.id_role = users.role_id', 'left');
        $this->db->join('alumni', 'users.alumni_id = alumni.id_alumni', 'left');
        $this->db->join('pendidikan', 'pendidikan.alumni_id = alumni.id_alumni', 'left');
        $this->db->join('pekerjaan', 'pekerjaan.alumni_id = alumni.id_alumni', 'left');
        $this->db->join('ref_pekerjaan', 'ref_pekerjaan.id_ref_pekerjaan = pekerjaan.id_ref_pekerjaan', 'left');
        $this->db->join('keterangan_tambahan', 'keterangan_tambahan.alumni_id = alumni.id_alumni', 'left');
        $this->db->join('provinsi', 'alumni.provinsi_id = provinsi.id_provinsi');
        $this->db->join('kabupaten', 'alumni.kabupaten_id = kabupaten.id_kabupaten');        
        $this->db->where('users.email', $email);
        return $this->db->get()->row();
    }
    
}
