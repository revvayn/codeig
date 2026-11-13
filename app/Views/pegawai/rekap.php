<?= $this->extend('pegawai/layout.php') ?>

<?= $this->section('content') ?>
<div class="app-page-head">
  <div>
    <h2 class="app-title">Rekap Kehadiran</h2>
    <p class="app-subtitle">Riwayat presensi dan pengajuan ketidakhadiran Anda.</p>
  </div>
  <form method="GET" action="<?= base_url('pegawai/rekap') ?>" class="flex items-end gap-2">
    <div>
      <label class="app-label">Bulan</label>
      <input type="month" name="bulan" class="app-input h-10 w-[150px] text-[12.5px]" value="<?= esc($bulan) ?>">
    </div>
    <button type="submit" class="app-btn-dark"><i class="fa-solid fa-magnifying-glass"></i> Tampilkan</button>
  </form>
</div>

<?php
$izinDisetujui = array_filter($izin, static fn ($row) => ($row['status_pengajuan'] ?? '') === 'Disetujui');
$izinMenunggu  = array_filter($izin, static fn ($row) => ($row['status_pengajuan'] ?? '') === 'Menunggu');
?>
<div class="mb-[26px] grid grid-cols-1 gap-[26px] sm:grid-cols-3">
  <div class="app-card relative overflow-hidden p-5">
    <span class="absolute inset-y-0 left-0 w-1 bg-emerald-500"></span>
    <div class="flex items-start justify-between">
      <div>
        <div class="text-[10.5px] font-bold uppercase tracking-[0.1em] text-slate-400">Hadir</div>
        <div class="mt-2 text-[34px] font-extrabold leading-none text-slate-900"><?= (int) $total_hadir ?></div>
        <div class="mt-1.5 text-[11px] text-slate-400"><?= esc($nama_bulan) ?></div>
      </div>
      <span class="grid h-10 w-10 place-items-center rounded-xl bg-emerald-50 text-emerald-600"><i class="fa-solid fa-calendar-check text-sm"></i></span>
    </div>
  </div>
  <div class="app-card relative overflow-hidden p-5">
    <span class="absolute inset-y-0 left-0 w-1 bg-sky-500"></span>
    <div class="flex items-start justify-between">
      <div>
        <div class="text-[10.5px] font-bold uppercase tracking-[0.1em] text-slate-400">Izin Disetujui</div>
        <div class="mt-2 text-[34px] font-extrabold leading-none text-slate-900"><?= count($izinDisetujui) ?></div>
        <div class="mt-1.5 text-[11px] text-slate-400">Bulan ini</div>
      </div>
      <span class="grid h-10 w-10 place-items-center rounded-xl bg-sky-50 text-sky-600"><i class="fa-solid fa-file-lines text-sm"></i></span>
    </div>
  </div>
  <div class="app-card relative overflow-hidden p-5">
    <span class="absolute inset-y-0 left-0 w-1 bg-amber-500"></span>
    <div class="flex items-start justify-between">
      <div>
        <div class="text-[10.5px] font-bold uppercase tracking-[0.1em] text-slate-400">Menunggu Persetujuan</div>
        <div class="mt-2 text-[34px] font-extrabold leading-none text-slate-900"><?= count($izinMenunggu) ?></div>
        <div class="mt-1.5 text-[11px] text-slate-400">Bulan ini</div>
      </div>
      <span class="grid h-10 w-10 place-items-center rounded-xl bg-amber-50 text-amber-600"><i class="fa-regular fa-clock text-sm"></i></span>
    </div>
  </div>
</div>

