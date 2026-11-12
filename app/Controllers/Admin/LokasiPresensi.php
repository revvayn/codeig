<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LokasiPresensiModel;

class LokasiPresensi extends BaseController
{
    private function idPerusahaan(): int
    {
        return (int) session()->get('id_perusahaan');
    }

    public function index()
    {
        $model = new LokasiPresensiModel();
        return view('admin/lokasi_presensi/lokasi_presensi', [
            'title'            => 'Data Lokasi Presensi',
            'lokasi_presensi'  => $model->where('id_perusahaan', $this->idPerusahaan())->orderBy('nama_lokasi', 'ASC')->findAll(),
        ]);
    }

    public function detail($id)
    {
        $model = new LokasiPresensiModel();
        $row   = $model->find($id);
        if (! $row || (int) $row['id_perusahaan'] !== $this->idPerusahaan()) {
            session()->setFlashdata('error', 'Lokasi presensi tidak ditemukan pada perusahaan Anda.');
            return redirect()->to(base_url('admin/lokasi_presensi'));
        }

        return view('admin/lokasi_presensi/detail', [
            'title'            => 'Detail Lokasi Presensi',
            'lokasi_presensi'  => $row,
        ]);
    }

    public function create()
    {
        return view('admin/lokasi_presensi/create', [
            'title'      => 'Tambah Lokasi Presensi (Plant)',
            'validation' => \Config\Services::validation(),
        ]);
    }

    public function store()
    {
        $rules = $this->rules();
        if (! $this->validate($rules)) {
            return view('admin/lokasi_presensi/create', [
                'title'      => 'Tambah Lokasi Presensi (Plant)',
                'validation' => \Config\Services::validation(),
            ]);
        }

        (new LokasiPresensiModel())->insert([
            'id_perusahaan'  => $this->idPerusahaan(),
            'nama_lokasi'    => $this->request->getPost('nama_lokasi'),
            'alamat_lokasi'  => $this->request->getPost('alamat_lokasi'),
            'tipe_lokasi'    => $this->request->getPost('tipe_lokasi'),
            'latitude'       => $this->request->getPost('latitude'),
            'longitude'      => $this->request->getPost('longitude'),
            'radius'         => $this->request->getPost('radius'),
            'zona_waktu'     => $this->request->getPost('zona_waktu'),
            'jam_masuk'      => $this->request->getPost('jam_masuk'),
            'jam_pulang'     => $this->request->getPost('jam_pulang'),
        ]);

        session()->setFlashdata('success', 'Lokasi presensi (plant) berhasil ditambahkan.');

        return redirect()->to(base_url('admin/lokasi_presensi'));
    }

    public function edit($id)
    {
        $model = new LokasiPresensiModel();
        $row   = $model->find($id);
        if (! $row || (int) $row['id_perusahaan'] !== $this->idPerusahaan()) {
            session()->setFlashdata('error', 'Lokasi presensi tidak ditemukan pada perusahaan Anda.');
            return redirect()->to(base_url('admin/lokasi_presensi'));
        }

        return view('admin/lokasi_presensi/edit', [
            'title'            => 'Edit Lokasi Presensi (Plant)',
            'lokasi_presensi'  => $row,
            'validation'       => \Config\Services::validation(),
        ]);
    }

    public function update($id)
    {
        $model = new LokasiPresensiModel();
        $row   = $model->find($id);
        if (! $row || (int) $row['id_perusahaan'] !== $this->idPerusahaan()) {
            session()->setFlashdata('error', 'Lokasi presensi tidak ditemukan pada perusahaan Anda.');
            return redirect()->to(base_url('admin/lokasi_presensi'));
        }

        $rules = $this->rules();
        if (! $this->validate($rules)) {
            return view('admin/lokasi_presensi/edit', [
                'title'            => 'Edit Lokasi Presensi (Plant)',
                'lokasi_presensi'  => $model->find($id),
                'validation'       => \Config\Services::validation(),
            ]);
        }

        $model->update($id, [
            'nama_lokasi'   => $this->request->getPost('nama_lokasi'),
            'alamat_lokasi' => $this->request->getPost('alamat_lokasi'),
            'tipe_lokasi'   => $this->request->getPost('tipe_lokasi'),
            'latitude'      => $this->request->getPost('latitude'),
            'longitude'     => $this->request->getPost('longitude'),
            'radius'        => $this->request->getPost('radius'),
            'zona_waktu'    => $this->request->getPost('zona_waktu'),
            'jam_masuk'     => $this->request->getPost('jam_masuk'),
            'jam_pulang'    => $this->request->getPost('jam_pulang'),
        ]);

        session()->setFlashdata('success', 'Lokasi presensi (plant) berhasil diperbarui.');

        return redirect()->to(base_url('admin/lokasi_presensi'));
    }

    public function delete($id)
    {
        $model = new LokasiPresensiModel();
        $row   = $model->find($id);
        if (! $row || (int) $row['id_perusahaan'] !== $this->idPerusahaan()) {
            session()->setFlashdata('error', 'Lokasi presensi tidak ditemukan pada perusahaan Anda.');
            return redirect()->to(base_url('admin/lokasi_presensi'));
        }

        $model->delete($id);

        session()->setFlashdata('success', 'Lokasi presensi (plant) berhasil dihapus.');

        return redirect()->to(base_url('admin/lokasi_presensi'));
    }

    private function rules(): array
    {
        return [
            'nama_lokasi' => ['rules' => 'required', 'errors' => ['required' => 'Nama Lokasi harus diisi.']],
            'alamat_lokasi' => ['rules' => 'required', 'errors' => ['required' => 'Alamat harus diisi.']],
            'tipe_lokasi' => ['rules' => 'required', 'errors' => ['required' => 'Tipe Lokasi harus diisi.']],
            'latitude' => ['rules' => 'required', 'errors' => ['required' => 'Latitude harus diisi.']],
            'longitude' => ['rules' => 'required', 'errors' => ['required' => 'Longitude harus diisi.']],
            'radius' => ['rules' => 'required', 'errors' => ['required' => 'Radius harus diisi.']],
            'zona_waktu' => ['rules' => 'required', 'errors' => ['required' => 'Zona Waktu harus diisi.']],
            'jam_masuk' => ['rules' => 'required', 'errors' => ['required' => 'Jam Masuk harus diisi.']],
            'jam_pulang' => ['rules' => 'required', 'errors' => ['required' => 'Jam Pulang harus diisi.']],
        ];
    }
}
