<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alumni extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Alumni_model');
        $this->load->library('session', 'upload','form_validation');
        $this->load->helper('url', 'form');
    }

    private function tkn($id=0)
    {
        $tkn = md5((int)$id + (int)date("Ymd"));
    }


    public function index()
    {
        $user_role = $this->session->userdata('role');
        $user_angkatan = $this->session->userdata('angkatan');
        $id_alumni = $this->session->userdata('id_alumni');

        // Ambil angkatan yang dipilih dari dropdown (hanya untuk admin)
        $selected_angkatan = $this->input->get('angkatan');

        // Jika bukan admin, paksa angkatan sesuai user login
        if ($user_role != 'admin') {
            $selected_angkatan = $user_angkatan;
        } else {
            // Jika admin belum memilih angkatan, default ke angkatan user (atau bisa default semua)
            if (!$selected_angkatan) {
                $selected_angkatan = $user_angkatan;
            }
        }

        // Ambil daftar angkatan untuk dropdown (hanya untuk admin)
        $angkatan_list = [];
        if ($user_role == 'admin') {
            $angkatan_list = $this->Alumni_model->get_all_angkatan();
        }


        $is_admin = false;
        if ($this->session->userdata('logged_in')) {
            if (
                $user_role == "admin" || // admin super
                ($user_role == 'admin_angkatan' && $user_angkatan == $selected_angkatan) // admin angkatan sama
            ) 
            {
                $is_admin = true;
            }
        }
        $data['is_admin'] = $is_admin;

        // Ambil data alumni berdasarkan angkatan yang dipilih
        $data['alumni_list'] = $this->Alumni_model->get_alumni_by_angkatan($selected_angkatan);
        $data['selected_angkatan'] = $selected_angkatan;
        $data['angkatan_list'] = $angkatan_list;
        $data['user_role'] = $user_role;

        $this->load->view('template/header');
        $this->load->view('alumni/list', $data);
        $this->load->view('template/footer');
    }

   public function get_kabupaten_ajax() {
    $provinsi_id = $this->input->post('provinsi_id');
    if (!$provinsi_id) {
        echo json_encode([]);
        return;
    }
    $kabupaten = $this->Alumni_model->get_kabupaten_by_provinsi($provinsi_id);
    echo json_encode($kabupaten);
    } 

    public function create() {

        $data['referral_code'] = $referral_code = $this->input->get('ut');
        $data['provinsi'] = $this->Alumni_model->get_provinsi();
        $data['pekerjaan_list'] = $this->Alumni_model->get_pekerjaan_grouped();

        $data['kabupaten'] = [];
        $data['ajax_kabupaten'] = true;


        $this->load->view('template/header');

        $referral_owner = $this->Alumni_model->get_alumni_by_referral($referral_code);
        // print_r($referral_owner);

        if (!$referral_owner) {
            $this->session->set_flashdata('error', 'Kode referral tidak valid.');
            echo "Alamat tidak valid";
        } else {
        $data['referred_by'] = $referral_owner->id_alumni;
        $this->load->view('alumni/form', $data);
        }
        $this->load->view('template/footer', $data);
    }

