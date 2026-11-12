<?= $this->extend('superadmin/layout.php') ?>
<?= $this->section('content') ?>

<h5 class="mb-3">Tambah Admin</h5>

<?php if (session()->getFlashdata('errors')): ?>
  <div class="alert alert-danger">
    <?php foreach (session()->getFlashdata('errors') as $e): ?>
      <div><?= esc($e) ?></div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<form method="POST" action="<?= base_url('superadmin/admin/store') ?>">
  <?= csrf_field() ?>
  <div class="mb-3">
    <label class="form-label">Perusahaan</label>
    <select name="id_perusahaan" class="form-select" required>
      <option value="">-- Pilih Perusahaan --</option>
      <?php foreach (($perusahaan ?? []) as $p): ?>
        <option value="<?= (int) $p['id'] ?>"><?= esc($p['nama_perusahaan']) ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Username</label>
    <input type="text" name="username" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Password</label>
    <input type="password" name="password" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Role</label>
    <select name="role" class="form-select" required>
      <option value="Admin">Admin</option>
      <option value="Superadmin">Superadmin</option>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select" required>
      <option value="Aktif">Aktif</option>
      <option value="Tidak Aktif">Tidak Aktif</option>
    </select>
  </div>
  <button type="submit" class="btn btn-dark">Simpan</button>
  <a href="<?= base_url('superadmin/admin') ?>" class="btn btn-outline-secondary">Batal</a>
</form>

<?= $this->endSection() ?>