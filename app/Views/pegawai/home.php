<?= $this->extend('pegawai/layout.php') ?>
<?= $this->section('content') ?>
<?php
$sudahMasuk  = ! empty($presensi_hari_ini);
$sudahPulang = $sudahMasuk && ! empty($presensi_hari_ini['jam_keluar']);
$terlambat   = false;

if ($sudahMasuk && $lokasi_presensi && ! empty($presensi_hari_ini['jam_masuk'])) {
    $terlambat = $presensi_hari_ini['jam_masuk'] > $lokasi_presensi['jam_masuk'];
}

$fotoPegawai = $pegawai['foto'] ?? session()->get('foto_pegawai');
$fotoUrl     = foto_profil_url($fotoPegawai);

$lokasiLat    = isset($lokasi_presensi['latitude']) ? (float) $lokasi_presensi['latitude'] : 0;
$lokasiLng    = isset($lokasi_presensi['longitude']) ? (float) $lokasi_presensi['longitude'] : 0;
$lokasiRadius = isset($lokasi_presensi['radius']) ? (int) $lokasi_presensi['radius'] : 0;
$punyaLokasi  = $lokasiLat !== 0.0 && $lokasiLng !== 0.0 && $lokasiRadius > 0;
?>

<div class="app-page-head">
  <div>
    <h2 class="app-title">Halo, <?= esc($pegawai['nama'] ?? session()->get('nama_pegawai')) ?> 👋</h2>
    <p class="app-subtitle"><?= esc($tanggal_hari_ini) ?> &middot; <?= esc($pegawai['jabatan'] ?? '-') ?></p>
  </div>
  <span class="inline-flex items-center gap-2 self-start rounded-full border border-brand-100 bg-brand-50 px-3.5 py-2 text-[11.5px] font-bold text-brand-700 sm:self-auto">
    <i class="fa-solid fa-location-dot"></i>
    <?= esc($lokasi_presensi['nama_lokasi'] ?? 'Lokasi belum diatur') ?>
  </span>
</div>

