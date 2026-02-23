<?php

namespace App\Controllers;

use App\Models\PageModel;

class Pages extends BaseController
{
    protected $pageModel;

    public function __construct()
    {
        $this->pageModel = new PageModel();
    }

    public function index(string $slug = 'home'): string
    {
        $data['page'] = $this->pageModel->getPageBySlug($slug);
        
        if (empty($data['page'])) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data['title'] = $data['page']['title'];

        return $this->render('page_view', $data);
    }
}