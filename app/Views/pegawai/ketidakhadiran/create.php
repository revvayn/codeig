<?= $this->extend('pegawai/layout.php') ?>

<?= $this->section('content') ?>
<?php $errors = session()->getFlashdata('errors') ?? []; ?>

<div class="app-page-head">
  <div>
    <h2 class="app-title">Ajukan Ketidakhadiran</h2>
    <p class="app-subtitle">Lengkapi formulir di bawah ini dengan keterangan yang jelas.</p>
  </div>
  <a href="<?= base_url('pegawai/ketidakhadiran') ?>" class="app-btn-outline"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
</div>

<div class="grid grid-cols-1 gap-[26px] lg:grid-cols-8">
  <div class="lg:col-span-5">
    <div class="app-card p-6">
      <?php if (! empty($errors)): ?>
        <div class="mb-5 rounded-xl bg-rose-50 px-4 py-3 text-[12.5px] text-rose-700 ring-1 ring-inset ring-rose-600/10">
          <?php foreach ($errors as $error): ?><div><?= esc($error) ?></div><?php endforeach; ?>
        </div>
      <?php endif; ?>

      <form action="<?= base_url('pegawai/ketidakhadiran/store') ?>" method="POST" enctype="multipart/form-data" class="space-y-5">
        <?= csrf_field() ?>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
          <div>
            <label class="app-label">Keterangan <span class="text-rose-500">*</span></label>
            <select name="keterangan" class="app-select" required>
              <option value="">-- Pilih Keterangan --</option>
              <?php foreach (['Izin', 'Sakit', 'Cuti'] as $opsi): ?>
                <option value="<?= $opsi ?>" <?= old('keterangan') === $opsi ? 'selected' : '' ?>><?= $opsi ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div>
            <label class="app-label">Tanggal <span class="text-rose-500">*</span></label>
            <input type="date" name="tanggal" class="app-input" value="<?= esc(old('tanggal', date('Y-m-d'))) ?>" required>
          </div>
          <div class="sm:col-span-2">
            <label class="app-label">Deskripsi / Alasan <span class="text-rose-500">*</span></label>
            <textarea name="deskripsi" class="app-textarea" rows="4" placeholder="Jelaskan alasan ketidakhadiran Anda" required><?= esc(old('deskripsi')) ?></textarea>
          </div>
          <div class="sm:col-span-2">
            <label class="app-label">Lampiran <span class="font-medium normal-case text-slate-400">(opsional, JPG/PNG/PDF, maks. 5 MB)</span></label>
            <input type="file" name="file" class="app-input pt-2.5 text-[12px] file:mr-3 file:rounded-md file:border-0 file:bg-brand-50 file:px-2.5 file:py-1 file:text-[11px] file:font-semibold file:text-brand-700" accept="image/jpeg,image/png,application/pdf">
          </div>
        </div>
        <div class="flex items-center gap-2 pt-1">
          <button type="submit" class="app-btn-primary"><i class="fa-solid fa-paper-plane"></i> Kirim Pengajuan</button>
          <a href="<?= base_url('pegawai/ketidakhadiran') ?>" class="app-btn-ghost">Batal</a>
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
        <li class="flex gap-2.5"><i class="fa-solid fa-check mt-1 text-[9px] text-emerald-500"></i> Pengajuan akan berstatus <strong class="text-slate-700">Menunggu</strong> sampai admin menyetujui.</li>
        <li class="flex gap-2.5"><i class="fa-solid fa-check mt-1 text-[9px] text-emerald-500"></i> Pastikan tanggal pengajuan sesuai dengan tanggal tidak hadir.</li>
        <li class="flex gap-2.5"><i class="fa-solid fa-check mt-1 text-[9px] text-emerald-500"></i> Lampiran seperti surat dokter atau surat izin akan membantu proses persetujuan.</li>
        <li class="flex gap-2.5"><i class="fa-solid fa-check mt-1 text-[9px] text-emerald-500"></i> Pengajuan yang disetujui akan dihitung pada rekap kehadiran.</li>
      </ul>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
