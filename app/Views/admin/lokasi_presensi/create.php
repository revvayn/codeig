<?= $this->extend('admin/layout.php') ?>
<?= $this->section('content') ?>

<div class="app-page-head">
  <div>
    <h2 class="app-title">Tambah Lokasi Presensi</h2>
    <p class="app-subtitle">Tentukan titik GPS, radius, dan jam presensi untuk plant baru.</p>
  </div>
  <a href="<?= base_url('admin/lokasi_presensi') ?>" class="app-btn-outline"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
</div>

<div class="grid grid-cols-1 gap-[26px] lg:grid-cols-8">
  <div class="lg:col-span-5">
    <div class="app-card p-6">
      <form method="POST" action="<?= base_url('admin/lokasi_presensi/store') ?>" class="space-y-5">
        <?= csrf_field() ?>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
          <div>
            <label class="app-label">Nama Lokasi <span class="text-rose-500">*</span></label>
            <input type="text" name="nama_lokasi" class="app-input <?= $validation->hasError('nama_lokasi') ? 'border-rose-300 focus:border-rose-500 focus:ring-rose-500/10' : '' ?>" value="<?= esc(old('nama_lokasi')) ?>" placeholder="Contoh: Plant BSD" required>
            <?php if ($validation->hasError('nama_lokasi')): ?><p class="app-error"><?= $validation->getError('nama_lokasi') ?></p><?php endif; ?>
          </div>
          <div>
            <label class="app-label">Tipe Lokasi <span class="text-rose-500">*</span></label>
            <input type="text" name="tipe_lokasi" class="app-input <?= $validation->hasError('tipe_lokasi') ? 'border-rose-300 focus:border-rose-500 focus:ring-rose-500/10' : '' ?>" value="<?= esc(old('tipe_lokasi')) ?>" placeholder="Kantor / Plant / Gudang" required>
            <?php if ($validation->hasError('tipe_lokasi')): ?><p class="app-error"><?= $validation->getError('tipe_lokasi') ?></p><?php endif; ?>
          </div>
          <div class="sm:col-span-2">
            <label class="app-label">Alamat Lokasi <span class="text-rose-500">*</span></label>
            <textarea name="alamat_lokasi" class="app-textarea <?= $validation->hasError('alamat_lokasi') ? 'border-rose-300 focus:border-rose-500 focus:ring-rose-500/10' : '' ?>" rows="2" placeholder="Alamat lengkap lokasi" required><?= esc(old('alamat_lokasi')) ?></textarea>
            <?php if ($validation->hasError('alamat_lokasi')): ?><p class="app-error"><?= $validation->getError('alamat_lokasi') ?></p><?php endif; ?>
          </div>
        </div>

        <div>
          <label class="app-label">Pilih Lokasi di Peta <span class="text-rose-500">*</span></label>
          <div id="map" class="h-[280px] w-full overflow-hidden rounded-xl border border-slate-200"></div>
          <p class="app-help"><i class="fa-solid fa-hand-pointer mr-1 text-brand-500"></i> Klik pada peta untuk menentukan titik GPS lokasi.</p>
          <?php if ($validation->getError('latitude') || $validation->getError('longitude')): ?>
            <p class="app-error"><?= $validation->getError('latitude') ?> <?= $validation->getError('longitude') ?></p>
          <?php endif; ?>
        </div>
        <input type="hidden" name="latitude" id="latitude" value="<?= esc(old('latitude')) ?>">
        <input type="hidden" name="longitude" id="longitude" value="<?= esc(old('longitude')) ?>">

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
          <div>
            <label class="app-label">Latitude</label>
            <input type="text" id="lat_display" class="app-input bg-slate-50 text-slate-500" value="<?= esc(old('latitude')) ?>" readonly>
          </div>
          <div>
            <label class="app-label">Longitude</label>
            <input type="text" id="lng_display" class="app-input bg-slate-50 text-slate-500" value="<?= esc(old('longitude')) ?>" readonly>
          </div>
          <div>
            <label class="app-label">Radius (meter) <span class="text-rose-500">*</span></label>
            <input type="number" name="radius" class="app-input <?= $validation->hasError('radius') ? 'border-rose-300 focus:border-rose-500 focus:ring-rose-500/10' : '' ?>" value="<?= esc(old('radius', 50)) ?>" min="1" required>
            <?php if ($validation->hasError('radius')): ?><p class="app-error"><?= $validation->getError('radius') ?></p><?php endif; ?>
          </div>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
          <div>
            <label class="app-label">Zona Waktu <span class="text-rose-500">*</span></label>
            <select name="zona_waktu" class="app-select <?= $validation->hasError('zona_waktu') ? 'border-rose-300 focus:border-rose-500 focus:ring-rose-500/10' : '' ?>" required>
              <option value="">Pilih Zona</option>
              <option value="WIB" <?= old('zona_waktu') === 'WIB' ? 'selected' : '' ?>>WIB</option>
              <option value="WITA" <?= old('zona_waktu') === 'WITA' ? 'selected' : '' ?>>WITA</option>
              <option value="WIT" <?= old('zona_waktu') === 'WIT' ? 'selected' : '' ?>>WIT</option>
            </select>
            <?php if ($validation->hasError('zona_waktu')): ?><p class="app-error"><?= $validation->getError('zona_waktu') ?></p><?php endif; ?>
          </div>
          <div>
            <label class="app-label">Jam Masuk <span class="text-rose-500">*</span></label>
            <input type="time" name="jam_masuk" class="app-input <?= $validation->hasError('jam_masuk') ? 'border-rose-300 focus:border-rose-500 focus:ring-rose-500/10' : '' ?>" value="<?= esc(old('jam_masuk', '08:00')) ?>" required>
            <?php if ($validation->hasError('jam_masuk')): ?><p class="app-error"><?= $validation->getError('jam_masuk') ?></p><?php endif; ?>
          </div>
          <div>
            <label class="app-label">Jam Pulang <span class="text-rose-500">*</span></label>
            <input type="time" name="jam_pulang" class="app-input <?= $validation->hasError('jam_pulang') ? 'border-rose-300 focus:border-rose-500 focus:ring-rose-500/10' : '' ?>" value="<?= esc(old('jam_pulang', '17:00')) ?>" required>
            <?php if ($validation->hasError('jam_pulang')): ?><p class="app-error"><?= $validation->getError('jam_pulang') ?></p><?php endif; ?>
          </div>
        </div>

        <div class="flex items-center gap-2 pt-1">
          <button type="submit" class="app-btn-primary"><i class="fa-solid fa-floppy-disk"></i> Simpan Lokasi</button>
          <a href="<?= base_url('admin/lokasi_presensi') ?>" class="app-btn-ghost">Batal</a>
        </div>
      </form>
    </div>
  </div>

  <div class="lg:col-span-3">
    <div class="app-card p-6">
      <h3 class="mb-4 flex items-center gap-2 text-[13px] font-bold text-slate-800">
        <span class="grid h-7 w-7 place-items-center rounded-lg bg-amber-50 text-amber-600"><i class="fa-solid fa-circle-info text-[10px]"></i></span>
        Petunjuk
      </h3>
      <ul class="space-y-3 text-[12.5px] leading-relaxed text-slate-500">
        <li class="flex gap-2.5"><i class="fa-solid fa-check mt-1 text-[9px] text-emerald-500"></i> Klik peta untuk menandai titik pusat lokasi.</li>
        <li class="flex gap-2.5"><i class="fa-solid fa-check mt-1 text-[9px] text-emerald-500"></i> Radius menentukan batas jarak presensi yang diizinkan.</li>
        <li class="flex gap-2.5"><i class="fa-solid fa-check mt-1 text-[9px] text-emerald-500"></i> Zona waktu memengaruhi jam presensi yang dicatat.</li>
        <li class="flex gap-2.5"><i class="fa-solid fa-check mt-1 text-[9px] text-emerald-500"></i> Satu perusahaan dapat memiliki banyak lokasi/plant.</li>
      </ul>
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
  var marker = null;
  if (latInput.value && lngInput.value) { marker = L.marker([lat, lng]).addTo(map); }
  map.on('click', function(e) {
    lat = e.latlng.lat; lng = e.latlng.lng;
    latInput.value = lat; lngInput.value = lng;
    latDisp.value = lat; lngDisp.value = lng;
    if (marker) { map.removeLayer(marker); }
    marker = L.marker([lat, lng]).addTo(map);
  });
})();
</script>
<?= $this->endSection() ?>