public function save() {
    $post = $this->input->post();


    $last_input = $this->session->userdata('last_alumni_input');
    if ($last_input && 
        $last_input['nama'] == $post['nama_lengkap'] && 
        (time() - $last_input['time']) < 1800) { // 30 menit
        $this->session->set_flashdata('error', 'Anda sudah menginput data dengan nama ini dalam 30 menit terakhir');
        redirect('alumni/create');
        return;
    }


    // Handle photo upload
    $photo_path = '';
    if (!empty($_FILES['foto']['name'])) {
        $upload_path = FCPATH . 'uploads/foto_alumni/';

        $config = [
            'upload_path'   => $upload_path,
            'allowed_types' => 'gif|jpg|jpeg|png|webp',
            'max_size'      => 10240, // 10MB
            'file_name'     => 'alumni_'.$post['nama_lengkap'].'_'.time(),
            'overwrite'     => false
        ];
        
        $this->load->library('upload', $config);
        
        if ($this->upload->do_upload('foto')) {
            $upload_data = $this->upload->data();
            $photo_path = 'uploads/foto_alumni/'.$upload_data['file_name'];

            // Resize image
            $this->load->library('image_lib');
            $resize_config = [
                'image_library'  => 'gd2',
                'source_image'   => $upload_data['full_path'],
                'maintain_ratio' => true,
                'width'          => 800,
                'height'         => 800,
                'quality'        => '85%'
            ];
            
            $this->image_lib->initialize($resize_config);
            $this->image_lib->resize();
            $this->image_lib->clear();
        } else {
            $this->session->set_flashdata('error', $this->upload->display_errors());
            redirect('alumni/create?ut='.$this->input->get('ut'));
            return;
        }
    }
    
    // Add photo path to post data
    $post['foto_profil'] = isset($upload_data) ? $upload_data['file_name'] : '';

    // Save alumni data (tanpa user jika email kosong)
    $email = trim($post['email']);
    $password = trim($post['password']);
    
    // Hapus email dan password dari $post agar tidak masuk ke tabel alumni
    unset($post['email']);
    unset($post['password']);
    
    // Simpan data alumni utama
    $alumni_id = $this->Alumni_model->insert_alumni($post);
    
    if (!$alumni_id) {
        // Clean up uploaded file if save failed
        if (!empty($photo_path) && file_exists(FCPATH.$photo_path)) {
            unlink(FCPATH.$photo_path);
        }
        $this->session->set_flashdata('error', 'Gagal menyimpan data alumni.');
        redirect('alumni/create?ut='.$this->input->get('ut'));
        return;
    }
    
    if (!$alumni_id) {
        if (!empty($photo_path)) {
            @unlink(FCPATH.$photo_path);
        }
        $this->session->set_flashdata('error', 'Gagal menyimpan data alumni');
        redirect('alumni/create?ut='.$this->input->get('ut'));
        return;
    }

    // Hanya buat user jika email dan password diisi
    if (!empty($email) && !empty($password)) {
        // Cek apakah email sudah ada
        $existing = $this->db->get_where('users', ['email' => $email])->row();
        if ($existing) {
            // Hapus data alumni yang sudah tersimpan
            $this->Alumni_model->hapus_alumni($alumni_id);
            if (!empty($photo_path) && file_exists(FCPATH.$photo_path)) {
                unlink(FCPATH.$photo_path);
            }
            
            $this->session->set_flashdata('error', 'Email sudah digunakan, silakan gunakan email lain.');
            redirect('alumni/create?ut='.$this->input->get('ut'));
            return;
        }
        
    if (!empty(trim($post['email']))) {
        $user_data = [
            'email' => trim($post['email']),
            'password_hash' => password_hash($post['password'], PASSWORD_BCRYPT),
            'role_id' => 5, // role alumni
            'alumni_id' => $alumni_id
        ];
        
        if (!$this->User_model->insert_user($user_data)) {
            $this->Alumni_model->delete_alumni($alumni_id);
            if (!empty($photo_path)) {
                @unlink(FCPATH.$photo_path);
            }
            $this->session->set_flashdata('error', 'Email sudah digunakan');
            redirect('alumni/create?ut='.$this->input->get('ut'));
            return;
            }
        }
        
        $user_id = $this->User_model->insert_user($user_data);
        
        if (!$user_id) {
            // Hapus data alumni jika gagal buat user
            $this->Alumni_model->delete_alumni($alumni_id);
            if (!empty($photo_path) && file_exists(FCPATH.$photo_path)) {
                unlink(FCPATH.$photo_path);
            }
            
            $this->session->set_flashdata('error', 'Gagal membuat akun pengguna.');
            redirect('alumni/create?ut='.$this->input->get('ut'));
            return;
        }
    }
    
    // Jika berhasil
    $this->session->set_userdata('last_alumni_input', [
        'nama' => $post['nama_lengkap'],
        'time' => time()
    ]);

    $referral = $post['referred_by'] ?? '';
    $this->session->set_flashdata('success', 'Data alumni berhasil disimpan.');

    // $message = 'Pendataan '. $post['nama_lengkap'] .' angkatan '.$post['angkatan'].' berhasil !!';
    $message = '<b><u>#INPUT DATA ALUMNI</u></b>' . "\n" .
               '🟢 <b>Status:</b> BERHASIL' . "\n" .
               '👨‍🎓 <b>Nama:</b> <i>' . htmlspecialchars($post['nama_lengkap']) . '</i>' . "\n" .
               '📌 <b>Angkatan:</b> <code>' . $post['angkatan'] . '</code>' . "\n" .
               '⏱ <i>Waktu: ' . date('d/m/Y H:i:s') . '</i>';
    $kirim_tele = $this->send_telegram_message($message);
    // print_r($kirim_tele); die();


    redirect('alumni/detail/'.$alumni_id.'?ut='.$referral);
}

    public function detail($id) {


        $data['alumni'] = $alumni = $this->Alumni_model->get_alumni($id);

        // print_r($data); die();   
        if(!$data['alumni']) {
            show_404();
        }
        $data['urutan_alumni'] = $this->Alumni_model->get_urutan_alumni($id);
        $data['total_alumni'] = $this->Alumni_model->get_total_alumni();
        $data['urutan_angkatan'] = $this->Alumni_model->get_urutan_alumni_angkatan($data['alumni']->angkatan, $id);
        $data['urutan_alumni'] = $this->Alumni_model->get_urutan_alumni_all($data['alumni']->angkatan, $id);
        $data['get_alumni_by_referred_by'] = $this->Alumni_model->get_alumni_by_referred_by($id);
        $data['foto'] = $this->Alumni_foto_model->get_foto_by_alumni($id);

  
        $user = $this->session->userdata(); // misal ['role_id' => ..., 'alumni_id' => ..., 'angkatan' => ...]
        // Ambil data alumni yang sedang dilihat, termasuk angkatannya
        $alumni_angkatan = $alumni->angkatan; // pastikan data angkatan sudah tersedia di objek $alumni

        // print_r($alumni);

        $bisa_edit = false;
        if ($this->session->userdata('logged_in')) {
            if (
                $user['role'] == "admin" || // admin super
                $user['id_alumni'] == $data['alumni']->id_alumni || // alumni itu sendiri
                ($user['role'] == 'admin_angkatan' && $user['angkatan'] == $alumni_angkatan) // admin angkatan sama
            ) 
            {
                $bisa_edit = true;
            }
        }
        // echo $alumni_angkatan;
        // echo $user['angkatan'];

// print_r($user)."<br><br><br>";
// print_r($alumni)."<br><br><br>";
// echo "bisa_edit = ".$bisa_edit;
// echo "id_alumni = ".$data['alumni']->id_alumni;
   
        $data['show_edit'] = $bisa_edit;
        // $data['referral'] = $this->input->get('ut');

        $this->load->view('template/header');
        $this->load->view('alumni/detail', $data);
        $this->load->view('template/footer');
    }


  public function upload_photo($id_alumni) {
        // Cek otorisasi
        // if (!$this->session->userdata('logged_in')) {
        //     redirect('login');
        // }

        // Validasi apakah user berhak mengedit
        $user_role = $this->session->userdata('role');
        $user_angkatan = $this->session->userdata('angkatan');
        $alumni_data = $this->Alumni_model->get_alumni($id_alumni);
        
        // if ($user_role != 'admin' && 
        //     ($user_role != 'admin_angkatan' || $user_angkatan != $alumni_data->angkatan) &&
        //     $this->session->userdata('id_alumni') != $id_alumni) {
        //     $this->session->set_flashdata('error', 'Anda tidak memiliki akses untuk mengubah foto profil ini');
        //     redirect('alumni/detail/'.$id_alumni);
        // }

        // Konfigurasi upload
        $config['upload_path'] = './uploads/foto_alumni/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size'] = 2048; // 2MB
        $config['file_name'] = 'alumni_'.$id_alumni.'_'.time();
        $config['overwrite'] = true;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('foto_profil')) {
            // Jika upload gagal
            $error = $this->upload->display_errors();
            $this->session->set_flashdata('error', $error);
        } else {
            // Jika upload berhasil
            $upload_data = $this->upload->data();
            $file_name = $upload_data['file_name'];

            // Update database
            $data = array(
                'foto_profil' => $file_name
            );

            if ($this->Alumni_model->update_alumni($id_alumni, $data)) {
                // Jika admin mengubah foto orang lain
                if ($this->session->userdata('id_alumni') != $id_alumni) {
                    $this->session->set_flashdata('success', 'Foto profil alumni berhasil diupdate');
                } else {
                    $this->session->set_flashdata('success', 'Foto profil Anda berhasil diupdate');
                }
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data foto ke database');
            }
        }

        redirect('alumni/detail/'.$id_alumni);
    }



    public function edit($id) {
        $data['alumni'] = $alumni = $this->Alumni_model->get_alumni($id);
        if(!$data['alumni']) {
            show_404();
        }
        $data['provinsi'] = $this->Alumni_model->get_provinsi();
        $data['kabupaten'] = $this->Alumni_model->get_kabupaten_by_provinsi($data['alumni']->provinsi_id);
        $data['pekerjaan_list'] = $this->Alumni_model->get_pekerjaan();
        $data['ajax_kabupaten'] = true;

        $user = $this->session->userdata(); // misal ['role_id' => ..., 'alumni_id' => ..., 'angkatan' => ...]
        // Ambil data alumni yang sedang dilihat, termasuk angkatannya
        $alumni_angkatan = $alumni->angkatan; // pastikan data angkatan sudah tersedia di objek $alumni

        // print_r($alumni);

        $bisa_edit = false;
        if ($this->session->userdata('logged_in')) {
            if (
                $user['role'] == "admin" || // admin super
                $user['id_alumni'] == $data['alumni']->id_alumni || // alumni itu sendiri
                ($user['role'] == 'admin_angkatan' && $user['angkatan'] == $alumni_angkatan) // admin angkatan sama
            ) 
            {
                $bisa_edit = true;
            }
        }
        // echo $alumni_angkatan;
        // echo $user['angkatan'];


        $this->load->view('template/header');
        if ($bisa_edit==1) {
            $this->load->view('alumni/edit', $data);
        } else {
            $this->load->view('forbidden', $data);
        }
        $this->load->view('template/footer');

    }

    public function update($id) {
        $post = $this->input->post();

        $updated = $this->Alumni_model->update_alumni_user($id, $post);

        if($updated) {
            $this->session->set_flashdata('success', 'Data alumni berhasil diperbarui.');

            $alumni = $this->Alumni_model->get_alumni($id_alumni);
            $message = '<b><u>#UPDATEDATA ALUMNI</u></b>' . "\n" .
                       '🟢 <b>Status:</b> BERHASIL' . "\n" .
                       '👨‍🎓 <b>Nama:</b> <i>' . htmlspecialchars($post['nama_lengkap']) . '</i>' . "\n" .
                       '📌 <b>Angkatan:</b> <code>' . $post['angkatan'] . '</code>' . "\n\n" .
                       '⭐ <b>Admin:</b> <code>' . $this->session->userdata('nama_lengkap') . '</code>' . "\n" .
                       '⏱ <i>Waktu: ' . date('d/m/Y H:i:s') . '</i>';
            $kirim_tele = $this->send_telegram_message($message);
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui data.');
        }
        redirect('alumni/detail/'.$id);
    }
