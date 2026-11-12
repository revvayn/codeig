<?php

namespace App\Controllers\Superadmin;

use App\Controllers\BaseController;
use App\Models\PerusahaanModel;
use App\Models\PegawaiModel;

class Perusahaan extends BaseController
{
    public function index()
    {
        $model = new PerusahaanModel();

        return view('superadmin/perusahaan/index', [
            'title'      => 'Data Perusahaan',
            'perusahaan' => $model->orderBy('nama_perusahaan', 'ASC')->findAll(),
        ]);
    }

    public function create()
    {
        return view('superadmin/perusahaan/create', [
            'title'      => 'Tambah Perusahaan',
            'validation' => \Config\Services::validation(),
        ]);
    }

    public function store()
    {
        if (! $this->validate($this->rules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        (new PerusahaanModel())->insert([
            'nama_perusahaan' => $this->request->getPost('nama_perusahaan'),
            'alamat'          => $this->request->getPost('alamat'),
            'telepon'         => $this->request->getPost('telepon'),
            'email'           => $this->request->getPost('email'),
            'status'          => $this->request->getPost('status') ?: 'Aktif',
        ]);

        session()->setFlashdata('success', 'Data perusahaan berhasil ditambahkan.');

        return redirect()->to(base_url('superadmin/perusahaan'));
    }

    public function edit($id)
    {
        $model = new PerusahaanModel();
        $data  = $model->find($id);

        if (! $data) {
            session()->setFlashdata('error', 'Data perusahaan tidak ditemukan.');
            return redirect()->to(base_url('superadmin/perusahaan'));
        }

        return view('superadmin/perusahaan/edit', [
            'title'      => 'Edit Perusahaan',
            'perusahaan' => $data,
            'validation' => \Config\Services::validation(),
        ]);
    }

    public function update($id)
    {
        $model = new PerusahaanModel();
        if (! $model->find($id)) {
            session()->setFlashdata('error', 'Data perusahaan tidak ditemukan.');
            return redirect()->to(base_url('superadmin/perusahaan'));
        }

        if (! $this->validate($this->rules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model->update($id, [
            'nama_perusahaan' => $this->request->getPost('nama_perusahaan'),
            'alamat'          => $this->request->getPost('alamat'),
            'telepon'         => $this->request->getPost('telepon'),
            'email'           => $this->request->getPost('email'),
            'status'          => $this->request->getPost('status') ?: 'Aktif',
        ]);

        session()->setFlashdata('success', 'Data perusahaan berhasil diperbarui.');

        return redirect()->to(base_url('superadmin/perusahaan'));
    }

    public function delete($id)
    {
        $model        = new PerusahaanModel();
        $pegawaiModel = new PegawaiModel();

        if (! $model->find($id)) {
            session()->setFlashdata('error', 'Data perusahaan tidak ditemukan.');
            return redirect()->to(base_url('superadmin/perusahaan'));
        }

        if ($pegawaiModel->jumlahPerusahaan((int) $id) > 0) {
            session()->setFlashdata('error', 'Perusahaan tidak bisa dihapus karena masih memiliki data pegawai.');
            return redirect()->to(base_url('superadmin/perusahaan'));
        }

        $model->delete($id);
        session()->setFlashdata('success', 'Data perusahaan berhasil dihapus.');

        return redirect()->to(base_url('superadmin/perusahaan'));
    }

    private function rules(): array
    {
        return [
            'nama_perusahaan' => [
                'rules'  => 'required|min_length[3]|max_length[150]',
                'errors' => ['required' => 'Nama perusahaan wajib diisi.', 'min_length' => 'Nama perusahaan minimal 3 karakter.'],
            ],
            'email' => [
                'rules'  => 'permit_empty|valid_email',
                'errors' => ['valid_email' => 'Format email tidak valid.'],
            ],
            'status' => [
                'rules'  => 'permit_empty|in_list[Aktif,Tidak Aktif]',
                'errors' => ['in_list' => 'Status tidak valid.'],
            ],
        ];
    }
}
