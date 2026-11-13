<?= $this->extend('admin/layout.php') ?>
<?= $this->section('content') ?>
<?php $errors = session()->getFlashdata('errors') ?? []; ?>

<div class="app-page-head">
  <div>
    <h2 class="app-title">Edit Data Pegawai</h2>
    <p class="app-subtitle">Perbarui data pribadi, kepegawaian, dan akun login.</p>
  </div>
  <a href="<?= base_url('admin/data_pegawai') ?>" class="app-btn-outline"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
</div>

<div class="grid grid-cols-1 gap-[26px] lg:grid-cols-8">
  <div class="lg:col-span-5">
    <div class="app-card p-6">
      <?php if (! empty($errors)): ?>
        <div class="mb-5 rounded-xl bg-rose-50 px-4 py-3 text-[12.5px] text-rose-700 ring-1 ring-inset ring-rose-600/10">
          <?php foreach ($errors as $error): ?><div><?= esc($error) ?></div><?php endforeach; ?>
        </div>
      <?php endif; ?>

      <form action="<?= base_url('admin/data_pegawai/update/' . $pegawai['id']) ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
        <?= csrf_field() ?>
        <input type="hidden" name="foto_lama" value="<?= esc($pegawai['foto']) ?>">

        <section>
          <h3 class="mb-4 flex items-center gap-2 text-[13px] font-bold text-slate-800">
            <span class="grid h-7 w-7 place-items-center rounded-lg bg-brand-50 text-brand-600"><i class="fa-solid fa-id-card text-[10px]"></i></span>
            Data Pribadi
          </h3>
          <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
              <label class="app-label">Nama Lengkap <span class="text-rose-500">*</span></label>
              <input type="text" name="nama" class="app-input" value="<?= esc(old('nama', $pegawai['nama'])) ?>" required>
            </div>
            <div>
              <label class="app-label">Jenis Kelamin <span class="text-rose-500">*</span></label>
              <select name="jenis_kelamin" class="app-select" required>
                <option value="Laki-laki" <?= old('jenis_kelamin', $pegawai['jenis_kelamin']) === 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                <option value="Perempuan" <?= old('jenis_kelamin', $pegawai['jenis_kelamin']) === 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
              </select>
            </div>
            <div class="sm:col-span-2">
              <label class="app-label">Alamat <span class="text-rose-500">*</span></label>
              <textarea name="alamat" class="app-textarea" rows="2" required><?= esc(old('alamat', $pegawai['alamat'])) ?></textarea>
            </div>
            <div>
              <label class="app-label">No. Handphone <span class="text-rose-500">*</span></label>
              <input type="text" name="no_handphone" class="app-input" value="<?= esc(old('no_handphone', $pegawai['no_handphone'])) ?>" required>
            </div>
            <div>
              <label class="app-label">Foto Baru <span class="font-medium normal-case text-slate-400">(opsional)</span></label>
              <input type="file" name="foto" class="app-input pt-2.5 text-[12px] file:mr-3 file:rounded-md file:border-0 file:bg-brand-50 file:px-2.5 file:py-1 file:text-[11px] file:font-semibold file:text-brand-700" accept="image/jpeg,image/png,image/webp">
            </div>
          </div>
        </section>

        <hr class="border-slate-100">

        <section>
          <h3 class="mb-4 flex items-center gap-2 text-[13px] font-bold text-slate-800">
            <span class="grid h-7 w-7 place-items-center rounded-lg bg-brand-50 text-brand-600"><i class="fa-solid fa-briefcase text-[10px]"></i></span>
            Data Kepegawaian
          </h3>
          <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
              <label class="app-label">Jabatan <span class="text-rose-500">*</span></label>
              <select name="jabatan" class="app-select" required>
                <?php foreach ($jabatan as $jab): ?>
                  <option value="<?= esc($jab['jabatan']) ?>" <?= old('jabatan', $pegawai['jabatan']) === $jab['jabatan'] ? 'selected' : '' ?>><?= esc($jab['jabatan']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div>
              <label class="app-label">Lokasi Presensi <span class="text-rose-500">*</span></label>
              <select name="lokasi_presensi" class="app-select" required>
                <?php foreach ($lokasi_presensi as $lok): ?>
                  <option value="<?= $lok['id'] ?>" <?= (string) old('lokasi_presensi', $pegawai['lokasi_presensi']) === (string) $lok['id'] ? 'selected' : '' ?>><?= esc($lok['nama_lokasi']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
        </section>

        <hr class="border-slate-100">

        <section>
          <h3 class="mb-4 flex items-center gap-2 text-[13px] font-bold text-slate-800">
            <span class="grid h-7 w-7 place-items-center rounded-lg bg-brand-50 text-brand-600"><i class="fa-solid fa-key text-[10px]"></i></span>
            Akun Login
          </h3>
          <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
              <label class="app-label">Username <span class="text-rose-500">*</span></label>
              <input type="text" name="username" class="app-input" value="<?= esc(old('username', $pegawai['username'])) ?>" required>
            </div>
            <div>
              <label class="app-label">Role <span class="text-rose-500">*</span></label>
              <input type="text" class="app-input bg-slate-50 text-slate-500" value="<?= esc($pegawai['role'] ?: 'Pegawai') ?>" readonly>
              <input type="hidden" name="role" value="<?= esc($pegawai['role'] ?: 'Pegawai') ?>">
              <p class="app-help">Akun admin dikelola Superadmin melalui menu Data Admin.</p>
            </div>
            <div>
              <label class="app-label">Password Baru <span class="font-medium normal-case text-slate-400">(kosongkan jika tidak diubah)</span></label>
              <input type="password" name="password" class="app-input" placeholder="Password baru">
            </div>
            <div>
              <label class="app-label">Konfirmasi Password Baru</label>
              <input type="password" name="konfirmasi_password" class="app-input" placeholder="Ulangi password baru">
            </div>
            <div>
              <label class="app-label">Status Akun <span class="text-rose-500">*</span></label>
              <select name="status" class="app-select" required>
                <option value="Aktif" <?= old('status', $pegawai['status']) === 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                <option value="Tidak Aktif" <?= old('status', $pegawai['status']) === 'Tidak Aktif' ? 'selected' : '' ?>>Tidak Aktif</option>
              </select>
            </div>
          </div>
        </section>

        <div class="flex items-center gap-2 pt-1">
          <button type="submit" class="app-btn-primary"><i class="fa-solid fa-floppy-disk"></i> Perbarui Data</button>
          <a href="<?= base_url('admin/data_pegawai') ?>" class="app-btn-ghost">Batal</a>
        </div>
      </form>
    </div>
  </div>

  <div class="lg:col-span-3">
    <div class="app-card p-6 text-center">
      <?php $foto = $pegawai['foto'] ?: ''; ?>
      <img src="<?= $foto && is_file(FCPATH . 'profile/' . $foto) ? base_url('profile/' . $foto) : base_url('assets/img/team-1.jpg') ?>" class="mx-auto mb-4 h-24 w-24 rounded-2xl object-cover ring-4 ring-slate-50 shadow-sm" alt="Foto pegawai">
      <h3 class="text-[15px] font-bold text-slate-900"><?= esc($pegawai['nama']) ?></h3>
      <div class="mt-0.5 text-[11.5px] text-slate-400"><?= esc($pegawai['nip']) ?></div>

      <dl class="mt-5 space-y-2.5 text-left text-[12.5px]">
        <div class="flex items-center justify-between gap-3 border-b border-slate-100 pb-2.5">
          <dt class="text-slate-400">Perusahaan</dt>
          <dd class="text-right font-semibold text-slate-700"><?= esc(session()->get('nama_perusahaan')) ?></dd>
        </div>
        <div class="flex items-center justify-between gap-3 border-b border-slate-100 pb-2.5">
          <dt class="text-slate-400">Jabatan</dt>
          <dd class="text-right font-semibold text-slate-700"><?= esc($pegawai['jabatan']) ?></dd>
        </div>
        <div class="flex items-center justify-between gap-3">
          <dt class="text-slate-400">Status</dt>
          <dd><?= badge_kehadiran($pegawai['status'] ?: 'Tidak Aktif') ?></dd>
        </div>
      </dl>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
