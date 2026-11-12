<?= $this->extend('admin/layout.php') ?>

<?= $this->section('content') ?>
<div class="content-header">
  <div>
    <h3>Data Ketidakhadiran</h3>
    <p>Tinjau dan setujui pengajuan izin, sakit, atau cuti karyawan.</p>
  </div>
  <form method="GET" action="<?= base_url('admin/ketidakhadiran') ?>" class="d-flex gap-2">
    <select name="status" class="form-select form-select-sm">
      <option value="">Semua Status</option>
      <?php foreach (['Menunggu', 'Disetujui', 'Ditolak'] as $opsi): ?>
        <option value="<?= $opsi ?>" <?= $status === $opsi ? 'selected' : '' ?>><?= $opsi ?></option>
      <?php endforeach; ?>
    </select>
    <button type="submit" class="btn btn-dark btn-sm">Filter</button>
  </form>
</div>

<div class="card">
  <div class="card-body p-3">
    <?php if (empty($data)): ?>
      <div class="empty-state">Belum ada pengajuan ketidakhadiran.</div>
    <?php else: ?>
      <div class="table-responsive">
        <table id="datatables" class="table align-items-center mb-0">
          <thead>
            <tr>
              <th>No</th>
              <th>Pegawai</th>
              <th>Keterangan</th>
              <th>Tanggal</th>
              <th>Deskripsi</th>
              <th>Lampiran</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; foreach ($data as $row): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td>
                  <div class="font-weight-semibold"><?= esc($row['nama']) ?></div>
                  <div class="text-xs text-secondary"><?= esc($row['nip']) ?></div>
                </td>
                <td><span class="badge bg-light text-dark border"><?= esc($row['keterangan']) ?></span></td>
                <td><?= tanggal_indo($row['tanggal']) ?></td>
                <td style="max-width:220px;"><?= esc($row['deskripsi']) ?></td>
                <td>
                  <?php if (! empty($row['file'])): ?>
                    <a href="<?= base_url('uploads/ketidakhadiran/' . $row['file']) ?>" target="_blank" class="btn btn-sm btn-outline-dark">
                      <i class="fas fa-paperclip"></i> Lihat
                    </a>
                  <?php else: ?>
                    <span class="text-secondary">-</span>
                  <?php endif; ?>
                </td>
                <td><?= badge_kehadiran($row['status_pengajuan']) ?></td>
                <td style="min-width:160px;">
                  <?php if ($row['status_pengajuan'] === 'Menunggu'): ?>
                    <form action="<?= base_url('admin/ketidakhadiran/status/' . $row['id']) ?>" method="POST" class="d-inline">
                      <?= csrf_field() ?>
                      <input type="hidden" name="status" value="Disetujui">
                      <button type="submit" class="btn btn-sm btn-success" title="Setujui"><i class="fas fa-check"></i></button>
                    </form>
                    <form action="<?= base_url('admin/ketidakhadiran/status/' . $row['id']) ?>" method="POST" class="d-inline">
                      <?= csrf_field() ?>
                      <input type="hidden" name="status" value="Ditolak">
                      <button type="submit" class="btn btn-sm btn-danger" title="Tolak"><i class="fas fa-times"></i></button>
                    </form>
                  <?php else: ?>
                    <span class="text-xs text-secondary">Sudah diproses</span>
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
