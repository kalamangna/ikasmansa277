<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alumni_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this -> load -> database();
    }

    public function get_provinsi() {
        return $this->db->get('provinsi')->result();
    }

    public function get_kabupaten_by_provinsi($provinsi_id) {
        return $this->db->where('id_provinsi', $provinsi_id)->get('kabupaten')->result();
    }

    public function get_pekerjaan() {
        return $this->db->get('ref_pekerjaan')->result();
    }
 
    public function get_pekerjaan_grouped() {
        $this->db->order_by('grup_pekerjaan', 'ASC');
        $this->db->order_by('id_ref_pekerjaan', 'ASC');
        $query = $this->db->get('ref_pekerjaan');
        return $query->result();
    }
    
    public function generateReferralCode($userId) {
        $salt = "Rahasia123!"; // ganti dengan string rahasia Anda
        $raw = $userId . time() . $salt;
        $hash = substr(strtoupper(md5($raw)), 0, 8); // 8 karakter kode referral
        return $hash;
    }
    // Insert data alumni sekaligus user
    // public function insert_alumni_user($data) {
    //     $this->db->trans_start();

    //     // Simpan data alumni
    //     $alumni_data = [
    //         'nama_lengkap' => $data['nama_lengkap'],
    //         'tempat_lahir' => $data['tempat_lahir'],
    //         'tanggal_lahir' => $data['tanggal_lahir'],
    //         'jenis_kelamin' => $data['jenis_kelamin'],
    //         'nama_panggilan' => $data['nama_panggilan'],            
    //         'alamat_domisili' => $data['alamat_domisili'],
    //         'provinsi_id' => $data['provinsi_id'],
    //         'kabupaten_id' => $data['kabupaten_id'],
    //         'no_telepon' => $data['no_telepon'],
    //         // 'email' => $data['email'],
    //         'referred_by' => isset($data['referred_by']) ? $data['referred_by'] : null

    //     ];
    //     $this->db->insert('alumni', $alumni_data);
    //     $alumni_id = $this->db->insert_id();

    //     // Simpan data pendidikan
    //     $pendidikan_data = [
    //         'alumni_id' => $alumni_id,
    //         'angkatan' => $data['angkatan'],
    //         'jurusan' => $data['jurusan']
    //     ];
    //     $this->db->insert('pendidikan', $pendidikan_data);

    //     // Simpan data pekerjaan
    //     $pekerjaan_data = [
    //         'alumni_id' => $alumni_id,
    //         'id_ref_pekerjaan' => $data['id_ref_pekerjaan'],
    //         'nama_perusahaan' => $data['nama_perusahaan'],
    //         'jabatan' => $data['jabatan'],
    //         'alamat_kantor' => $data['alamat_kantor']
    //     ];
    //     $this->db->insert('pekerjaan', $pekerjaan_data);

    //     // Simpan keterangan tambahan
    //     $keterangan_data = [
    //         'alumni_id' => $alumni_id,
    //         'bergabung_komunitas' => isset($data['bergabung_komunitas']) ? 1 : 0,
    //         'partisipasi_kegiatan' => isset($data['partisipasi_kegiatan']) ? 1 : 0,
    //         'saran_masukan' => $data['saran_masukan']
    //     ];
    //     $this->db->insert('keterangan_tambahan', $keterangan_data);


    //     // Simpan data user untuk login
    //     $password_hash = password_hash($data['password'], PASSWORD_DEFAULT);
    //     $user_data = [
    //         'email' => $data['email'],
    //         'password_hash' => $password_hash,
    //         'role_id' => 5, // misal 5 = alumni
    //         'alumni_id' => $alumni_id
    //     ];
    //     $this->db->insert('users', $user_data);

    //     $this->db->trans_complete();

    //     if ($this->db->trans_status() === FALSE) {
    //         return false;
    //     } else {
    //         return $alumni_id;
    //     }
    // }

