<?= $this->extend('admin/layout.php') ?>

<?= $this->section('content') ?>
<div class="content-header">
  <div>
    <h3>Rekap Kehadiran Harian</h3>
    <p>Pantau kehadiran seluruh karyawan pada tanggal tertentu.</p>
  </div>
  <form method="GET" action="<?= base_url('admin/rekap/harian') ?>" class="d-flex gap-2">
    <input type="date" name="tanggal" class="form-control form-control-sm" value="<?= esc($tanggal) ?>">
    <button type="submit" class="btn btn-dark btn-sm"><i class="fas fa-search me-1"></i> Tampilkan</button>
  </form>
</div>

<?php
$jumlahHadir = 0;
$jumlahAlpa = 0;
$jumlahIzin = 0;
foreach ($rekap as $row) {
    if ($row['status'] === 'Hadir' || $row['status'] === 'Terlambat') {
        $jumlahHadir++;
    } elseif ($row['status'] === 'Alpa') {
        $jumlahAlpa++;
    } else {
        $jumlahIzin++;
    }
}
?>
<div class="row g-3 mb-4">
  <div class="col-md-4">
    <div class="card stat-card">
      <div class="card-body p-4">
        <div class="stat-label">Hadir</div>
        <div class="stat-value text-success"><?= $jumlahHadir ?></div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card stat-card">
      <div class="card-body p-4">
        <div class="stat-label">Izin / Sakit / Cuti</div>
        <div class="stat-value text-warning"><?= $jumlahIzin ?></div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card stat-card">
      <div class="card-body p-4">
        <div class="stat-label">Alpa / Belum Presensi</div>
        <div class="stat-value text-danger"><?= $jumlahAlpa ?></div>
      </div>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-header py-3 d-flex justify-content-between align-items-center">
    <div>
      <h6 class="mb-0">Rekap <?= tanggal_indo($tanggal, true) ?></h6>
      <small class="text-secondary"><?= count($rekap) ?> karyawan</small>
    </div>
  </div>
  <div class="card-body p-3">
    <div class="table-responsive">
      <table id="datatables" class="table align-items-center mb-0">
        <thead>
          <tr>
            <th>No</th>
            <th>Pegawai</th>
            <th>NIP</th>
            <th>Jabatan</th>
            <th>Jam Masuk</th>
            <th>Jam Pulang</th>
            <th>Status</th>
            <th>Keterangan</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1; foreach ($rekap as $row): ?>
            <tr>
              <td><?= $no++ ?></td>
              <td>
                <div class="d-flex align-items-center gap-2">
                  <?php $foto = $row['pegawai']['foto'] ?: ''; ?>
                  <img src="<?= $foto && is_file(FCPATH . 'profile/' . $foto) ? base_url('profile/' . $foto) : base_url('assets/img/team-1.jpg') ?>" class="avatar avatar-sm" alt="Foto">
                  <span class="font-weight-semibold"><?= esc($row['pegawai']['nama']) ?></span>
                </div>
              </td>
              <td><?= esc($row['pegawai']['nip']) ?></td>
              <td><?= esc($row['pegawai']['jabatan']) ?></td>
              <td><?= esc($row['jam_masuk']) ?></td>
              <td><?= esc($row['jam_keluar']) ?></td>
              <td><?= badge_kehadiran($row['status']) ?></td>
              <td>
                <?php if ($row['izin']): ?>
                  <span class="text-xs text-secondary"><?= esc($row['izin']['deskripsi']) ?></span>
                <?php else: ?>
                  <span class="text-secondary">-</span>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
