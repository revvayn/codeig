<?= $this->extend('admin/layout.php') ?>

<?= $this->section('content') ?>
<?php $errors = session()->getFlashdata('errors') ?? []; ?>

<div class="app-page-head">
  <div>
    <h2 class="app-title">Tambah Perusahaan</h2>
    <p class="app-subtitle">Lengkapi informasi perusahaan baru.</p>
  </div>
  <a href="<?= base_url('admin/perusahaan') ?>" class="app-btn-outline"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
</div>

<div class="mx-auto w-full max-w-2xl">
  <div class="app-card p-6">
    <?php if (! empty($errors)): ?>
      <div class="mb-5 rounded-xl bg-rose-50 px-4 py-3 text-[12.5px] text-rose-700 ring-1 ring-inset ring-rose-600/10">
        <?php foreach ($errors as $error): ?><div><?= esc($error) ?></div><?php endforeach; ?>
      </div>
    <?php endif; ?>

    <form action="<?= base_url('admin/perusahaan/store') ?>" method="POST" class="space-y-5">
      <?= csrf_field() ?>
      <div>
        <label class="app-label">Nama Perusahaan <span class="text-rose-500">*</span></label>
        <input type="text" name="nama_perusahaan" class="app-input" value="<?= esc(old('nama_perusahaan')) ?>" placeholder="Contoh: PT. Nusantara Jaya" required>
      </div>
      <div>
        <label class="app-label">Alamat</label>
        <textarea name="alamat" class="app-textarea" rows="3" placeholder="Alamat lengkap perusahaan"><?= esc(old('alamat')) ?></textarea>
      </div>
      <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div>
          <label class="app-label">Telepon</label>
          <input type="text" name="telepon" class="app-input" value="<?= esc(old('telepon')) ?>" placeholder="024-1234567">
        </div>
        <div>
          <label class="app-label">Email</label>
          <input type="email" name="email" class="app-input" value="<?= esc(old('email')) ?>" placeholder="admin@perusahaan.co.id">
        </div>
      </div>
      <div>
        <label class="app-label">Status</label>
        <select name="status" class="app-select">
          <option value="Aktif" <?= old('status') === 'Aktif' ? 'selected' : '' ?>>Aktif</option>
          <option value="Tidak Aktif" <?= old('status') === 'Tidak Aktif' ? 'selected' : '' ?>>Tidak Aktif</option>
        </select>
        <p class="app-help">Hanya perusahaan aktif yang tampil pada halaman login.</p>
      </div>
      <div class="flex items-center gap-2 pt-1">
        <button type="submit" class="app-btn-primary"><i class="fa-solid fa-floppy-disk"></i> Simpan Perusahaan</button>
        <a href="<?= base_url('admin/perusahaan') ?>" class="app-btn-ghost">Batal</a>
      </div>
    </form>
  </div>
</div>
<?= $this->endSection() ?>
