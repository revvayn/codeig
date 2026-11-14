<?php
$namaUser   = session()->get('nama_pegawai') ?: session()->get('username');
$roleUser   = session()->get('role_id') ?: '-';
$perusahaan = session()->get('nama_perusahaan') ?: '-';
$foto       = session()->get('foto_pegawai');
$avatar     = (! empty($foto) && is_file(FCPATH . 'profile/' . $foto))
    ? base_url('profile/' . $foto)
    : base_url('assets/img/team-1.jpg');
?>
<header class="sticky top-0 z-20 flex h-[68px] items-center gap-3 border-b border-slate-200/70 bg-white/85 px-4 backdrop-blur-xl sm:px-6 lg:px-[42px]">
  <button type="button" id="sidebarToggle" aria-label="Buka menu"
    class="grid h-10 w-10 shrink-0 place-items-center rounded-xl border border-slate-200 bg-white text-slate-600 transition hover:bg-slate-50 lg:hidden">
    <i class="fa-solid fa-bars text-sm"></i>
  </button>

  <div class="min-w-0">
    <h1 class="truncate text-[14.5px] font-bold tracking-tight text-slate-900"><?= esc($title ?? 'Dashboard') ?></h1>
    <p class="hidden text-[10.5px] font-medium text-slate-400 sm:block">Sistem Presensi Karyawan</p>
  </div>

  <div class="ml-auto flex items-center gap-2 sm:gap-3">
    <span class="hidden items-center gap-2 rounded-full border border-slate-200 bg-white px-3.5 py-2 text-[11.5px] font-semibold text-slate-600 shadow-sm md:inline-flex">
      <i class="fa-regular fa-building text-brand-500"></i>
      <span class="max-w-[180px] truncate"><?= esc($perusahaan) ?></span>
    </span>

    <button type="button" id="notifButton" title="Notifikasi" aria-label="Notifikasi"
      class="grid h-10 w-10 place-items-center rounded-xl border border-slate-200 bg-white text-slate-500 transition hover:border-brand-200 hover:text-brand-600">
      <i class="fa-regular fa-bell text-sm"></i>
    </button>

    <div class="relative">
      <button type="button" id="userMenuButton"
        class="flex items-center gap-2.5 rounded-xl border border-slate-200 bg-white p-1.5 pr-2.5 transition hover:border-brand-200">
        <img src="<?= esc($avatar) ?>" alt="Avatar" class="h-8 w-8 rounded-lg object-cover">
        <span class="hidden text-left sm:block">
          <span class="block max-w-[130px] truncate text-[12px] font-bold leading-tight text-slate-800"><?= esc($namaUser) ?></span>
          <span class="block text-[10px] font-medium leading-tight text-slate-400"><?= esc($roleUser) ?></span>
        </span>
        <i class="fa-solid fa-chevron-down text-[8.5px] text-slate-400"></i>
      </button>

      <div id="userMenu"
        class="absolute right-0 mt-2 hidden w-56 overflow-hidden rounded-2xl border border-slate-200 bg-white p-1.5 shadow-xl">
        <div class="px-3 py-2.5">
          <p class="text-[10.5px] text-slate-400">Login sebagai</p>
          <p class="truncate text-[13px] font-bold text-slate-800"><?= esc(session()->get('username') ?: $namaUser) ?></p>
        </div>
        <div class="my-1 h-px bg-slate-100"></div>
        <?php $profilPrefix = session()->get('role_id') === 'Superadmin' ? 'superadmin' : (session()->get('role_id') === 'Pegawai' ? 'pegawai' : 'admin'); ?>
        <a href="<?= base_url($profilPrefix . '/profile') ?>"
          class="flex items-center gap-2.5 rounded-xl px-3 py-2.5 text-[12.5px] font-semibold text-slate-700 transition hover:bg-slate-50">
          <i class="fa-solid fa-user-gear text-slate-400"></i> Profil Saya
        </a>
        <a href="<?= base_url('logout') ?>"
          class="flex items-center gap-2.5 rounded-xl px-3 py-2.5 text-[12.5px] font-semibold text-rose-600 transition hover:bg-rose-50">
          <i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar
        </a>
      </div>
    </div>
  </div>
</header>