<div class="mb-[26px] grid grid-cols-1 gap-[26px] lg:grid-cols-8">
  <!-- Jam server -->
  <div class="lg:col-span-5">
    <div class="app-card relative h-full overflow-hidden p-6">
      <div class="pointer-events-none absolute -right-16 -top-16 h-48 w-48 rounded-full bg-brand-500/[0.06]"></div>
      <div class="flex items-start justify-between gap-4">
        <div>
          <div class="text-[10.5px] font-bold uppercase tracking-[0.12em] text-slate-400">Waktu Server</div>
          <div class="mt-3 flex items-baseline gap-1 text-[42px] font-extrabold leading-none tracking-tight text-slate-900 tabular-nums">
            <span id="jam">--</span>
            <span class="text-slate-300">:</span>
            <span id="menit">--</span>
            <span class="text-slate-300">:</span>
            <span id="detik">--</span>
          </div>
        </div>
        <span class="rounded-full bg-brand-50 px-3 py-1.5 text-[10.5px] font-bold text-brand-700"><?= esc($lokasi_presensi['zona_waktu'] ?? 'WIB') ?></span>
      </div>

      <div class="mt-6 rounded-2xl border border-slate-100 bg-slate-50/70 p-4">
        <div class="flex flex-wrap items-center justify-between gap-4">
          <div>
            <div class="text-[10.5px] font-bold uppercase tracking-[0.12em] text-slate-400">Status Hari Ini</div>
            <div class="mt-2 flex flex-wrap gap-2">
              <?php if ($sudahPulang): ?>
                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-[11px] font-bold text-emerald-700 ring-1 ring-inset ring-emerald-600/20"><span class="h-1.5 w-1.5 rounded-full bg-current"></span>Presensi Lengkap</span>
              <?php elseif ($sudahMasuk): ?>
                <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-3 py-1 text-[11px] font-bold text-amber-700 ring-1 ring-inset ring-amber-600/20"><span class="h-1.5 w-1.5 rounded-full bg-current"></span>Sudah Masuk, Belum Pulang</span>
                <?php if ($terlambat): ?>
                  <span class="inline-flex items-center gap-1.5 rounded-full bg-rose-50 px-3 py-1 text-[11px] font-bold text-rose-700 ring-1 ring-inset ring-rose-600/20"><span class="h-1.5 w-1.5 rounded-full bg-current"></span>Terlambat</span>
                <?php endif; ?>
              <?php else: ?>
                <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1 text-[11px] font-bold text-slate-600 ring-1 ring-inset ring-slate-500/20"><span class="h-1.5 w-1.5 rounded-full bg-current"></span>Belum Presensi</span>
              <?php endif; ?>
            </div>
          </div>
          <div class="flex gap-6">
            <div>
              <div class="text-[10.5px] font-medium text-slate-400">Masuk</div>
              <div class="mt-0.5 text-[15px] font-bold text-slate-800"><?= $sudahMasuk && $presensi_hari_ini['jam_masuk'] ? substr($presensi_hari_ini['jam_masuk'], 0, 5) : '--:--' ?></div>
            </div>
            <div>
              <div class="text-[10.5px] font-medium text-slate-400">Pulang</div>
              <div class="mt-0.5 text-[15px] font-bold text-slate-800"><?= $sudahPulang ? substr($presensi_hari_ini['jam_keluar'], 0, 5) : '--:--' ?></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Statistik -->
  <div class="grid grid-cols-1 gap-[26px] sm:grid-cols-2 lg:col-span-3 lg:grid-cols-1">
    <div class="grid grid-cols-2 gap-[26px] lg:col-span-1">
      <div class="app-card flex items-center gap-3 p-5">
        <div class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-emerald-50 text-emerald-600">
          <i class="fa-solid fa-calendar-check text-sm"></i>
        </div>
        <div>
          <div class="text-[26px] font-extrabold leading-none text-slate-900"><?= (int) $total_hadir ?></div>
          <div class="mt-1 text-[10.5px] font-semibold text-slate-400">Hadir Bulan Ini</div>
        </div>
      </div>
      <div class="app-card flex items-center gap-3 p-5">
        <div class="grid h-11 w-11 shrink-0 place-items-center rounded-xl bg-sky-50 text-sky-600">
          <i class="fa-solid fa-file-lines text-sm"></i>
        </div>
        <div>
          <div class="text-[26px] font-extrabold leading-none text-slate-900"><?= (int) $total_izin ?></div>
          <div class="mt-1 text-[10.5px] font-semibold text-slate-400">Izin Disetujui</div>
        </div>
      </div>
    </div>

    <div class="app-card p-5 lg:col-span-1">
      <div class="mb-3 flex items-center justify-between">
        <span class="text-[10.5px] font-bold uppercase tracking-[0.12em] text-slate-400">Ringkasan</span>
        <a href="<?= base_url('pegawai/rekap') ?>" class="text-[11px] font-bold text-brand-600 hover:text-brand-700">Lihat rekap</a>
      </div>
      <div class="space-y-2 text-[12.5px]">
        <div class="flex items-center justify-between">
          <span class="text-slate-500">Jam masuk kantor</span>
          <span class="font-bold text-slate-800"><?= $lokasi_presensi ? substr($lokasi_presensi['jam_masuk'], 0, 5) : '-' ?></span>
        </div>
        <div class="flex items-center justify-between">
          <span class="text-slate-500">Jam pulang kantor</span>
          <span class="font-bold text-slate-800"><?= $lokasi_presensi ? substr($lokasi_presensi['jam_pulang'], 0, 5) : '-' ?></span>
        </div>
        <div class="flex items-center justify-between">
          <span class="text-slate-500">Radius lokasi</span>
          <span class="font-bold text-slate-800"><?= $lokasi_presensi ? (int) $lokasi_presensi['radius'] . ' m' : '-' ?></span>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Foto pegawai + lokasi GPS -->
