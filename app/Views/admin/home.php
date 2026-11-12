<?= $this->extend('admin/layout.php') ?>

<?= $this->section('content') ?>
<div class="content-header">
  <div>
    <h3>Dashboard Admin</h3>
    <p>Ringkasan kehadiran karyawan pada <?= tanggal_indo($tanggal, true) ?>.</p>
  </div>
  <a href="<?= base_url('admin/rekap/harian') ?>" class="btn btn-dark btn-sm">
    <i class="fas fa-chart-bar me-1"></i> Lihat Rekap Harian
  </a>
</div>

<div class="row g-3 mb-4">
  <div class="col-xl-3 col-sm-6">
    <div class="card stat-card h-100">
      <div class="card-body p-4">
        <div class="icon bg-dark text-white">
          <svg fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
          </svg>
        </div>
        <div class="stat-value"><?= (int) $total_pegawai ?></div>
        <div class="stat-label mt-1">Total Pegawai</div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-sm-6">
    <div class="card stat-card h-100">
      <div class="card-body p-4">
        <div class="icon bg-success text-white">
          <svg fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
        <div class="stat-value"><?= (int) $hadir ?></div>
        <div class="stat-label mt-1">Hadir Hari Ini</div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-sm-6">
    <div class="card stat-card h-100">
      <div class="card-body p-4">
        <div class="icon bg-warning text-white">
          <svg fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
          </svg>
        </div>
        <div class="stat-value"><?= (int) $izin ?></div>
        <div class="stat-label mt-1">Izin / Sakit / Cuti</div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-sm-6">
    <div class="card stat-card h-100">
      <div class="card-body p-4">
        <div class="icon bg-danger text-white">
          <svg fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
        <div class="stat-value"><?= (int) $alpa ?></div>
        <div class="stat-label mt-1">Belum Presensi / Alpa</div>
      </div>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-header d-flex align-items-center justify-content-between py-3">
    <div>
      <h6 class="mb-0">Presensi Hari Ini</h6>
      <small class="text-secondary">Daftar karyawan yang sudah melakukan presensi masuk.</small>
    </div>
    <span class="badge bg-primary"><?= count($presensi_hari_ini) ?> data</span>
  </div>
  <div class="card-body p-3">
    <?php if (empty($presensi_hari_ini)): ?>
      <div class="empty-state">
        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <div>Belum ada karyawan yang presensi hari ini.</div>
      </div>
    <?php else: ?>
      <div class="table-responsive">
        <table class="table align-items-center mb-0">
          <thead>
            <tr>
              <th>Nama</th>
              <th>NIP</th>
              <th>Jam Masuk</th>
              <th>Jam Pulang</th>
              <th>Foto</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($presensi_hari_ini as $row): ?>
              <tr>
                <td class="font-weight-semibold"><?= esc($row['nama']) ?></td>
                <td><?= esc($row['nip']) ?></td>
                <td><?= $row['jam_masuk'] ? substr($row['jam_masuk'], 0, 5) : '-' ?></td>
                <td><?= $row['jam_keluar'] ? substr($row['jam_keluar'], 0, 5) : '<span class="text-secondary">Belum</span>' ?></td>
                <td>
                  <?php if (! empty($row['foto_masuk'])): ?>
                    <img src="<?= base_url('uploads/presensi/' . $row['foto_masuk']) ?>" alt="Foto presensi" class="avatar avatar-sm">
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
