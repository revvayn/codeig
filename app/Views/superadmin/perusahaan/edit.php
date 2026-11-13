<?= $this->extend('superadmin/layout.php') ?>

<?= $this->section('content') ?>
<?php $errors = session()->getFlashdata('errors') ?? []; ?>

<div class="app-page-head">
  <div>
    <h2 class="app-title">Edit Perusahaan</h2>
    <p class="app-subtitle">Perbarui informasi perusahaan dan titik GPS default plant.</p>
  </div>
  <a href="<?= base_url('superadmin/perusahaan') ?>" class="app-btn-outline"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
</div>

<div class="grid grid-cols-1 gap-[26px] lg:grid-cols-8">
  <div class="lg:col-span-5">
    <div class="app-card p-6">
      <?php if (! empty($errors)): ?>
        <div class="mb-5 rounded-xl bg-rose-50 px-4 py-3 text-[12.5px] text-rose-700 ring-1 ring-inset ring-rose-600/10">
          <?php foreach ($errors as $error): ?><div><?= esc($error) ?></div><?php endforeach; ?>
        </div>
      <?php endif; ?>

      <form action="<?= base_url('superadmin/perusahaan/update/' . $perusahaan['id']) ?>" method="POST" class="space-y-6">
        <?= csrf_field() ?>

        <section>
          <h3 class="mb-4 flex items-center gap-2 text-[13px] font-bold text-slate-800">
            <span class="grid h-7 w-7 place-items-center rounded-lg bg-brand-50 text-brand-600"><i class="fa-solid fa-building text-[10px]"></i></span>
            Informasi Perusahaan
          </h3>
          <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div class="sm:col-span-2">
              <label class="app-label">Nama Perusahaan <span class="text-rose-500">*</span></label>
              <input type="text" name="nama_perusahaan" class="app-input" value="<?= esc(old('nama_perusahaan', $perusahaan['nama_perusahaan'])) ?>" required>
            </div>
            <div class="sm:col-span-2">
              <label class="app-label">Alamat</label>
              <textarea name="alamat" class="app-textarea" rows="3"><?= esc(old('alamat', $perusahaan['alamat'])) ?></textarea>
            </div>
            <div>
              <label class="app-label">Telepon</label>
              <input type="text" name="telepon" class="app-input" value="<?= esc(old('telepon', $perusahaan['telepon'])) ?>">
            </div>
            <div>
              <label class="app-label">Email</label>
              <input type="email" name="email" class="app-input" value="<?= esc(old('email', $perusahaan['email'])) ?>">
            </div>
          </div>
        </section>

        <hr class="border-slate-100">

        <section>
          <h3 class="mb-4 flex items-center gap-2 text-[13px] font-bold text-slate-800">
            <span class="grid h-7 w-7 place-items-center rounded-lg bg-emerald-50 text-emerald-600"><i class="fa-solid fa-location-dot text-[10px]"></i></span>
            Pengaturan GPS (Default Plant)
          </h3>
          <div id="map" class="h-[300px] w-full overflow-hidden rounded-xl border border-slate-200"></div>
          <p class="app-help"><i class="fa-solid fa-hand-pointer mr-1 text-brand-500"></i> Klik pada peta untuk menentukan titik GPS perusahaan.</p>
          <input type="hidden" name="latitude" id="latitude" value="<?= esc(old('latitude', $perusahaan['latitude'])) ?>">
          <input type="hidden" name="longitude" id="longitude" value="<?= esc(old('longitude', $perusahaan['longitude'])) ?>">
          <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
              <label class="app-label">Latitude</label>
              <input type="text" id="lat_display" class="app-input bg-slate-50 text-slate-500" value="<?= esc(old('latitude', $perusahaan['latitude'])) ?>" readonly>
            </div>
            <div>
              <label class="app-label">Longitude</label>
              <input type="text" id="lng_display" class="app-input bg-slate-50 text-slate-500" value="<?= esc(old('longitude', $perusahaan['longitude'])) ?>" readonly>
            </div>
          </div>
          <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div>
              <label class="app-label">Radius (meter)</label>
              <input type="number" name="radius" class="app-input" value="<?= esc(old('radius', $perusahaan['radius'])) ?>">
            </div>
            <div>
              <label class="app-label">Zona Waktu</label>
              <select name="zona_waktu" class="app-select">
                <?php foreach (['WIB', 'WITA', 'WIT'] as $zona): ?>
                  <option value="<?= $zona ?>" <?= old('zona_waktu', $perusahaan['zona_waktu']) === $zona ? 'selected' : '' ?>><?= $zona ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div>
              <label class="app-label">Jam Masuk</label>
              <input type="time" name="jam_masuk" class="app-input" value="<?= esc(old('jam_masuk', $perusahaan['jam_masuk'])) ?>">
            </div>
            <div>
              <label class="app-label">Jam Pulang</label>
              <input type="time" name="jam_pulang" class="app-input" value="<?= esc(old('jam_pulang', $perusahaan['jam_pulang'])) ?>">
            </div>
            <div class="sm:col-span-2">
              <label class="app-label">Status</label>
              <select name="status" class="app-select">
                <option value="Aktif" <?= old('status', $perusahaan['status']) === 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                <option value="Tidak Aktif" <?= old('status', $perusahaan['status']) === 'Tidak Aktif' ? 'selected' : '' ?>>Tidak Aktif</option>
              </select>
            </div>
          </div>
        </section>

        <div class="flex items-center gap-2 pt-1">
          <button type="submit" class="app-btn-primary"><i class="fa-solid fa-floppy-disk"></i> Perbarui Perusahaan</button>
          <a href="<?= base_url('superadmin/perusahaan') ?>" class="app-btn-ghost">Batal</a>
        </div>
      </form>
    </div>
  </div>

  <div class="lg:col-span-3">
    <div class="app-card p-6">
      <h3 class="mb-4 flex items-center gap-2 text-[13px] font-bold text-slate-800">
        <span class="grid h-7 w-7 place-items-center rounded-lg bg-brand-50 text-brand-600"><i class="fa-solid fa-circle-nodes text-[10px]"></i></span>
        Ringkasan
      </h3>
      <dl class="space-y-2.5 text-[12.5px]">
        <div class="flex items-center justify-between gap-3 border-b border-slate-100 pb-2.5">
          <dt class="text-slate-400">Nama</dt>
          <dd class="text-right font-semibold text-slate-700"><?= esc($perusahaan['nama_perusahaan']) ?></dd>
        </div>
        <div class="flex items-center justify-between gap-3 border-b border-slate-100 pb-2.5">
          <dt class="text-slate-400">Status</dt>
          <dd><?= badge_kehadiran($perusahaan['status'] ?: 'Tidak Aktif') ?></dd>
        </div>
        <div class="flex items-center justify-between gap-3 border-b border-slate-100 pb-2.5">
          <dt class="text-slate-400">Zona waktu</dt>
          <dd class="font-semibold text-slate-700"><?= esc($perusahaan['zona_waktu'] ?: 'WIB') ?></dd>
        </div>
        <div class="flex items-center justify-between gap-3">
          <dt class="text-slate-400">Jam kerja</dt>
          <dd class="font-semibold text-slate-700">
            <?= $perusahaan['jam_masuk'] ? substr($perusahaan['jam_masuk'], 0, 5) : '--:--' ?> &ndash;
            <?= $perusahaan['jam_pulang'] ? substr($perusahaan['jam_pulang'], 0, 5) : '--:--' ?>
          </dd>
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
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
  }).addTo(map);
  var marker = null;
  if (latInput.value && lngInput.value) {
    marker = L.marker([lat, lng]).addTo(map);
  }
  map.on('click', function(e) {
    lat = e.latlng.lat;
    lng = e.latlng.lng;
    latInput.value = lat;
    lngInput.value = lng;
    latDisp.value = lat;
    lngDisp.value = lng;
    if (marker) { map.removeLayer(marker); }
    marker = L.marker([lat, lng]).addTo(map);
  });
})();
</script>
<?= $this->endSection() ?>
