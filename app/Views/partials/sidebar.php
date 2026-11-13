<?php
/**
 * Sidebar bersama. Variabel yang dibutuhkan:
 * - $brandUrl   : URL logo/brand
 * - $navGroups  : daftar grup navigasi
 *   [ ['label' => 'Kehadiran', 'items' => [
 *       ['label' => 'Rekap Harian', 'url' => '...', 'icon' => 'fa-chart-column', 'active' => true, 'children' => [...]]]],
 *   ]
 */
$namaUser  = session()->get('nama_pegawai') ?: session()->get('username');
$roleUser  = session()->get('role_id') ?: '-';
$perusahaan = session()->get('nama_perusahaan') ?: 'Perusahaan';
$foto      = session()->get('foto_pegawai');
$avatar    = (! empty($foto) && is_file(FCPATH . 'profile/' . $foto))
    ? base_url('profile/' . $foto)
    : base_url('assets/img/team-1.jpg');
?>
<aside id="appSidebar"
  class="fixed inset-y-0 left-0 z-40 flex w-[264px] -translate-x-full flex-col bg-[#0b1220] text-slate-300 transition-transform duration-300 ease-out-expo lg:translate-x-0">

  <!-- Brand -->
  <a href="<?= esc($brandUrl ?? base_url('/')) ?>" class="flex h-[68px] shrink-0 items-center gap-3 border-b border-white/10 px-5">
    <span class="grid h-10 w-10 place-items-center rounded-2xl bg-gradient-to-br from-brand-500 to-violet-500 text-base font-extrabold text-white shadow-lg shadow-brand-950/50">P</span>
    <span class="min-w-0">
      <span class="block text-[15px] font-bold leading-tight text-white">PresensiKu</span>
      <span class="block truncate text-[10.5px] text-slate-400"><?= esc($perusahaan) ?></span>
    </span>
  </a>

  <!-- Navigasi -->
  <nav class="app-scroll flex-1 overflow-y-auto px-3.5 py-4">
    <?php foreach (($navGroups ?? []) as $group): ?>
      <?php if (! empty($group['label'])): ?>
        <div class="sidebar-label"><?= esc($group['label']) ?></div>
      <?php endif; ?>
      <ul class="space-y-1">
        <?php foreach (($group['items'] ?? []) as $item): ?>
          <li>
            <?php if (! empty($item['children'])): ?>
              <details <?= ! empty($item['active']) ? 'open' : '' ?>>
                <summary class="sidebar-link <?= ! empty($item['active']) ? 'is-active' : '' ?> cursor-pointer select-none">
                  <i class="fa-solid <?= esc($item['icon'] ?? 'fa-circle') ?> w-[18px] text-center text-[13px]"></i>
                  <span><?= esc($item['label']) ?></span>
                  <i class="fa-solid fa-chevron-down sidebar-chevron"></i>
                </summary>
                <ul class="mb-1 ml-[30px] mt-1 space-y-0.5 border-l border-white/10 pl-3">
                  <?php foreach ($item['children'] as $child): ?>
                    <li>
                      <a href="<?= esc($child['url']) ?>"
                        class="flex items-center gap-2 rounded-lg px-2.5 py-2 text-[12px] font-medium transition <?= ! empty($child['active']) ? 'bg-brand-500/15 text-white' : 'text-slate-400 hover:bg-white/5 hover:text-white' ?>">
                        <?php if (! empty($child['active'])): ?>
                          <span class="h-1.5 w-1.5 rounded-full bg-brand-400"></span>
                        <?php else: ?>
                          <span class="h-1 w-1 rounded-full bg-slate-600"></span>
                        <?php endif; ?>
                        <?= esc($child['label']) ?>
                      </a>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </details>
            <?php else: ?>
              <a href="<?= esc($item['url'] ?? '#') ?>"
                class="sidebar-link <?= ! empty($item['active']) ? 'is-active' : '' ?>">
                <i class="fa-solid <?= esc($item['icon'] ?? 'fa-circle') ?> w-[18px] text-center text-[13px]"></i>
                <span><?= esc($item['label']) ?></span>
              </a>
            <?php endif; ?>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endforeach; ?>
  </nav>

  <!-- Profil + logout -->
  <div class="shrink-0 border-t border-white/10 p-3.5">
    <div class="flex items-center gap-3 rounded-2xl bg-white/5 p-2.5">
      <a href="<?= esc($profileUrl ?? base_url('/')) ?>" class="flex min-w-0 flex-1 items-center gap-3 rounded-xl transition hover:opacity-90" title="Buka profil saya">
        <img src="<?= esc($avatar) ?>" alt="Foto profil" class="h-9 w-9 shrink-0 rounded-xl object-cover ring-2 ring-white/15">
        <div class="min-w-0 flex-1">
          <div class="truncate text-[12.5px] font-bold text-white"><?= esc($namaUser) ?></div>
          <div class="truncate text-[10.5px] text-slate-400"><?= esc($roleUser) ?></div>
        </div>
      </a>
      <a href="<?= base_url('logout') ?>" title="Keluar"
        class="grid h-8 w-8 shrink-0 place-items-center rounded-lg text-slate-400 transition hover:bg-rose-500/15 hover:text-rose-400">
        <i class="fa-solid fa-arrow-right-from-bracket text-[11px]"></i>
      </a>
    </div>
  </div>
</aside>
