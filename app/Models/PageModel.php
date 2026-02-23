<?php

namespace App\Models;

use CodeIgniter\Model;

class PageModel extends Model
{
    protected $table            = 'pages';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['title', 'slug', 'content', 'created_at', 'updated_at'];

    public function getPageBySlug(string $slug)
    {
        return $this->where('slug', $slug)->first();
    }

    public function getPages(): array
    {
        return $this->findAll();
    }

    public function getPage(int $id)
    {
        return $this->find($id);
    }

    public function insertPage(array $data)
    {
        return $this->insert($data);
    }

    public function updatePage(int $id, array $data)
    {
        return $this->update($id, $data);
    }

    public function deletePage(int $id)
    {
        return $this->delete($id);
    }
}
