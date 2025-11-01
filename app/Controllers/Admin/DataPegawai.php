<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PegawaiModel;
use App\Models\UserModel;

class DataPegawai extends BaseController
{
    public function index()
    {
        $PegawaiModel = new PegawaiModel();
        $data = [
            'title' => 'Data Data Pegawai ',
            'data_pegawai' => $PegawaiModel->findAll(),
        ];
        return view('admin/data_pegawai/data_pegawai', $data);
    }
    public function detail($id)
    {
        $PegawaiModel = new PegawaiModel();
        $data = [
            'title' => 'Detail Data Pegawai',
            'data_pegawai' => $PegawaiModel->find($id),
        ];
        return view('admin/data_pegawai/detail', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Data Pegawai',
            'validation' => \Config\Services::validation(),
        ];
        return view('admin/data_pegawai/create', $data);
    }
    public function store()
    {
        $rules = [
            'nama_lokasi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Lokasi harus diisi.',
                ],
            ],
            'alamat_lokasi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Alamat harus diisi.',
                ],
            ],
            'tipe_lokasi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tipe Lokasi harus diisi.',
                ],
            ],
            'latitude' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Latitude harus diisi.',
                ],
            ],
            'longitude' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Longitude harus diisi.',
                ],
            ],
            'radius' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Radius harus diisi.',
                ],
            ],
            'zona_waktu' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Zona Waktu harus diisi.',
                ],
            ],
            'jam_masuk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jam Masuk harus diisi.',
                ],
            ],
            'jam_pulang' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jam Pulang harus diisi.',
                ],
            ],
        ];
        if (!$this->validate($rules)) {
            $data = [
                'title' => 'Tambah Data Pegawai',
                'validation' => \Config\Services::validation(),
            ];
            echo view('admin/data_pegawai/create', $data);
        } else {
            $PegawaiModel = new PegawaiModel();
            $PegawaiModel->insert([
                'nama_lokasi' => $this->request->getPost('nama_lokasi'),
                'alamat_lokasi' => $this->request->getPost('alamat_lokasi'),
                'tipe_lokasi' => $this->request->getPost('tipe_lokasi'),
                'latitude' => $this->request->getPost('latitude'),
                'longitude' => $this->request->getPost('longitude'),
                'radius' => $this->request->getPost('radius'),
                'zona_waktu' => $this->request->getPost('zona_waktu'),
                'jam_masuk' => $this->request->getPost('jam_masuk'),
                'jam_pulang' => $this->request->getPost('jam_pulang'),
            ]);
            session()->setFlashdata('success', 'Data Pegawai berhasil ditambahkan.');

            return redirect()->to(base_url('admin/data_pegawai'));
        }
    }
    public function edit($id)
    {
        $PegawaiModel = new PegawaiModel();
        $data = [
            'title' => 'Edit Data Pegawai',
            'data_pegawai' => $PegawaiModel->find($id),
            'validation' => \Config\Services::validation(),
        ];
        return view('admin/data_pegawai/edit', $data);
    }
    public function update($id)
    {
        $PegawaiModel = new PegawaiModel();
        $rules = [
            'nama_lokasi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Lokasi harus diisi.',
                ],
            ],
            'alamat_lokasi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Alamat harus diisi.',
                ],
            ],
            'tipe_lokasi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tipe Lokasi harus diisi.',
                ],
            ],
            'latitude' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Latitude harus diisi.',
                ],
            ],
            'longitude' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Longitude harus diisi.',
                ],
            ],
            'radius' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Radius harus diisi.',
                ],
            ],
            'zona_waktu' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Zona Waktu harus diisi.',
                ],
            ],
            'jam_masuk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jam Masuk harus diisi.',
                ],
            ],
            'jam_pulang' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jam Pulang harus diisi.',
                ],
            ],
        ];
        if (!$this->validate($rules)) {
            $data = [
                'title' => 'Edit Data Pegawai',
                'data_pegawai' => $PegawaiModel->find($id),
                'validation' => \Config\Services::validation(),
            ];
            echo view('admin/data_pegawai/edit', $data);
        } else {
            $PegawaiModel = new PegawaiModel();
            $PegawaiModel->update($id, [
                'nama_lokasi' => $this->request->getPost('nama_lokasi'),
                'alamat_lokasi' => $this->request->getPost('alamat_lokasi'),
                'tipe_lokasi' => $this->request->getPost('tipe_lokasi'),
                'latitude' => $this->request->getPost('latitude'),
                'longitude' => $this->request->getPost('longitude'),
                'radius' => $this->request->getPost('radius'),
                'zona_waktu' => $this->request->getPost('zona_waktu'),
                'jam_masuk' => $this->request->getPost('jam_masuk'),
                'jam_pulang' => $this->request->getPost('jam_pulang'),
            ]);
            session()->setFlashdata('success', 'Data Pegawai berhasil diupdate.');

            return redirect()->to(base_url('admin/data_pegawai'));
        }
    }
    public function delete($id)
    {
        $PegawaiModel = new PegawaiModel();
        $PegawaiModel->delete($id);

        session()->setFlashdata('success', 'Data Pegawai berhasil dihapus!');
        return redirect()->to(base_url('admin/data_pegawai'));
    }
}
