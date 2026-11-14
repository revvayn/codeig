<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LokasiPresensiModel;
use App\Models\PerusahaanModel;
use App\Models\PegawaiModel;

class Perusahaan extends BaseController
{
    public function index()
    {
        $idPerusahaan = $this->idPerusahaan();
        $data         = (new PerusahaanModel())->find($idPerusahaan);

        if (! $data) {
            session()->setFlashdata('error', 'Data perusahaan tidak ditemukan.');

            return redirect()->to(base_url('admin/home'));
        }

        return view('admin/perusahaan/index', [
            'title'         => 'Data Perusahaan',
            'perusahaan'    => $data,
            'jumlahPegawai' => (new PegawaiModel())->jumlahPegawaiPerusahaan($idPerusahaan),
            'jumlahLokasi'  => (new LokasiPresensiModel())->where('id_perusahaan', $idPerusahaan)->countAllResults(),
        ]);
    }

    public function create()
    {
        // Admin hanya mengelola perusahaannya sendiri, bukan menambah perusahaan baru.
        return redirect()->to(base_url('admin/perusahaan'));
    }

    public function store()
    {
        // Admin hanya mengelola perusahaannya sendiri, bukan menambah perusahaan baru.
        return redirect()->to(base_url('admin/perusahaan'));
    }

    public function edit($id)
    {
        $model = new PerusahaanModel();
        $data  = $model->find($id);

        if (! $data || ! $this->milikSendiri($id)) {
            session()->setFlashdata('error', 'Anda hanya dapat mengelola data perusahaan sendiri.');

            return redirect()->to(base_url('admin/perusahaan'));
        }

        return view('admin/perusahaan/edit', [
            'title'      => 'Edit Perusahaan',
            'perusahaan' => $data,
            'validation' => \Config\Services::validation(),
        ]);
    }

    public function update($id)
    {
        $model = new PerusahaanModel();
        if (! $model->find($id) || ! $this->milikSendiri($id)) {
            session()->setFlashdata('error', 'Anda hanya dapat mengelola data perusahaan sendiri.');

            return redirect()->to(base_url('admin/perusahaan'));
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

        return redirect()->to(base_url('admin/perusahaan'));
    }

    public function delete($id)
    {
        // Admin tidak menghapus perusahaannya sendiri; penghapusan dilakukan Superadmin.
        session()->setFlashdata('error', 'Data perusahaan hanya dapat dihapus oleh Superadmin.');

        return redirect()->to(base_url('admin/perusahaan'));
    }

    private function idPerusahaan(): int
    {
        return (int) session()->get('id_perusahaan');
    }

    private function milikSendiri($id): bool
    {
        return (int) $id === $this->idPerusahaan();
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
