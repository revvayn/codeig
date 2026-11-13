<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PegawaiModel;
use App\Models\UserModel;

class Profile extends BaseController
{
    public function __construct()
    {
        helper(['url', 'form']);
    }

    public function index()
    {
        $user    = $this->currentUser();
        $pegawai = $this->currentPegawai($user);

        return view('profile/index', [
            'title'      => 'Profil Saya',
            'layout'     => $this->layoutForRole($user['role']),
            'user'       => $user,
            'pegawai'    => $pegawai,
            'validation' => \Config\Services::validation(),
        ]);
    }

    public function update()
    {
        $user = $this->currentUser();
        $id   = (int) $user['id'];

        $rules = [
            'username' => [
                'rules'  => 'required|alpha_numeric|min_length[3]|is_unique[users.username,id,' . $id . ']',
                'errors' => [
                    'required'      => 'Username harus diisi.',
                    'alpha_numeric' => 'Username hanya boleh berisi huruf dan angka.',
                    'min_length'    => 'Username minimal 3 karakter.',
                    'is_unique'     => 'Username sudah digunakan.',
                ],
            ],
            'password' => [
                'rules'  => 'permit_empty|min_length[5]',
                'errors' => ['min_length' => 'Password minimal 5 karakter.'],
            ],
            'konfirmasi_password' => [
                'rules'  => 'permit_empty|matches[password]',
                'errors' => ['matches' => 'Konfirmasi password tidak sesuai.'],
            ],
            'foto' => [
                'rules'  => 'permit_empty|max_size[foto,10240]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png,image/webp]',
                'errors' => [
                    'max_size' => 'Ukuran foto terlalu besar (maksimal 10 MB).',
                    'is_image' => 'File harus berupa gambar.',
                    'mime_in'  => 'Format foto tidak valid. Gunakan JPG, JPEG, PNG, atau WEBP.',
                ],
            ],
        ];

        $pegawai = $this->currentPegawai($user);

        if ($pegawai) {
            $rules['nama'] = [
                'rules'  => 'required|min_length[3]|max_length[150]',
                'errors' => ['required' => 'Nama harus diisi.', 'min_length' => 'Nama minimal 3 karakter.'],
            ];
            $rules['alamat'] = [
                'rules'  => 'required',
                'errors' => ['required' => 'Alamat harus diisi.'],
            ];
            $rules['no_handphone'] = [
                'rules'  => 'required|max_length[20]',
                'errors' => ['required' => 'No Handphone harus diisi.'],
            ];
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();
        $dataUser  = ['username' => trim((string) $this->request->getPost('username'))];

        $password = (string) $this->request->getPost('password');
        if ($password !== '') {
            $dataUser['password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        $fotoName = $pegawai['foto'] ?? null;

        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && ! $foto->hasMoved()) {
            $fotoBaru = $foto->getRandomName();
            $foto->move(FCPATH . 'profile', $fotoBaru);

            if (! empty($fotoName) && is_file(FCPATH . 'profile/' . $fotoName)) {
                @unlink(FCPATH . 'profile/' . $fotoName);
            }

            $fotoName = $fotoBaru;
        }

        $userModel->update($id, $dataUser);

        if ($pegawai) {
            (new PegawaiModel())->update((int) $pegawai['id'], [
                'nama'         => $this->request->getPost('nama'),
                'alamat'       => $this->request->getPost('alamat'),
                'no_handphone' => $this->request->getPost('no_handphone'),
                'foto'         => $fotoName,
            ]);
        }

        $session = session();
        $session->set([
            'username'     => $dataUser['username'],
            'nama_pegawai' => $pegawai ? $this->request->getPost('nama') : $session->get('nama_pegawai'),
            'foto_pegawai' => $fotoName ?? $session->get('foto_pegawai'),
        ]);

        \App\Models\AuditLogModel::catat('update', 'profil', $id, 'Memperbarui profil sendiri');

        session()->setFlashdata('success', 'Profil berhasil diperbarui.');

        return redirect()->to(base_url($this->prefixForRole($user['role']) . '/profile'));
    }

    private function currentUser(): array
    {
        $user = (new UserModel())->find((int) session()->get('id_user'));

        if (! $user) {
            throw new \RuntimeException('Akun tidak ditemukan.');
        }

        return $user;
    }

    private function currentPegawai(array $user): ?array
    {
        if (empty($user['id_pegawai'])) {
            return null;
        }

        return (new PegawaiModel())->find((int) $user['id_pegawai']);
    }

    private function prefixForRole(?string $role): string
    {
        return match ($role) {
            'Superadmin' => 'superadmin',
            'Pegawai'    => 'pegawai',
            default      => 'admin',
        };
    }

    private function layoutForRole(?string $role): string
    {
        return $this->prefixForRole($role) . '/layout.php';
    }
}
