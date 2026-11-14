<?= $this->extend('admin/layout.php') ?>

<?= $this->section('content') ?>
<?php
$p = $perusahaan;

$jam = static function ($nilai): string {
    $nilai = trim((string) $nilai);

    return $nilai === '' || $nilai === '00:00:00' ? '-' : substr($nilai, 0, 5);
};

$punyaKoordinat = ! empty($p['latitude']) && ! empty($p['longitude']);
$koordinat      = number_format((float) $p['latitude'], 5, '.', '') . ', ' . number_format((float) $p['longitude'], 5, '.', '');
?>
<div class="app-page-head">
  <div>
    <h2 class="app-title">Data Perusahaan</h2>
    <p class="app-subtitle">Informasi perusahaan tempat Anda bertugas.</p>
  </div>
  <a href="<?= base_url('admin/perusahaan/edit/' . $p['id']) ?>" class="app-btn-primary">
    <i class="fa-solid fa-pen-to-square"></i> Edit Data
  </a>
</div>

<div class="grid grid-cols-1 gap-[26px] xl:grid-cols-8">

  <!-- Kolom kiri: identitas + jam operasional -->
  <div class="space-y-[26px] xl:col-span-3">

    <!-- Kartu identitas perusahaan -->
    <div class="app-card flex flex-col overflow-hidden">
      <div class="relative h-[104px] bg-gradient-to-br from-brand-500 via-brand-600 to-indigo-700">
        <span class="pointer-events-none absolute -right-6 -top-8 h-28 w-28 rounded-full bg-white/10"></span>
        <span class="pointer-events-none absolute -bottom-10 left-6 h-24 w-24 rounded-full bg-white/10"></span>
      </div>

      <div class="flex flex-col items-center px-5 pb-6">
        <div class="-mt-10 grid h-20 w-20 place-items-center rounded-2xl bg-white text-brand-600 shadow-lg ring-4 ring-white">
          <i class="fa-solid fa-building text-[26px]"></i>
        </div>

        <h3 class="mt-3 text-center text-[17px] font-extrabold leading-snug text-slate-900"><?= esc($p['nama_perusahaan']) ?></h3>
        <div class="mt-2"><?= badge_kehadiran($p['status']) ?></div>
        <p class="mt-1 text-[11px] font-medium uppercase tracking-[0.08em] text-slate-400">Perusahaan Anda</p>

        <div class="mt-5 grid w-full grid-cols-2 gap-2.5">
          <div class="rounded-xl border border-slate-100 bg-slate-50/70 px-3 py-3 text-center">
            <div class="text-[20px] font-extrabold leading-none text-slate-900"><?= (int) $jumlahPegawai ?></div>
            <div class="mt-1 text-[10px] font-bold uppercase tracking-[0.07em] text-slate-400">Pegawai</div>
          </div>
          <div class="rounded-xl border border-slate-100 bg-slate-50/70 px-3 py-3 text-center">
            <div class="text-[20px] font-extrabold leading-none text-slate-900"><?= (int) $jumlahLokasi ?></div>
            <div class="mt-1 text-[10px] font-bold uppercase tracking-[0.07em] text-slate-400">Lokasi</div>
          </div>
        </div>

        <?php if (! empty($p['zona_waktu'])): ?>
          <div class="mt-3 inline-flex items-center gap-2 rounded-full border border-slate-100 bg-white px-3 py-1.5 text-[11.5px] font-semibold text-slate-500">
            <i class="fa-regular fa-clock text-brand-500"></i> Zona waktu <?= esc($p['zona_waktu']) ?>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- Jam operasional -->
    <div class="app-card overflow-hidden">
      <div class="app-card-header">
        <div class="flex items-center gap-2.5">
          <span class="grid h-8 w-8 place-items-center rounded-lg bg-brand-50 text-brand-600"><i class="fa-regular fa-clock text-[11px]"></i></span>
          <div>
            <h3 class="text-[14px] font-bold text-slate-900">Jam Operasional</h3>
            <p class="mt-0.5 text-[11px] text-slate-400">Waktu kerja perusahaan</p>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-2 gap-4 p-5">
        <div>
          <div class="app-label">Jam Masuk</div>
          <div class="flex items-center gap-2.5 rounded-xl border border-slate-100 bg-slate-50/60 px-3 py-2.5">
            <span class="grid h-7 w-7 shrink-0 place-items-center rounded-lg bg-white text-emerald-600 ring-1 ring-slate-200/70"><i class="fa-solid fa-right-to-bracket text-[10.5px]"></i></span>
            <span class="text-[13px] font-semibold text-slate-700"><?= esc($jam($p['jam_masuk'] ?? '')) ?></span>
          </div>
        </div>

        <div>
          <div class="app-label">Jam Pulang</div>
          <div class="flex items-center gap-2.5 rounded-xl border border-slate-100 bg-slate-50/60 px-3 py-2.5">
            <span class="grid h-7 w-7 shrink-0 place-items-center rounded-lg bg-white text-rose-500 ring-1 ring-slate-200/70"><i class="fa-solid fa-right-from-bracket text-[10.5px]"></i></span>
            <span class="text-[13px] font-semibold text-slate-700"><?= esc($jam($p['jam_pulang'] ?? '')) ?></span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Kolom kanan: kontak + titik absensi -->
  <div class="space-y-[26px] xl:col-span-5">

    <!-- Informasi kontak -->
    <div class="app-card overflow-hidden">
      <div class="app-card-header">
        <div class="flex items-center gap-2.5">
          <span class="grid h-8 w-8 place-items-center rounded-lg bg-brand-50 text-brand-600"><i class="fa-solid fa-circle-info text-[11px]"></i></span>
          <div>
            <h3 class="text-[14px] font-bold text-slate-900">Informasi Perusahaan</h3>
            <p class="mt-0.5 text-[11px] text-slate-400">Data kontak perusahaan</p>
          </div>
        </div>
      </div>

      <div class="p-5 sm:p-6">
        <div class="grid grid-cols-1 gap-x-6 gap-y-5 sm:grid-cols-2">

          <div class="sm:col-span-2">
            <div class="app-label">Alamat</div>
            <div class="flex items-start gap-3 rounded-xl border border-slate-100 bg-slate-50/60 px-3.5 py-3">
              <span class="mt-0.5 grid h-7 w-7 shrink-0 place-items-center rounded-lg bg-white text-brand-600 ring-1 ring-slate-200/70"><i class="fa-solid fa-location-dot text-[11px]"></i></span>
              <p class="text-[13px] leading-relaxed text-slate-700"><?= esc($p['alamat'] ?: 'Belum diisi') ?></p>
            </div>
          </div>

          <div>
            <div class="app-label">Telepon</div>
            <div class="flex items-center gap-3 rounded-xl border border-slate-100 bg-slate-50/60 px-3.5 py-3">
              <span class="grid h-7 w-7 shrink-0 place-items-center rounded-lg bg-white text-brand-600 ring-1 ring-slate-200/70"><i class="fa-solid fa-phone text-[10.5px]"></i></span>
              <span class="text-[13px] font-medium text-slate-700"><?= esc($p['telepon'] ?: '-') ?></span>
            </div>
          </div>

          <div>
            <div class="app-label">Email</div>
            <div class="flex items-center gap-3 rounded-xl border border-slate-100 bg-slate-50/60 px-3.5 py-3">
              <span class="grid h-7 w-7 shrink-0 place-items-center rounded-lg bg-white text-brand-600 ring-1 ring-slate-200/70"><i class="fa-regular fa-envelope text-[10.5px]"></i></span>
              <span class="truncate text-[13px] font-medium text-slate-700" title="<?= esc($p['email'] ?: '-') ?>"><?= esc($p['email'] ?: '-') ?></span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Titik & radius absensi -->
    <div class="app-card overflow-hidden">
      <div class="app-card-header">
        <div class="flex items-center gap-2.5">
          <span class="grid h-8 w-8 place-items-center rounded-lg bg-brand-50 text-brand-600"><i class="fa-solid fa-bullseye text-[11px]"></i></span>
          <div>
            <h3 class="text-[14px] font-bold text-slate-900">Titik &amp; Radius Absensi</h3>
            <p class="mt-0.5 text-[11px] text-slate-400">Pusat koordinat perusahaan</p>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 gap-5 p-5 sm:grid-cols-2 sm:p-6">
        <div>
          <div class="app-label">Radius</div>
          <div class="flex items-center gap-3 rounded-xl border border-slate-100 bg-slate-50/60 px-3.5 py-3">
            <span class="grid h-7 w-7 shrink-0 place-items-center rounded-lg bg-white text-brand-600 ring-1 ring-slate-200/70"><i class="fa-solid fa-circle-dot text-[10.5px]"></i></span>
            <span class="text-[13px] font-semibold text-slate-700">
              <?= ! empty($p['radius']) ? (int) $p['radius'] . ' meter' : 'Belum diatur' ?>
            </span>
          </div>
        </div>

        <div>
          <div class="app-label">Koordinat</div>
          <div class="flex items-center gap-3 rounded-xl border border-slate-100 bg-slate-50/60 px-3.5 py-3">
            <span class="grid h-7 w-7 shrink-0 place-items-center rounded-lg bg-white text-brand-600 ring-1 ring-slate-200/70"><i class="fa-solid fa-map-location-dot text-[10.5px]"></i></span>
            <?php if ($punyaKoordinat): ?>
              <a href="https://www.google.com/maps?q=<?= esc($p['latitude'], 'url') ?>,<?= esc($p['longitude'], 'url') ?>"
                 target="_blank" rel="noopener" title="<?= esc($koordinat) ?>"
                 class="truncate text-[12.5px] font-semibold text-brand-600 hover:text-brand-700 hover:underline">
                <?= esc($koordinat) ?>
              </a>
            <?php else: ?>
              <span class="text-[13px] font-medium text-slate-400">Belum diatur</span>
            <?php endif; ?>
          </div>
        </div>

        <p class="sm:col-span-2 rounded-xl bg-brand-50/60 px-3.5 py-3 text-[11.5px] leading-relaxed text-brand-700/80 ring-1 ring-inset ring-brand-600/10">
          <i class="fa-solid fa-circle-info mr-1"></i>
          Titik absensi tiap plant diatur pada menu <span class="font-semibold">Lokasi Presensi</span>. Nilai di atas adalah pusat koordinat perusahaan.
        </p>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
