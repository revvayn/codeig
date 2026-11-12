<?= $this->extend('superadmin/layout.php') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h5 class="mb-0">Data Admin</h5>
  <a href="<?= base_url('superadmin/admin/create') ?>" class="btn btn-dark btn-sm">Tambah Admin</a>
</div>

<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
<?php endif; ?>

<div class="card border-0 shadow-sm">
  <div class="card-body">
    <table class="table table-sm align-middle">
      <thead class="table-light">
        <tr>
          <th>Username</th>
          <th>Role</th>
          <th>Perusahaan</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach (($data ?? []) as $row): ?>
          <tr>
            <td><?= esc($row['username']) ?></td>
            <td><?= esc($row['role']) ?></td>
            <td><?= esc($row['nama_perusahaan'] ?? '-') ?></td>
            <td><?= esc($row['status']) ?></td>
            <td>
              <a href="<?= base_url('superadmin/admin/edit/' . $row['id']) ?>" class="btn btn-sm btn-outline-warning">Edit</a>
              <a href="<?= base_url('superadmin/admin/delete/' . $row['id']) ?>" class="btn btn-sm btn-outline-danger tombol-hapus">Hapus</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?= $this->endSection() ?>