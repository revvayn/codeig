<?= $this->extend('superadmin/layout.php') ?>
<?= $this->section('content') ?>

<div class="app-page-head">
  <div>
    <h2 class="app-title">Dashboard Superadmin</h2>
    <p class="app-subtitle">Ringkasan seluruh perusahaan, admin, dan pegawai pada sistem presensi.</p>
  </div>
  <div class="flex flex-wrap items-center gap-2">
    <span class="hidden items-center gap-2 rounded-full border border-slate-200 bg-white px-3.5 py-2 text-[11.5px] font-semibold text-slate-500 sm:inline-flex">
      <i class="fa-regular fa-calendar text-brand-500"></i> <?= tanggal_indo(date('Y-m-d'), true) ?>
    </span>
    <a href="<?= base_url('superadmin/audit') ?>" class="app-btn-primary">
      <i class="fa-solid fa-clipboard-list"></i> Audit Log
    </a>
  </div>
</div>

<div class="mb-[26px] grid grid-cols-1 gap-[26px] sm:grid-cols-2 xl:grid-cols-5">
  <?php
  $cards = [
    ['Perusahaan', (int) ($total_perusahaan ?? 0), 'from-brand-500 to-violet-600', 'text-white', 'fa-building'],
    ['Admin', (int) ($total_admin ?? 0), 'from-sky-500 to-blue-600', 'text-white', 'fa-user-shield'],
    ['Superadmin', (int) ($total_superadmin ?? 0), 'from-slate-600 to-slate-900', 'text-white', 'fa-user-tie'],
    ['Pegawai', (int) ($total_pegawai ?? 0), 'from-emerald-500 to-teal-600', 'text-white', 'fa-users'],
    ['Plant / Lokasi', (int) ($total_plant ?? 0), 'from-amber-400 to-orange-500', 'text-white', 'fa-location-dot'],
  ];
  foreach ($cards as [$label, $value, $gradient, $text, $icon]):
  ?>
    <div class="app-card group relative overflow-hidden p-5 transition duration-300 hover:-translate-y-0.5 hover:shadow-lift sm:last:col-span-2 xl:last:col-span-1">
      <div class="pointer-events-none absolute -right-8 -top-8 h-24 w-24 rounded-full bg-gradient-to-br <?= $gradient ?> opacity-[0.08] transition group-hover:opacity-[0.14]"></div>
      <div class="flex items-center justify-between">
        <div class="grid h-10 w-10 place-items-center rounded-xl bg-gradient-to-br <?= $gradient ?> <?= $text ?> shadow-lg shadow-slate-900/10">
          <i class="fa-solid <?= $icon ?> text-[13px]"></i>
        </div>
        <span class="rounded-full bg-slate-50 px-2 py-1 text-[9.5px] font-bold uppercase tracking-wide text-slate-400">Total</span>
      </div>
      <div class="mt-4 text-[34px] font-extrabold leading-none tracking-tight text-slate-900"><?= $value ?></div>
      <div class="mt-2 text-[10.5px] font-bold uppercase tracking-[0.08em] text-slate-400"><?= $label ?></div>
    </div>
  <?php endforeach; ?>
</div>

<div class="app-card overflow-hidden">
  <div class="app-card-header">
    <div class="flex items-center gap-2.5">
      <span class="grid h-8 w-8 place-items-center rounded-lg bg-brand-50 text-brand-600"><i class="fa-solid fa-building text-[11px]"></i></span>
      <div>
        <h3 class="text-[14px] font-bold text-slate-900">Daftar Perusahaan</h3>
        <p class="text-[11px] text-slate-400"><?= count($perusahaan ?? []) ?> perusahaan terdaftar</p>
      </div>
    </div>
    <a href="<?= base_url('superadmin/perusahaan') ?>" class="app-btn-outline app-btn-sm">Kelola perusahaan</a>
  </div>
  <div class="p-3 sm:p-4">
    <?php if (empty($perusahaan)): ?>
      <div class="app-empty">
        <i class="fa-regular fa-building"></i>
        <div>Belum ada perusahaan terdaftar.</div>
      </div>
    <?php else: ?>
      <div class="overflow-x-auto">
        <table class="app-table">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Perusahaan</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; foreach ($perusahaan as $row): ?>
              <tr>
                <td class="text-slate-400"><?= $no++ ?></td>
                <td class="font-semibold text-slate-800"><?= esc($row['nama_perusahaan']) ?></td>
                <td><?= badge_kehadiran($row['status'] ?: 'Tidak Aktif') ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>
</div>

<?= $this->endSection() ?>
