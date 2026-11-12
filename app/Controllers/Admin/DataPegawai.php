<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\JabatanModel;
use App\Models\KetidakhadiranModel;
use App\Models\LokasiPresensiModel;
use App\Models\PegawaiModel;
use App\Models\PresensiModel;
use App\Models\UserModel;

class DataPegawai extends BaseController
{
    public function __construct()
    {
        helper(['url', 'form']);
    }

    public function index()
    {
        $idPerusahaan = (int) session()->get('id_perusahaan');

        return view('admin/data_pegawai/data_pegawai', [
            'title'        => 'Data Pegawai',
            'data_pegawai' => (new PegawaiModel())->byPerusahaan($idPerusahaan),
        ]);
    }

    public function detail($id)
    {
        $pegawai = (new PegawaiModel())->DetailPegawai($id);

        if (! $pegawai || (int) $pegawai['id_perusahaan'] !== (int) session()->get('id_perusahaan')) {
            session()->setFlashdata('error', 'Data pegawai tidak ditemukan pada perusahaan Anda.');
            return redirect()->to(base_url('admin/data_pegawai'));
        }

        return view('admin/data_pegawai/detail', [
            'title'        => 'Detail Data Pegawai',
            'data_pegawai' => $pegawai,
        ]);
    }

    public function create()
    {
        $lokasi_presensi = new LokasiPresensiModel();
        $jabatan         = new JabatanModel();

        return view('admin/data_pegawai/create', [
            'title'           => 'Tambah Data Pegawai',
            'lokasi_presensi' => $lokasi_presensi->orderBy('nama_lokasi', 'ASC')->findAll(),
            'jabatan'         => $jabatan->orderBy('jabatan', 'ASC')->findAll(),
            'validation'      => \Config\Services::validation(),
        ]);
    }

    public function generateNIP()
    {
        $pegawaiModel    = new PegawaiModel();
        $pegawaiTerakhir = $pegawaiModel->select('nip')->orderBy('id', 'DESC')->first();
        $nipTerakhir     = $pegawaiTerakhir['nip'] ?? 'PEG-000000';
        $angkaNIP        = (int) substr($nipTerakhir, 4);
        $angkaNIP++;

        return 'PEG-' . str_pad((string) $angkaNIP, 6, '0', STR_PAD_LEFT);
    }

    public function store()
    {
        $rules = [
            'nama' => [
                'rules'  => 'required|min_length[3]|max_length[150]',
                'errors' => ['required' => 'Nama harus diisi.', 'min_length' => 'Nama minimal 3 karakter.'],
            ],
            'jenis_kelamin' => [
                'rules'  => 'required|in_list[Laki-laki,Perempuan]',
                'errors' => ['required' => 'Jenis Kelamin harus diisi.', 'in_list' => 'Jenis Kelamin tidak valid.'],
            ],
            'alamat' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Alamat harus diisi.'],
            ],
            'no_handphone' => [
                'rules'  => 'required|max_length[20]',
                'errors' => ['required' => 'No Handphone harus diisi.'],
            ],
            'jabatan' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Jabatan harus diisi.'],
            ],
            'lokasi_presensi' => [
                'rules'  => 'required|is_natural_no_zero',
                'errors' => ['required' => 'Lokasi presensi harus diisi.', 'is_natural_no_zero' => 'Lokasi presensi tidak valid.'],
            ],
            'foto' => [
                'rules'  => 'uploaded[foto]|max_size[foto,10240]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png,image/webp]',
                'errors' => [
                    'uploaded' => 'Foto harus diunggah.',
                    'max_size' => 'Ukuran foto terlalu besar (maksimal 10 MB).',
                    'is_image' => 'File harus berupa gambar.',
                    'mime_in'  => 'Format foto tidak valid. Gunakan JPG, JPEG, PNG, atau WEBP.',
                ],
            ],
            'username' => [
                'rules'  => 'required|alpha_numeric|min_length[5]|is_unique[users.username]',
                'errors' => [
                    'required'     => 'Username harus diisi.',
                    'alpha_numeric'=> 'Username hanya boleh berisi huruf dan angka.',
                    'min_length'   => 'Username minimal 5 karakter.',
                    'is_unique'    => 'Username sudah digunakan.',
                ],
            ],
            'password' => [
                'rules'  => 'required|min_length[5]',
                'errors' => ['required' => 'Password harus diisi.', 'min_length' => 'Password minimal 5 karakter.'],
            ],
            'konfirmasi_password' => [
                'rules'  => 'required|matches[password]',
                'errors' => ['required' => 'Konfirmasi Password harus diisi.', 'matches' => 'Konfirmasi Password tidak sesuai.'],
            ],
            'role' => [
                'rules'  => 'required|in_list[Admin,Pegawai]',
                'errors' => ['required' => 'Role harus diisi.', 'in_list' => 'Role tidak valid.'],
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $foto     = $this->request->getFile('foto');
        $fotoName = $foto->getRandomName();
        $foto->move(FCPATH . 'profile', $fotoName);

        $idPerusahaan = (int) session()->get('id_perusahaan');
        $pegawaiModel = new PegawaiModel();
        $pegawaiModel->insert([
            'id_perusahaan'   => $idPerusahaan,
            'nip'             => $this->generateNIP(),
            'nama'            => $this->request->getPost('nama'),
            'jenis_kelamin'   => $this->request->getPost('jenis_kelamin'),
            'alamat'          => $this->request->getPost('alamat'),
            'no_handphone'    => $this->request->getPost('no_handphone'),
            'jabatan'         => $this->request->getPost('jabatan'),
            'lokasi_presensi' => $this->request->getPost('lokasi_presensi'),
            'foto'            => $fotoName,
        ]);

        (new UserModel())->insert([
            'id_perusahaan' => $idPerusahaan,
            'id_pegawai'    => $pegawaiModel->insertID(),
            'username'      => $this->request->getPost('username'),
            'password'      => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'status'        => 'Aktif',
            'role'          => $this->request->getPost('role'),
        ]);

        session()->setFlashdata('success', 'Data pegawai berhasil ditambahkan.');

        return redirect()->to(base_url('admin/data_pegawai'));
    }