<div class="mb-[26px] grid grid-cols-1 gap-[26px] lg:grid-cols-12">
  <!-- 1. Foto -->
  <div class="lg:col-span-4">
    <div class="app-card flex h-full flex-col overflow-hidden">
      <div class="app-card-header">
        <div class="flex items-center gap-2.5">
          <span class="grid h-6 w-6 shrink-0 place-items-center rounded-full bg-brand-600 text-[10.5px] font-extrabold text-white">1</span>
          <h3 class="text-[14px] font-bold text-slate-900">Foto Pegawai</h3>
        </div>
        <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-[10px] font-bold text-emerald-700 ring-1 ring-inset ring-emerald-600/15">
          <i class="fa-solid fa-circle-check mr-1"></i> Terverifikasi
        </span>
      </div>
      <div class="flex flex-1 flex-col p-5">
        <div class="relative mx-auto w-full max-w-[260px] overflow-hidden rounded-2xl bg-slate-100 ring-1 ring-slate-200">
          <img src="<?= $fotoUrl ?>" alt="Foto <?= esc($pegawai['nama'] ?? 'pegawai') ?>" class="aspect-[4/5] w-full object-cover">
          <span class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-slate-950/70 to-transparent px-3 pb-2.5 pt-8 text-[10px] font-semibold text-white">
            Foto dasar profil
          </span>
        </div>
        <div class="mt-4 text-center">
          <div class="text-[15px] font-bold text-slate-900"><?= esc($pegawai['nama'] ?? session()->get('nama_pegawai')) ?></div>
          <div class="mt-0.5 text-[11.5px] text-slate-400">
            <?= esc($pegawai['jabatan'] ?? '-') ?>
            <?php if (! empty($pegawai['nip'])): ?> &middot; NIP <?= esc($pegawai['nip']) ?><?php endif; ?>
          </div>
        </div>
        <p class="mt-auto pt-4 text-center text-[11px] leading-relaxed text-slate-400">
          Foto presensi memakai foto profil kepegawaian, jadi tidak perlu unggah ulang saat presensi.
        </p>
      </div>
    </div>
  </div>

  <!-- 2. Lokasi & radius -->
  <div class="lg:col-span-8">
    <div class="app-card flex h-full flex-col overflow-hidden">
      <div class="app-card-header">
        <div class="flex items-center gap-2.5">
          <span class="grid h-6 w-6 shrink-0 place-items-center rounded-full bg-brand-600 text-[10.5px] font-extrabold text-white">2</span>
          <div>
            <h3 class="text-[14px] font-bold text-slate-900">Lokasi &amp; Radius Presensi</h3>
            <p class="mt-0.5 text-[11px] text-slate-400">
              <?= esc($lokasi_presensi['nama_lokasi'] ?? 'Lokasi belum diatur') ?>
              <?php if ($punyaLokasi): ?> &middot; radius <?= $lokasiRadius ?> m<?php endif; ?>
            </p>
          </div>
        </div>
        <?php if ($punyaLokasi): ?>
          <button type="button" id="perbaruiLokasi" class="app-btn-outline app-btn-sm">
            <i class="fa-solid fa-crosshairs"></i> Perbarui
          </button>
        <?php endif; ?>
      </div>

      <?php if ($punyaLokasi): ?>
        <div class="flex flex-1 flex-col px-4 pt-4">
          <div id="petaPresensi" class="min-h-[300px] w-full flex-1 overflow-hidden rounded-xl border border-slate-200 bg-slate-100"></div>
        </div>
        <div class="mt-auto grid grid-cols-3 divide-x divide-slate-100 border-t border-slate-100">
          <div class="px-4 py-3.5">
            <div class="text-[10px] font-bold uppercase tracking-[0.08em] text-slate-400">Jarak Anda</div>
            <div id="jarakAnda" class="mt-1 text-[15px] font-extrabold tabular-nums text-slate-800">--</div>
          </div>
          <div class="px-4 py-3.5">
            <div class="text-[10px] font-bold uppercase tracking-[0.08em] text-slate-400">Radius</div>
            <div class="mt-1 text-[15px] font-extrabold tabular-nums text-slate-800"><?= $lokasiRadius ?> m</div>
          </div>
          <div class="px-4 py-3.5">
            <div class="text-[10px] font-bold uppercase tracking-[0.08em] text-slate-400">Status</div>
            <div id="statusRadius" class="mt-1 inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 text-[10.5px] font-bold text-slate-500">
              <span class="h-1.5 w-1.5 rounded-full bg-current"></span> Mendeteksi…
            </div>
          </div>
        </div>
        <div class="flex flex-wrap items-center gap-x-5 gap-y-1.5 border-t border-slate-100 bg-slate-50/60 px-4 py-2.5 text-[10.5px] font-medium text-slate-500">
          <span class="inline-flex items-center gap-1.5"><span class="h-2.5 w-2.5 rounded-full bg-brand-600 ring-2 ring-white"></span> Titik lokasi presensi</span>
          <span class="inline-flex items-center gap-1.5"><span class="h-2.5 w-2.5 rounded-full bg-sky-500 ring-2 ring-white"></span> Posisi Anda saat ini</span>
          <span class="inline-flex items-center gap-1.5"><span class="h-2.5 w-2.5 rounded-full border border-brand-500 bg-brand-500/20"></span> Area radius</span>
        </div>
      <?php else: ?>
        <div class="app-empty m-4">
          <i class="fa-regular fa-map"></i>
          <div>Lokasi presensi Anda belum diatur. Hubungi admin perusahaan.</div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<div class="mb-[26px] grid grid-cols-1 gap-[26px] lg:grid-cols-2">
  <!-- Presensi masuk -->
  <div class="app-card flex flex-col overflow-hidden">
    <div class="app-card-header">
      <div class="flex items-center gap-2.5">
        <span class="grid h-8 w-8 place-items-center rounded-lg bg-emerald-50 text-emerald-600"><i class="fa-solid fa-right-to-bracket text-[11px]"></i></span>
        <h3 class="text-[14px] font-bold text-slate-900">Presensi Masuk</h3>
      </div>
      <span class="text-[10.5px] font-semibold text-slate-400">Foto dasar profil</span>
    </div>
    <div class="flex flex-1 flex-col p-5">
      <?php if ($sudahMasuk): ?>
        <div class="flex items-start gap-2.5 rounded-xl bg-emerald-50 px-4 py-3.5 text-[12.5px] text-emerald-700 ring-1 ring-inset ring-emerald-600/10">
          <i class="fa-solid fa-circle-check mt-0.5"></i>
          <span>Anda sudah presensi masuk pukul <strong><?= substr($presensi_hari_ini['jam_masuk'], 0, 5) ?></strong>.</span>
        </div>
      <?php else: ?>
        <form method="POST" action="<?= base_url('pegawai/presensi_masuk') ?>" class="form-presensi flex flex-1 flex-col" data-nama="masuk">
          <?= csrf_field() ?>
          <input type="hidden" name="latitude" class="input-latitude">
          <input type="hidden" name="longitude" class="input-longitude">
          <div class="space-y-2.5 text-[12px] text-slate-500">
            <div class="flex items-center gap-2.5"><i class="fa-solid fa-camera w-4 text-center text-slate-400"></i> Foto presensi menggunakan foto dasar profil Anda.</div>
            <div class="flex items-center gap-2.5"><i class="fa-solid fa-location-crosshairs w-4 text-center text-slate-400"></i> Lokasi GPS akan diperiksa otomatis saat tombol ditekan.</div>
          </div>
          <button type="submit" class="app-btn mt-5 h-12 w-full bg-emerald-600 text-[13.5px] text-white shadow-lg shadow-emerald-600/20 hover:bg-emerald-700 focus:ring-emerald-500/20">
            <i class="fa-solid fa-fingerprint"></i> Presensi Masuk Sekarang
          </button>
        </form>
      <?php endif; ?>
    </div>
  </div>

  <!-- Presensi pulang -->
  <div class="app-card flex flex-col overflow-hidden">
    <div class="app-card-header">
      <div class="flex items-center gap-2.5">
        <span class="grid h-8 w-8 place-items-center rounded-lg bg-rose-50 text-rose-600"><i class="fa-solid fa-right-from-bracket text-[11px]"></i></span>
        <h3 class="text-[14px] font-bold text-slate-900">Presensi Pulang</h3>
      </div>
      <span class="text-[10.5px] font-semibold text-slate-400">Foto dasar profil</span>
    </div>
    <div class="flex flex-1 flex-col p-5">
      <?php if (! $sudahMasuk): ?>
        <div class="flex items-start gap-2.5 rounded-xl bg-slate-100 px-4 py-3.5 text-[12.5px] text-slate-600">
          <i class="fa-solid fa-circle-info mt-0.5"></i>
          <span>Lakukan presensi masuk terlebih dahulu.</span>
        </div>
      <?php elseif ($sudahPulang): ?>
        <div class="flex items-start gap-2.5 rounded-xl bg-emerald-50 px-4 py-3.5 text-[12.5px] text-emerald-700 ring-1 ring-inset ring-emerald-600/10">
          <i class="fa-solid fa-circle-check mt-0.5"></i>
          <span>Anda sudah presensi pulang pukul <strong><?= substr($presensi_hari_ini['jam_keluar'], 0, 5) ?></strong>.</span>
        </div>
      <?php else: ?>
        <form method="POST" action="<?= base_url('pegawai/presensi_pulang') ?>" class="form-presensi flex flex-1 flex-col" data-nama="pulang">
          <?= csrf_field() ?>
          <input type="hidden" name="latitude" class="input-latitude">
          <input type="hidden" name="longitude" class="input-longitude">
          <div class="space-y-2.5 text-[12px] text-slate-500">
            <div class="flex items-center gap-2.5"><i class="fa-solid fa-camera w-4 text-center text-slate-400"></i> Foto presensi menggunakan foto dasar profil Anda.</div>
            <div class="flex items-center gap-2.5"><i class="fa-solid fa-location-crosshairs w-4 text-center text-slate-400"></i> Pastikan Anda berada dalam radius lokasi presensi.</div>
          </div>
          <button type="submit" class="app-btn mt-5 h-12 w-full bg-rose-600 text-[13.5px] text-white shadow-lg shadow-rose-600/20 hover:bg-rose-700 focus:ring-rose-500/20">
            <i class="fa-solid fa-door-open"></i> Presensi Pulang Sekarang
          </button>
        </form>
      <?php endif; ?>
    </div>
  </div>
