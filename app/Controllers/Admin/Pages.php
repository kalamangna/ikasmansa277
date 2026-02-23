<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PageModel;

class Pages extends BaseController
{
    protected $pageModel;

    public function __construct()
    {
        $this->pageModel = new PageModel();
    }

    public function index(): string
    {
        $data = [
            'pages' => $this->pageModel->getPages(),
            'title' => 'Manajemen Halaman'
        ];
        return $this->render('admin/pages/index', $data);
    }

    public function create()
    {
        $rules = [
            'title'   => 'required|trim',
            'content' => 'required'
        ];

        if ($this->request->is('post') && $this->validate($rules)) {
            $title = $this->request->getPost('title');
            $slug  = url_title($title, '-', true);

            $baseSlug = $slug;
            $count    = 0;
            while ($this->pageModel->getPageBySlug($slug)) {
                $count++;
                $slug = $baseSlug . '-' . $count;
            }

            $data = [
                'title'   => $title,
                'slug'    => $slug,
                'content' => $this->request->getPost('content')
            ];
            
            $this->pageModel->insertPage($data);
            session()->setFlashdata('success', 'Halaman berhasil ditambahkan.');
            return redirect()->to('admin/pages');
        }

        return $this->render('admin/pages/add', ['title' => 'Tambah Halaman']);
    }

    public function edit(int $id)
    {
        $page = $this->pageModel->getPage($id);
        if (!$page) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'title'   => 'required|trim',
            'content' => 'required'
        ];

        if ($this->request->is('post') && $this->validate($rules)) {
            $title = $this->request->getPost('title');
            $slug  = $page['slug']; 

            if ($title !== $page['title']) {
                $slug = url_title($title, '-', true);
                $baseSlug = $slug;
                $count = 0;
                while ($existing = $this->pageModel->getPageBySlug($slug)) {
                    if ($existing['id'] == $id) break;
                    $count++;
                    $slug = $baseSlug . '-' . $count;
                }
            }

            $updateData = [
                'title'   => $title,
                'slug'    => $slug,
                'content' => $this->request->getPost('content')
            ];

            $this->pageModel->updatePage($id, $updateData);
            session()->setFlashdata('success', 'Halaman berhasil diperbarui.');
            return redirect()->to('admin/pages');
        }

        $data = [
            'page'  => $page,
            'title' => 'Edit Halaman'
        ];
        return $this->render('admin/pages/edit', $data);
    }

    public function delete(int $id)
    {
        $this->pageModel->deletePage($id);
        session()->setFlashdata('success', 'Halaman berhasil dihapus.');
        return redirect()->to('admin/pages');
    }
}