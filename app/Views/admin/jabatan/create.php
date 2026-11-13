<?= $this->extend('admin/layout.php') ?>
<?= $this->section('content') ?>

<div class="app-page-head">
  <div>
    <h2 class="app-title">Tambah Jabatan</h2>
    <p class="app-subtitle">Tambahkan nama jabatan baru untuk perusahaan Anda.</p>
  </div>
  <a href="<?= base_url('admin/jabatan') ?>" class="app-btn-outline"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
</div>

<div class="mx-auto w-full max-w-xl">
  <div class="app-card p-6">
    <form method="POST" action="<?= base_url('admin/jabatan/store') ?>" class="space-y-5">
      <?= csrf_field() ?>
      <div>
        <label class="app-label">Nama Jabatan <span class="text-rose-500">*</span></label>
        <input type="text" name="jabatan" class="app-input <?= $validation->hasError('jabatan') ? 'border-rose-300 focus:border-rose-500 focus:ring-rose-500/10' : '' ?>" value="<?= esc(old('jabatan')) ?>" placeholder="Contoh: Staff Administrasi" required>
        <?php if ($validation->hasError('jabatan')): ?>
          <p class="app-error"><?= $validation->getError('jabatan') ?></p>
        <?php endif; ?>
      </div>
      <div class="flex items-center gap-2">
        <button type="submit" class="app-btn-primary"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
        <a href="<?= base_url('admin/jabatan') ?>" class="app-btn-ghost">Batal</a>
      </div>
    </form>
  </div>
</div>

<?= $this->endSection() ?>
