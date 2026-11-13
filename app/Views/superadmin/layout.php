<?php
$uri = uri_string();
$on  = static fn (string $prefix): bool => str_starts_with($uri, $prefix);

$navGroups = [
    [
        'items' => [
            ['label' => 'Dashboard', 'url' => base_url('superadmin/home'), 'icon' => 'fa-gauge-high', 'active' => $on('superadmin/home')],
        ],
    ],
    [
        'label' => 'Manajemen',
        'items' => [
            ['label' => 'Data Perusahaan', 'url' => base_url('superadmin/perusahaan'), 'icon' => 'fa-building', 'active' => $on('superadmin/perusahaan')],
            ['label' => 'Data Admin', 'url' => base_url('superadmin/admin'), 'icon' => 'fa-user-shield', 'active' => $on('superadmin/admin')],
            ['label' => 'Audit Log', 'url' => base_url('superadmin/audit'), 'icon' => 'fa-clipboard-list', 'active' => $on('superadmin/audit')],
        ],
    ],
    [
        'label' => 'Akun',
        'items' => [
            ['label' => 'Profil Saya', 'url' => base_url('superadmin/profile'), 'icon' => 'fa-user-gear', 'active' => $on('superadmin/profile')],
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
      'brandUrl'   => base_url('superadmin/home'),
      'profileUrl' => base_url('superadmin/profile'),
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