</div>

<div class="app-card overflow-hidden">
  <div class="app-card-header">
    <div>
      <h3 class="text-[15px] font-bold text-slate-900">Riwayat Presensi Terakhir</h3>
      <p class="mt-0.5 text-[11.5px] text-slate-400">7 data terakhir.</p>
    </div>
    <a href="<?= base_url('pegawai/rekap') ?>" class="app-btn-outline app-btn-sm">Lihat semua</a>
  </div>
  <div class="p-3 sm:p-4">
    <?php if (empty($riwayat)): ?>
      <div class="app-empty">
        <i class="fa-regular fa-calendar"></i>
        <div>Belum ada riwayat presensi.</div>
      </div>
    <?php else: ?>
      <div class="overflow-x-auto">
        <table class="app-table">
          <thead>
            <tr>
              <th>Tanggal</th>
              <th>Jam Masuk</th>
              <th>Jam Pulang</th>
              <th>Foto</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($riwayat as $row): ?>
              <tr>
                <td class="font-semibold text-slate-800"><?= tanggal_indo($row['tanggal_masuk'], true) ?></td>
                <td><?= $row['jam_masuk'] ? substr($row['jam_masuk'], 0, 5) : '-' ?></td>
                <td><?= $row['jam_keluar'] ? substr($row['jam_keluar'], 0, 5) : '<span class="text-slate-400">Belum</span>' ?></td>
                <td>
                  <?php $fotoRiwayat = foto_presensi_url($row['foto_masuk'] ?? ''); ?>
                  <?php if ($fotoRiwayat !== ''): ?>
                    <img src="<?= $fotoRiwayat ?>" class="h-8 w-8 rounded-lg object-cover ring-2 ring-white shadow-sm" alt="Foto">
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

