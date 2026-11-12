<?= $this->extend('pegawai/layout.php') ?>

<?= $this->section('content') ?>
<div class="content-header">
  <div>
    <h3>Pengajuan Ketidakhadiran</h3>
    <p>Ajukan izin, sakit, atau cuti dan pantau status persetujuannya.</p>
  </div>
  <a href="<?= base_url('pegawai/ketidakhadiran/create') ?>" class="btn btn-dark btn-sm">
    <i class="fas fa-plus me-1"></i> Ajukan Baru
  </a>
</div>

<div class="card">
  <div class="card-body p-3">
    <?php if (empty($data)): ?>
      <div class="empty-state">
        <div>Belum ada pengajuan ketidakhadiran.</div>
        <a href="<?= base_url('pegawai/ketidakhadiran/create') ?>" class="btn btn-sm btn-dark mt-3">Buat pengajuan pertama</a>
      </div>
    <?php else: ?>
      <div class="table-responsive">
        <table id="datatables" class="table align-items-center mb-0">
          <thead>
            <tr>
              <th>No</th>
              <th>Tanggal</th>
              <th>Keterangan</th>
              <th>Deskripsi</th>
              <th>Lampiran</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; foreach ($data as $row): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td class="font-weight-semibold"><?= tanggal_indo($row['tanggal']) ?></td>
                <td><span class="badge bg-light text-dark border"><?= esc($row['keterangan']) ?></span></td>
                <td style="max-width:300px;"><?= esc($row['deskripsi']) ?></td>
                <td>
                  <?php if (! empty($row['file'])): ?>
                    <a href="<?= base_url('uploads/ketidakhadiran/' . $row['file']) ?>" target="_blank" class="btn btn-sm btn-outline-dark">
                      <i class="fas fa-paperclip"></i> Lihat
                    </a>
                  <?php else: ?><span class="text-secondary">-</span><?php endif; ?>
                </td>
                <td><?= badge_kehadiran($row['status_pengajuan']) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>
</div>
<?= $this->endSection() ?>
