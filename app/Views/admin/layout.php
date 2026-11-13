<?php
$uri = uri_string();
$on  = static fn (string $prefix): bool => str_starts_with($uri, $prefix);

$navGroups = [
    [
        'items' => [
            ['label' => 'Dashboard', 'url' => base_url('admin/home'), 'icon' => 'fa-gauge-high', 'active' => $on('admin/home')],
            ['label' => 'Data Pegawai', 'url' => base_url('admin/data_pegawai'), 'icon' => 'fa-users', 'active' => $on('admin/data_pegawai')],
        ],
    ],
    [
        'label' => 'Kehadiran',
        'items' => [
            [
                'label' => 'Rekap Kehadiran', 'icon' => 'fa-chart-column', 'active' => $on('admin/rekap'),
                'children' => [
                    ['label' => 'Rekap Harian', 'url' => base_url('admin/rekap/harian'), 'active' => $on('admin/rekap/harian')],
                    ['label' => 'Rekap Bulanan', 'url' => base_url('admin/rekap/bulanan'), 'active' => $on('admin/rekap/bulanan')],
                ],
            ],
            ['label' => 'Ketidakhadiran', 'url' => base_url('admin/ketidakhadiran'), 'icon' => 'fa-calendar-xmark', 'active' => $on('admin/ketidakhadiran')],
        ],
    ],
    [
        'label' => 'Master Data',
        'items' => [
            ['label' => 'Data Jabatan', 'url' => base_url('admin/jabatan'), 'icon' => 'fa-sitemap', 'active' => $on('admin/jabatan')],
            ['label' => 'Lokasi Presensi', 'url' => base_url('admin/lokasi_presensi'), 'icon' => 'fa-location-dot', 'active' => $on('admin/lokasi_presensi')],
            ['label' => 'Data Perusahaan', 'url' => base_url('admin/perusahaan'), 'icon' => 'fa-building', 'active' => $on('admin/perusahaan')],
        ],
    ],
    [
        'label' => 'Akun',
        'items' => [
            ['label' => 'Profil Saya', 'url' => base_url('admin/profile'), 'icon' => 'fa-user-gear', 'active' => $on('admin/profile')],
        ],
    ],
];
?>
<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
  <?= $this->include('partials/theme_head', ['title' => $title ?? 'Dashboard']) ?>
</head>

<body class="min-h-full bg-[#f5f6fb] font-sans text-slate-800 antialiased">
  <div id="appOverlay" class="fixed inset-0 z-30 hidden bg-slate-950/50 backdrop-blur-sm lg:hidden"></div>

  <?php $this->setData([
      'brandUrl'   => base_url('admin/home'),
      'profileUrl' => base_url('admin/profile'),
      'navGroups'  => $navGroups,
  ]); ?>
  <?= $this->include('partials/sidebar') ?>

  <div class="flex min-h-screen flex-col lg:pl-[264px]">
    <?= $this->include('partials/topbar', ['title' => $title ?? 'Dashboard']) ?>

    <main class="mx-auto w-full max-w-app flex-1 px-4 py-6 sm:px-6 lg:px-[42px] lg:py-8">
      <?= $this->renderSection('content') ?>
    </main>

    <footer class="border-t border-slate-200/70 px-4 py-5 sm:px-6 lg:px-[42px]">
      <div class="mx-auto flex max-w-app flex-col items-center justify-between gap-2 text-[11px] text-slate-400 sm:flex-row">
        <span>&copy; <?= date('Y') ?> PresensiKu. Semua hak dilindungi.</span>
        <span class="font-medium"><?= esc(session()->get('nama_perusahaan') ?? '') ?></span>
      </div>
    </footer>
  </div>

  <?= $this->include('partials/foot_scripts') ?>
  <?= $this->renderSection('scripts') ?>
</body>
</html>
