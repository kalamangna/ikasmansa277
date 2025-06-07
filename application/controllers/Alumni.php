<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alumni extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Alumni_model');
        $this->load->library('session', 'upload','form_validation');
        $this->load->helper('url', 'form');
    }

    public function index()
    {
        $user_role = $this->session->userdata('role');
        $user_angkatan = $this->session->userdata('angkatan');

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
        
        // Check email exists






        $email = $this->input->post('email', true);
        $existing = $this->db->get_where('users', ['email' => $email])->row();

        if ($existing) {
            $this->session->set_flashdata('error', 'Email sudah digunakan, silakan gunakan email lain.');
            redirect('alumni/create?ut='.$this->input->get('ut'));
            return;
        }

        // Handle photo upload
        $photo_path = '';
        if (!empty($_FILES['foto']['name'])) {
            // Create upload directory if it doesn't exist
            $upload_path = FCPATH . 'uploads/foto_alumni/';


            // if (!is_dir($upload_path)) {
            //     if (!mkdir($upload_path, 0755, true)) {
            //         log_message('error', 'Failed to create directory: ' . $upload_path);
            //         $this->session->set_flashdata('error', 'Gagal membuat folder upload.');
            //         redirect('alumni/create?ut='.$this->input->get('ut'));
            //         return;
            //     }
            // }


            
            $config = [
                'upload_path'   => $upload_path,
                'allowed_types' => 'gif|jpg|jpeg|png',
                'max_size'      => 2048, // 2MB
                'file_name'     => 'alumni_'.$post['id_alumni'].'_'.time(),
                'overwrite'     => false
            ];
            
            $this->load->library('upload', $config);
            
            if ($this->upload->do_upload('foto')) {
                $upload_data = $this->upload->data();
                $photo_path = 'uploads/foto_alumni/'.$upload_data['file_name'];

                
                // Resize image if needed
                $this->load->library('image_lib');
                $resize_config = [
                    'image_library'  => 'gd2',
                    'source_image'   => $upload_data['full_path'],
                    'maintain_ratio' => true,
                    'width'          => 800,
                    'height'         => 800
                ];
                
                $this->image_lib->initialize($resize_config);
                if (!$this->image_lib->resize()) {
                    // Log error but don't stop execution
                    log_message('error', 'Image resize failed: '.$this->image_lib->display_errors());
                }
                $this->image_lib->clear();
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('alumni/create?ut='.$this->input->get('ut'));
                return;
            }
        }
        
        // Add photo path to post data
        $post['foto_profil'] = $upload_data['file_name'];

        // Save alumni data
        $alumni_id = $this->Alumni_model->insert_alumni_user($post);

        if (is_int($alumni_id)) {
            $referral = $post['referred_by'] ?? '';
            $this->session->set_flashdata('success', 'Data alumni dan user berhasil disimpan.');
            redirect('alumni/detail/'.$alumni_id.'?ut='.$referral);
        } else {
            // Clean up uploaded file if save failed
            if (!empty($photo_path) && file_exists(FCPATH.$photo_path)) {
                unlink(FCPATH.$photo_path);
            }
            $this->session->set_flashdata('error', 'Gagal menyimpan data.');
            redirect('alumni/create?ut='.$this->input->get('ut'));
        }
    }

    // public function save() {
    //     $post = $this->input->post();
    //     // print_r($post); die();
    //     // Validasi sederhana bisa ditambahkan di sini

    //     $email = $this->input->post('email', true);
    //     $existing = $this->db->get_where('users', ['email' => $email])->row();

    //     if ($existing) {
    //         // Email sudah terdaftar, kembalikan ke form dengan pesan error
    //         $this->session->set_flashdata('error', 'Email sudah digunakan, silakan gunakan email lain.');
    //         redirect('alumni/create?ut='.$this->input->get('ut'));
    //         return;
    //     }

 

    //     $alumni_id = $this->Alumni_model->insert_alumni_user($post);



    //     if(is_int($alumni_id)) {
    //         // Ambil kode referral dari data yang baru disimpan (misal dari $post atau database)
    //         $referral = isset($post['referred_by']) ? $post['referred_by'] : '';

    //         // Simpan pesan sukses dan redirect ke halaman detail alumni
    //         $this->session->set_flashdata('success', 'Data alumni dan user berhasil disimpan.');
    //         redirect('alumni/detail/'.$alumni_id.'?ut='.$referral);
    //     } else {
    //         $this->session->set_flashdata('error', 'Gagal menyimpan data.');
    //         print_r($alumni_id);
    //         // redirect('alumni/create');
    //         // redirect('alumni/create?ut='.$this->input->get('ut'));
    //     }


    // }

    // public function save()
    // {
    //     // Konfigurasi upload foto
    //     // print_r($this->input->post()); die();
    //     // if (!is_dir('./uploads/foto_alumni/')) {
    //     //     mkdir('./uploads/foto_alumni/', 0755, true);
    //     // }
    //     $config['upload_path'] = './uploads/foto_alumni/';
    //     $config['allowed_types'] = 'jpg|jpeg|png';
    //     $config['max_size'] = 1024; // maksimal 1MB
    //     $config['encrypt_name'] = TRUE;

    //     // print_r($config); die();

    //     if (!is_dir($config['upload_path'])) {
    //         mkdir($config['upload_path'], 0755, true);
    //     }

    //     $this->load->library('upload', $config);

    //     if (!$this->upload->do_upload('foto')) {
    //         $error = $this->upload->display_errors();
    //         $this->session->set_flashdata('error', $error);
    //         redirect('alumni/create?ut='.$this->input->get('ut'));
    //         return;
    //     }

    //     $upload_data = $this->upload->data();


    //     $image_path = $upload_data['upload_path'];

    //     // Cek dimensi foto potrait
    //     list($width, $height) = getimagesize($image_path);
    //     if ($height <= $width) {
    //         // Bukan potrait, hapus file dan beri pesan error
    //         unlink($image_path);
    //         $this->session->set_flashdata('error', 'Foto harus berbentuk potrait (tinggi lebih besar dari lebar).');
    //         redirect('alumni/create?ut='.$this->input->get('ut'));
    //         return;
    //     }

    //     // $alumni_id = $this->Alumni_model->insert_alumni_user($post);
    //     // Simpan data alumni beserta nama file foto
    //     $data_alumni = [
    //         'nama_lengkap' => $this->input->post('nama_lengkap', true),
    //         'jenis_kelamin' => $this->input->post('jenis_kelamin', true),
    //         // kolom lain sesuai kebutuhan
    //         'foto' => $upload_data['file_name']
    //     ];

    //     $this->Alumni_model->insert_alumni_user($data_alumni);
    //     $alumni_id = $this->Alumni_model->insert_alumni_user($post);

    //     $this->session->set_flashdata('success', 'Data alumni berhasil disimpan.');
    //     redirect('alumni/create');
    // }


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
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui data.');
        }
        redirect('alumni/edit/'.$id);
    }

    public function update_user($id_alumni) {
        // print_r($this->input->post()); die();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        $email = $this->input->post('email');
        $existing = $this->db->get_where('users', ['email' => $email])->row();

        if ($existing and $this->input->post('email_current')!=$email) {
            // Email sudah terdaftar, kembalikan ke form dengan pesan error
            $this->session->set_flashdata('error', 'Email sudah digunakan, silakan gunakan email lain.');
            redirect('alumni/detail/'.$id_alumni);
            return;
        }




        if ($this->input->post('password')) {
            $this->form_validation->set_rules('password', 'Password', 'min_length[6]');
            // $this->form_validation->set_rules('password_confirm', 'Konfirmasi Password', 'matches[password]');
        }

        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, kembalikan ke halaman detail dengan error
            $this->session->set_flashdata('error', validation_errors());
            redirect('alumni/detail/'.$this->input->post('alumni_id'));
        } else {
            $update_data = [
                'email' => $this->input->post('email'),
            ];
            if ($this->input->post('password')) {
                $update_data['password_hash'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
            }
            if ($this->session->userdata('role') == 'admin') {
                $update_data['role_id'] = $this->input->post('role_id');
            }
            $this->load->model('User_model');
            $this->User_model->update_user($this->input->post('alumni_id'), $update_data);

            $this->session->set_flashdata('success', 'Data user berhasil diperbarui.');
            redirect('alumni/detail/'.$this->input->post('alumni_id'));
        }
    }
    
}
