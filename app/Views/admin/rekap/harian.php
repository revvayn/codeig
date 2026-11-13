<?= $this->extend('admin/layout.php') ?>
<?= $this->section('content') ?>

<div class="app-page-head">
  <div>
    <h2 class="app-title">Rekap Kehadiran Harian</h2>
    <p class="app-subtitle">Pantau kehadiran seluruh karyawan pada tanggal tertentu.</p>
  </div>
  <div class="flex flex-wrap items-end gap-2">
    <form method="GET" action="<?= base_url('admin/rekap/harian') ?>" class="flex items-end gap-2">
      <div>
        <label class="app-label">Tanggal</label>
        <input type="date" name="tanggal" class="app-input h-10 w-[150px] text-[12.5px]" value="<?= esc($tanggal) ?>">
      </div>
      <button type="submit" class="app-btn-dark"><i class="fa-solid fa-magnifying-glass"></i> Tampilkan</button>
    </form>
    <a href="<?= base_url('admin/rekap/harian/export?tanggal=' . urlencode($tanggal)) ?>" class="app-btn-outline border-emerald-200 text-emerald-700 hover:border-emerald-300 hover:bg-emerald-50 hover:text-emerald-800">
      <i class="fa-solid fa-file-csv"></i> Export CSV
    </a>
  </div>
</div>

<?php
$jumlahHadir = 0;
$jumlahAlpa = 0;
$jumlahIzin = 0;
foreach ($rekap as $row) {
    if ($row['status'] === 'Hadir' || $row['status'] === 'Terlambat') {
        $jumlahHadir++;
    } elseif ($row['status'] === 'Alpa') {
        $jumlahAlpa++;
    } else {
        $jumlahIzin++;
    }
}
?>
<div class="mb-[26px] grid grid-cols-1 gap-[26px] sm:grid-cols-3">
  <div class="app-card relative overflow-hidden p-5">
    <span class="absolute inset-y-0 left-0 w-1 bg-emerald-500"></span>
    <div class="text-[10.5px] font-bold uppercase tracking-[0.1em] text-slate-400">Hadir</div>
    <div class="mt-2 text-[34px] font-extrabold leading-none text-emerald-600"><?= $jumlahHadir ?></div>
  </div>
  <div class="app-card relative overflow-hidden p-5">
    <span class="absolute inset-y-0 left-0 w-1 bg-amber-500"></span>
    <div class="text-[10.5px] font-bold uppercase tracking-[0.1em] text-slate-400">Izin / Sakit / Cuti</div>
    <div class="mt-2 text-[34px] font-extrabold leading-none text-amber-500"><?= $jumlahIzin ?></div>
  </div>
  <div class="app-card relative overflow-hidden p-5">
    <span class="absolute inset-y-0 left-0 w-1 bg-rose-500"></span>
    <div class="text-[10.5px] font-bold uppercase tracking-[0.1em] text-slate-400">Alpa / Belum Presensi</div>
    <div class="mt-2 text-[34px] font-extrabold leading-none text-rose-600"><?= $jumlahAlpa ?></div>
  </div>
</div>

<div class="app-card overflow-hidden">
  <div class="app-card-header">
    <div>
      <h3 class="text-[15px] font-bold text-slate-900">Rekap <?= tanggal_indo($tanggal, true) ?></h3>
      <p class="mt-0.5 text-[11.5px] text-slate-400"><?= count($rekap) ?> karyawan</p>
    </div>
    <span class="inline-flex items-center gap-2 rounded-full bg-brand-50 px-3 py-1.5 text-[11px] font-bold text-brand-700">
      <span class="h-1.5 w-1.5 rounded-full bg-brand-500"></span> Harian
    </span>
  </div>
  <div class="p-3 sm:p-4">
      <table id="datatables" class="app-table">
        <thead>
          <tr>
            <th>No</th>
            <th>Pegawai</th>
            <th>NIP</th>
            <th>Jabatan</th>
            <th>Jam Masuk</th>
            <th>Jam Pulang</th>
            <th>Status</th>
            <th>Keterangan</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1; foreach ($rekap as $row): ?>
            <tr>
              <td class="text-slate-400"><?= $no++ ?></td>
              <td>
                <div class="flex items-center gap-2.5">
                  <?php $foto = $row['pegawai']['foto'] ?: ''; ?>
                  <img src="<?= $foto && is_file(FCPATH . 'profile/' . $foto) ? base_url('profile/' . $foto) : base_url('assets/img/team-1.jpg') ?>" class="h-8 w-8 rounded-lg object-cover ring-2 ring-white shadow-sm" alt="Foto">
                  <span class="font-semibold text-slate-800"><?= esc($row['pegawai']['nama']) ?></span>
                </div>
              </td>
              <td><?= esc($row['pegawai']['nip']) ?></td>
              <td><?= esc($row['pegawai']['jabatan']) ?></td>
              <td><?= esc($row['jam_masuk']) ?></td>
              <td><?= esc($row['jam_keluar']) ?></td>
              <td><?= badge_kehadiran($row['status']) ?></td>
              <td class="max-w-[220px] truncate text-[11.5px] text-slate-400">
                <?= $row['izin'] ? esc($row['izin']['deskripsi']) : '-' ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
  </div>
</div>

<?= $this->endSection() ?>
