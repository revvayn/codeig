<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PegawaiModel;
use App\Models\UserModel;
use App\Models\LokasiPresensiModel;
use App\Models\JabatanModel;

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
            'data_pegawai' => $PegawaiModel->DetailPegawai($id),
        ];
        return view('admin/data_pegawai/detail', $data);
    }

    public function create()
    {
        $lokasi_presensi = new LokasiPresensiModel();
        $jabatan = new JabatanModel();
        $data = [
            'title' => 'Tambah Data Pegawai',
            'lokasi_presensi' => $lokasi_presensi->findAll(),
            'jabatan' => $jabatan->orderBy('jabatan', 'ASC')->findAll(),
            'validation' => \Config\Services::validation(),
        ];
        return view('admin/data_pegawai/create', $data);
    }

    public function generateNIP()
    {
        $PegawaiModel = new PegawaiModel();
        $PegawaiTerakhir = $PegawaiModel->select('nip')->orderBy('id', 'DESC')->first();
        $nipTerakhir = $PegawaiTerakhir ? $PegawaiTerakhir['nip'] : 'PEG-000000';
        $angkaNIP = (int) substr($nipTerakhir, 6);
        $angkaNIP++;
        return 'PEG-' . str_pad($angkaNIP, 6, '0', STR_PAD_LEFT);
    }

    public function store()
    {
        $rules = [
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama harus diisi.',
                ],
            ],
            'jenis_kelamin' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jenis Kelamin harus diisi.',
                ],
            ],
            'alamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Alamat harus diisi.',
                ],
            ],
            'no_handphone' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'No Handphone harus diisi.',
                ],
            ],
            'jabatan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jabatan harus diisi.',
                ],
            ],
            'lokasi_presensi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Lokasi presensi harus diisi.',
                ],
            ],
            'foto' => [
                'rules' => 'uploaded[foto]|max_size[foto,10240]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'required' => 'Foto harus diisi.',
                    'max_size' => 'Ukuran foto terlalu besar.',
                    'mime_in' => 'Format foto tidak valid. Hanya jpg, jpeg, png yang diperbolehkan.',
                ],
            ],
            'username' => [
                'rules' => 'required|alpha_numeric|min_length[5]|is_unique[users.username]',
                'errors' => [
                    'required' => 'Username harus diisi.',
                    'alpha_numeric' => 'Username hanya boleh berisi huruf dan angka.',
                    'min_length' => 'Username minimal 5 karakter.',
                    'is_unique' => 'Username sudah digunakan.',
                ],
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password harus diisi.',
                ],
            ],
            'konfirmasi_password' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Konfirmasi Password harus diisi.',
                    'matches' => 'Konfirmasi Password tidak sesuai dengan Password.',
                ],
            ],
            'role' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Role harus diisi.',
                ],
            ],
        ];
        if (!$this->validate($rules)) {
            $lokasi_presensi = new LokasiPresensiModel();
            $jabatan = new JabatanModel();
            $data = [
                'title' => 'Tambah Data Pegawai',
                'lokasi_presensi' => $lokasi_presensi->findAll(),
                'jabatan' => $jabatan->orderBy('jabatan', 'ASC')->findAll(),
                'validation' => \Config\Services::validation(),
            ];
            echo view('admin/data_pegawai/create', $data);
        } else {
            $nipNew = $this->generateNIP();
            $foto = $this->request->getFile('foto');
            if ($foto->getError() == 4) {
                $fotoName = '';
            } else {
                $fotoName = $foto->getRandomName();
                $foto->move('profile', $fotoName);
            }

            $PegawaiModel = new PegawaiModel();
            $PegawaiModel->insert([
                'nip' => $nipNew,
                'nama' => $this->request->getPost('nama'),
                'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
                'alamat' => $this->request->getPost('alamat'),
                'no_handphone' => $this->request->getPost('no_handphone'),
                'jabatan' => $this->request->getPost('jabatan'),
                'lokasi_presensi' => $this->request->getPost('lokasi_presensi'),
                'foto' => $fotoName,
            ]);
            $id_pegawai =$PegawaiModel->insertID();
            $UserModel = new UserModel();
            $UserModel->insert([
                'id_pegawai' => $id_pegawai,
                'username' => $this->request->getPost('username'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
                'status' => 'Aktif',
                'role' => $this->request->getPost('role'),
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
