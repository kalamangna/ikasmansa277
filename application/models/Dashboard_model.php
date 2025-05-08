<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this -> load -> database();        
        $this->load->library('session');
        $this->load->helper(array('form', 'url'));

    }

    // Menghitung total alumni
    public function getTotalAlumni() {
        return $this->db->count_all('alumni');
    }

    public function get_total_angkatan()
    {
        $this->db->select('COUNT(DISTINCT angkatan) AS total_angkatan');
        $query = $this->db->get('pendidikan');
        return $query->row()->total_angkatan;
    }
    // Menghitung jumlah alumni per angkatan
    public function getAlumniCountByAngkatan() {
        $this->db->select('angkatan as angkatan, COUNT(*) as jumlah_alumni');
        $this->db->group_by('angkatan');
        $this->db->order_by('angkatan', 'ASC');
        $query = $this->db->get('pendidikan');
        return $query->result();
    }

    // Menghitung jumlah alumni per jurusan
    public function getAlumniCountByJurusan() {
        $this->db->select('jurusan, COUNT(*) as jumlah_alumni');
        $this->db->group_by('jurusan');
        $this->db->order_by('jumlah_alumni', 'DESC');
        $query = $this->db->get('pendidikan');
        return $query->result();
    }

    // Menghitung jumlah alumni berdasarkan status pekerjaan (misal: bekerja, wirausaha, belum bekerja)
    public function getAlumniCountByStatusPekerjaan() {
        $this->db->select('pekerjaan, COUNT(*) as jumlah_alumni');
        $this->db->group_by('pekerjaan');
        $query = $this->db->get('alumni');
        return $query->result();
    }


    // public function get_gender_count_per_angkatan()
    // {
    //     $this->db->select('pendidikan.angkatan, alumni.jenis_kelamin, COUNT(*) as jumlah');
    //     $this->db->from('alumni');
    //     $this->db->join('pendidikan', 'pendidikan.alumni_id = alumni.id_alumni');
    //     $this->db->group_by(['pendidikan.angkatan', 'alumni.jenis_kelamin']);
    //     $this->db->order_by('pendidikan.angkatan', 'ASC');
    //     $this->db->order_by('pendidikan.jenis_kelamin', 'ASC');
    //     $query = $this->db->get();
    //     return $query->result();
    // }
    public function get_gender_count_per_angkatan()
    {
        $this->db->select('
            pendidikan.angkatan,
            SUM(CASE WHEN alumni.jenis_kelamin = "Laki-laki" THEN 1 ELSE 0 END) AS jumlah_laki_laki,
            SUM(CASE WHEN alumni.jenis_kelamin = "Perempuan" THEN 1 ELSE 0 END) AS jumlah_perempuan
        ');
        $this->db->from('alumni');
        $this->db->join('pendidikan', 'pendidikan.alumni_id = alumni.id_alumni');
        $this->db->group_by('pendidikan.angkatan');
        $this->db->order_by('pendidikan.angkatan', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }
    public function get_gender_count_total()
    {
    $this->db->select('
        SUM(CASE WHEN jenis_kelamin = "Laki-laki" THEN 1 ELSE 0 END) AS total_laki_laki,
        SUM(CASE WHEN jenis_kelamin = "Perempuan" THEN 1 ELSE 0 END) AS total_perempuan
    ');
    $query = $this->db->get('alumni');
    return $query->row();
    }

    public function get_alumni_per_kabupaten()
    {
        $this->db->select('
            kabupaten.nama_kabupaten as nama_kabupaten,
            provinsi.nama_provinsi as nama_provinsi,
            COUNT(alumni.id_alumni) AS total_alumni
        ');
        $this->db->from('alumni');
        $this->db->join('kabupaten', 'alumni.kabupaten_id = kabupaten.id_kabupaten', 'left');
        $this->db->join('provinsi', 'kabupaten.id_provinsi = provinsi.id_provinsi', 'left');
        $this->db->group_by('kabupaten.id_kabupaten');
        $this->db->order_by('total_alumni', 'DESC');
        $this->db->order_by('nama_provinsi', 'DESC');
        $this->db->order_by('nama_kabupaten', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }


    public function get_total_alumni_per_pekerjaan()
    {
        $this->db->select('ref_pekerjaan.nama_pekerjaan, COUNT(pekerjaan.alumni_id) AS total_alumni');
        $this->db->from('pekerjaan');
        $this->db->join('ref_pekerjaan', 'pekerjaan.id_ref_pekerjaan = ref_pekerjaan.id_ref_pekerjaan');
        $this->db->group_by('ref_pekerjaan.nama_pekerjaan');
        $this->db->order_by('total_alumni', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }







}
