<?= $this->extend('superadmin/layout.php') ?>

<?= $this->section('content') ?>
<?php $errors = session()->getFlashdata('errors') ?? []; ?>
<div class="content-header">
  <div>
    <h3>Tambah Perusahaan</h3>
    <p>Lengkapi informasi perusahaan baru.</p>
  </div>
  <a href="<?= base_url('superadmin/perusahaan') ?>" class="btn btn-sm btn-outline-dark">
    <i class="fas fa-arrow-left me-1"></i> Kembali
  </a>
</div>

<div class="row">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-body p-4">
        <?php if (! empty($errors)): ?>
          <div class="alert alert-danger">
            <?php foreach ($errors as $error): ?><div><?= esc($error) ?></div><?php endforeach; ?>
          </div>
        <?php endif; ?>

        <form action="<?= base_url('superadmin/perusahaan/store') ?>" method="POST">
          <?= csrf_field() ?>
          <div class="mb-3">
            <label class="form-label">Nama Perusahaan <span class="text-danger">*</span></label>
            <input type="text" name="nama_perusahaan" class="form-control" value="<?= old('nama_perusahaan') ?>" placeholder="Contoh: PT. Nusantara Jaya" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control" rows="3" placeholder="Alamat lengkap perusahaan"><?= old('alamat') ?></textarea>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Telepon</label>
              <input type="text" name="telepon" class="form-control" value="<?= old('telepon') ?>" placeholder="024-1234567">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" value="<?= old('email') ?>" placeholder="admin@perusahaan.co.id">
            </div>
          </div>
          <div class="mb-4">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
              <option value="Aktif" <?= old('status') === 'Aktif' ? 'selected' : '' ?>>Aktif</option>
              <option value="Tidak Aktif" <?= old('status') === 'Tidak Aktif' ? 'selected' : '' ?>>Tidak Aktif</option>
            </select>
            <div class="text-xs text-secondary mt-1">Hanya perusahaan aktif yang tampil pada halaman login.</div>
          </div>
          <button type="submit" class="btn btn-dark">
            <i class="fas fa-save me-1"></i> Simpan Perusahaan
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
