<?php

namespace App\Controllers\Superadmin;

use App\Controllers\BaseController;
use App\Models\PerusahaanModel;
use App\Models\UserModel;

class Admin extends BaseController
{
    public function index()
    {
        $users = (new UserModel())
            ->select('users.*, perusahaan.nama_perusahaan')
            ->join('perusahaan', 'perusahaan.id = users.id_perusahaan', 'left')
            ->whereIn('users.role', ['Admin', 'Superadmin'])
            ->orderBy('users.role', 'ASC')
            ->orderBy('users.username', 'ASC')
            ->findAll();

        return view('superadmin/admin/index', [
            'title' => 'Data Admin',
            'data'  => $users,
        ]);
    }

    public function create()
    {
        return view('superadmin/admin/create', [
            'title'        => 'Tambah Admin',
            'perusahaan'   => (new PerusahaanModel())->orderBy('nama_perusahaan', 'ASC')->findAll(),
            'validation'   => \Config\Services::validation(),
        ]);
    }

    public function store()
    {
        $rules = [
            'id_perusahaan' => 'required|is_natural_no_zero',
            'username'      => 'required|alpha_numeric|min_length[5]|is_unique[users.username]',
            'password'      => 'required|min_length[5]',
            'status'        => 'required|in_list[Aktif,Tidak Aktif]',
            'role'          => 'required|in_list[Admin,Superadmin]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        (new UserModel())->insert([
            'id_perusahaan' => (int) $this->request->getPost('id_perusahaan'),
            'id_pegawai'    => null,
            'username'      => $this->request->getPost('username'),
            'password'      => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'status'        => $this->request->getPost('status'),
            'role'          => $this->request->getPost('role'),
        ]);

        session()->setFlashdata('success', 'Akun admin berhasil ditambahkan.');
        \App\Models\AuditLogModel::catat('create', 'admin_user', null, 'Menambah admin ' . $this->request->getPost('username'));

        return redirect()->to(base_url('superadmin/admin'));
    }

    public function edit($id)
    {
        $user = (new UserModel())->find($id);
        if (! $user || ! in_array($user['role'], ['Admin', 'Superadmin'], true)) {
            session()->setFlashdata('error', 'Akun tidak ditemukan.');
            return redirect()->to(base_url('superadmin/admin'));
        }

        return view('superadmin/admin/edit', [
            'title'      => 'Edit Admin',
            'user'       => $user,
            'perusahaan' => (new PerusahaanModel())->orderBy('nama_perusahaan', 'ASC')->findAll(),
            'validation' => \Config\Services::validation(),
        ]);
    }

    public function update($id)
    {
        $userModel = new UserModel();
        $user      = $userModel->find($id);
        if (! $user || ! in_array($user['role'], ['Admin', 'Superadmin'], true)) {
            session()->setFlashdata('error', 'Akun tidak ditemukan.');
            return redirect()->to(base_url('superadmin/admin'));
        }

        $rules = [
            'id_perusahaan' => 'required|is_natural_no_zero',
            'username'      => 'required|alpha_numeric|min_length[5]|is_unique[users.username,id,' . $user['id'] . ']',
            'status'        => 'required|in_list[Aktif,Tidak Aktif]',
            'role'          => 'required|in_list[Admin,Superadmin]',
        ];
        if ($this->request->getPost('password') !== '' && $this->request->getPost('password') !== null) {
            $rules['password'] = 'min_length[5]';
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'id_perusahaan' => (int) $this->request->getPost('id_perusahaan'),
            'username'      => $this->request->getPost('username'),
            'status'        => $this->request->getPost('status'),
            'role'          => $this->request->getPost('role'),
        ];

        if ($this->request->getPost('password') !== '' && $this->request->getPost('password') !== null) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_BCRYPT);
        }

        $userModel->update($id, $data);

        session()->setFlashdata('success', 'Akun admin berhasil diperbarui.');
        \App\Models\AuditLogModel::catat('update', 'admin_user', (int) $id, 'Memperbarui admin ID ' . $id);

        return redirect()->to(base_url('superadmin/admin'));
    }

    public function delete($id)
    {
        $userModel = new UserModel();
        $user      = $userModel->find($id);

        if (! $user || ! in_array($user['role'], ['Admin', 'Superadmin'], true)) {
            session()->setFlashdata('error', 'Akun tidak ditemukan.');
            return redirect()->to(base_url('superadmin/admin'));
        }

        if ((int) $user['id'] === (int) session()->get('id_user')) {
            session()->setFlashdata('error', 'Anda tidak dapat menghapus akun yang sedang digunakan.');
            return redirect()->to(base_url('superadmin/admin'));
        }

        $userModel->delete($id);

        session()->setFlashdata('success', 'Akun admin berhasil dihapus.');
        \App\Models\AuditLogModel::catat('delete', 'admin_user', (int) $id, 'Menghapus admin ID ' . $id);

        return redirect()->to(base_url('superadmin/admin'));
    }
}
