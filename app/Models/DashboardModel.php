<?php

namespace App\Models;

use CodeIgniter\Model;

class DashboardModel extends Model
{
    protected $table = 'alumni';

    public function getTotalAlumni(): int
    {
        return $this->countAllResults();
    }

    public function getTotalAngkatan(): int
    {
        return $this->db->table('pendidikan')
            ->select('COUNT(DISTINCT angkatan) as total')
            ->get()
            ->getRow()->total ?? 0;
    }

    public function getAlumniFaster(): array
    {
        return $this->builder()
            ->select('alumni.*, pendidikan.angkatan, pendidikan.jurusan, provinsi.nama_provinsi as provinsi, kabupaten.nama_kabupaten as kabupaten')
            ->join('pendidikan', 'pendidikan.alumni_id = alumni.id_alumni')
            ->join('provinsi', 'alumni.provinsi_id = provinsi.id_provinsi')
            ->join('kabupaten', 'alumni.kabupaten_id = kabupaten.id_kabupaten')
            ->limit(10)
            ->orderBy('alumni.created_at', 'ASC')
            ->orderBy('alumni.id_alumni', 'ASC')
            ->get()
            ->getResult();
    }

    public function getAlumniRecent(): array
    {
        return $this->builder()
            ->select('alumni.*, pendidikan.angkatan, pendidikan.jurusan, provinsi.nama_provinsi as provinsi, kabupaten.nama_kabupaten as kabupaten')
            ->join('pendidikan', 'pendidikan.alumni_id = alumni.id_alumni')
            ->join('provinsi', 'alumni.provinsi_id = provinsi.id_provinsi')
            ->join('kabupaten', 'alumni.kabupaten_id = kabupaten.id_kabupaten')
            ->limit(10)
            ->orderBy('alumni.created_at', 'DESC')
            ->get()
            ->getResult();
    }

    public function getReferredRank(): array
    {
        return $this->builder()
            ->select('alumni.*, pendidikan.angkatan')
            ->select('(SELECT COUNT(A2.id_alumni) FROM alumni A2 WHERE A2.referred_by = CAST(alumni.id_alumni AS CHAR) OR A2.referred_by = alumni.referral) AS ref_jumlah', false)
            ->join('pendidikan', 'pendidikan.alumni_id = alumni.id_alumni', 'left')
            ->having('ref_jumlah >', 0)
            ->orderBy('ref_jumlah', 'DESC')
            ->limit(20)
            ->get()
            ->getResult();
    }

    public function getAlumniCountByAngkatan(): array
    {
        return $this->db->table('pendidikan')
            ->select('angkatan, COUNT(*) as jumlah_alumni')
            ->groupBy('angkatan')
            ->orderBy('angkatan', 'ASC')
            ->get()
            ->getResult();
    }

    public function getAlumniCountByJurusan(): array
    {
        return $this->db->table('pendidikan')
            ->select('jurusan, COUNT(*) as jumlah_alumni')
            ->groupBy('jurusan')
            ->orderBy('jumlah_alumni', 'DESC')
            ->get()
            ->getResult();
    }

    public function getGenderCountPerAngkatan(): array
    {
        return $this->db->table('alumni')
            ->select('pendidikan.angkatan')
            ->selectSum("CASE WHEN alumni.jenis_kelamin = 'Laki-laki' THEN 1 ELSE 0 END", 'jumlah_laki_laki')
            ->selectSum("CASE WHEN alumni.jenis_kelamin = 'Perempuan' THEN 1 ELSE 0 END", 'jumlah_perempuan')
            ->join('pendidikan', 'pendidikan.alumni_id = alumni.id_alumni')
            ->groupBy('pendidikan.angkatan')
            ->orderBy('pendidikan.angkatan', 'ASC')
            ->get()
            ->getResult();
    }

    public function getGenderCountTotal()
    {
        return $this->builder()
            ->selectSum("CASE WHEN jenis_kelamin = 'Laki-laki' THEN 1 ELSE 0 END", 'total_laki_laki')
            ->selectSum("CASE WHEN jenis_kelamin = 'Perempuan' THEN 1 ELSE 0 END", 'total_perempuan')
            ->get()
            ->getRow();
    }

    public function getAlumniPerKabupaten(): array
    {
        return $this->builder()
            ->select('kabupaten.nama_kabupaten, provinsi.nama_provinsi, COUNT(alumni.id_alumni) AS total_alumni')
            ->join('kabupaten', 'alumni.kabupaten_id = kabupaten.id_kabupaten', 'left')
            ->join('provinsi', 'kabupaten.id_provinsi = provinsi.id_provinsi', 'left')
            ->groupBy(['kabupaten.id_kabupaten', 'kabupaten.nama_kabupaten', 'provinsi.nama_provinsi'])
            ->orderBy('total_alumni', 'DESC')
            ->get()
            ->getResult();
    }

    public function getTotalAlumniPerPekerjaan(): array
    {
        return $this->db->table('pekerjaan')
            ->select('ref_pekerjaan.nama_pekerjaan, COUNT(pekerjaan.alumni_id) AS total_alumni')
            ->join('ref_pekerjaan', 'pekerjaan.id_ref_pekerjaan = ref_pekerjaan.id_ref_pekerjaan')
            ->groupBy('ref_pekerjaan.nama_pekerjaan')
            ->orderBy('total_alumni', 'DESC')
            ->get()
            ->getResult();
    }

    public function getAdminAlumni(): array
    {
        return $this->builder('alumni a')
            ->select('a.*, r.nama_role, p.angkatan')
            ->join('users u', 'a.id_alumni = u.alumni_id')
            ->join('roles r', 'u.role_id = r.id_role')
            ->join('pendidikan p', 'a.id_alumni = p.alumni_id')
            ->whereIn('u.role_id', [1, 2])
            ->orderBy('u.role_id')
            ->get()
            ->getResultArray();
    }
}
