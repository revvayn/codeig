<?= $this->extend('admin/layout.php') ?>
<?= $this->section('content') ?>
<?php $errors = session()->getFlashdata('errors') ?? []; ?>

<div class="app-page-head">
  <div>
    <h2 class="app-title">Tambah Data Pegawai</h2>
    <p class="app-subtitle">Pegawai akan otomatis terdaftar pada <?= esc(session()->get('nama_perusahaan')) ?>.</p>
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

      <form action="<?= base_url('admin/data_pegawai/store') ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
        <?= csrf_field() ?>

        <section>
          <h3 class="mb-4 flex items-center gap-2 text-[13px] font-bold text-slate-800">
            <span class="grid h-7 w-7 place-items-center rounded-lg bg-brand-50 text-brand-600"><i class="fa-solid fa-id-card text-[10px]"></i></span>
            Data Pribadi
          </h3>
          <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
              <label class="app-label">Nama Lengkap <span class="text-rose-500">*</span></label>
              <input type="text" name="nama" class="app-input" value="<?= esc(old('nama')) ?>" placeholder="Nama pegawai" required>
            </div>
            <div>
              <label class="app-label">Jenis Kelamin <span class="text-rose-500">*</span></label>
              <select name="jenis_kelamin" class="app-select" required>
                <option value="">-- Pilih --</option>
                <option value="Laki-laki" <?= old('jenis_kelamin') === 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                <option value="Perempuan" <?= old('jenis_kelamin') === 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
              </select>
            </div>
            <div class="sm:col-span-2">
              <label class="app-label">Alamat <span class="text-rose-500">*</span></label>
              <textarea name="alamat" class="app-textarea" rows="2" placeholder="Alamat lengkap" required><?= esc(old('alamat')) ?></textarea>
            </div>
            <div>
              <label class="app-label">No. Handphone <span class="text-rose-500">*</span></label>
              <input type="text" name="no_handphone" class="app-input" value="<?= esc(old('no_handphone')) ?>" placeholder="08xxxxxxxxxx" required>
            </div>
            <div>
              <label class="app-label">Foto <span class="text-rose-500">*</span></label>
              <input type="file" name="foto" class="app-input pt-2.5 text-[12px] file:mr-3 file:rounded-md file:border-0 file:bg-brand-50 file:px-2.5 file:py-1 file:text-[11px] file:font-semibold file:text-brand-700" accept="image/jpeg,image/png,image/webp" required>
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
                <option value="">-- Pilih Jabatan --</option>
                <?php foreach ($jabatan as $jab): ?>
                  <option value="<?= esc($jab['jabatan']) ?>" <?= old('jabatan') === $jab['jabatan'] ? 'selected' : '' ?>><?= esc($jab['jabatan']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div>
              <label class="app-label">Lokasi Presensi <span class="text-rose-500">*</span></label>
              <select name="lokasi_presensi" class="app-select" required>
                <option value="">-- Pilih Lokasi --</option>
                <?php foreach ($lokasi_presensi as $lok): ?>
                  <option value="<?= $lok['id'] ?>" <?= (string) old('lokasi_presensi') === (string) $lok['id'] ? 'selected' : '' ?>><?= esc($lok['nama_lokasi']) ?></option>
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
              <input type="text" name="username" class="app-input" value="<?= esc(old('username')) ?>" placeholder="Minimal 5 karakter, huruf/angka" required>
            </div>
            <div>
              <label class="app-label">Role <span class="text-rose-500">*</span></label>
              <input type="text" class="app-input bg-slate-50 text-slate-500" value="Pegawai" readonly>
              <input type="hidden" name="role" value="Pegawai">
              <p class="app-help">Akun admin dibuat oleh Superadmin melalui menu Data Admin.</p>
            </div>
            <div>
              <label class="app-label">Password <span class="text-rose-500">*</span></label>
              <input type="password" name="password" class="app-input" placeholder="Minimal 5 karakter" required>
            </div>
            <div>
              <label class="app-label">Konfirmasi Password <span class="text-rose-500">*</span></label>
              <input type="password" name="konfirmasi_password" class="app-input" placeholder="Ulangi password" required>
            </div>
          </div>
        </section>

        <div class="flex items-center gap-2 pt-1">
          <button type="submit" class="app-btn-primary"><i class="fa-solid fa-floppy-disk"></i> Simpan Data Pegawai</button>
          <a href="<?= base_url('admin/data_pegawai') ?>" class="app-btn-ghost">Batal</a>
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
        <li class="flex gap-2.5"><i class="fa-solid fa-check mt-1 text-[9px] text-emerald-500"></i> NIP dibuat otomatis oleh sistem.</li>
        <li class="flex gap-2.5"><i class="fa-solid fa-check mt-1 text-[9px] text-emerald-500"></i> Username harus unik dan hanya berisi huruf/angka.</li>
        <li class="flex gap-2.5"><i class="fa-solid fa-check mt-1 text-[9px] text-emerald-500"></i> Data Pegawai hanya memuat akun <strong class="text-slate-700">Pegawai</strong>; akun admin dikelola Superadmin.</li>
        <li class="flex gap-2.5"><i class="fa-solid fa-check mt-1 text-[9px] text-emerald-500"></i> Pegawai langsung berstatus <strong class="text-slate-700">Aktif</strong> setelah disimpan.</li>
      </ul>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
