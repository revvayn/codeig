<?= $this->extend('superadmin/layout.php') ?>
<?= $this->section('content') ?>

<div class="app-page-head">
  <div>
    <h2 class="app-title">Tambah Admin</h2>
    <p class="app-subtitle">Buat akun admin atau superadmin baru dan hubungkan dengan perusahaan.</p>
  </div>
  <a href="<?= base_url('superadmin/admin') ?>" class="app-btn-outline"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
</div>

<div class="grid grid-cols-1 gap-[26px] lg:grid-cols-8">
  <div class="lg:col-span-5">
    <div class="app-card p-6">
      <?php if (session()->getFlashdata('errors')): ?>
        <div class="mb-5 rounded-xl bg-rose-50 px-4 py-3 text-[12.5px] text-rose-700 ring-1 ring-inset ring-rose-600/10">
          <?php foreach (session()->getFlashdata('errors') as $e): ?><div><?= esc($e) ?></div><?php endforeach; ?>
        </div>
      <?php endif; ?>

      <form method="POST" action="<?= base_url('superadmin/admin/store') ?>" class="space-y-5">
        <?= csrf_field() ?>
        <div>
          <label class="app-label">Perusahaan <span class="text-rose-500">*</span></label>
          <select name="id_perusahaan" class="app-select" required>
            <option value="">-- Pilih Perusahaan --</option>
            <?php foreach (($perusahaan ?? []) as $p): ?>
              <option value="<?= (int) $p['id'] ?>" <?= (string) old('id_perusahaan') === (string) $p['id'] ? 'selected' : '' ?>><?= esc($p['nama_perusahaan']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
          <div>
            <label class="app-label">Username <span class="text-rose-500">*</span></label>
            <input type="text" name="username" class="app-input" value="<?= esc(old('username')) ?>" placeholder="Minimal 5 karakter" required>
          </div>
          <div>
            <label class="app-label">Password <span class="text-rose-500">*</span></label>
            <input type="password" name="password" class="app-input" placeholder="Minimal 5 karakter" required>
          </div>
          <div>
            <label class="app-label">Role <span class="text-rose-500">*</span></label>
            <select name="role" class="app-select" required>
              <option value="Admin" <?= old('role') === 'Admin' ? 'selected' : '' ?>>Admin</option>
              <option value="Superadmin" <?= old('role') === 'Superadmin' ? 'selected' : '' ?>>Superadmin</option>
            </select>
          </div>
          <div>
            <label class="app-label">Status <span class="text-rose-500">*</span></label>
            <select name="status" class="app-select" required>
              <option value="Aktif" <?= old('status') === 'Aktif' ? 'selected' : '' ?>>Aktif</option>
              <option value="Tidak Aktif" <?= old('status') === 'Tidak Aktif' ? 'selected' : '' ?>>Tidak Aktif</option>
            </select>
          </div>
        </div>
        <div class="flex items-center gap-2 pt-1">
          <button type="submit" class="app-btn-primary"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
          <a href="<?= base_url('superadmin/admin') ?>" class="app-btn-ghost">Batal</a>
        </div>
      </form>
    </div>
  </div>

  <div class="lg:col-span-3">
    <div class="app-card p-6">
      <h3 class="mb-4 flex items-center gap-2 text-[13px] font-bold text-slate-800">
        <span class="grid h-7 w-7 place-items-center rounded-lg bg-amber-50 text-amber-600"><i class="fa-solid fa-circle-info text-[10px]"></i></span>
        Informasi
      </h3>
      <ul class="space-y-3 text-[12.5px] leading-relaxed text-slate-500">
        <li class="flex gap-2.5"><i class="fa-solid fa-check mt-1 text-[9px] text-emerald-500"></i> Role <strong class="text-slate-700">Admin</strong> hanya mengelola data perusahaannya sendiri.</li>
        <li class="flex gap-2.5"><i class="fa-solid fa-check mt-1 text-[9px] text-emerald-500"></i> Role <strong class="text-slate-700">Superadmin</strong> dapat mengelola seluruh perusahaan.</li>
        <li class="flex gap-2.5"><i class="fa-solid fa-check mt-1 text-[9px] text-emerald-500"></i> Username harus unik pada sistem.</li>
      </ul>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
