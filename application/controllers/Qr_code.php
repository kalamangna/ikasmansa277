<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qr_code extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('ciqrcode');
        $this->load->model('Qr_code_model');
    }

public function index() {
    $url = $this->input->get('url');
    if (!$url) {
        echo "Parameter 'url' tidak ditemukan.";
        return;
    }

    // Load model dan library
    $this->load->model('Qr_code_model');
    $this->load->library('ciqrcode');

    // Buat nama file unik berdasarkan hash URL
    $filename = 'qr_' . md5($url) . '.png';
    $folder = FCPATH . 'uploads/qr_code/';
    $filepath = $folder . $filename;

    // Pastikan folder ada
    if (!is_dir($folder)) {
        mkdir($folder, 0755, true);
    }

    // Cek apakah URL sudah ada di database
    $qr_data = $this->Qr_code_model->get_by_content($url);
    if ($qr_data && file_exists($filepath)) {
        // File ada, tampilkan langsung
        header('Content-Type: image/png');
        readfile($filepath);
        return;
    }

    // Jika belum ada atau file tidak ada, generate QR Code baru
    $params['data'] = $url;
    $params['level'] = 'H';
    $params['size'] = 10;
    $params['savename'] = $filepath;

    $this->ciqrcode->generate($params);

    // Simpan data ke database jika belum ada
    if (!$qr_data) {
        $data_db = [
            'content' => $url,
            'filename' => $filename
        ];
        $this->Qr_code_model->insert_qr_code($data_db);
    }
    // print_r($data_db); die();

    // Tampilkan gambar yang baru dibuat
    header('Content-Type: image/png');
    readfile($filepath);
}


    // public function index() {
    //     $url = $this->input->get('url');
    //     if (!$url) {
    //         echo "Parameter 'url' tidak ditemukan.";
    //         return;
    //     }

    //     // Load model dan library
    //     $this->load->model('Qr_code_model');
    //     $this->load->library('ciqrcode');

    //     // Cek apakah URL sudah ada di database
    //     $qr_data = $this->Qr_code_model->get_by_content($url);

    //     if ($qr_data) {
    //         $filepath = FCPATH . 'uploads/' . $qr_data->filename;
    //         if (file_exists($filepath)) {
    //             // File ada, tampilkan langsung
    //             header('Content-Type: image/png');
    //             readfile($filepath);
    //             return;
    //         }
    //     }

    //     // Jika belum ada atau file tidak ada, generate QR Code baru
    //     $filename = 'qr_code_' . time() . '.png';
    //     $filepath = FCPATH . 'uploads/' . $filename;

    //     $params['data'] = $url;
    //     $params['level'] = 'H';
    //     $params['size'] = 10;
    //     $params['savename'] = $filepath;

    //     $this->ciqrcode->generate($params);

    //     // Simpan data ke database
    //     $data_db = [
    //         'content' => $url,
    //         'filename' => $filename
    //     ];
    //     $this->Qr_code_model->insert_qr_code($data_db);

    //     // Tampilkan gambar yang baru dibuat
    //     header('Content-Type: image/png');
    //     readfile($filepath);
    // }


    // public function index() {
    //     $url = $this->input->get('url');
    //     if (!$url) {
    //         echo "Parameter 'url' tidak ditemukan.";
    //         return;
    //     }

    // // Cek di database
    //     $qr_data = $this->Qr_code_model->get_by_content($url);

    //     if ($qr_data) {
    //         $filepath = FCPATH . 'uploads/' . $qr_data->filename;
    //         if (file_exists($filepath)) {
    //         // File ada, tampilkan langsung
    //             echo '<h3>QR Code untuk URL: ' . htmlspecialchars($url) . '</h3>';
    //             echo '<img src="' . base_url('uploads/' . $qr_data->filename) . '" />';
    //             return;
    //         }
    //     }

    // // Jika tidak ada data atau file tidak ada, generate baru
    //     $filename = 'qr_code_' . time() . '.png';
    //     $filepath = FCPATH . 'uploads/' . $filename;

    //     $params['data'] = $url;
    //     $params['level'] = 'H';
    //     $params['size'] = 10;
    //     $params['savename'] = $filepath;

    //     $this->ciqrcode->generate($params);

    // // Simpan ke database
    //     $data_db = [
    //         'content' => $url,
    //         'filename' => $filename
    //     ];
    //     $this->Qr_code_model->insert_qr_code($data_db);

    //     echo '<h3>QR Code untuk URL: ' . htmlspecialchars($url) . '</h3>';
    //     echo '<img src="' . base_url('uploads/' . $filename) . '" />';
    // }    

}
