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

public function update_alumni($id_alumni, $data) {
    $this->db->where('id_alumni', $id_alumni);
    return $this->db->update('alumni', $data);
}

public function insert_alumni($data) {
    $this->db->trans_start();
    
    // $tanggal_input = $data['tanggal_lahir'];
    // $tanggal_mysql = date('Y-m-d', strtotime(str_replace('-', '/', $tanggal_input)));
    

    $tanggal_input = $data['tanggal_lahir'];
    list($day, $month, $year) = explode('-', $tanggal_input);
    $tanggal_mysql = "$year-$month-$day";


    // Simpan data alumni - ADD foto_path HERE
    $alumni_data = [
        'nama_lengkap' => $data['nama_lengkap'],
        'tempat_lahir' => $data['tempat_lahir'],
        'tanggal_lahir' => $tanggal_mysql,
        'jenis_kelamin' => $data['jenis_kelamin'],
        'nama_panggilan' => $data['nama_panggilan'],            
        'alamat_domisili' => $data['alamat_domisili'],
        'provinsi_id' => $data['provinsi_id'],
        'kabupaten_id' => $data['kabupaten_id'],
        'no_telepon' => $data['no_telepon'],
        'foto_profil' => isset($data['foto_profil']) ? $data['foto_profil'] : null, // Add this line
        'referred_by' => isset($data['referred_by']) ? $data['referred_by'] : null
    ];

    // print_r($alumni_data);die();
    $this->db->insert('alumni', $alumni_data);
    $alumni_id = $this->db->insert_id();

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


    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
        return false;
    } else {
        return $alumni_id;
    }
}

    public function insert_user($data) {
        // Skip jika email kosong (sebagai backup)
        if (empty($data['email'])) return true;
        
        // Cek duplikat
        if ($this->db->get_where('users', ['email' => $data['email']])->row()) {
            return false;
        }
        
        return $this->db->insert('users', $data);
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
        // $this->db->distinct();
        // $this->db->select('pendidikan.angkatan');
        // $this->db->from('pendidikan');
        // $this->db->order_by('pendidikan.angkatan', 'ASC');
        // $query = $this->db->get();
        // return $query->result_array();

        $this->db->select('
            pendidikan.angkatan,
            SUM(CASE WHEN alumni.jenis_kelamin = "Laki-laki" THEN 1 ELSE 0 END) AS jumlah_laki_laki,
            SUM(CASE WHEN alumni.jenis_kelamin = "Perempuan" THEN 1 ELSE 0 END) AS jumlah_perempuan

        ');
            // COUNT(*) AS total_semua
        $this->db->from('alumni');
        $this->db->join('pendidikan', 'pendidikan.alumni_id like alumni.id_alumni');
        $this->db->group_by('pendidikan.angkatan');
        $this->db->order_by('pendidikan.angkatan', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

        // Ambil alumni berdasarkan angkatan
    public function get_alumni_by_angkatan($angkatan) 
    {
        $this->db->select('alumni.*, pendidikan.angkatan, pendidikan.jurusan, provinsi.nama_provinsi as provinsi, kabupaten.nama_kabupaten as kabupaten,
            (SELECT COUNT(A2.id_alumni) FROM alumni A2 WHERE A2.referred_by = alumni.id_alumni) AS ref_jumlah 
            ');
        $this->db->from('alumni');
        $this->db->join('pendidikan', 'pendidikan.alumni_id like alumni.id_alumni');
        $this->db->join('provinsi', 'alumni.provinsi_id = provinsi.id_provinsi');
        $this->db->join('kabupaten', 'alumni.kabupaten_id = kabupaten.id_kabupaten');        
        $this->db->where('pendidikan.angkatan', $angkatan);
        $this->db->order_by('alumni.nama_lengkap', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }        

    public function search_alumni_by_name($keyword) 
    {
        $this->db->select('alumni.*, pendidikan.angkatan, pendidikan.jurusan, provinsi.nama_provinsi as provinsi, kabupaten.nama_kabupaten as kabupaten,
            (SELECT COUNT(A2.id_alumni) FROM alumni A2 WHERE A2.referred_by = alumni.id_alumni) AS ref_jumlah');
        $this->db->from('alumni');
        $this->db->join('pendidikan', 'pendidikan.alumni_id = alumni.id_alumni');
        $this->db->join('provinsi', 'alumni.provinsi_id = provinsi.id_provinsi');
        $this->db->join('kabupaten', 'alumni.kabupaten_id = kabupaten.id_kabupaten');
        
        // Pencarian dengan LIKE untuk partial matching
        $this->db->like('alumni.nama_lengkap', $keyword);
        
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
        $this->db->order_by('alumni.created_at', 'ASC');
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
            'updated_at' => date('Y-m-d H:i:s')
            // 'email' => $data['email'],
            // 'referred_by' => isset($data['referred_by']) ? $data['referred_by'] : null

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
        // $user_data = [
        //     'email' => $data['email']
        // ];
        // if (!empty($data['password'])) {
        //     $user_data['password_hash'] = password_hash($data['password'], PASSWORD_DEFAULT);
        // }
        // $this->db->where('alumni_id', $id);
        // $this->db->update('users', $user_data);

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
    public function total_angkatan($angkatan) {
        $this->db->select('COUNT(*) as jml');
        $this->db->where('angkatan', $angkatan);
        $this->db->join('pendidikan', 'pendidikan.alumni_id = alumni.id_alumni');
        $query = $this->db->get('alumni')->row();
        return $query ? $query->jml : 0;
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

 public function hapus_alumni($id_alumni) {

    
    $this->db->trans_start();
    
    // Proses penghapusan database
    $tables = ['pekerjaan', 'pendidikan', 'keterangan_tambahan', 'users', 'alumni'];
               
    foreach ($tables as $table) {
        $field = ($table == 'alumni') ? 'id_alumni' : 'alumni_id';
        $this->db->where($field, $id_alumni);
        $this->db->delete($table);
    }
    
    $this->db->trans_complete();
    
    if ($this->db->trans_status()) {
        
        return true;
    }
    
    return false;
}
    // Function untuk mendapatkan data alumni sebelum dihapus (opsional)
    public function get_alumni_data($id_alumni) {
        $this->db->where('id_alumni', $id_alumni);
        return $this->db->get('alumni')->row();
    }



    public function get_alumni_dobel($banyak=10) {
        $query = $this -> db -> query("
            SELECT alumni.nama_lengkap,alumni.alamat_domisili, count(alumni.id_alumni) as jml 
            FROM alumni 
            GROUP BY alumni.nama_lengkap,alumni.alamat_domisili 
            ORDER BY jml DESC 
            LIMIT $banyak;
                ");
        return $query -> result();
    }


    public function get_dobel_data($nama_lengkap=null, $alamat_domisili=null) 
    {
        $this->db->select('alumni.*, pendidikan.angkatan, pendidikan.jurusan, 
            (SELECT COUNT(A2.id_alumni) FROM alumni A2 WHERE A2.referred_by = alumni.id_alumni) AS ref_jumlah 
            ');
        $this->db->from('alumni');
        $this->db->join('pendidikan', 'pendidikan.alumni_id = alumni.id_alumni');
        $this->db->where('alumni.nama_lengkap', $nama_lengkap);
        $this->db->where('alumni.alamat_domisili', $alamat_domisili);
        $this->db->order_by('alumni.id_alumni', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }        



}
