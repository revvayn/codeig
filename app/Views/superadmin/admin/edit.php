<?= $this->extend('superadmin/layout.php') ?>
<?= $this->section('content') ?>

<div class="app-page-head">
  <div>
    <h2 class="app-title">Edit Admin</h2>
    <p class="app-subtitle">Perbarui data akun, role, dan status admin.</p>
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

      <form method="POST" action="<?= base_url('superadmin/admin/update/' . $user['id']) ?>" class="space-y-5">
        <?= csrf_field() ?>
        <div>
          <label class="app-label">Perusahaan <span class="text-rose-500">*</span></label>
          <select name="id_perusahaan" class="app-select" required>
            <?php foreach (($perusahaan ?? []) as $p): ?>
              <option value="<?= (int) $p['id'] ?>" <?= ((int) $p['id'] === (int) $user['id_perusahaan']) ? 'selected' : '' ?>>
                <?= esc($p['nama_perusahaan']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
          <div>
            <label class="app-label">Username <span class="text-rose-500">*</span></label>
            <input type="text" name="username" class="app-input" value="<?= esc($user['username']) ?>" required>
          </div>
          <div>
            <label class="app-label">Password Baru <span class="font-medium normal-case text-slate-400">(opsional)</span></label>
            <input type="password" name="password" class="app-input" placeholder="Kosongkan jika tidak diubah">
          </div>
          <div>
            <label class="app-label">Role <span class="text-rose-500">*</span></label>
            <select name="role" class="app-select" required>
              <option value="Admin" <?= $user['role'] === 'Admin' ? 'selected' : '' ?>>Admin</option>
              <option value="Superadmin" <?= $user['role'] === 'Superadmin' ? 'selected' : '' ?>>Superadmin</option>
            </select>
          </div>
          <div>
            <label class="app-label">Status <span class="text-rose-500">*</span></label>
            <select name="status" class="app-select" required>
              <option value="Aktif" <?= $user['status'] === 'Aktif' ? 'selected' : '' ?>>Aktif</option>
              <option value="Tidak Aktif" <?= $user['status'] === 'Tidak Aktif' ? 'selected' : '' ?>>Tidak Aktif</option>
            </select>
          </div>
        </div>
        <div class="flex items-center gap-2 pt-1">
          <button type="submit" class="app-btn-primary"><i class="fa-solid fa-floppy-disk"></i> Perbarui</button>
          <a href="<?= base_url('superadmin/admin') ?>" class="app-btn-ghost">Batal</a>
        </div>
      </form>
    </div>
  </div>

  <div class="lg:col-span-3">
    <div class="app-card p-6 text-center">
      <div class="mx-auto mb-4 grid h-20 w-20 place-items-center rounded-2xl bg-brand-50 text-brand-600">
        <i class="fa-solid fa-user-shield text-2xl"></i>
      </div>
      <h3 class="text-[15px] font-bold text-slate-900"><?= esc($user['username']) ?></h3>
      <div class="mt-1 text-[11.5px] text-slate-400"><?= esc($user['role']) ?></div>
      <div class="mt-3"><?= badge_kehadiran($user['status'] ?: 'Tidak Aktif') ?></div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
