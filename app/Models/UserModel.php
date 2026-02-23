<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id_user';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = [
        'email', 'password_hash', 'nama_lengkap', 'role_id', 'alumni_id', 'is_active', 'created_at', 'updated_at'
    ];

    /**
     * Check login credentials
     */
    public function checkLogin(string $email, string $password)
    {
        $user = $this->where('email', $email)->first();

        if ($user && password_verify($password, $user->password_hash)) {
            return $user;
        }

        return false;
    }

    public function updateUser(int $id, array $data)
    {
        return $this->where('alumni_id', $id)->update(null, $data);
    }

    public function insertUser(array $data)
    {
        if (empty($data['email'])) {
            return true;
        }
        
        if ($this->where('email', $data['email'])->first()) {
            return false;
        }
        
        return $this->insert($data);
    }

    public function getUser(string $email)
    {
        return $this->builder()
            ->select('users.*, roles.nama_role as role')
            ->join('roles', 'roles.id_role = users.role_id', 'left')
            ->where('users.email', $email)
            ->get()
            ->getRow();
    }

    /**
     * Comprehensive user data fetch (for session population)
     */
    public function getUserFullDetails(string $email)
    {
        return $this->builder()
            ->select('users.*, roles.nama_role as role, alumni.*, pendidikan.angkatan, 
                      pendidikan.jurusan, pekerjaan.nama_perusahaan, pekerjaan.id_pekerjaan, 
                      ref_pekerjaan.id_ref_pekerjaan, pekerjaan.jabatan, ref_pekerjaan.nama_pekerjaan, 
                      pekerjaan.alamat_kantor, keterangan_tambahan.bergabung_komunitas, 
                      keterangan_tambahan.partisipasi_kegiatan, keterangan_tambahan.saran_masukan, 
                      provinsi.nama_provinsi as provinsi, kabupaten.nama_kabupaten as kabupaten')
            ->join('roles', 'roles.id_role = users.role_id', 'left')
            ->join('alumni', 'users.alumni_id = alumni.id_alumni', 'left')
            ->join('pendidikan', 'pendidikan.alumni_id = alumni.id_alumni', 'left')
            ->join('pekerjaan', 'pekerjaan.alumni_id = alumni.id_alumni', 'left')
            ->join('ref_pekerjaan', 'ref_pekerjaan.id_ref_pekerjaan = pekerjaan.id_ref_pekerjaan', 'left')
            ->join('keterangan_tambahan', 'keterangan_tambahan.alumni_id = alumni.id_alumni', 'left')
            ->join('provinsi', 'alumni.provinsi_id = provinsi.id_provinsi')
            ->join('kabupaten', 'alumni.kabupaten_id = kabupaten.id_kabupaten')
            ->where('users.email', $email)
            ->get()
            ->getRow();
    }
}
