<?= $this->extend('admin/layout.php') ?>
<?= $this->section('content') ?>

<div class="app-page-head">
  <div>
    <h2 class="app-title">Dashboard Admin</h2>
    <p class="app-subtitle">Ringkasan kehadiran karyawan perusahaan Anda hari ini.</p>
  </div>
  <div class="flex flex-wrap items-center gap-2">
    <span class="hidden items-center gap-2 rounded-full border border-slate-200 bg-white px-3.5 py-2 text-[11.5px] font-semibold text-slate-500 sm:inline-flex">
      <i class="fa-regular fa-calendar text-brand-500"></i> <?= tanggal_indo($tanggal, true) ?>
    </span>
    <a href="<?= base_url('admin/rekap/harian') ?>" class="app-btn-primary">
      <i class="fa-solid fa-chart-column"></i> Lihat Rekap Harian
    </a>
  </div>
</div>

<div class="mb-[26px] grid grid-cols-1 gap-[26px] sm:grid-cols-2 xl:grid-cols-4">
  <?php
  $cards = [
    ['Total Pegawai', (int) $total_pegawai, 'from-slate-700 to-slate-900', 'text-slate-100', 'bg-white/15', 'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z'],
    ['Hadir Hari Ini', (int) $hadir, 'from-emerald-500 to-teal-600', 'text-white', 'bg-white/20', 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
    ['Izin / Sakit / Cuti', (int) $izin, 'from-amber-400 to-orange-500', 'text-white', 'bg-white/20', 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5'],
    ['Belum Presensi / Alpa', (int) $alpa, 'from-rose-500 to-red-600', 'text-white', 'bg-white/20', 'M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
  ];
  foreach ($cards as [$label, $value, $gradient, $text, $iconBg, $path]):
  ?>
    <div class="app-card group relative overflow-hidden p-5 transition duration-300 hover:-translate-y-0.5 hover:shadow-lift">
      <div class="pointer-events-none absolute -right-10 -top-10 h-32 w-32 rounded-full bg-gradient-to-br <?= $gradient ?> opacity-[0.07] transition group-hover:opacity-[0.12]"></div>
      <div class="flex items-center justify-between">
        <div class="grid h-10 w-10 place-items-center rounded-xl bg-gradient-to-br <?= $gradient ?> <?= $text ?> shadow-lg shadow-slate-900/10">
          <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="<?= $path ?>" />
          </svg>
        </div>
        <span class="rounded-full bg-slate-50 px-2 py-1 text-[9.5px] font-bold uppercase tracking-wide text-slate-400"><?= $label === 'Total Pegawai' ? 'Total' : 'Hari ini' ?></span>
      </div>
      <div class="mt-4">
        <div class="text-[34px] font-extrabold leading-none tracking-tight text-slate-900"><?= $value ?></div>
        <div class="mt-2 text-[10.5px] font-bold uppercase tracking-[0.08em] text-slate-400"><?= $label ?></div>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<div class="app-card overflow-hidden">
  <div class="app-card-header">
    <div class="flex items-center gap-2.5">
      <span class="grid h-8 w-8 place-items-center rounded-lg bg-brand-50 text-brand-600"><i class="fa-regular fa-clock text-[11px]"></i></span>
      <div>
        <h3 class="text-[14px] font-bold text-slate-900">Presensi Hari Ini</h3>
        <p class="text-[11px] text-slate-400">Daftar karyawan yang sudah melakukan presensi masuk.</p>
      </div>
    </div>
    <span class="inline-flex items-center gap-2 rounded-full bg-brand-50 px-3 py-1.5 text-[11px] font-bold text-brand-700">
      <span class="h-1.5 w-1.5 rounded-full bg-brand-500"></span> <?= count($presensi_hari_ini) ?> data
    </span>
  </div>

  <div class="p-3 sm:p-4">
    <?php if (empty($presensi_hari_ini)): ?>
      <div class="app-empty">
        <i class="fa-regular fa-clock"></i>
        <div>Belum ada karyawan yang presensi hari ini.</div>
      </div>
    <?php else: ?>
      <div class="overflow-x-auto">
        <table class="app-table">
          <thead>
            <tr>
              <th>Nama</th>
              <th>NIP</th>
              <th>Jam Masuk</th>
              <th>Jam Pulang</th>
              <th>Foto</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($presensi_hari_ini as $row): ?>
              <tr>
                <td class="font-semibold text-slate-800"><?= esc($row['nama']) ?></td>
                <td><?= esc($row['nip']) ?></td>
                <td><span class="inline-flex items-center gap-1.5 font-semibold text-slate-700"><i class="fa-regular fa-clock text-[10px] text-emerald-500"></i><?= $row['jam_masuk'] ? substr($row['jam_masuk'], 0, 5) : '-' ?></span></td>
                <td>
                  <?php if ($row['jam_keluar']): ?>
                    <span class="inline-flex items-center gap-1.5 font-semibold text-slate-700"><i class="fa-regular fa-clock text-[10px] text-rose-400"></i><?= substr($row['jam_keluar'], 0, 5) ?></span>
                  <?php else: ?>
                    <span class="text-slate-400">Belum</span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php $fotoPresensi = foto_presensi_url($row['foto_masuk'] ?? ''); ?>
                  <?php if ($fotoPresensi !== ''): ?>
                    <img src="<?= $fotoPresensi ?>" alt="Foto presensi" class="h-8 w-8 rounded-lg object-cover ring-2 ring-white shadow-sm">
                  <?php else: ?>
                    <span class="text-slate-400">-</span>
                  <?php endif; ?>
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
