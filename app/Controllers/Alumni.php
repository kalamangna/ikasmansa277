<?php

namespace App\Controllers;

use App\Models\AlumniModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class Alumni extends BaseController
{
    protected $alumniModel;
    protected $db;

    public function __construct()
    {
        $this->alumniModel = new AlumniModel();
        $this->db = \Config\Database::connect();
    }

    /**
     * List Alumni with integrated CI4 Pagination
     */
    public function index(): string
    {
        $search   = $this->request->getGet('q');
        $angkatan = $this->request->getGet('angkatan');

        $loggedInUserAngkatan = null;
        if (session()->get('id_alumni')) { // Check if user is logged in
            $userId = session()->get('id_alumni');
            $loggedInUserAngkatan = $this->alumniModel->getAngkatanByAlumniId($userId); 
        }

        // Apply default angkatan if not specified in URL
        // Prioritize GET parameter, then logged-in user's angkatan, then legacy session filter
        if ($angkatan === null) {
            if ($loggedInUserAngkatan !== null) {
                $angkatan = $loggedInUserAngkatan;
            } else if (session()->has('angkatan')) { // Fallback to legacy session filter if user's angkatan isn't found
                $angkatan = session()->get('angkatan');
            }
        }

        $page = (int)($this->request->getGet('page') ?? 1);
        $perPage = 20; // Default items per page
        $offset = ($page - 1) * $perPage;

        $totalAlumni = $this->alumniModel->countAllAlumni($search, $angkatan);
        
        $pager = \Config\Services::pager();
        $pager->makeLinks($page, $perPage, $totalAlumni);

        $data = [
            'alumni_list'       => $this->alumniModel->getAlumniPaginated($perPage, $offset, $search, $angkatan),
            'pager'             => $pager,
            'total_alumni'      => $totalAlumni,
            'current_page'      => $page,
            'per_page'          => $perPage,
            'search_query'      => $search,
            'selected_angkatan' => $angkatan,
            'angkatan_list'     => $this->alumniModel->getAngkatanListWithCounts(),
            'title'             => 'Daftar Alumni'
        ];

        return $this->render('alumni/list', $data);
    }

    /**
     * Show Alumni Detail
     */
    public function detail(?int $id = null): string
    {
        $alumni = $this->alumniModel->getAlumni($id);
        if (!$alumni) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'alumni'                    => $alumni,
            'show_edit'                 => $this->canEdit($id, $alumni->angkatan),
            'get_alumni_by_referred_by' => $this->alumniModel->getByReferredBy($id, $alumni->referral ?? null),
            'urutan_angkatan'           => $this->alumniModel->get_alumni_rank_by_angkatan($id, $alumni->angkatan),
            'urutan_alumni'             => $this->alumniModel->get_alumni_rank_global($id),
            'title'                     => 'Detail Alumni'
        ];

        return $this->render('alumni/detail', $data);
    }

    /**
     * Show Edit Alumni Form
     */
    public function edit(?int $id = null): string
    {
        // Check if an ID is provided
        if ($id === null) {
            return redirect()->back()->with('error', 'ID Alumni tidak ditemukan.');
        }

        $alumni = $this->alumniModel->getAlumni($id);

        // Check if alumni exists
        if (!$alumni) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Access Control
        if (!$this->canEdit($id, $alumni->angkatan)) {
            return redirect()->to('alumni/detail/' . $id)->with('error', 'Anda tidak memiliki izin untuk mengedit alumni ini.');
        }

        // Fetch all provinces
        $provinces = $this->alumniModel->get_provinsi();
        // Fetch kabupatens for the selected province (if any)
        $kabupatens = [];
        if ($alumni->provinsi_id) {
            $kabupatens = $this->alumniModel->get_kabupaten_by_provinsi($alumni->provinsi_id);
        }

        $data = [
            'alumni'         => $alumni,
            'provinsi'       => $provinces,
            'kabupaten'      => $kabupatens,
            'pekerjaan_list' => $this->alumniModel->get_all_pekerjaan(),
            'title'          => 'Edit Alumni'
        ];

        return $this->render('alumni/edit_form', $data);
    }

    /**
     * Process Update Alumni Data
     */
    public function update($id)
    {
        // Access Control (re-check canEdit here)
        $alumni = $this->alumniModel->getAlumni($id);
        if (!$alumni) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        if (!$this->canEdit($id, $alumni->angkatan)) {
            return redirect()->to('alumni/detail/' . $id)->with('error', 'Anda tidak memiliki izin untuk mengedit alumni ini.');
        }

        // Validate input
        if (!$this->validate([
            'nama_lengkap' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'angkatan' => 'required',
            'jurusan' => 'required',
            'provinsi_id' => 'required',
            'kabupaten_id' => 'required',
            'alamat_domisili' => 'required',
            'no_telepon' => 'required',
            'foto' => 'max_size[foto,10240]|mime_in[foto,image/png,image/jpg,image/jpeg]', // 10MB max, png/jpg
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $postData = $this->request->getPost();

        // Handle file upload
        $fileName = $alumni->foto_profil; // Keep existing file if not new one
        $img = $this->request->getFile('foto');

        if ($img && $img->isValid() && !$img->hasMoved()) {
            // Delete old photo if exists
            if (!empty($fileName) && file_exists(FCPATH . 'uploads/foto_alumni/' . $fileName)) {
                unlink(FCPATH . 'uploads/foto_alumni/' . $fileName);
            }
            $fileName = $img->getRandomName();
            $img->move(FCPATH . 'uploads/foto_alumni', $fileName);

            // Update session foto_profil if the current user is being updated
            if (session()->get('id_alumni') == $id) {
                session()->set('foto_profil', $fileName);
            }
        }
        $postData['foto_profil'] = $fileName;

        // Update alumni data
        $this->db->transStart();

        $alumniData = array_intersect_key($postData, array_flip($this->alumniModel->allowedFields));
        $this->alumniModel->update($id, $alumniData);

        // Update pendidikan data
        $this->db->table('pendidikan')
                 ->where('alumni_id', $id)
                 ->update([
                     'angkatan'  => $postData['angkatan'] ?? null,
                     'jurusan'   => $postData['jurusan'] ?? null
                 ]);

        // Update pekerjaan data
        // Check if pekerjaan exists, if not, insert
        $existingPekerjaan = $this->db->table('pekerjaan')->where('alumni_id', $id)->get()->getRow();
        $pekerjaanData = [
            'id_ref_pekerjaan' => $postData['id_ref_pekerjaan'] ?? null,
            'nama_perusahaan'  => $postData['nama_perusahaan'] ?? null,
            'jabatan'          => $postData['jabatan'] ?? null,
            'alamat_kantor'    => $postData['alamat_kantor'] ?? null
        ];

        if ($existingPekerjaan) {
            $this->db->table('pekerjaan')
                     ->where('alumni_id', $id)
                     ->update($pekerjaanData);
        } else {
            $pekerjaanData['alumni_id'] = $id;
            $this->db->table('pekerjaan')->insert($pekerjaanData);
        }

        // Update keterangan_tambahan data
        $existingKeterangan = $this->db->table('keterangan_tambahan')->where('alumni_id', $id)->get()->getRow();
        $keteranganData = [
            'bergabung_komunitas'  => $postData['bergabung_komunitas'] ?? 0,
            'partisipasi_kegiatan' => $postData['partisipasi_kegiatan'] ?? 0,
            'saran_masukan'        => $postData['saran_masukan'] ?? null
        ];

        if ($existingKeterangan) {
            $this->db->table('keterangan_tambahan')
                     ->where('alumni_id', $id)
                     ->update($keteranganData);
        } else {
            $keteranganData['alumni_id'] = $id;
            $this->db->table('keterangan_tambahan')->insert($keteranganData);
        }
        
        // Update user email if provided
        if (!empty($postData['email'])) {
            $this->db->table('users')
                     ->where('alumni_id', $id)
                     ->update(['email' => $postData['email']]);
        }


        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan perubahan.');
        }

        return redirect()->to('alumni/detail/' . $id)->with('success', 'Data alumni berhasil diperbarui.');
    }

    /**
     * Upload photo for alumni
     */
    public function uploadPhoto(?int $id = null): ResponseInterface
    {
        // Check if an ID is provided
        if ($id === null) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                                  ->setJSON(['status' => 'error', 'message' => 'ID Alumni tidak ditemukan.']);
        }

        $alumni = $this->alumniModel->getAlumni($id);

        // Check if alumni exists
        if (!$alumni) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                                  ->setJSON(['status' => 'error', 'message' => 'Alumni tidak ditemukan.']);
        }

        // Access Control
        if (!$this->canEdit($id, $alumni->angkatan)) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_FORBIDDEN)
                                  ->setJSON(['status' => 'error', 'message' => 'Anda tidak memiliki izin untuk mengedit alumni ini.']);
        }

        // Validate input
        if (!$this->validate([
            'foto_profil' => 'uploaded[foto_profil]|max_size[foto_profil,10240]|mime_in[foto_profil,image/png,image/jpg,image/jpeg]', // 10MB max, png/jpg
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors())->with('openModal', 'uploadPhotoModal');
        }

        $img = $this->request->getFile('foto_profil');
        $fileName = $alumni->foto_profil; // Keep existing file if not new one

        if ($img && $img->isValid() && !$img->hasMoved()) {
            // Delete old photo if exists
            if (!empty($fileName) && file_exists(FCPATH . 'uploads/foto_alumni/' . $fileName)) {
                unlink(FCPATH . 'uploads/foto_alumni/' . $fileName);
            }
            $fileName = $img->getRandomName();
            $img->move(FCPATH . 'uploads/foto_alumni', $fileName);
        }

        // Update alumni data with new photo file name
        $this->alumniModel->update($id, ['foto_profil' => $fileName]);

        // Update session foto_profil
        session()->set('foto_profil', $fileName);

        return redirect()->to('alumni/detail/' . $id)->with('success', 'Foto profil berhasil diunggah.');
    }

    /**
     * API to get kabupaten list by provinsi ID
     */
    public function getKabupatenApi(?int $provinsiId = null)
    {
        if ($provinsiId === null) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                                  ->setJSON(['error' => 'Provinsi ID is required.']);
        }

        $kabupatens = $this->alumniModel->get_kabupaten_by_provinsi($provinsiId);

        return $this->response->setJSON($kabupatens);
    }


    /**
     * Registration Form
     */
    public function create(): string
    {
        $referred_by = null;
        if (session()->get('role') != 'admin' && session()->get('role') != 'admin_angkatan') {
             $referred_by_code = $this->request->getGet('ut');
             if (empty($referred_by_code)) {
                 session()->setFlashdata('error', 'Link referral diperlukan.');
                 return redirect()->to('welcome');
             }
             $ref_alumni = $this->alumniModel->getByReferral($referred_by_code);
             if (!$ref_alumni) {
                 session()->setFlashdata('error', 'Referral invalid.');
                 return redirect()->to('welcome');
             }
             $referred_by = $ref_alumni->referral;
        }

        $data = [
            'provinsi'       => $this->alumniModel->get_provinsi(),
            'pekerjaan_list' => $this->alumniModel->get_all_pekerjaan(),
            'referred_by'    => $referred_by,
            'title'          => 'Registrasi Alumni'
        ];
        
        return $this->render('alumni/form', $data);
    }

    /**
     * Process Registration
     */
    public function save()
    {
        if (!$this->validate([
            'nama_lengkap' => 'required'
        ])) {
            return $this->create();
        }

        $img = $this->request->getFile('foto');
        $fileName = null;

        if ($img && $img->isValid() && !$img->hasMoved()) {
            $fileName = $img->getRandomName();
            $img->move(FCPATH . 'uploads/foto_alumni', $fileName);
        }

        $postData = $this->request->getPost();
        $postData['foto_profil'] = $fileName;
        $postData['password']    = password_hash(bin2hex(random_bytes(4)), PASSWORD_DEFAULT);
        $postData['role_id']     = 5;
        $postData['created_at']  = date('Y-m-d H:i:s');

        if ($this->alumniModel->createAlumni($postData)) {
            return redirect()->to('auth/login')->with('success', 'Registrasi berhasil.');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal registrasi.');
    }

    /**
     * Refactored Access Control
     */
    private function canEdit(int $targetId, $targetAngkatan): bool
    {
        $role = session()->get('role');
        $myId = session()->get('id_alumni');
        $myAngkatan = session()->get('angkatan');

        if ($role === 'admin') return true;
        if ($myId == $targetId) return true;
        if ($role === 'admin_angkatan' && $myAngkatan == $targetAngkatan) return true;

        return false;
    }

    public function search(): string
    {
        $search = $this->request->getGet('q');
        $perPage = 50;

        $page = (int)($this->request->getGet('page') ?? 1);
        $offset = ($page - 1) * $perPage;

        $totalResults = $this->alumniModel->count_search_alumni_by_name($search);
        
        $pager = \Config\Services::pager();
        $pager->makeLinks($page, $perPage, $totalResults);

        $data = [
            'keyword'           => $search,
            'results'           => $this->alumniModel->search_alumni_by_name($search, $perPage, $offset),
            'pager'             => $pager,
            'total_results'     => $totalResults,
            'current_page'      => $page,
            'per_page'          => $perPage,
            'current_offset'    => $offset, // Added this line
            'title'             => 'Hasil Pencarian'
        ];
        
        return $this->render('alumni/search_results', $data);
    }
}