public function update_user($id_alumni) {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

    $email = $this->input->post('email');
    $existing = $this->db->get_where('users', ['email' => $email])->row();


    if ($this->form_validation->run() == FALSE) {
        $this->session->set_flashdata('error', validation_errors());
        redirect('alumni/detail/'.$this->input->post('alumni_id'));
    } else {
        $user_data = [
            'email' => $this->input->post('email'),
            'alumni_id' => $this->input->post('alumni_id') // Pastikan ada relasi dengan alumni
        ];

        // Tambahkan password jika diisi
        if ($this->input->post('password')) {
            $user_data['password_hash'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
        }

        // Tambahkan role jika admin
        if ($this->session->userdata('role') == 'admin') {
            $user_data['role_id'] = $this->input->post('role_id');
        }

        $this->load->model('User_model');
        
        // Cek apakah user sudah ada berdasarkan alumni_id
        $user_exists = $this->db->get_where('users', ['alumni_id' => $this->input->post('alumni_id')])->row();
        
        if ($user_exists) {
            // UPDATE jika user sudah ada
            $this->User_model->update_user($this->input->post('alumni_id'), $user_data);
            $message = 'Data user berhasil diperbarui.';
        } else {
            // INSERT jika user belum ada
            // Tambahkan data default jika diperlukan
            // $user_data['active'] = 1; // Contoh: set user sebagai aktif
            $user_data['updated_at'] = date('Y-m-d H:i:s');
            
            $this->User_model->insert_user($user_data); // Pastikan ada method create_user di model
            $message = 'Akun user berhasil dibuat.';
        }

        $this->session->set_flashdata('success', $message);

        $alumni = $this->Alumni_model->get_alumni($id_alumni);
        $message = '<b><u>#UPDATEUSER ALUMNI</u></b>' . "\n" .
                   '🟢 <b>Status:</b> BERHASIL' . "\n" .
                   '👨‍🎓 <b>Nama:</b> <i>' . htmlspecialchars($alumni->nama_lengkap) . '</i>' . "\n" .
                   '📌 <b>Angkatan:</b> <code>' . $alumni->angkatan . '</code>' . "\n\n" .
                   '⭐ <b>Admin:</b> <code>' . $this->session->userdata('nama_lengkap') . '</code>' . "\n" .
                   '⏱ <i>Waktu: ' . date('d/m/Y H:i:s') . '</i>';
        $kirim_tele = $this->send_telegram_message($message);
        // print_r($kirim_tele); die();


        redirect('alumni/detail/'.$this->input->post('alumni_id'));
    }
}

    // public function update_user($id_alumni) {
    //     // print_r($this->input->post()); die();
    //     $this->load->library('form_validation');
    //     $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

    //     $email = $this->input->post('email');
    //     $existing = $this->db->get_where('users', ['email' => $email])->row();

    //     if ($existing and $this->input->post('email_current')!=$email) {
    //         // Email sudah terdaftar, kembalikan ke form dengan pesan error
    //         $this->session->set_flashdata('error', 'Email sudah digunakan, silakan gunakan email lain.');
    //         redirect('alumni/detail/'.$id_alumni);
    //         return;
    //     }




    //     if ($this->input->post('password')) {
    //         $this->form_validation->set_rules('password', 'Password', 'min_length[6]');
    //         // $this->form_validation->set_rules('password_confirm', 'Konfirmasi Password', 'matches[password]');
    //     }

    //     if ($this->form_validation->run() == FALSE) {
    //         // Jika validasi gagal, kembalikan ke halaman detail dengan error
    //         $this->session->set_flashdata('error', validation_errors());
    //         redirect('alumni/detail/'.$this->input->post('alumni_id'));
    //     } else {
    //         $update_data = [
    //             'email' => $this->input->post('email'),
    //         ];
    //         if ($this->input->post('password')) {
    //             $update_data['password_hash'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
    //         }
    //         if ($this->session->userdata('role') == 'admin') {
    //             $update_data['role_id'] = $this->input->post('role_id');
    //         }
    //         $this->load->model('User_model');
    //         $this->User_model->update_user($this->input->post('alumni_id'), $update_data);

    //         $this->session->set_flashdata('success', 'Data user berhasil diperbarui.');
    //         redirect('alumni/detail/'.$this->input->post('alumni_id'));
    //     }
    // }


   public function hapus_alumni($id_alumni) {
        // Mulai transaksi database
        $this->db->trans_start();
        
        try {
            // 1. Hapus data pekerjaan terkait
            $this->db->where('alumni_id', $id_alumni);
            $this->db->delete('pekerjaan');
            
            // 2. Hapus data pendidikan terkait
            $this->db->where('alumni_id', $id_alumni);
            $this->db->delete('pendidikan');
            
            // 3. Hapus data keterangan tambahan terkait
            $this->db->where('alumni_id', $id_alumni);
            $this->db->delete('keterangan_tambahan');
            
            // 4. Hapus data foto terkait
            $this->db->where('id_alumni', $id_alumni);
            $this->db->delete('alumni_foto');
            
            // 5. Hapus data user terkait
            $this->db->where('alumni_id', $id_alumni);
            $this->db->delete('users');
            
            // 6. Hapus data alumni
            $this->db->where('id_alumni', $id_alumni);
            $this->db->delete('alumni');
            
            // Selesaikan transaksi
            $this->db->trans_complete();
            
            // Cek jika transaksi berhasil
            if ($this->db->trans_status() === FALSE) {
                // Jika gagal, rollback transaksi
                $this->db->trans_rollback();
                return false;
            } else {
                return true;
            }
            
        } catch (Exception $e) {
            // Jika terjadi error, rollback transaksi
            $this->db->trans_rollback();
            log_message('error', 'Error menghapus alumni: ' . $e->getMessage());
            return false;
        }
    }
    
    // Function untuk mendapatkan data alumni sebelum dihapus (opsional)
    public function get_alumni_data($id_alumni) {
        $this->db->where('id_alumni', $id_alumni);
        return $this->db->get('alumni')->row();
    }



    public function hapus($id) {
        // Cek otorisasi sebelum menghapus

        $user_role = $this->session->userdata('role');
        $user_angkatan = $this->session->userdata('angkatan');
        $id_alumni = $this->session->userdata('id_alumni');
        $alumni = $this->Alumni_model->get_alumni($id);
        // print_r($alumni);die();




        $is_admin = false;
        if ($this->session->userdata('logged_in')) {
            if (
                $user_role == "admin" || // admin super
                ($user_role == 'admin_angkatan' && $user_angkatan == $alumni->angkatan) // admin angkatan sama
            ) 
            {
                $is_admin = true;
            }
        }


        if (!$is_admin) {
            show_error('Anda tidak memiliki izin untuk melakukan aksi ini.', 403);
        }
        // Panggil function hapus
        $result = $this->Alumni_model->hapus_alumni($id);
        
        if ($result) {
            $this->session->set_flashdata('success', 'Data alumni '.$alumni->nama_lengkap.' dan semua data terkait berhasil dihapus.');

            $message = '<b><u>#HAPUS ALUMNI</u></b>' . "\n" .
                       '🟢 <b>Status:</b> BERHASIL' . "\n" .
                       '👨‍🎓 <b>Nama:</b> <i>' . htmlspecialchars($alumni->nama_lengkap) . '</i>' . "\n" .
                       '📌 <b>Angkatan:</b> <code>' . $alumni->angkatan . '</code>' . "\n\n" .
                       '⭐ <b>Admin:</b> <code>' . $this->session->userdata('nama_lengkap') . '</code>' . "\n" .
                       '⏱ <i>Waktu: ' . date('d/m/Y H:i:s') . '</i>';
            $kirim_tele = $this->send_telegram_message($message);
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data alumni.');
        }
        
        redirect('alumni?angkatan='.$alumni->angkatan); // Redirect ke halaman daftar alumni
    }







    public function dobel($banyak=2) {

        $sesi = $this->session->userdata();
        // print_r($sesi);

        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login'); // arahkan ke halaman login jika belum login
        }        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login'); // arahkan ke halaman login jika belum login
        }

        $data_dobel = $this->Alumni_model->get_alumni_dobel($banyak);

        $all = 1;
        foreach ($data_dobel as $db) {
            $get_dobel_data = $this->Alumni_model->get_dobel_data($db->nama_lengkap, $db->alamat_domisili);
            $ur = 1;
            foreach ($get_dobel_data as $gdb) {
                echo "<br/>".$ur++." - ".$gdb->nama_lengkap." - (".$gdb->angkatan.") - ".$gdb->alamat_domisili." - ".$gdb->ref_jumlah."- ".$all++;

                if ($ur>2 AND $gdb->ref_jumlah==0) {
                    // echo "perlu dihapus";
                   $hapus = $this -> hapus_alumni($gdb->id_alumni);
                   if($hapus){
                    echo "- berhasil dihapus";
                   }
                }


            }


        }



        // $this->load->view('template/header');
        // $this->load->view('admin/dobel');
        // $this->load->view('template/footer');
    }


    public function send_telegram_message($message) {
        // URL API Telegram
        $url = "https://api.telegram.org/bot" . TELEGRAM_BOT_TOKEN . "/sendMessage";
        
        // Data yang akan dikirim
        $data = array(
            'chat_id' => TELEGRAM_CHAT_ID,
            'text' => $message,
            'parse_mode' => 'HTML'
        );
        
        // Inisialisasi cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        // Untuk development (nonaktifkan di production)
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        // Eksekusi request
        $result = curl_exec($ch);
        
        // Tutup koneksi cURL
        curl_close($ch);
        
        // Decode response JSON
        $resultArray = json_decode($result, TRUE);
        
        if (isset($resultArray['ok']) && $resultArray['ok']) {
            return true;
        }
        
        return isset($resultArray['description']) ? $resultArray['description'] : 'Unknown error';
    }
    // Contoh penggunaan fungsi
    public function test_send_message() {
        $message = 'Halo! Ini adalah pesan test dari CodeIgniter 3.';
        
        $result = $this->send_telegram_message($message);
        
        if ($result === true) {
            echo 'Pesan berhasil dikirim!';
        } else {
            echo 'Gagal mengirim pesan: ' . $result;
        }
    }

    
}
