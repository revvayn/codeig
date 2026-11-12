<?= $this->extend('superadmin/layout.php') ?>
<?= $this->section('content') ?>

<h5 class="mb-3">Edit Admin</h5>

<?php if (session()->getFlashdata('errors')): ?>
  <div class="alert alert-danger">
    <?php foreach (session()->getFlashdata('errors') as $e): ?>
      <div><?= esc($e) ?></div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<form method="POST" action="<?= base_url('superadmin/admin/update/' . $user['id']) ?>">
  <?= csrf_field() ?>
  <div class="mb-3">
    <label class="form-label">Perusahaan</label>
    <select name="id_perusahaan" class="form-select" required>
      <?php foreach (($perusahaan ?? []) as $p): ?>
        <option value="<?= (int) $p['id'] ?>" <?= ((int)$p['id'] === (int)$user['id_perusahaan']) ? 'selected' : '' ?>>
          <?= esc($p['nama_perusahaan']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Username</label>
    <input type="text" name="username" class="form-control" value="<?= esc($user['username']) ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Password Baru (kosongkan jika tidak diubah)</label>
    <input type="password" name="password" class="form-control">
  </div>
  <div class="mb-3">
    <label class="form-label">Role</label>
    <select name="role" class="form-select" required>
      <option value="Admin" <?= $user['role'] === 'Admin' ? 'selected' : '' ?>>Admin</option>
      <option value="Superadmin" <?= $user['role'] === 'Superadmin' ? 'selected' : '' ?>>Superadmin</option>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select" required>
      <option value="Aktif" <?= $user['status'] === 'Aktif' ? 'selected' : '' ?>>Aktif</option>
      <option value="Tidak Aktif" <?= $user['status'] === 'Tidak Aktif' ? 'selected' : '' ?>>Tidak Aktif</option>
    </select>
  </div>
  <button type="submit" class="btn btn-dark">Simpan</button>
  <a href="<?= base_url('superadmin/admin') ?>" class="btn btn-outline-secondary">Batal</a>
</form>

<?= $this->endSection() ?>