<?= $this->section('styles') ?>
<?php if ($punyaLokasi): ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
  .titik-anda {
    display: block;
    width: 18px;
    height: 18px;
    border-radius: 9999px;
    background: #0ea5e9;
    border: 3px solid #fff;
    box-shadow: 0 0 0 4px rgba(14, 165, 233, .28);
    animation: denyutAnda 2s ease-out infinite;
  }
  @keyframes denyutAnda {
    0%   { box-shadow: 0 0 0 4px rgba(14, 165, 233, .30); }
    70%  { box-shadow: 0 0 0 14px rgba(14, 165, 233, 0); }
    100% { box-shadow: 0 0 0 4px rgba(14, 165, 233, 0); }
  }
  #petaPresensi .leaflet-container { font-family: inherit; }
</style>
<?php endif; ?>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<?php if ($punyaLokasi): ?>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
  (function () {
    var el = document.getElementById('petaPresensi');
    if (!el || typeof L === 'undefined') return;

    var kantorLat = <?= json_encode($lokasiLat) ?>;
    var kantorLng = <?= json_encode($lokasiLng) ?>;
    var radius    = <?= json_encode($lokasiRadius) ?>;
    var namaLokasi = '<?= esc($lokasi_presensi['nama_lokasi'] ?? '', 'js') ?>';

    var jarakEl  = document.getElementById('jarakAnda');
    var statusEl = document.getElementById('statusRadius');
    var tombol   = document.getElementById('perbaruiLokasi');

    var zoom = radius <= 50 ? 18 : radius <= 150 ? 17 : radius <= 400 ? 16 : radius <= 1000 ? 15 : 14;
    var peta = L.map(el, { scrollWheelZoom: false }).setView([kantorLat, kantorLng], zoom);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '&copy; OpenStreetMap'
    }).addTo(peta);

    // Area radius presensi
    L.circle([kantorLat, kantorLng], {
      radius: radius,
      color: '#4f46e5', weight: 2, opacity: .85,
      fillColor: '#4f46e5', fillOpacity: .12
    }).addTo(peta);

    // Titik lokasi presensi
    var ikonKantor = L.divIcon({
      className: '',
      html: '<span style="display:grid;place-items:center;width:34px;height:34px;border-radius:9999px;background:#4f46e5;color:#fff;border:3px solid #fff;box-shadow:0 8px 18px -6px rgba(79,70,229,.85)"><i class="fa-solid fa-building" style="font-size:12px"></i></span>',
      iconSize: [34, 34], iconAnchor: [17, 17]
    });
    L.marker([kantorLat, kantorLng], { icon: ikonKantor, title: namaLokasi })
      .addTo(peta)
      .bindTooltip(namaLokasi, { direction: 'top', offset: [0, -16] });

    // Posisi pengguna
    var ikonAnda = L.divIcon({
      className: '',
      html: '<span class="titik-anda"></span>',
      iconSize: [18, 18], iconAnchor: [9, 9]
    });
    var penandaAnda     = null;
    var lingkaranAkurasi = null;

    function jarakMeter(lat1, lng1, lat2, lng2) {
      var R = 6371000;
      var dLat = (lat2 - lat1) * Math.PI / 180;
      var dLng = (lng2 - lng1) * Math.PI / 180;
      var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
              Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
              Math.sin(dLng / 2) * Math.sin(dLng / 2);
      return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    }

    function setStatus(kelas, teks) {
      statusEl.className = 'mt-1 inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-[10.5px] font-bold ring-1 ring-inset ' + kelas;
      statusEl.innerHTML = '<span class="h-1.5 w-1.5 rounded-full bg-current"></span> ' + teks;
    }

    function resetTombol() {
      if (!tombol) return;
      tombol.disabled = false;
      tombol.innerHTML = '<i class="fa-solid fa-crosshairs"></i> Perbarui';
    }

    function gagal(pesan, notif) {
      jarakEl.textContent = '--';
      setStatus('bg-amber-50 text-amber-700 ring-amber-600/20', 'GPS tidak aktif');
      if (notif) Swal.fire('Lokasi tidak terdeteksi', pesan, 'error');
      resetTombol();
    }

    function deteksi(notif) {
      if (!navigator.geolocation) {
        gagal('Browser Anda tidak mendukung geolokasi. Gunakan browser terbaru.', notif);
        return;
      }
      if (tombol) {
        tombol.disabled = true;
        tombol.innerHTML = '<span class="mr-1.5 inline-block h-3 w-3 animate-spin rounded-full border-2 border-slate-300 border-t-brand-600 align-[-2px]"></span> Mencari…';
      }

      navigator.geolocation.getCurrentPosition(function (pos) {
        var uLat = pos.coords.latitude;
        var uLng = pos.coords.longitude;
        var akurasi = pos.coords.accuracy || 0;
        var jarak = jarakMeter(uLat, uLng, kantorLat, kantorLng);

        if (!penandaAnda) {
          penandaAnda = L.marker([uLat, uLng], { icon: ikonAnda, zIndexOffset: 1000, title: 'Posisi Anda' }).addTo(peta);
        } else {
          penandaAnda.setLatLng([uLat, uLng]);
        }

        if (!lingkaranAkurasi) {
          lingkaranAkurasi = L.circle([uLat, uLng], {
            radius: akurasi, color: '#0ea5e9', weight: 1, opacity: .5,
            fillColor: '#0ea5e9', fillOpacity: .08
          }).addTo(peta);
        } else {
          lingkaranAkurasi.setLatLng([uLat, uLng]).setRadius(akurasi);
        }

        jarakEl.textContent = Math.round(jarak) + ' m';
        if (jarak <= radius) {
          setStatus('bg-emerald-50 text-emerald-700 ring-emerald-600/20', 'Di dalam radius');
        } else {
          setStatus('bg-rose-50 text-rose-700 ring-rose-600/20', 'Di luar radius');
        }

        peta.fitBounds([[kantorLat, kantorLng], [uLat, uLng]], { padding: [40, 40], maxZoom: 18 });
        resetTombol();
      }, function (err) {
        var pesan = 'Aktifkan GPS dan izinkan akses lokasi pada browser untuk melakukan presensi.';
        if (err.code === err.PERMISSION_DENIED) {
          pesan = 'Akses lokasi ditolak. Izinkan akses lokasi pada pengaturan browser.';
        }
        gagal(pesan, notif);
      }, { enableHighAccuracy: true, timeout: 15000, maximumAge: 0 });
    }

    tombol && tombol.addEventListener('click', function () { deteksi(true); });

    setTimeout(function () {
      peta.invalidateSize();
      deteksi(false);
    }, 300);
  })();