<div class="app-card mb-[26px] overflow-hidden">
  <div class="app-card-header">
    <div>
      <h3 class="text-[15px] font-bold text-slate-900">Riwayat Presensi</h3>
      <p class="mt-0.5 text-[11.5px] text-slate-400"><?= esc($nama_bulan) ?></p>
    </div>
    <span class="inline-flex items-center gap-2 rounded-full bg-brand-50 px-3 py-1.5 text-[11px] font-bold text-brand-700">
      <span class="h-1.5 w-1.5 rounded-full bg-brand-500"></span> <?= count($presensi) ?> data
    </span>
  </div>
  <div class="p-3 sm:p-4">
    <?php if (empty($presensi)): ?>
      <div class="app-empty">
        <i class="fa-regular fa-calendar"></i>
        <div>Belum ada presensi pada bulan ini.</div>
      </div>
    <?php else: ?>
        <table id="datatables" class="app-table">
          <thead>
            <tr>
              <th>No</th>
              <th>Tanggal</th>
              <th>Jam Masuk</th>
              <th>Jam Pulang</th>
              <th>Foto Masuk</th>
              <th>Foto Pulang</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; foreach ($presensi as $row): ?>
              <tr>
                <td class="text-slate-400"><?= $no++ ?></td>
                <td class="font-semibold text-slate-800"><?= tanggal_indo($row['tanggal_masuk'], true) ?></td>
                <td><?= $row['jam_masuk'] ? substr($row['jam_masuk'], 0, 5) : '-' ?></td>
                <td><?= $row['jam_keluar'] ? substr($row['jam_keluar'], 0, 5) : '<span class="text-slate-400">Belum</span>' ?></td>
                <td>
                  <?php $fotoMasuk = foto_presensi_url($row['foto_masuk'] ?? ''); ?>
                  <?php if ($fotoMasuk !== ''): ?>
                    <a href="<?= $fotoMasuk ?>" target="_blank">
                      <img src="<?= $fotoMasuk ?>" class="h-9 w-9 rounded-lg object-cover ring-2 ring-white shadow-sm" alt="Foto masuk">
                    </a>
                  <?php else: ?><span class="text-slate-400">-</span><?php endif; ?>
                </td>
                <td>
                  <?php $fotoKeluar = foto_presensi_url($row['foto_keluar'] ?? ''); ?>
                  <?php if ($fotoKeluar !== ''): ?>
                    <a href="<?= $fotoKeluar ?>" target="_blank">
                      <img src="<?= $fotoKeluar ?>" class="h-9 w-9 rounded-lg object-cover ring-2 ring-white shadow-sm" alt="Foto pulang">
                    </a>
                  <?php else: ?><span class="text-slate-400">-</span><?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
    <?php endif; ?>
  </div>
</div>

<div class="app-card overflow-hidden">
  <div class="app-card-header">
    <div>
      <h3 class="text-[15px] font-bold text-slate-900">Pengajuan Ketidakhadiran</h3>
      <p class="mt-0.5 text-[11.5px] text-slate-400"><?= esc($nama_bulan) ?></p>
    </div>
    <a href="<?= base_url('pegawai/ketidakhadiran/create') ?>" class="app-btn-dark app-btn-sm">
      <i class="fa-solid fa-plus"></i> Ajukan
    </a>
  </div>
  <div class="p-3 sm:p-4">
    <?php if (empty($izin)): ?>
      <div class="app-empty">
        <i class="fa-regular fa-calendar-xmark"></i>
        <div>Belum ada pengajuan pada bulan ini.</div>
      </div>
    <?php else: ?>
      <div class="overflow-x-auto">
        <table class="app-table">
          <thead>
            <tr>
              <th>Tanggal</th>
              <th>Keterangan</th>
              <th>Deskripsi</th>
              <th>Status</th>
              <th>Lampiran</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($izin as $row): ?>
              <tr>
                <td class="font-semibold text-slate-800"><?= tanggal_indo($row['tanggal']) ?></td>
                <td>
                  <span class="inline-flex rounded-md bg-slate-100 px-2 py-0.5 text-[11px] font-semibold text-slate-600 ring-1 ring-inset ring-slate-200"><?= esc($row['keterangan']) ?></span>
                </td>
                <td class="max-w-[260px] truncate text-[11.5px] text-slate-500" title="<?= esc($row['deskripsi']) ?>"><?= esc($row['deskripsi']) ?></td>
                <td><?= badge_kehadiran($row['status_pengajuan']) ?></td>
                <td>
                  <?php if (! empty($row['file'])): ?>
                    <a href="<?= base_url('uploads/ketidakhadiran/' . $row['file']) ?>" target="_blank" class="app-btn-outline app-btn-sm h-8">
                      <i class="fa-solid fa-paperclip text-[10px]"></i> Lihat
                    </a>
                  <?php else: ?><span class="text-slate-400">-</span><?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>
</div>
<?= $this->endSection() ?>
