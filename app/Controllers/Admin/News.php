<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\NewsModel;

class News extends BaseController
{
    protected $newsModel;

    public function __construct()
    {
        $this->newsModel = new NewsModel();
    }

    public function index(): string
    {
        $data = [
            'news'  => $this->newsModel->getNews(),
            'title' => 'Berita'
        ];
        return $this->render('admin/news/index', $data);
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
            while ($this->newsModel->getNewsBySlug($slug)) {
                $count++;
                $slug = $baseSlug . '-' . $count;
            }

            $data = [
                'title'      => $title,
                'slug'       => $slug,
                'content'    => $this->request->getPost('content'),
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $this->newsModel->insertNews($data);
            session()->setFlashdata('success', 'Berita berhasil ditambahkan.');
            return redirect()->to('admin/news');
        }

        return $this->render('admin/news/add', ['title' => 'Tambah Berita']);
    }

    public function edit(int $id)
    {
        $news = $this->newsModel->getNewsItem($id);
        if (!$news) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'title'   => 'required|trim',
            'content' => 'required'
        ];

        if ($this->request->is('post') && $this->validate($rules)) {
            $updateData = [
                'title'      => $this->request->getPost('title'),
                'content'    => $this->request->getPost('content'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $this->newsModel->updateNews($id, $updateData);
            session()->setFlashdata('success', 'Berita berhasil diperbarui.');
            return redirect()->to('admin/news');
        }

        $data = [
            'news_item' => $news,
            'title'     => 'Edit Berita'
        ];
        return $this->render('admin/news/edit', $data);
    }

    public function delete(int $id)
    {
        $this->newsModel->deleteNews($id);
        session()->setFlashdata('success', 'Berita berhasil dihapus.');
        return redirect()->to('admin/news');
    }
}