</script>
<?php endif; ?>
<script>
  (function() {
    var jam = <?= (int) date('H') ?>;
    var menit = <?= (int) date('i') ?>;
    var detik = <?= (int) date('s') ?>;

    function dua(n) { return n < 10 ? '0' + n : n; }
    function render() {
      document.getElementById('jam').textContent = dua(jam);
      document.getElementById('menit').textContent = dua(menit);
      document.getElementById('detik').textContent = dua(detik);
    }
    setInterval(function() {
      detik++;
      if (detik >= 60) { detik = 0; menit++; }
      if (menit >= 60) { menit = 0; jam++; }
      if (jam >= 24) { jam = 0; }
      render();
    }, 1000);
    render();
  })();

  document.querySelectorAll('.form-presensi').forEach(function(form) {
    form.addEventListener('submit', function(event) {
      if (form.dataset.siap === '1') return;
      event.preventDefault();
      var tombol = form.querySelector('button[type="submit"]');
      var teksAsli = tombol.innerHTML;
      tombol.disabled = true;
      tombol.innerHTML = '<span class="mr-2 inline-block h-4 w-4 animate-spin rounded-full border-2 border-white/40 border-t-white"></span>Mendeteksi lokasi...';

      if (!navigator.geolocation) {
        Swal.fire('GPS tidak tersedia', 'Browser Anda tidak mendukung geolokasi. Gunakan browser terbaru.', 'error');
        tombol.disabled = false;
        tombol.innerHTML = teksAsli;
        return;
      }

      navigator.geolocation.getCurrentPosition(function(position) {
        form.querySelector('.input-latitude').value = position.coords.latitude;
        form.querySelector('.input-longitude').value = position.coords.longitude;
        form.dataset.siap = '1';
        form.submit();
      }, function(error) {
        var pesan = 'Aktifkan GPS dan izinkan akses lokasi pada browser untuk melakukan presensi.';
        if (error.code === error.PERMISSION_DENIED) {
          pesan = 'Akses lokasi ditolak. Izinkan akses lokasi pada pengaturan browser.';
        }
        Swal.fire('Lokasi tidak terdeteksi', pesan, 'error');
        tombol.disabled = false;
        tombol.innerHTML = teksAsli;
      }, { enableHighAccuracy: true, timeout: 15000, maximumAge: 0 });
    });
  });
</script>
<?= $this->endSection() ?>
