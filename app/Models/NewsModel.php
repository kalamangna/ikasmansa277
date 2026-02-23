<?php

namespace App\Models;

use CodeIgniter\Model;

class NewsModel extends Model
{
    protected $table            = 'news';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['title', 'slug', 'content', 'created_at', 'updated_at'];

    public function getNewsBySlug(string $slug)
    {
        return $this->where('slug', $slug)->first();
    }

    public function getNews(): array
    {
        return $this->findAll();
    }

    public function getNewsItem(int $id)
    {
        return $this->find($id);
    }

    public function insertNews(array $data)
    {
        return $this->insert($data);
    }

    public function updateNews(int $id, array $data)
    {
        return $this->update($id, $data);
    }

    public function deleteNews(int $id)
    {
        return $this->delete($id);
    }
}
