<?= $this->extend('superadmin/layout.php') ?>

<?= $this->section('content') ?>
<div class="content-header">
  <div>
    <h3>Data Perusahaan</h3>
    <p>Kelola daftar perusahaan yang terdaftar pada sistem presensi.</p>
  </div>
  <a href="<?= base_url('superadmin/perusahaan/create') ?>" class="btn btn-dark btn-sm">
    <i class="fas fa-plus me-1"></i> Tambah Perusahaan
  </a>
</div>

<div class="card">
  <div class="card-body p-3">
    <div class="table-responsive">
      <table id="datatables" class="table align-items-center mb-0">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Perusahaan</th>
            <th>Alamat</th>
            <th>Kontak</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1; foreach ($perusahaan as $row): ?>
            <tr>
              <td><?= $no++ ?></td>
              <td class="font-weight-semibold"><?= esc($row['nama_perusahaan']) ?></td>
              <td><?= esc($row['alamat'] ?: '-') ?></td>
              <td>
                <div><?= esc($row['telepon'] ?: '-') ?></div>
                <div class="text-xs text-secondary"><?= esc($row['email'] ?: '-') ?></div>
              </td>
              <td><?= badge_kehadiran($row['status']) ?></td>
              <td>
                <a href="<?= base_url('superadmin/perusahaan/edit/' . $row['id']) ?>" class="btn btn-sm btn-outline-warning">
                  <i class="fas fa-pen"></i>
                </a>
                <a href="<?= base_url('superadmin/perusahaan/delete/' . $row['id']) ?>" class="btn btn-sm btn-outline-danger tombol-hapus">
                  <i class="fas fa-trash"></i>
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
