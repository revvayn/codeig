<?= $this->extend('admin/layout.php') ?>
<?= $this->section('content') ?>

<div class="app-page-head">
  <div>
    <h2 class="app-title">Detail Lokasi Presensi</h2>
    <p class="app-subtitle">Informasi pengaturan GPS dan jam presensi lokasi.</p>
  </div>
  <div class="flex flex-wrap items-center gap-2">
    <a href="<?= base_url('admin/lokasi_presensi') ?>" class="app-btn-outline"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
    <a href="<?= base_url('admin/lokasi_presensi/edit/' . $lokasi_presensi['id']) ?>" class="app-btn-primary"><i class="fa-solid fa-pen"></i> Edit</a>
  </div>
</div>

<div class="grid grid-cols-1 gap-[26px] lg:grid-cols-8">
  <div class="lg:col-span-5">
    <div class="app-card overflow-hidden">
      <div class="app-card-header">
        <div class="flex items-center gap-2.5">
          <span class="grid h-8 w-8 place-items-center rounded-lg bg-brand-50 text-brand-600"><i class="fa-solid fa-location-dot text-[11px]"></i></span>
          <h3 class="text-[14px] font-bold text-slate-900"><?= esc($lokasi_presensi['nama_lokasi']) ?></h3>
        </div>
        <span class="inline-flex rounded-md bg-slate-100 px-2 py-0.5 text-[11px] font-semibold text-slate-600 ring-1 ring-inset ring-slate-200"><?= esc($lokasi_presensi['tipe_lokasi']) ?></span>
      </div>
      <div class="p-6">
        <div class="grid grid-cols-1 gap-x-6 gap-y-5 sm:grid-cols-2">
          <div class="sm:col-span-2">
            <div class="app-label">Alamat</div>
            <div class="text-[13px] font-semibold text-slate-800"><?= esc($lokasi_presensi['alamat_lokasi']) ?></div>
          </div>
          <div>
            <div class="app-label">Radius</div>
            <div class="text-[13px] font-semibold text-slate-800"><?= (int) $lokasi_presensi['radius'] ?> meter</div>
          </div>
          <div>
            <div class="app-label">Zona Waktu</div>
            <div class="text-[13px] font-semibold text-slate-800"><?= esc($lokasi_presensi['zona_waktu']) ?></div>
          </div>
          <div>
            <div class="app-label">Jam Masuk</div>
            <div class="text-[13px] font-semibold text-slate-800"><?= $lokasi_presensi['jam_masuk'] ? esc(substr($lokasi_presensi['jam_masuk'], 0, 5)) : '-' ?></div>
          </div>
          <div>
            <div class="app-label">Jam Pulang</div>
            <div class="text-[13px] font-semibold text-slate-800"><?= $lokasi_presensi['jam_pulang'] ? esc(substr($lokasi_presensi['jam_pulang'], 0, 5)) : '-' ?></div>
          </div>
          <div>
            <div class="app-label">Latitude</div>
            <div class="font-mono text-[12px] font-semibold text-slate-700"><?= esc($lokasi_presensi['latitude']) ?></div>
          </div>
          <div>
            <div class="app-label">Longitude</div>
            <div class="font-mono text-[12px] font-semibold text-slate-700"><?= esc($lokasi_presensi['longitude']) ?></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="lg:col-span-3">
    <div class="app-card h-full overflow-hidden p-4">
      <div id="map" class="h-[300px] w-full overflow-hidden rounded-xl border border-slate-200 lg:h-full lg:min-h-[300px]"></div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
(function() {
  var lat = parseFloat('<?= esc($lokasi_presensi['latitude']) ?>') || -7.101301356164437;
  var lng = parseFloat('<?= esc($lokasi_presensi['longitude']) ?>') || 109.9167435556062;
  var map = L.map('map').setView([lat, lng], 17);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; OpenStreetMap contributors' }).addTo(map);
  L.marker([lat, lng]).addTo(map);
  setTimeout(function(){ map.invalidateSize(); }, 200);
})();
</script>
<?= $this->endSection() ?>
