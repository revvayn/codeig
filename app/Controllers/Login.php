<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LoginModel;
use App\Models\PerusahaanModel;
use App\Models\PegawaiModel;

class Login extends BaseController
{
    public function index()
    {
        if (session()->get('logged_in')) {
            return $this->arahkanBerdasarkanRole(session()->get('role_id'));
        }

        $perusahaanModel = new PerusahaanModel();

        $data = [
            'title'       => 'Login Presensi',
            'validation'  => \Config\Services::validation(),
            'perusahaan'  => $perusahaanModel->where('status', 'Aktif')->orderBy('nama_perusahaan', 'ASC')->findAll(),
        ];

        return view('login', $data);
    }

    public function login_action()
    {
        $rules = [
            'id_perusahaan' => [
                'rules'  => 'required|is_natural_no_zero',
                'errors' => [
                    'required'           => 'Nama perusahaan wajib dipilih.',
                    'is_natural_no_zero' => 'Nama perusahaan tidak valid.',
                ],
            ],
            'username' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Username wajib diisi.'],
            ],
            'password' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Password wajib diisi.'],
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $session         = session();
        $loginModel      = new LoginModel();
        $perusahaanModel = new PerusahaanModel();

        $idPerusahaan = (int) $this->request->getPost('id_perusahaan');
        $username     = trim((string) $this->request->getPost('username'));
        $password     = (string) $this->request->getPost('password');

        $perusahaan = $perusahaanModel->find($idPerusahaan);

        if (! $perusahaan || $perusahaan['status'] !== 'Aktif') {
            return redirect()->back()->withInput()->with('pesan', 'Perusahaan tidak ditemukan atau tidak aktif.');
        }

        $user = $loginModel
            ->where('username', $username)
            ->where('id_perusahaan', $idPerusahaan)
            ->first();

        if (! $user) {
            return redirect()->back()->withInput()->with('pesan', 'Username tidak terdaftar pada perusahaan tersebut.');
        }

        if (! password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('pesan', 'Password salah, silakan coba lagi.');
        }

        if (($user['status'] ?? '') !== 'Aktif') {
            return redirect()->back()->withInput()->with('pesan', 'Akun Anda tidak aktif. Hubungi admin perusahaan.');
        }

        $pegawaiModel = new PegawaiModel();
        $pegawai      = $pegawaiModel->find($user['id_pegawai']);

        $session->regenerate();
        $session->set([
            'id_user'        => $user['id'],
            'username'       => $user['username'],
            'logged_in'      => true,
            'role_id'        => $user['role'],
            'id_pegawai'     => $user['id_pegawai'],
            'nama_pegawai'   => $pegawai['nama'] ?? $user['username'],
            'foto_pegawai'   => $pegawai['foto'] ?? '',
            'id_perusahaan'  => $perusahaan['id'],
            'nama_perusahaan'=> $perusahaan['nama_perusahaan'],
        ]);

        session()->setFlashdata('success', 'Selamat datang, ' . ($pegawai['nama'] ?? $user['username']) . '!');

        return $this->arahkanBerdasarkanRole($user['role']);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('/'))->with('pesan', 'Anda berhasil logout.');
    }

    private function arahkanBerdasarkanRole(?string $role)
    {
        return match ($role) {
            'Superadmin' => redirect()->to(base_url('superadmin/home')),
            'Admin'      => redirect()->to(base_url('admin/home')),
            'Pegawai'    => redirect()->to(base_url('pegawai/home')),
            default      => redirect()->to(base_url('/'))->with('pesan', 'Role akun tidak dikenali.'),
        };
    }
}