    public function edit($id)
    {
        $pegawai = (new PegawaiModel())->EditPegawai($id);

        if (! $pegawai || (int) $pegawai['id_perusahaan'] !== (int) session()->get('id_perusahaan')) {
            session()->setFlashdata('error', 'Data pegawai tidak ditemukan pada perusahaan Anda.');
            return redirect()->to(base_url('admin/data_pegawai'));
        }

        $lokasi_presensi = new LokasiPresensiModel();
        $jabatan         = new JabatanModel();

        return view('admin/data_pegawai/edit', [
            'title'           => 'Edit Data Pegawai',
            'pegawai'         => $pegawai,
            'lokasi_presensi' => $lokasi_presensi->orderBy('nama_lokasi', 'ASC')->findAll(),
            'jabatan'         => $jabatan->orderBy('jabatan', 'ASC')->findAll(),
            'validation'      => \Config\Services::validation(),
        ]);
    }

    public function update($id)
    {
        $pegawai = (new PegawaiModel())->EditPegawai($id);

        if (! $pegawai || (int) $pegawai['id_perusahaan'] !== (int) session()->get('id_perusahaan')) {
            session()->setFlashdata('error', 'Data pegawai tidak ditemukan pada perusahaan Anda.');
            return redirect()->to(base_url('admin/data_pegawai'));
        }

        $userModel = new UserModel();
        $user      = $userModel->where('id_pegawai', $id)->first();

        $rules = [
            'nama' => [
                'rules'  => 'required|min_length[3]|max_length[150]',
                'errors' => ['required' => 'Nama harus diisi.', 'min_length' => 'Nama minimal 3 karakter.'],
            ],
            'jenis_kelamin' => [
                'rules'  => 'required|in_list[Laki-laki,Perempuan]',
                'errors' => ['required' => 'Jenis Kelamin harus diisi.', 'in_list' => 'Jenis Kelamin tidak valid.'],
            ],
            'alamat' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Alamat harus diisi.'],
            ],
            'no_handphone' => [
                'rules'  => 'required|max_length[20]',
                'errors' => ['required' => 'No Handphone harus diisi.'],
            ],
            'jabatan' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Jabatan harus diisi.'],
            ],
            'lokasi_presensi' => [
                'rules'  => 'required|is_natural_no_zero',
                'errors' => ['required' => 'Lokasi presensi harus diisi.', 'is_natural_no_zero' => 'Lokasi presensi tidak valid.'],
            ],
            'foto' => [
                'rules'  => 'permit_empty|max_size[foto,10240]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png,image/webp]',
                'errors' => [
                    'max_size' => 'Ukuran foto terlalu besar (maksimal 10 MB).',
                    'mime_in'  => 'Format foto tidak valid.',
                ],
            ],
            'username' => [
                'rules'  => 'required|alpha_numeric|min_length[5]' . ($user ? '|is_unique[users.username,id,' . $user['id'] . ']' : ''),
                'errors' => [
                    'required'      => 'Username harus diisi.',
                    'alpha_numeric' => 'Username hanya boleh berisi huruf dan angka.',
                    'min_length'    => 'Username minimal 5 karakter.',
                    'is_unique'     => 'Username sudah digunakan.',
                ],
            ],
            'password' => [
                'rules'  => 'permit_empty|min_length[5]',
                'errors' => ['min_length' => 'Password minimal 5 karakter.'],
            ],
            'konfirmasi_password' => [
                'rules'  => 'permit_empty|matches[password]',
                'errors' => ['matches' => 'Konfirmasi Password tidak sesuai.'],
            ],
            'role' => [
                'rules'  => 'required|in_list[Admin,Pegawai]',
                'errors' => ['required' => 'Role harus diisi.', 'in_list' => 'Role tidak valid.'],
            ],
            'status' => [
                'rules'  => 'required|in_list[Aktif,Tidak Aktif]',
                'errors' => ['required' => 'Status harus diisi.', 'in_list' => 'Status tidak valid.'],
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $foto     = $this->request->getFile('foto');
        $fotoName = $this->request->getPost('foto_lama');

        if ($foto && $foto->isValid() && ! $foto->hasMoved()) {
            $fotoBaru = $foto->getRandomName();
            $foto->move(FCPATH . 'profile', $fotoBaru);

            if (! empty($fotoName) && is_file(FCPATH . 'profile/' . $fotoName)) {
                @unlink(FCPATH . 'profile/' . $fotoName);
            }

            $fotoName = $fotoBaru;
        }

        (new PegawaiModel())->update($id, [
            'nama'            => $this->request->getPost('nama'),
            'jenis_kelamin'   => $this->request->getPost('jenis_kelamin'),
            'alamat'          => $this->request->getPost('alamat'),
            'no_handphone'    => $this->request->getPost('no_handphone'),
            'jabatan'         => $this->request->getPost('jabatan'),
            'lokasi_presensi' => $this->request->getPost('lokasi_presensi'),
            'foto'            => $fotoName,
        ]);

        $dataUser = [
            'username' => $this->request->getPost('username'),
            'status'   => $this->request->getPost('status'),
            'role'     => $this->request->getPost('role'),
        ];

        if ($this->request->getPost('password') !== '' && $this->request->getPost('password') !== null) {
            $dataUser['password'] = password_hash($this->request->getPost('password'), PASSWORD_BCRYPT);
        }

        if ($user) {
            $userModel->update($user['id'], $dataUser);
        } else {
            $dataUser['id_pegawai']    = $id;
            $dataUser['id_perusahaan'] = (int) session()->get('id_perusahaan');
            $dataUser['password']      = password_hash($this->request->getPost('password') ?: 'password', PASSWORD_BCRYPT);
            $userModel->insert($dataUser);
        }

        session()->setFlashdata('success', 'Data pegawai berhasil diperbarui.');

        return redirect()->to(base_url('admin/data_pegawai'));
    }

    public function delete($id)
    {
        $pegawaiModel = new PegawaiModel();
        $pegawai      = $pegawaiModel->find($id);

        if (! $pegawai || (int) $pegawai['id_perusahaan'] !== (int) session()->get('id_perusahaan')) {
            session()->setFlashdata('error', 'Data pegawai tidak ditemukan pada perusahaan Anda.');
            return redirect()->to(base_url('admin/data_pegawai'));
        }

        // Hapus data turunan terlebih dahulu agar tidak melanggar foreign key.
        (new PresensiModel())->where('id_pegawai', $id)->delete();
        (new KetidakhadiranModel())->where('id_pegawai', $id)->delete();
        (new UserModel())->where('id_pegawai', $id)->delete();
        $pegawaiModel->delete($id);

        if (! empty($pegawai['foto']) && is_file(FCPATH . 'profile/' . $pegawai['foto'])) {
            @unlink(FCPATH . 'profile/' . $pegawai['foto']);
        }

        session()->setFlashdata('success', 'Data pegawai berhasil dihapus.');

        return redirect()->to(base_url('admin/data_pegawai'));
    }
}
