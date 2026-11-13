<?= $this->extend('admin/layout.php') ?>
<?= $this->section('content') ?>

<div class="app-page-head">
  <div>
    <h2 class="app-title">Edit Lokasi Presensi</h2>
    <p class="app-subtitle">Perbarui titik GPS, radius, dan jam presensi lokasi.</p>
  </div>
  <a href="<?= base_url('admin/lokasi_presensi') ?>" class="app-btn-outline"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
</div>

<div class="grid grid-cols-1 gap-[26px] lg:grid-cols-8">
  <div class="lg:col-span-5">
    <div class="app-card p-6">
      <form method="POST" action="<?= base_url('admin/lokasi_presensi/update/' . $lokasi_presensi['id']) ?>" class="space-y-5">
        <?= csrf_field() ?>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
          <div>
            <label class="app-label">Nama Lokasi <span class="text-rose-500">*</span></label>
            <input type="text" name="nama_lokasi" class="app-input <?= $validation->hasError('nama_lokasi') ? 'border-rose-300 focus:border-rose-500 focus:ring-rose-500/10' : '' ?>" value="<?= esc(old('nama_lokasi', $lokasi_presensi['nama_lokasi'])) ?>" required>
            <?php if ($validation->hasError('nama_lokasi')): ?><p class="app-error"><?= $validation->getError('nama_lokasi') ?></p><?php endif; ?>
          </div>
          <div>
            <label class="app-label">Tipe Lokasi <span class="text-rose-500">*</span></label>
            <input type="text" name="tipe_lokasi" class="app-input <?= $validation->hasError('tipe_lokasi') ? 'border-rose-300 focus:border-rose-500 focus:ring-rose-500/10' : '' ?>" value="<?= esc(old('tipe_lokasi', $lokasi_presensi['tipe_lokasi'])) ?>" required>
            <?php if ($validation->hasError('tipe_lokasi')): ?><p class="app-error"><?= $validation->getError('tipe_lokasi') ?></p><?php endif; ?>
          </div>
          <div class="sm:col-span-2">
            <label class="app-label">Alamat Lokasi <span class="text-rose-500">*</span></label>
            <textarea name="alamat_lokasi" class="app-textarea <?= $validation->hasError('alamat_lokasi') ? 'border-rose-300 focus:border-rose-500 focus:ring-rose-500/10' : '' ?>" rows="2" required><?= esc(old('alamat_lokasi', $lokasi_presensi['alamat_lokasi'])) ?></textarea>
            <?php if ($validation->hasError('alamat_lokasi')): ?><p class="app-error"><?= $validation->getError('alamat_lokasi') ?></p><?php endif; ?>
          </div>
        </div>

        <div>
          <label class="app-label">Pilih Lokasi di Peta</label>
          <div id="map" class="h-[280px] w-full overflow-hidden rounded-xl border border-slate-200"></div>
          <p class="app-help"><i class="fa-solid fa-hand-pointer mr-1 text-brand-500"></i> Klik pada peta untuk memindahkan titik GPS lokasi.</p>
        </div>
        <input type="hidden" name="latitude" id="latitude" value="<?= esc($lokasi_presensi['latitude']) ?>">
        <input type="hidden" name="longitude" id="longitude" value="<?= esc($lokasi_presensi['longitude']) ?>">

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
          <div>
            <label class="app-label">Latitude</label>
            <input type="text" id="lat_display" class="app-input bg-slate-50 text-slate-500" value="<?= esc($lokasi_presensi['latitude']) ?>" readonly>
          </div>
          <div>
            <label class="app-label">Longitude</label>
            <input type="text" id="lng_display" class="app-input bg-slate-50 text-slate-500" value="<?= esc($lokasi_presensi['longitude']) ?>" readonly>
          </div>
          <div>
            <label class="app-label">Radius (meter) <span class="text-rose-500">*</span></label>
            <input type="number" name="radius" class="app-input <?= $validation->hasError('radius') ? 'border-rose-300 focus:border-rose-500 focus:ring-rose-500/10' : '' ?>" value="<?= esc(old('radius', $lokasi_presensi['radius'])) ?>" min="1" required>
            <?php if ($validation->hasError('radius')): ?><p class="app-error"><?= $validation->getError('radius') ?></p><?php endif; ?>
          </div>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
          <div>
            <label class="app-label">Zona Waktu <span class="text-rose-500">*</span></label>
            <select name="zona_waktu" class="app-select <?= $validation->hasError('zona_waktu') ? 'border-rose-300 focus:border-rose-500 focus:ring-rose-500/10' : '' ?>" required>
              <option value="">Pilih Zona</option>
              <?php foreach (['WIB', 'WITA', 'WIT'] as $zona): ?>
                <option value="<?= $zona ?>" <?= old('zona_waktu', $lokasi_presensi['zona_waktu']) === $zona ? 'selected' : '' ?>><?= $zona ?></option>
              <?php endforeach; ?>
            </select>
            <?php if ($validation->hasError('zona_waktu')): ?><p class="app-error"><?= $validation->getError('zona_waktu') ?></p><?php endif; ?>
          </div>
          <div>
            <label class="app-label">Jam Masuk <span class="text-rose-500">*</span></label>
            <input type="time" name="jam_masuk" class="app-input <?= $validation->hasError('jam_masuk') ? 'border-rose-300 focus:border-rose-500 focus:ring-rose-500/10' : '' ?>" value="<?= esc(old('jam_masuk', $lokasi_presensi['jam_masuk'])) ?>" required>
            <?php if ($validation->hasError('jam_masuk')): ?><p class="app-error"><?= $validation->getError('jam_masuk') ?></p><?php endif; ?>
          </div>
          <div>
            <label class="app-label">Jam Pulang <span class="text-rose-500">*</span></label>
            <input type="time" name="jam_pulang" class="app-input <?= $validation->hasError('jam_pulang') ? 'border-rose-300 focus:border-rose-500 focus:ring-rose-500/10' : '' ?>" value="<?= esc(old('jam_pulang', $lokasi_presensi['jam_pulang'])) ?>" required>
            <?php if ($validation->hasError('jam_pulang')): ?><p class="app-error"><?= $validation->getError('jam_pulang') ?></p><?php endif; ?>
          </div>
        </div>

        <div class="flex items-center gap-2 pt-1">
          <button type="submit" class="app-btn-primary"><i class="fa-solid fa-floppy-disk"></i> Perbarui Lokasi</button>
          <a href="<?= base_url('admin/lokasi_presensi') ?>" class="app-btn-ghost">Batal</a>
        </div>
      </form>
    </div>
  </div>

  <div class="lg:col-span-3">
    <div class="app-card p-6">
      <h3 class="mb-4 flex items-center gap-2 text-[13px] font-bold text-slate-800">
        <span class="grid h-7 w-7 place-items-center rounded-lg bg-brand-50 text-brand-600"><i class="fa-solid fa-location-dot text-[10px]"></i></span>
        Ringkasan
      </h3>
      <dl class="space-y-2.5 text-[12.5px]">
        <div class="flex items-center justify-between gap-3 border-b border-slate-100 pb-2.5">
          <dt class="text-slate-400">Nama</dt>
          <dd class="text-right font-semibold text-slate-700"><?= esc($lokasi_presensi['nama_lokasi']) ?></dd>
        </div>
        <div class="flex items-center justify-between gap-3 border-b border-slate-100 pb-2.5">
          <dt class="text-slate-400">Radius</dt>
          <dd class="font-semibold text-slate-700"><?= (int) $lokasi_presensi['radius'] ?> m</dd>
        </div>
        <div class="flex items-center justify-between gap-3 border-b border-slate-100 pb-2.5">
          <dt class="text-slate-400">Zona waktu</dt>
          <dd class="font-semibold text-slate-700"><?= esc($lokasi_presensi['zona_waktu']) ?></dd>
        </div>
        <div class="flex items-center justify-between gap-3">
          <dt class="text-slate-400">Jam kerja</dt>
          <dd class="font-semibold text-slate-700"><?= substr($lokasi_presensi['jam_masuk'], 0, 5) ?> – <?= substr($lokasi_presensi['jam_pulang'], 0, 5) ?></dd>
        </div>
      </dl>
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
  var latInput = document.getElementById('latitude');
  var lngInput = document.getElementById('longitude');
  var latDisp = document.getElementById('lat_display');
  var lngDisp = document.getElementById('lng_display');
  var lat = parseFloat(latInput.value) || -7.101301356164437;
  var lng = parseFloat(lngInput.value) || 109.9167435556062;
  var map = L.map('map').setView([lat, lng], 16);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; OpenStreetMap contributors' }).addTo(map);
  var marker = L.marker([lat, lng]).addTo(map);
  map.on('click', function(e) {
    lat = e.latlng.lat; lng = e.latlng.lng;
    latInput.value = lat; lngInput.value = lng;
    latDisp.value = lat; lngDisp.value = lng;
    map.removeLayer(marker);
    marker = L.marker([lat, lng]).addTo(map);
  });
})();
</script>
<?= $this->endSection() ?>
