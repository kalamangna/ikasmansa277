<?php

namespace App\Models;

use CodeIgniter\Model;

class QrCodeModel extends Model
{
    protected $table            = 'qr_codes';
    protected $primaryKey       = 'id';
    protected $returnType       = 'object';
    protected $allowedFields    = ['content', 'filename', 'created_at'];

    public function getAllQrCodes(): array
    {
        return $this->findAll();
    }

    public function getByContent(string $content)
    {
        return $this->where('content', $content)->first();
    }

    public function insertQrCode(array $data)
    {
        return $this->insert($data);
    }
}
