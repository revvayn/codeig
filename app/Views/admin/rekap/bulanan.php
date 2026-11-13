<?= $this->extend('admin/layout.php') ?>
<?= $this->section('content') ?>

<div class="app-page-head">
  <div>
    <h2 class="app-title">Rekap Kehadiran Bulanan</h2>
    <p class="app-subtitle">Akumulasi kehadiran karyawan per bulan. Alpa dihitung dari hari kerja yang tidak memiliki presensi.</p>
  </div>
  <div class="flex flex-wrap items-end gap-2">
    <form method="GET" action="<?= base_url('admin/rekap/bulanan') ?>" class="flex items-end gap-2">
      <div>
        <label class="app-label">Bulan</label>
        <input type="month" name="bulan" class="app-input h-10 w-[150px] text-[12.5px]" value="<?= esc($bulan) ?>">
      </div>
      <button type="submit" class="app-btn-dark"><i class="fa-solid fa-magnifying-glass"></i> Tampilkan</button>
    </form>
    <a href="<?= base_url('admin/rekap/bulanan/export?bulan=' . urlencode($bulan)) ?>" class="app-btn-outline border-emerald-200 text-emerald-700 hover:border-emerald-300 hover:bg-emerald-50 hover:text-emerald-800">
      <i class="fa-solid fa-file-csv"></i> Export CSV
    </a>
  </div>
</div>

<div class="app-card mb-[26px] p-6">
  <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
    <div>
      <div class="text-[10.5px] font-bold uppercase tracking-[0.1em] text-slate-400">Periode</div>
      <div class="mt-1.5 text-[15px] font-bold text-slate-900"><?= esc($nama_bulan) ?></div>
    </div>
    <div>
      <div class="text-[10.5px] font-bold uppercase tracking-[0.1em] text-slate-400">Hari Kerja</div>
      <div class="mt-1.5 text-[15px] font-bold text-slate-900"><?= (int) $hari_kerja ?> hari</div>
    </div>
    <div>
      <div class="text-[10.5px] font-bold uppercase tracking-[0.1em] text-slate-400">Jumlah Pegawai</div>
      <div class="mt-1.5 text-[15px] font-bold text-slate-900"><?= count($rekap) ?> orang</div>
    </div>
  </div>
</div>

<div class="app-card overflow-hidden">
  <div class="app-card-header">
    <div>
      <h3 class="text-[15px] font-bold text-slate-900">Rekap <?= esc($nama_bulan) ?></h3>
      <p class="mt-0.5 text-[11.5px] text-slate-400">Persentase kehadiran dihitung dari hari kerja efektif.</p>
    </div>
  </div>
  <div class="p-3 sm:p-4">
      <table id="datatables" class="app-table">
        <thead>
          <tr>
            <th>No</th>
            <th>Pegawai</th>
            <th>NIP</th>
            <th class="text-center">Hadir</th>
            <th class="text-center">Izin</th>
            <th class="text-center">Sakit</th>
            <th class="text-center">Cuti</th>
            <th class="text-center">Alpa</th>
            <th>Kehadiran</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1; foreach ($rekap as $row): ?>
            <?php $persen = $row['hari_kerja'] > 0 ? round(($row['hadir'] / $row['hari_kerja']) * 100) : 0; ?>
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
              <td class="text-center font-bold text-emerald-600"><?= (int) $row['hadir'] ?></td>
              <td class="text-center"><?= (int) $row['izin'] ?></td>
              <td class="text-center"><?= (int) $row['sakit'] ?></td>
              <td class="text-center"><?= (int) $row['cuti'] ?></td>
              <td class="text-center font-bold text-rose-600"><?= (int) $row['alpa'] ?></td>
              <td class="min-w-[150px]">
                <div class="flex items-center gap-2.5">
                  <div class="h-2 flex-1 overflow-hidden rounded-full bg-slate-100">
                    <div class="h-full rounded-full bg-gradient-to-r from-emerald-400 to-teal-500" style="width: <?= $persen ?>%"></div>
                  </div>
                  <span class="w-9 text-right text-[11px] font-bold text-slate-600"><?= $persen ?>%</span>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
  </div>
</div>
<?= $this->endSection() ?>
