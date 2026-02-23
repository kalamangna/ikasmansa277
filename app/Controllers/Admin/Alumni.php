<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AlumniModel;

class Alumni extends BaseController
{
    protected $alumniModel;

    public function __construct()
    {
        $this->alumniModel = new AlumniModel();
    }

    public function index(): string
    {
        $search   = $this->request->getGet('q');
        $angkatan = $this->request->getGet('angkatan');
        $perPage  = 50;

        $data = [
            'alumni_list'       => $this->alumniModel->getAlumniPaginated($perPage, ($this->request->getGet('page') ?? 1 - 1) * $perPage, $search, $angkatan),
            'pager'             => $this->alumniModel->pager,
            'total_alumni'      => $this->alumniModel->countAllAlumni($search, $angkatan),
            'current_page'      => $this->request->getGet('page') ?? 1,
            'per_page'          => $perPage,
            'search_query'      => $search,
            'selected_angkatan' => $angkatan,
            'angkatan_list'     => $this->alumniModel->getAngkatanListWithCounts(),
            'title'             => 'Manajemen Alumni'
        ];

        return $this->render('alumni/list', $data);
    }

    public function edit(int $id)
    {
        $alumni = $this->alumniModel->getAlumni($id);
        if (!$alumni) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'nama_lengkap' => 'required|trim',
            'angkatan'     => 'required|numeric'
        ];

        if ($this->request->is('post') && $this->validate($rules)) {
            $updateData = $this->request->getPost();
            if ($this->alumniModel->update($id, $updateData)) {
                session()->setFlashdata('success', 'Data alumni berhasil diperbarui.');
                return redirect()->to('admin/alumni/detail/' . $id);
            } else {
                session()->setFlashdata('error', 'Gagal memperbarui data.');
                return redirect()->to('admin/alumni/edit/' . $id);
            }
        }

        $data = [
            'alumni'         => $alumni,
            'provinsi'       => $this->alumniModel->get_provinsi(),
            'kabupaten'      => ($alumni->provinsi_id) ? $this->alumniModel->get_kabupaten_by_provinsi($alumni->provinsi_id) : [],
            'pekerjaan_list' => $this->alumniModel->get_all_pekerjaan(),
            'title'          => 'Edit Alumni (Admin)'
        ];
        return $this->render('alumni/edit', $data);
    }

    public function detail(int $id): string
    {
        $alumni = $this->alumniModel->getAlumni($id);
        if (!$alumni) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'alumni'    => $alumni,
            'title'     => 'Detail Alumni',
            'show_edit' => true
        ];
        
        return $this->render('alumni/detail', $data);
    }

    public function delete(int $id)
    {
        $alumni = $this->alumniModel->find($id);
        if ($alumni) {
            if ($alumni->foto_profil && file_exists(FCPATH . 'uploads/foto_alumni/' . $alumni->foto_profil)) {
                unlink(FCPATH . 'uploads/foto_alumni/' . $alumni->foto_profil);
            }
            $this->alumniModel->delete($id);
            session()->setFlashdata('success', 'Alumni berhasil dihapus.');
        } else {
            session()->setFlashdata('error', 'Alumni tidak ditemukan.');
        }
        return redirect()->to('admin/alumni');
    }
}