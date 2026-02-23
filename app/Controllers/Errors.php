<?php

namespace App\Controllers;

class Errors extends BaseController
{
    public function page_not_found(): string
    {
        log_message('error', '404 Page Not Found: ' . current_url());

        $data = [
            'title'         => '404 Page Not Found',
            'message'       => 'Maaf, halaman yang Anda cari tidak ditemukan.',
            'helpful_links' => [
                'Homepage'   => base_url(),
                'Contact Us' => '#',
                'Site Map'   => '#'
            ]
        ];

        $this->response->setStatusCode(404);
        
        return $this->render('errors/html/error_404', $data);
    }
}