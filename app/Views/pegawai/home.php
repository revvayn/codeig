<?= $this->extend('pegawai/layout.php') ?>

<?= $this->section('content') ?>
<?php
$sudahMasuk  = ! empty($presensi_hari_ini);
$sudahPulang = $sudahMasuk && ! empty($presensi_hari_ini['jam_keluar']);
$terlambat   = false;

if ($sudahMasuk && $lokasi_presensi && ! empty($presensi_hari_ini['jam_masuk'])) {
    $terlambat = $presensi_hari_ini['jam_masuk'] > $lokasi_presensi['jam_masuk'];
}
?>
<div class="content-header">
  <div>
    <h3>Halo, <?= esc($pegawai['nama'] ?? session()->get('nama_pegawai')) ?> 👋</h3>
    <p><?= esc($tanggal_hari_ini) ?> &middot; <?= esc($pegawai['jabatan'] ?? '-') ?></p>
  </div>
  <div class="company-pill">
    <svg fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
      <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
    </svg>
    <?= esc($lokasi_presensi['nama_lokasi'] ?? 'Lokasi belum diatur') ?>
  </div>
</div>

<div class="row g-3 mb-3">
  <div class="col-lg-7">
    <div class="card h-100">
      <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-start mb-3">
          <div>
            <div class="text-xs text-uppercase text-secondary font-weight-bold">Waktu Server</div>
            <div class="clock-display mt-1">
              <span id="jam">--</span><span class="sep">:</span><span id="menit">--</span><span class="sep">:</span><span id="detik">--</span>
            </div>
          </div>
          <span class="badge bg-primary"><?= esc($lokasi_presensi['zona_waktu'] ?? 'WIB') ?></span>
        </div>

        <div class="status-box <?= $sudahMasuk ? 'active' : '' ?>">
          <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
              <div class="text-xs text-secondary font-weight-bold text-uppercase">Status Hari Ini</div>
              <div class="mt-1">
                <?php if ($sudahPulang): ?>
                  <span class="badge bg-success">Presensi Lengkap</span>
                <?php elseif ($sudahMasuk): ?>
                  <span class="badge bg-warning">Sudah Masuk, Belum Pulang</span>
                  <?php if ($terlambat): ?>
                    <span class="badge bg-danger ms-1">Terlambat</span>
                  <?php endif; ?>
                <?php else: ?>
                  <span class="badge bg-secondary">Belum Presensi</span>
                <?php endif; ?>
              </div>
            </div>
            <div class="d-flex gap-4">
              <div>
                <div class="text-xs text-secondary">Masuk</div>
                <div class="font-weight-bold"><?= $sudahMasuk && $presensi_hari_ini['jam_masuk'] ? substr($presensi_hari_ini['jam_masuk'], 0, 5) : '--:--' ?></div>
              </div>
              <div>
                <div class="text-xs text-secondary">Pulang</div>
                <div class="font-weight-bold"><?= $sudahPulang ? substr($presensi_hari_ini['jam_keluar'], 0, 5) : '--:--' ?></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-5">
    <div class="row g-3 h-100">
      <div class="col-6">
        <div class="card stat-mini h-100">
          <div class="icon bg-success-subtle text-success" style="background:#ecfdf5;">
            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
            </svg>
          </div>
          <div>
            <div class="value"><?= (int) $total_hadir ?></div>
            <div class="label">Hadir Bulan Ini</div>
          </div>
        </div>
      </div>
      <div class="col-6">
        <div class="card stat-mini h-100">
          <div class="icon" style="background:#eff6ff;color:#2563eb;">
            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z" />
            </svg>
          </div>
          <div>
            <div class="value"><?= (int) $total_izin ?></div>
            <div class="label">Izin Disetujui</div>
          </div>
        </div>
      </div>
      <div class="col-12">
        <div class="card h-100">
          <div class="card-body p-3">
            <div class="d-flex align-items-center justify-content-between mb-2">
              <span class="text-xs text-secondary font-weight-bold text-uppercase">Ringkasan</span>
              <a href="<?= base_url('pegawai/rekap') ?>" class="text-xs text-decoration-none font-weight-bold">Lihat rekap</a>
            </div>
            <div class="d-flex justify-content-between text-sm mb-1">
              <span class="text-secondary">Jam masuk kantor</span>
              <span class="font-weight-bold"><?= $lokasi_presensi ? substr($lokasi_presensi['jam_masuk'], 0, 5) : '-' ?></span>
            </div>
            <div class="d-flex justify-content-between text-sm mb-1">
              <span class="text-secondary">Jam pulang kantor</span>
              <span class="font-weight-bold"><?= $lokasi_presensi ? substr($lokasi_presensi['jam_pulang'], 0, 5) : '-' ?></span>
            </div>
            <div class="d-flex justify-content-between text-sm">
              <span class="text-secondary">Radius lokasi</span>
              <span class="font-weight-bold"><?= $lokasi_presensi ? (int) $lokasi_presensi['radius'] . ' m' : '-' ?></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row g-3 mb-4">
  <div class="col-lg-6">
    <div class="card h-100">
      <div class="card-header py-3">
        <i class="fas fa-sign-in-alt me-1 text-success"></i> Presensi Masuk
      </div>
      <div class="card-body p-4">
        <?php if ($sudahMasuk): ?>
          <div class="alert alert-success border-0 mb-0">
            <i class="fas fa-check-circle me-2"></i> Anda sudah presensi masuk pukul <strong><?= substr($presensi_hari_ini['jam_masuk'], 0, 5) ?></strong>.
          </div>
        <?php else: ?>
          <form method="POST" action="<?= base_url('pegawai/presensi_masuk') ?>" enctype="multipart/form-data" class="form-presensi" data-nama="masuk">
            <?= csrf_field() ?>
            <input type="hidden" name="latitude" class="input-latitude">
            <input type="hidden" name="longitude" class="input-longitude">

            <div class="mb-3">
              <label class="form-label">Foto Presensi <span class="text-secondary font-weight-normal">(opsional)</span></label>
              <input type="file" name="foto_masuk" class="form-control" accept="image/*" capture="user">
            </div>
            <div class="small text-secondary mb-3">
              <i class="fas fa-map-marker-alt me-1"></i>
              Lokasi GPS akan diperiksa otomatis saat tombol ditekan.
            </div>
            <button type="submit" class="btn btn-primary w-100">
              <i class="fas fa-fingerprint me-1"></i> Presensi Masuk Sekarang
            </button>
          </form>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="card h-100">
      <div class="card-header py-3">
        <i class="fas fa-sign-out-alt me-1 text-danger"></i> Presensi Pulang
      </div>
      <div class="card-body p-4">
        <?php if (! $sudahMasuk): ?>
          <div class="alert alert-secondary border-0 mb-0">
            <i class="fas fa-info-circle me-2"></i> Lakukan presensi masuk terlebih dahulu.
          </div>
        <?php elseif ($sudahPulang): ?>
          <div class="alert alert-success border-0 mb-0">
            <i class="fas fa-check-circle me-2"></i> Anda sudah presensi pulang pukul <strong><?= substr($presensi_hari_ini['jam_keluar'], 0, 5) ?></strong>.
          </div>
        <?php else: ?>
          <form method="POST" action="<?= base_url('pegawai/presensi_pulang') ?>" enctype="multipart/form-data" class="form-presensi" data-nama="pulang">
            <?= csrf_field() ?>
            <input type="hidden" name="latitude" class="input-latitude">
            <input type="hidden" name="longitude" class="input-longitude">

            <div class="mb-3">
              <label class="form-label">Foto Presensi <span class="text-secondary font-weight-normal">(opsional)</span></label>
              <input type="file" name="foto_keluar" class="form-control" accept="image/*" capture="user">
            </div>
            <div class="small text-secondary mb-3">
              <i class="fas fa-map-marker-alt me-1"></i>
              Pastikan Anda berada dalam radius lokasi presensi.
            </div>
            <button type="submit" class="btn btn-danger w-100">
              <i class="fas fa-door-open me-1"></i> Presensi Pulang Sekarang
            </button>
          </form>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-header d-flex align-items-center justify-content-between py-3">
    <div>
      <h6 class="mb-0">Riwayat Presensi Terakhir</h6>
      <small class="text-secondary">7 data terakhir.</small>
    </div>
    <a href="<?= base_url('pegawai/rekap') ?>" class="btn btn-sm btn-outline-dark">Lihat semua</a>
  </div>
  <div class="card-body p-3">
    <?php if (empty($riwayat)): ?>
      <div class="empty-state">Belum ada riwayat presensi.</div>
    <?php else: ?>
      <div class="table-responsive">
        <table class="table mb-0">
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
                <td class="font-weight-semibold"><?= tanggal_indo($row['tanggal_masuk'], true) ?></td>
                <td><?= $row['jam_masuk'] ? substr($row['jam_masuk'], 0, 5) : '-' ?></td>
                <td><?= $row['jam_keluar'] ? substr($row['jam_keluar'], 0, 5) : '<span class="text-secondary">Belum</span>' ?></td>
                <td>
                  <?php if (! empty($row['foto_masuk'])): ?>
                    <img src="<?= base_url('uploads/presensi/' . $row['foto_masuk']) ?>" class="avatar avatar-sm" alt="Foto">
                  <?php else: ?>
                    <span class="text-secondary">-</span>
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

<?= $this->section('scripts') ?>
<script>
  (function() {
    var jam = <?= (int) date('H') ?>;
    var menit = <?= (int) date('i') ?>;
    var detik = <?= (int) date('s') ?>;

    function dua(n) {
      return n < 10 ? '0' + n : n;
    }

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
      if (form.dataset.siap === '1') {
        return;
      }

      event.preventDefault();

      var tombol = form.querySelector('button[type="submit"]');
      var teksAsli = tombol.innerHTML;
      tombol.disabled = true;
      tombol.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mendeteksi lokasi...';

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
      }, {
        enableHighAccuracy: true,
        timeout: 15000,
        maximumAge: 0
      });
    });
  });
</script>
<?= $this->endSection() ?>
