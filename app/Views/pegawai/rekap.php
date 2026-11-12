<?= $this->extend('pegawai/layout.php') ?>

<?= $this->section('content') ?>
<div class="content-header">
  <div>
    <h3>Rekap Kehadiran</h3>
    <p>Riwayat presensi dan pengajuan ketidakhadiran Anda.</p>
  </div>
  <form method="GET" action="<?= base_url('pegawai/rekap') ?>" class="d-flex gap-2">
    <input type="month" name="bulan" class="form-control form-control-sm" value="<?= esc($bulan) ?>">
    <button type="submit" class="btn btn-dark btn-sm"><i class="fas fa-search me-1"></i> Tampilkan</button>
  </form>
</div>

<?php
$izinDisetujui = array_filter($izin, static fn ($row) => ($row['status_pengajuan'] ?? '') === 'Disetujui');
$izinMenunggu  = array_filter($izin, static fn ($row) => ($row['status_pengajuan'] ?? '') === 'Menunggu');
?>
<div class="row g-3 mb-4">
  <div class="col-md-4">
    <div class="card stat-mini h-100">
      <div class="icon" style="background:#ecfdf5;color:#059669;">
        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
      </div>
      <div>
        <div class="value"><?= (int) $total_hadir ?></div>
        <div class="label">Hadir - <?= esc($nama_bulan) ?></div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card stat-mini h-100">
      <div class="icon" style="background:#eff6ff;color:#2563eb;">
        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z" />
        </svg>
      </div>
      <div>
        <div class="value"><?= count($izinDisetujui) ?></div>
        <div class="label">Izin Disetujui</div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card stat-mini h-100">
      <div class="icon" style="background:#fff7ed;color:#ea580c;">
        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
      </div>
      <div>
        <div class="value"><?= count($izinMenunggu) ?></div>
        <div class="label">Menunggu Persetujuan</div>
      </div>
    </div>
  </div>
</div>

<div class="card mb-4">
  <div class="card-header py-3 d-flex justify-content-between align-items-center">
    <div>
      <h6 class="mb-0">Riwayat Presensi</h6>
      <small class="text-secondary"><?= esc($nama_bulan) ?></small>
    </div>
    <span class="badge bg-primary"><?= count($presensi) ?> data</span>
  </div>
  <div class="card-body p-3">
    <?php if (empty($presensi)): ?>
      <div class="empty-state">Belum ada presensi pada bulan ini.</div>
    <?php else: ?>
      <div class="table-responsive">
        <table id="datatables" class="table align-items-center mb-0">
          <thead>
            <tr>
              <th>No</th>
              <th>Tanggal</th>
              <th>Jam Masuk</th>
              <th>Jam Pulang</th>
              <th>Foto Masuk</th>
              <th>Foto Pulang</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; foreach ($presensi as $row): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td class="font-weight-semibold"><?= tanggal_indo($row['tanggal_masuk'], true) ?></td>
                <td><?= $row['jam_masuk'] ? substr($row['jam_masuk'], 0, 5) : '-' ?></td>
                <td><?= $row['jam_keluar'] ? substr($row['jam_keluar'], 0, 5) : '<span class="text-secondary">Belum</span>' ?></td>
                <td>
                  <?php if (! empty($row['foto_masuk'])): ?>
                    <a href="<?= base_url('uploads/presensi/' . $row['foto_masuk']) ?>" target="_blank">
                      <img src="<?= base_url('uploads/presensi/' . $row['foto_masuk']) ?>" class="avatar avatar-sm" alt="Foto masuk">
                    </a>
                  <?php else: ?><span class="text-secondary">-</span><?php endif; ?>
                </td>
                <td>
                  <?php if (! empty($row['foto_keluar'])): ?>
                    <a href="<?= base_url('uploads/presensi/' . $row['foto_keluar']) ?>" target="_blank">
                      <img src="<?= base_url('uploads/presensi/' . $row['foto_keluar']) ?>" class="avatar avatar-sm" alt="Foto pulang">
                    </a>
                  <?php else: ?><span class="text-secondary">-</span><?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>
</div>

<div class="card">
  <div class="card-header py-3 d-flex justify-content-between align-items-center">
    <div>
      <h6 class="mb-0">Pengajuan Ketidakhadiran</h6>
      <small class="text-secondary"><?= esc($nama_bulan) ?></small>
    </div>
    <a href="<?= base_url('pegawai/ketidakhadiran/create') ?>" class="btn btn-sm btn-dark">
      <i class="fas fa-plus me-1"></i> Ajukan
    </a>
  </div>
  <div class="card-body p-3">
    <?php if (empty($izin)): ?>
      <div class="empty-state">Belum ada pengajuan pada bulan ini.</div>
    <?php else: ?>
      <div class="table-responsive">
        <table class="table align-items-center mb-0">
          <thead>
            <tr>
              <th>Tanggal</th>
              <th>Keterangan</th>
              <th>Deskripsi</th>
              <th>Status</th>
              <th>Lampiran</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($izin as $row): ?>
              <tr>
                <td class="font-weight-semibold"><?= tanggal_indo($row['tanggal']) ?></td>
                <td><span class="badge bg-light text-dark border"><?= esc($row['keterangan']) ?></span></td>
                <td><?= esc($row['deskripsi']) ?></td>
                <td><?= badge_kehadiran($row['status_pengajuan']) ?></td>
                <td>
                  <?php if (! empty($row['file'])): ?>
                    <a href="<?= base_url('uploads/ketidakhadiran/' . $row['file']) ?>" target="_blank" class="btn btn-sm btn-outline-dark">
                      <i class="fas fa-paperclip"></i>
                    </a>
                  <?php else: ?><span class="text-secondary">-</span><?php endif; ?>
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
