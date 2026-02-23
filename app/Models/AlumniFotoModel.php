<?php

namespace App\Models;

use CodeIgniter\Model;

class AlumniFotoModel extends Model
{
    protected $table            = 'alumni_foto';
    protected $primaryKey       = 'id';
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_alumni', 'file_name', 'created_at'];

    public function getFotoByAlumni(int $idAlumni): array
    {
        return $this->where('id_alumni', $idAlumni)->findAll();
    }
}
