<?php

namespace App\Models;

use CodeIgniter\Model;

class AlumniModel extends Model
{
    protected $table            = 'alumni';
    protected $primaryKey       = 'id_alumni';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama_lengkap', 'nama_panggilan', 'jenis_kelamin', 'tempat_lahir', 
        'tanggal_lahir', 'no_telepon', 'alamat_domisili', 'provinsi_id', 
        'kabupaten_id', 'foto_profil', 'referral', 'referred_by', 'created_at', 'updated_at'
    ];

    /**
     * Get detailed alumni data with joins
     */
    public function getAlumni(int $id)
    {
        return $this->builder()
            ->select('alumni.*, pendidikan.angkatan, pendidikan.jurusan, ref_pekerjaan.nama_pekerjaan, 
                      ref_pekerjaan.grup_pekerjaan, pekerjaan.id_ref_pekerjaan, pekerjaan.nama_perusahaan, pekerjaan.jabatan, 
                      pekerjaan.alamat_kantor, kabupaten.nama_kabupaten as kabupaten, 
                      provinsi.nama_provinsi as provinsi, users.email, roles.nama_role,
                      keterangan_tambahan.bergabung_komunitas, keterangan_tambahan.partisipasi_kegiatan, 
                      keterangan_tambahan.saran_masukan')
            ->join('pendidikan', 'pendidikan.alumni_id = alumni.id_alumni', 'left')
            ->join('pekerjaan', 'pekerjaan.alumni_id = alumni.id_alumni', 'left')
            ->join('ref_pekerjaan', 'ref_pekerjaan.id_ref_pekerjaan = pekerjaan.id_ref_pekerjaan', 'left')
            ->join('kabupaten', 'kabupaten.id_kabupaten = alumni.kabupaten_id', 'left')
            ->join('provinsi', 'provinsi.id_provinsi = alumni.provinsi_id', 'left')
            ->join('users', 'users.alumni_id = alumni.id_alumni', 'left')
            ->join('roles', 'roles.id_role = users.role_id', 'left')
            ->join('keterangan_tambahan', 'keterangan_tambahan.alumni_id = alumni.id_alumni', 'left')
            ->where('alumni.id_alumni', $id)
            ->get()
            ->getRow();
    }

    public function getAngkatanByAlumniId(int $alumniId): ?string
    {
        $result = $this->db->table('pendidikan')
                           ->select('angkatan')
                           ->where('alumni_id', $alumniId)
                           ->get()
                           ->getRow();

        return $result->angkatan ?? null;
    }

    public function getAlumniPaginated(int $limit, int $offset, ?string $search = null, ?string $angkatan = null)
    {
        $this->applyFilters($search, $angkatan);
        
        return $this->builder()
            ->select('alumni.id_alumni, alumni.nama_lengkap, alumni.nama_panggilan, alumni.foto_profil, 
                      pendidikan.angkatan, pendidikan.jurusan, kabupaten.nama_kabupaten as kabupaten, 
                      provinsi.nama_provinsi as provinsi,
                      (SELECT COUNT(*) FROM alumni AS r WHERE r.referred_by = alumni.referral OR r.referred_by = CAST(alumni.id_alumni AS CHAR)) as ref_jumlah')
            ->join('pendidikan', 'pendidikan.alumni_id = alumni.id_alumni', 'left')
            ->join('kabupaten', 'kabupaten.id_kabupaten = alumni.kabupaten_id', 'left')
            ->join('provinsi', 'provinsi.id_provinsi = alumni.provinsi_id', 'left')
            ->orderBy('pendidikan.angkatan', 'DESC')
            ->orderBy('alumni.nama_lengkap', 'ASC')
            ->get($limit, $offset)
            ->getResult();
    }

    public function countAllAlumni(?string $search = null, ?string $angkatan = null): int
    {
        $this->applyFilters($search, $angkatan);
        return $this->builder()
            ->join('pendidikan', 'pendidikan.alumni_id = alumni.id_alumni', 'left')
            ->join('kabupaten', 'kabupaten.id_kabupaten = alumni.kabupaten_id', 'left')
            ->join('provinsi', 'provinsi.id_provinsi = alumni.provinsi_id', 'left')
            ->countAllResults();
    }

    private function applyFilters(?string $search, ?string $angkatan)
    {
        if ($search) {
            $this->builder()->groupStart()
                ->like('alumni.nama_lengkap', $search)
                ->orLike('pendidikan.jurusan', $search)
                ->orLike('kabupaten.nama_kabupaten', $search)
                ->orLike('provinsi.nama_provinsi', $search)
                ->groupEnd();
        }

        if ($angkatan) {
            $this->builder()->where('pendidikan.angkatan', $angkatan);
        }
    }

    public function getAngkatanListWithCounts(): array
    {
        return $this->db->table('alumni')
            ->select('pendidikan.angkatan, 
                      SUM(CASE WHEN alumni.jenis_kelamin = "Laki-laki" THEN 1 ELSE 0 END) as jumlah_laki_laki, 
                      SUM(CASE WHEN alumni.jenis_kelamin = "Perempuan" THEN 1 ELSE 0 END) as jumlah_perempuan')
            ->join('pendidikan', 'pendidikan.alumni_id = alumni.id_alumni', 'inner')
            ->groupBy('pendidikan.angkatan')
            ->orderBy('pendidikan.angkatan', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function getByReferral(string $code)
    {
        return $this->where('referral', $code)->first();
    }

    public function getByReferredBy(int $id, ?string $code): array
    {
        $builder = $this->builder()->select('id_alumni, nama_lengkap');
        
        $builder->groupStart();
        $builder->where('referred_by', (string)$id);
        if (!empty($code)) {
            $builder->orWhere('referred_by', $code);
        }
        $builder->groupEnd();
        
        return $builder->get()->getResult();
    }

    public function createAlumni(array $data)
    {
        $this->db->transStart();

        $alumniData = array_intersect_key($data, array_flip($this->allowedFields));
        $alumniData['referral'] = $this->generateUniqueReferralCode();
        
        $this->insert($alumniData);
        $alumniId = $this->insertID();

        // Related Tables
        $this->db->table('pendidikan')->insert([
            'alumni_id' => $alumniId,
            'angkatan'  => $data['angkatan'] ?? null,
            'jurusan'   => $data['jurusan'] ?? null
        ]);

        $this->db->table('pekerjaan')->insert([
            'alumni_id'        => $alumniId,
            'id_ref_pekerjaan' => $data['id_ref_pekerjaan'] ?? null,
            'nama_perusahaan'  => $data['nama_perusahaan'] ?? null,
            'jabatan'          => $data['jabatan'] ?? null,
            'alamat_kantor'    => $data['alamat_kantor'] ?? null
        ]);

        $this->db->table('keterangan_tambahan')->insert([
            'alumni_id'            => $alumniId,
            'bergabung_komunitas'  => $data['bergabung_komunitas'] ?? 0,
            'partisipasi_kegiatan' => $data['partisipasi_kegiatan'] ?? 0,
            'saran_masukan'        => $data['saran_masukan'] ?? null
        ]);

        if (!empty($data['email']) && !empty($data['password'])) {
            $this->db->table('users')->insert([
                'email'         => $data['email'],
                'password_hash' => $data['password'],
                'nama_lengkap'  => $data['nama_lengkap'],
                'role_id'       => $data['role_id'] ?? 5,
                'alumni_id'     => $alumniId,
                'is_active'     => 1,
                'created_at'    => date('Y-m-d H:i:s')
            ]);
        }

        $this->db->transComplete();
        return $this->db->transStatus() ? $alumniId : false;
    }

    private function generateUniqueReferralCode(): string
    {
        helper('text');
        $code = random_string('alnum', 8);
        while ($this->where('referral', $code)->countAllResults() > 0) {
            $code = random_string('alnum', 8);
        }
        return $code;
    }

    public function formatTanggalIndo(?string $tanggal): string
    {
        if (!$tanggal || $tanggal == '0000-00-00') return '-';
        $bulan = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $split = explode('-', $tanggal);
        return $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];
    }

    public function getAlumniRankDataByAngkatanAndRegisterDate($angkatan) {
        return $this->db->table('alumni')
            ->select('alumni.id_alumni, alumni.created_at') // Select necessary fields for ranking
            ->join('pendidikan', 'pendidikan.alumni_id = alumni.id_alumni', 'left')
            ->where('pendidikan.angkatan', $angkatan) // Filter by specific angkatan
            ->orderBy('alumni.created_at', 'ASC') // Primary sort by register date
            ->orderBy('alumni.id_alumni', 'ASC') // Secondary sort for tie-breaking
            ->get()
            ->getResult();
    }

    public function getAlumniRankDataGlobalByRegisterDate() {
        return $this->db->table('alumni')
            ->select('alumni.id_alumni, alumni.created_at') // Select necessary fields for ranking
            ->orderBy('alumni.created_at', 'ASC') // Primary sort by register date
            ->orderBy('alumni.id_alumni', 'ASC') // Secondary sort for tie-breaking
            ->get()
            ->getResult();
    }

    public function get_alumni_rank_by_angkatan($alumni_id, $angkatan) {
        $rank = 0;
        $previous_sort_value = null; // To track created_at for tie-breaking
        $rank_counter = 0;
        $results = $this->getAlumniRankDataByAngkatanAndRegisterDate($angkatan); // Get the sorted list

        foreach ($results as $row) {
            $rank_counter++;
            // If the current created_at is different from the previous one, update rank
            if ($row->created_at != $previous_sort_value) {
                $rank = $rank_counter;
            }
            if ($row->id_alumni == $alumni_id) {
                return $rank;
            }
            $previous_sort_value = $row->created_at;
        }
        return $rank; // Return 0 if alumni_id not found in the list
    }

    public function get_alumni_rank_global($alumni_id) {
        $rank = 0;
        $previous_sort_value = null; // To track created_at for tie-breaking
        $rank_counter = 0;
        $results = $this->getAlumniRankDataGlobalByRegisterDate(); // Get the sorted list

        foreach ($results as $row) {
            $rank_counter++;
            // If the current created_at is different from the previous one, update rank
            if ($row->created_at != $previous_sort_value) {
                $rank = $rank_counter;
            }
            if ($row->id_alumni == $alumni_id) {
                return $rank;
            }
            $previous_sort_value = $row->created_at;
        }
        return $rank; // Return 0 if alumni_id not found in the list
    }

    public function get_provinsi() {
        return $this->db->table('provinsi')->get()->getResult();
    }

    public function get_all_pekerjaan() {
        return $this->db->table('ref_pekerjaan')->orderBy('grup_pekerjaan, nama_pekerjaan')->get()->getResult();
    }

    public function get_kabupaten_by_provinsi($provinsi_id) {
        return $this->db->table('kabupaten')->where('id_provinsi', $provinsi_id)->get()->getResult();
    }

    public function search_alumni_by_name($q, $limit, $offset) {
        return $this->builder()
            ->select('alumni.id_alumni, alumni.nama_lengkap, alumni.nama_panggilan, alumni.foto_profil, 
                      pendidikan.angkatan, pendidikan.jurusan, kabupaten.nama_kabupaten as kabupaten, 
                      provinsi.nama_provinsi as provinsi,
                      (SELECT COUNT(*) FROM alumni AS r WHERE r.referred_by = alumni.referral OR r.referred_by = CAST(alumni.id_alumni AS CHAR)) as ref_jumlah')
            ->join('pendidikan', 'pendidikan.alumni_id = alumni.id_alumni', 'left')
            ->join('kabupaten', 'kabupaten.id_kabupaten = alumni.kabupaten_id', 'left')
            ->join('provinsi', 'provinsi.id_provinsi = alumni.provinsi_id', 'left')
            ->groupStart()
                ->like('alumni.nama_lengkap', $q)
                ->orLike('alumni.nama_panggilan', $q)
            ->groupEnd()
            ->orderBy('alumni.nama_lengkap', 'ASC')
            ->get($limit, $offset)
            ->getResult();
    }

    public function count_search_alumni_by_name($q) {
        return $this->builder()
            ->groupStart()
                ->like('alumni.nama_lengkap', $q)
                ->orLike('alumni.nama_panggilan', $q)
            ->groupEnd()
            ->countAllResults();
    }
}
