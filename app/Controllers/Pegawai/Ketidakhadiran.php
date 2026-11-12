<?php

namespace App\Controllers\Pegawai;

use App\Controllers\BaseController;
use App\Models\KetidakhadiranModel;

class Ketidakhadiran extends BaseController
{
    public function index()
    {
        $idPegawai = (int) session()->get('id_pegawai');

        return view('pegawai/ketidakhadiran/index', [
            'title' => 'Pengajuan Ketidakhadiran',
            'data'  => (new KetidakhadiranModel())->byPegawai($idPegawai),
        ]);
    }

    public function create()
    {
        return view('pegawai/ketidakhadiran/create', [
            'title'      => 'Ajukan Ketidakhadiran',
            'validation' => \Config\Services::validation(),
        ]);
    }

    public function store()
    {
        $rules = [
            'keterangan' => [
                'rules'  => 'required|in_list[Izin,Sakit,Cuti]',
                'errors' => ['required' => 'Keterangan wajib dipilih.', 'in_list' => 'Keterangan tidak valid.'],
            ],
            'tanggal' => [
                'rules'  => 'required|valid_date[Y-m-d]',
                'errors' => ['required' => 'Tanggal wajib diisi.', 'valid_date' => 'Format tanggal tidak valid.'],
            ],
            'deskripsi' => [
                'rules'  => 'required|min_length[5]|max_length[225]',
                'errors' => ['required' => 'Deskripsi wajib diisi.', 'min_length' => 'Deskripsi minimal 5 karakter.'],
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('file');
        $namaFile = '';

        if ($file && $file->isValid() && ! $file->hasMoved()) {
            if ($file->getSize() > 5 * 1024 * 1024) {
                session()->setFlashdata('error', 'Ukuran lampiran maksimal 5 MB.');
                return redirect()->back()->withInput();
            }

            $mime = $file->getMimeType();
            if (! in_array($mime, ['image/jpeg', 'image/png', 'application/pdf'], true)) {
                session()->setFlashdata('error', 'Lampiran harus berupa JPG, PNG, atau PDF.');
                return redirect()->back()->withInput();
            }

            $folder = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'ketidakhadiran';
            if (! is_dir($folder)) {
                mkdir($folder, 0775, true);
            }

            $namaFile = $file->getRandomName();
            $file->move($folder, $namaFile);
        }

        (new KetidakhadiranModel())->insert([
            'id_pegawai'       => (int) session()->get('id_pegawai'),
            'keterangan'       => $this->request->getPost('keterangan'),
            'tanggal'          => $this->request->getPost('tanggal'),
            'deskripsi'        => $this->request->getPost('deskripsi'),
            'file'             => $namaFile,
            'status_pengajuan' => 'Menunggu',
        ]);

        session()->setFlashdata('success', 'Pengajuan ketidakhadiran berhasil dikirim dan menunggu persetujuan admin.');

        return redirect()->to(base_url('pegawai/ketidakhadiran'));
    }
}