public function insert_alumni_user($data) {
    $this->db->trans_start();

    // Simpan data alumni
    $alumni_data = [
        'nama_lengkap' => $data['nama_lengkap'],
        'tempat_lahir' => $data['tempat_lahir'],
        'tanggal_lahir' => $data['tanggal_lahir'],
        'jenis_kelamin' => $data['jenis_kelamin'],
        'nama_panggilan' => $data['nama_panggilan'],            
        'alamat_domisili' => $data['alamat_domisili'],
        'provinsi_id' => $data['provinsi_id'],
        'kabupaten_id' => $data['kabupaten_id'],
        'no_telepon' => $data['no_telepon'],
        // 'email' => $data['email'],
        'referred_by' => isset($data['referred_by']) ? $data['referred_by'] : null
    ];
    $this->db->insert('alumni', $alumni_data);
    $alumni_id = $this->db->insert_id();

    // echo "$alumni_id"; die();
    // Upload dan validasi foto

    
    // if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
    //     $config['upload_path'] =  FCPATH . 'uploads/foto_alumni/';
    //     $config['allowed_types'] = 'jpg|jpeg|png';
    //     $config['max_size'] = 1024; // 1MB
    //     $config['encrypt_name'] = TRUE;

    //     // if (!is_dir($config['upload_path'])) {
    //     //     mkdir($config['upload_path'], 0755, true);
    //     // }

    //     $this->load->library('upload', $config);

    //     if (!$this->upload->do_upload('foto')) {
    //         // Jika gagal upload, batalkan transaksi dan return error
    //         $this->db->trans_rollback();
    //         return ['error' => $this->upload->display_errors()];
    //     }

    //     $upload_data = $this->upload->data();
    //     $image_path = $upload_data['full_path'];

    //     // Cek dimensi foto potrait
    //     list($width, $height) = getimagesize($image_path);
    //     if ($height <= $width) {
    //         // Bukan potrait, hapus file dan batalkan transaksi
    //         unlink($image_path);
    //         $this->db->trans_rollback();
    //         return ['error' => 'Foto harus berbentuk potrait (tinggi lebih besar dari lebar).'];
    //     }

    //     // Simpan nama file foto ke tabel alumni_foto
    //     $foto_data = [
    //         'id_alumni' => $alumni_id,
    //         'nama_file' => $upload_data['file_name']
    //     ];
    //     $this->db->insert('alumni_foto', $foto_data);
    // }

    // Simpan data pendidikan
    $pendidikan_data = [
        'alumni_id' => $alumni_id,
        'angkatan' => $data['angkatan'],
        'jurusan' => $data['jurusan']
    ];
    $this->db->insert('pendidikan', $pendidikan_data);

    // Simpan data pekerjaan
    $pekerjaan_data = [
        'alumni_id' => $alumni_id,
        'id_ref_pekerjaan' => $data['id_ref_pekerjaan'],
        'nama_perusahaan' => $data['nama_perusahaan'],
        'jabatan' => $data['jabatan'],
        'alamat_kantor' => $data['alamat_kantor']
    ];
    $this->db->insert('pekerjaan', $pekerjaan_data);

    // Simpan keterangan tambahan
    $keterangan_data = [
        'alumni_id' => $alumni_id,
        'bergabung_komunitas' => isset($data['bergabung_komunitas']) ? 1 : 0,
        'partisipasi_kegiatan' => isset($data['partisipasi_kegiatan']) ? 1 : 0,
        'saran_masukan' => $data['saran_masukan']
    ];
    $this->db->insert('keterangan_tambahan', $keterangan_data);

    // Simpan data user untuk login
    $password_hash = password_hash($data['password'], PASSWORD_DEFAULT);
    $user_data = [
        'email' => $data['email'],
        'password_hash' => $password_hash,
        'role_id' => 5, // misal 5 = alumni
        'alumni_id' => $alumni_id
    ];
    $this->db->insert('users', $user_data);

    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
        return false;
    } else {
        return $alumni_id;
    }
}
   



    public function get_alumni_by_referral($referral_code) {
        return $this->db->get_where('alumni', ['referral' => $referral_code])->row();
    }

    // Ambil data alumni lengkap berdasarkan id
    public function get_alumni($id) {

        $alumni = $this->db->get_where('alumni', ['id_alumni' => $id])->row();


        if ($alumni && empty($alumni->referral)) {
            // Generate kode referral baru
            $referral_code = $this->generateReferralCode($alumni->id_alumni);
            // Update kolom referral di database
            $this->db->where('id_alumni', $alumni->id_alumni);
            $this->db->update('alumni', ['referral' => $referral_code]);
            // Update objek alumni agar kode referral terbaru tersedia
            $alumni->referral = $referral_code;
        }

        $this->db->select('alumni.*, pendidikan.angkatan, pendidikan.jurusan, pekerjaan.nama_perusahaan, pekerjaan.id_pekerjaan, ref_pekerjaan.id_ref_pekerjaan, pekerjaan.jabatan, ref_pekerjaan.nama_pekerjaan, pekerjaan.alamat_kantor, keterangan_tambahan.bergabung_komunitas, keterangan_tambahan.partisipasi_kegiatan, roles.nama_role as role, keterangan_tambahan.saran_masukan, provinsi.nama_provinsi as provinsi, kabupaten.nama_kabupaten as kabupaten, users.role_id, users.email  ');
        $this->db->from('alumni');
        $this->db->join('users', 'users.alumni_id = alumni.id_alumni', 'left');
        $this->db->join('pendidikan', 'pendidikan.alumni_id = alumni.id_alumni', 'left');
        $this->db->join('pekerjaan', 'pekerjaan.alumni_id = alumni.id_alumni', 'left');
        $this->db->join('ref_pekerjaan', 'ref_pekerjaan.id_ref_pekerjaan = pekerjaan.id_ref_pekerjaan', 'left');
        $this->db->join('keterangan_tambahan', 'keterangan_tambahan.alumni_id = alumni.id_alumni', 'left');
        $this->db->join('roles', 'roles.id_role = users.role_id', 'left');
        $this->db->join('provinsi', 'alumni.provinsi_id = provinsi.id_provinsi');
        $this->db->join('kabupaten', 'alumni.kabupaten_id = kabupaten.id_kabupaten');        
        $this->db->where('alumni.id_alumni', $id);
        return $this->db->get()->row();
    }
    public function get_all_angkatan()
    {
        $this->db->distinct();
        $this->db->select('pendidikan.angkatan');
        $this->db->from('pendidikan');
        $this->db->order_by('pendidikan.angkatan', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
        // Ambil alumni berdasarkan angkatan
    public function get_alumni_by_angkatan($angkatan)
    {
        $this->db->select('alumni.*, pendidikan.angkatan, pendidikan.jurusan, provinsi.nama_provinsi as provinsi, kabupaten.nama_kabupaten as kabupaten');
        $this->db->from('alumni');
        $this->db->join('pendidikan', 'pendidikan.alumni_id = alumni.id_alumni');
        $this->db->join('provinsi', 'alumni.provinsi_id = provinsi.id_provinsi');
        $this->db->join('kabupaten', 'alumni.kabupaten_id = kabupaten.id_kabupaten');        
        $this->db->where('pendidikan.angkatan', $angkatan);
        $this->db->order_by('alumni.nama_lengkap', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }        

    // Ambil alumni berdasarkan referral
    public function get_alumni_by_referred_by($id_alumni)
    {
        $this->db->select('alumni.*, pendidikan.angkatan, pendidikan.jurusan, provinsi.nama_provinsi as provinsi, kabupaten.nama_kabupaten as kabupaten');
        $this->db->from('alumni');
        $this->db->join('pendidikan', 'pendidikan.alumni_id = alumni.id_alumni');
        $this->db->join('provinsi', 'alumni.provinsi_id = provinsi.id_provinsi');
        $this->db->join('kabupaten', 'alumni.kabupaten_id = kabupaten.id_kabupaten');        
        $this->db->where('alumni.referred_by', $id_alumni);
        $this->db->order_by('pendidikan.angkatan', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }
    // Update data alumni dan user
    public function update_alumni_user($id, $data) {
        $this->db->trans_start();

        // Update tabel alumni
        $alumni_data = [
            'nama_lengkap' => $data['nama_lengkap'],
            'tempat_lahir' => $data['tempat_lahir'],
            'jenis_kelamin' => $data['jenis_kelamin'],
            'nama_panggilan' => $data['nama_panggilan'],
            'tanggal_lahir' => $data['tanggal_lahir'],
            'alamat_domisili' => $data['alamat_domisili'],
            'provinsi_id' => $data['provinsi_id'],
            'kabupaten_id' => $data['kabupaten_id'],
            'no_telepon' => $data['no_telepon'],
            'email' => $data['email'],
            'referred_by' => isset($data['referred_by']) ? $data['referred_by'] : null

        ];
        $this->db->where('id_alumni', $id);
        $this->db->update('alumni', $alumni_data);

        // Update pendidikan
        $pendidikan_data = [
            'angkatan' => $data['angkatan'],
            'jurusan' => $data['jurusan']
        ];
        $this->db->where('alumni_id', $id);
        $this->db->update('pendidikan', $pendidikan_data);

        // Update pekerjaan
        $pekerjaan_data = [
            'id_ref_pekerjaan' => $data['id_ref_pekerjaan'],
            'nama_perusahaan' => $data['nama_perusahaan'],
            'jabatan' => $data['jabatan'],
            'alamat_kantor' => $data['alamat_kantor']
        ];
        $this->db->where('id_pekerjaan', $id_pekerjaan);
        $this->db->update('pekerjaan', $pekerjaan_data);

        // Update keterangan tambahan
        $keterangan_data = [
            'bergabung_komunitas' => isset($data['bergabung_komunitas']) ? 1 : 0,
            'partisipasi_kegiatan' => isset($data['partisipasi_kegiatan']) ? 1 : 0,
            'saran_masukan' => $data['saran_masukan']
        ];
        $this->db->where('alumni_id', $id);
        $this->db->update('keterangan_tambahan', $keterangan_data);

        // Update user (email dan password jika diisi)
        $user_data = [
            'email' => $data['email']
        ];
        if (!empty($data['password'])) {
            $user_data['password_hash'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        $this->db->where('alumni_id', $id);
        $this->db->update('users', $user_data);

        $this->db->trans_complete();

        return ($this->db->trans_status() !== FALSE);
    }

    public function formatTanggalIndo($tanggal) {
        $bulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
            4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September',
            10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        $parts = explode('-', $tanggal);
        if(count($parts) !== 3) {
            return $tanggal; // Jika format tidak sesuai, kembalikan apa adanya
        }
        $tahun = $parts[0];
        $bulanIndex = (int)$parts[1];
        $hari = $parts[2];
        return ltrim($hari, '0') . ' ' . $bulan[$bulanIndex] . ' ' . $tahun;
    }

    public function get_urutan_alumni($id) {
        $this->db->select('COUNT(*) as urutan');
        $this->db->where('id_alumni <=', $id);
        $query = $this->db->get('alumni')->row();
        return $query ? $query->urutan : 0;
    }

    // Total alumni yang sudah melakukan pendataan
    public function get_total_alumni() {
        return $this->db->count_all('alumni');
    }

    // Urutan alumni dari angkatan yang sama berdasarkan id_alumni
    public function get_urutan_alumni_angkatan($angkatan, $id) {
        $this->db->select('COUNT(*) as urutan');
        $this->db->where('angkatan', $angkatan);
        $this->db->where('id_alumni <=', $id);
        $this->db->join('pendidikan', 'pendidikan.alumni_id = alumni.id_alumni');
        $query = $this->db->get('alumni')->row();
        return $query ? $query->urutan : 0;
    }

    public function get_urutan_alumni_all($angkatan, $id) {
        $this->db->select('COUNT(*) as urutan');
        $this->db->where('id_alumni <=', $id);
        $this->db->join('pendidikan', 'pendidikan.alumni_id = alumni.id_alumni');
        $query = $this->db->get('alumni')->row();
        return $query ? $query->urutan : 0;
    }


}
