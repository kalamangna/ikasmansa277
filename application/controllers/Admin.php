<?php
class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login'); // arahkan ke halaman login jika belum login
        }
    }

    // Halaman dashboard admin
    public function index() {


        $sesi = $this->session->userdata();
        // print_r($sesi);


        $this->load->view('template/header');
        $this->load->view('admin/dashboard');
        $this->load->view('template/footer');
    }

    // Pages
    public function pages() {
        $data['pages'] = $this->Page_model->get_pages();
        $this->load->view('template/header');
        $this->load->view('admin/pages/index', $data);
        $this->load->view('template/footer');
    }


    public function add_page() {
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('content', 'Content', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('template/header');
            $this->load->view('admin/pages/add');
            $this->load->view('template/footer');
        } else {
            $title = $this->input->post('title');
            $slug = $this->create_slug($title);

            // Cek apakah slug sudah ada, jika ada tambahkan angka unik
            $count = 0;
            $base_slug = $slug;
            while ($this->Page_model->get_page_by_slug($slug)) {
                $count++;
                $slug = $base_slug . '-' . $count;
            }

            $data = [
                'title' => $title,
                'slug' => $slug,
                'content' => $this->input->post('content')
            ];
            $this->Page_model->insert_page($data);
            redirect('admin/pages');
        }
    }



public function edit_page($id) {
    $data['page'] = $this->Page_model->get_page($id);

    if (empty($data['page'])) {
        show_404();
    }

    $this->form_validation->set_rules('title', 'Title', 'required');
    $this->form_validation->set_rules('content', 'Content', 'required');

    if ($this->form_validation->run() === FALSE) {
        $this->load->view('template/header');
        $this->load->view('admin/pages/edit', $data);
        $this->load->view('template/footer');

    } else {
        $title = $this->input->post('title');
        $content = $this->input->post('content');
        $slug = $data['page']['slug']; // default slug lama

        if ($title !== $data['page']['title']) {
            // Judul berubah, buat slug baru
            $slug = $this->create_slug($title);

            // Cek slug unik, kecuali untuk id ini sendiri
            $count = 0;
            $base_slug = $slug;
            while ($existing = $this->Page_model->get_page_by_slug($slug)) {
                if ($existing['id'] == $id) break; // slug milik page ini, boleh pakai
                $count++;
                $slug = $base_slug . '-' . $count;
            }
        }

        $update_data = [
            'title' => $title,
            'slug' => $slug,
            'content' => $content
        ];

        $this->Page_model->update_page($id, $update_data);
        redirect('admin/pages');
    }
}
    public function delete_page($id) {
        $this->Page_model->delete_page($id);
        redirect('admin/pages');
    }

    // News
    public function news() {
        $data['news'] = $this->News_model->get_news();
        $this->load->view('template/header');
        $this->load->view('admin/news/index', $data);
        $this->load->view('template/footer');

    }

    public function add_news() {
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('content', 'Content', 'required');

        if ($this->form_validation->run() === FALSE) {
        $this->load->view('template/header');
        $this->load->view('admin/news/add');
        $this->load->view('template/footer');
        } else {
            $title = $this->input->post('title');
            $slug = $this->create_slug($title);

            // Cek apakah slug sudah ada, jika ada tambahkan angka unik
            $count = 0;
            $base_slug = $slug;
            while ($this->News_model->get_news_by_slug($slug)) {
                $count++;
                $slug = $base_slug . '-' . $count;
            }

            $data = [
                'title' => $title,
                'slug' => $slug,
                'content' => $this->input->post('content')
            ];
            $this->News_model->insert_news($data);
            redirect('admin/news');
        }
    }
    public function edit_news($id) {
        $data['news_item'] = $this->News_model->get_news_item($id);

        if (empty($data['news_item'])) {
            show_404();
        }

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('slug', 'Slug', 'required');
        $this->form_validation->set_rules('content', 'Content', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('template/header');
            $this->load->view('admin/news/edit', $data);
            $this->load->view('template/footer');
        } else {
            $update_data = [
                'title' => $this->input->post('title'),
                'slug' => $this->input->post('slug'),
                'content' => $this->input->post('content')
            ];
            $this->News_model->update_news($id, $update_data);
            redirect('admin/news');
        }
    }

    public function delete_news($id) {
        $this->News_model->delete_news($id);
        redirect('admin/news');
    }

    private function create_slug($string) {
        // Ubah ke huruf kecil
        $slug = strtolower($string);
        // Ganti spasi dan karakter non-alfanumerik dengan strip
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
        // Hapus strip di awal dan akhir
        $slug = trim($slug, '-');
        return $slug;
    }

}
