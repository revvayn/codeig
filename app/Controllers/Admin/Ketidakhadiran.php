<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KetidakhadiranModel;

class Ketidakhadiran extends BaseController
{
    public function index()
    {
        $idPerusahaan = (int) session()->get('id_perusahaan');
        $status       = $this->request->getGet('status');

        $model = new KetidakhadiranModel();

        return view('admin/ketidakhadiran/index', [
            'title'   => 'Data Ketidakhadiran',
            'data'    => $model->denganPegawai($idPerusahaan, $status ?: null),
            'status'  => $status,
        ]);
    }

    public function updateStatus($id)
    {
        $model        = new KetidakhadiranModel();
        $idPerusahaan = (int) session()->get('id_perusahaan');
        $data         = $model->denganPegawaiById((int) $id);

        if (! $data || (int) $data['id_perusahaan'] !== $idPerusahaan) {
            session()->setFlashdata('error', 'Data pengajuan tidak ditemukan pada perusahaan Anda.');
            return redirect()->to(base_url('admin/ketidakhadiran'));
        }

        $status = $this->request->getPost('status');
        if (! in_array($status, ['Disetujui', 'Ditolak', 'Menunggu'], true)) {
            session()->setFlashdata('error', 'Status pengajuan tidak valid.');
            return redirect()->to(base_url('admin/ketidakhadiran'));
        }

        $model->update($id, ['status_pengajuan' => $status]);
        \App\Models\AuditLogModel::catat('update_status', 'ketidakhadiran', (int) $id, 'Status menjadi ' . $status);
        session()->setFlashdata('success', 'Status pengajuan berhasil diubah menjadi ' . $status . '.');

        return redirect()->to(base_url('admin/ketidakhadiran'));
    }
}
