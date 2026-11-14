<?= $this->extend('admin/layout.php') ?>

<?= $this->section('content') ?>
<?php $errors = session()->getFlashdata('errors') ?? []; ?>

<div class="app-page-head">
  <div>
    <h2 class="app-title">Edit Perusahaan</h2>
    <p class="app-subtitle">Perbarui informasi perusahaan Anda.</p>
  </div>
  <a href="<?= base_url('admin/perusahaan') ?>" class="app-btn-outline"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
</div>

<div class="grid grid-cols-1 gap-[26px] lg:grid-cols-8">
  <div class="lg:col-span-5">
    <div class="app-card p-6">
      <?php if (! empty($errors)): ?>
        <div class="mb-5 rounded-xl bg-rose-50 px-4 py-3 text-[12.5px] text-rose-700 ring-1 ring-inset ring-rose-600/10">
          <?php foreach ($errors as $error): ?><div><?= esc($error) ?></div><?php endforeach; ?>
        </div>
      <?php endif; ?>

      <form action="<?= base_url('admin/perusahaan/update/' . $perusahaan['id']) ?>" method="POST" class="space-y-5">
        <?= csrf_field() ?>
        <div>
          <label class="app-label">Nama Perusahaan <span class="text-rose-500">*</span></label>
          <input type="text" name="nama_perusahaan" class="app-input" value="<?= esc(old('nama_perusahaan', $perusahaan['nama_perusahaan'])) ?>" required>
        </div>
        <div>
          <label class="app-label">Alamat</label>
          <textarea name="alamat" class="app-textarea" rows="3"><?= esc(old('alamat', $perusahaan['alamat'])) ?></textarea>
        </div>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
          <div>
            <label class="app-label">Telepon</label>
            <input type="text" name="telepon" class="app-input" value="<?= esc(old('telepon', $perusahaan['telepon'])) ?>">
          </div>
          <div>
            <label class="app-label">Email</label>
            <input type="email" name="email" class="app-input" value="<?= esc(old('email', $perusahaan['email'])) ?>">
          </div>
        </div>
        <div>
          <label class="app-label">Status</label>
          <select name="status" class="app-select">
            <option value="Aktif" <?= old('status', $perusahaan['status']) === 'Aktif' ? 'selected' : '' ?>>Aktif</option>
            <option value="Tidak Aktif" <?= old('status', $perusahaan['status']) === 'Tidak Aktif' ? 'selected' : '' ?>>Tidak Aktif</option>
          </select>
        </div>
        <div class="flex items-center gap-2 pt-1">
          <button type="submit" class="app-btn-primary"><i class="fa-solid fa-floppy-disk"></i> Perbarui Perusahaan</button>
          <a href="<?= base_url('admin/perusahaan') ?>" class="app-btn-ghost">Batal</a>
        </div>
      </form>
    </div>
  </div>

  <div class="lg:col-span-3">
    <div class="app-card p-6">
      <h3 class="mb-4 flex items-center gap-2 text-[13px] font-bold text-slate-800">
        <span class="grid h-7 w-7 place-items-center rounded-lg bg-amber-50 text-amber-600"><i class="fa-solid fa-circle-info text-[10px]"></i></span>
        Petunjuk
      </h3>
      <ul class="space-y-3 text-[12.5px] leading-relaxed text-slate-500">
        <li class="flex gap-2.5"><i class="fa-solid fa-check mt-1 text-[9px] text-emerald-500"></i> Perubahan hanya berlaku untuk perusahaan Anda.</li>
        <li class="flex gap-2.5"><i class="fa-solid fa-check mt-1 text-[9px] text-emerald-500"></i> Status tidak aktif membuat perusahaan tidak tampil di halaman login.</li>
        <li class="flex gap-2.5"><i class="fa-solid fa-check mt-1 text-[9px] text-emerald-500"></i> Titik GPS dan radius tiap plant diatur pada menu Lokasi Presensi.</li>
      </ul>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
