<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\JabatanModel;

class Jabatan extends BaseController
{
    public function index()
    {
        $jabatan_model = new JabatanModel();
        $data = [
            'title' => 'Data Jabatan',
            'jabatan' => $jabatan_model->findAll(),
        ];
        return view('admin/jabatan/jabatan', $data);
    }
    public function create()
    {
        $data = [
            'title' => 'Tambah Jabatan',
            'validation' => \Config\Services::validation(),
        ];
        return view('admin/jabatan/create', $data);
    }
    public function store()
    {
        $rules = [
            'jabatan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Jabatan harus diisi.',
                ],
            ],
        ];
        if (!$this->validate($rules)) {
            $data = [
                'title' => 'Tambah Jabatan',
                'validation' => \Config\Services::validation(),
            ];
            echo view('admin/jabatan/create', $data);
        } else {
            $jabatan_model = new JabatanModel();
            $jabatan_model->insert([
                'jabatan' => $this->request->getPost('jabatan'),
            ]);
            session()->setFlashdata('success', 'Jabatan berhasil ditambahkan.');

            return redirect()->to(base_url('admin/jabatan'));
        }
    }
    public function edit($id)
    {
        $jabatan_model = new JabatanModel();
        $data = [
            'title' => 'Edit Jabatan',
            'jabatan' => $jabatan_model->find($id),
            'validation' => \Config\Services::validation(),
        ];
        return view('admin/jabatan/edit', $data);
    }
    public function update($id)
    {
        $jabatan_model = new JabatanModel();
        $rules = [
            'jabatan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Jabatan harus diisi.',
                ],
            ],
        ];
        if (!$this->validate($rules)) {
            $data = [
                'title' => 'Edit Jabatan',
                'jabatan' => $jabatan_model->find($id),
                'validation' => \Config\Services::validation(),
            ];
            echo view('admin/jabatan/edit', $data);
        } else {
            $jabatan_model = new JabatanModel();
            $jabatan_model->update($id, [
                'jabatan' => $this->request->getPost('jabatan'),
            ]);
            session()->setFlashdata('success', 'Jabatan berhasil diupdate.');

            return redirect()->to(base_url('admin/jabatan'));
        }
    }
    public function delete($id)
    {
        $jabatanModel = new JabatanModel();
        $jabatanModel->delete($id);

        session()->setFlashdata('success', 'Data jabatan berhasil dihapus!');
        return redirect()->to(base_url('admin/jabatan'));
    }
}
