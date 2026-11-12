<?= $this->extend('admin/layout.php') ?>

<?= $this->section('content') ?>
<div class="content-header">
  <div>
    <h3>Data Pegawai</h3>
    <p>Daftar pegawai pada <?= esc(session()->get('nama_perusahaan')) ?>.</p>
  </div>
  <a href="<?= base_url('admin/data_pegawai/create') ?>" class="btn btn-dark btn-sm">
    <i class="fas fa-user-plus me-1"></i> Tambah Pegawai
  </a>
</div>

<div class="card">
  <div class="card-body p-3">
    <?php if (empty($data_pegawai)): ?>
      <div class="empty-state">Belum ada data pegawai. Tambahkan pegawai pertama Anda.</div>
    <?php else: ?>
      <div class="table-responsive">
        <table id="datatables" class="table align-items-center mb-0">
          <thead>
            <tr>
              <th>No</th>
              <th>Pegawai</th>
              <th>NIP</th>
              <th>Jabatan</th>
              <th>Lokasi Presensi</th>
              <th>Role</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; foreach ($data_pegawai as $pegawai): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <?php $foto = $pegawai['foto'] ?: ''; ?>
                    <img src="<?= $foto && is_file(FCPATH . 'profile/' . $foto) ? base_url('profile/' . $foto) : base_url('assets/img/team-1.jpg') ?>" class="avatar avatar-sm" alt="Foto">
                    <div>
                      <div class="font-weight-semibold"><?= esc($pegawai['nama']) ?></div>
                      <div class="text-xs text-secondary">@<?= esc($pegawai['username'] ?: '-') ?></div>
                    </div>
                  </div>
                </td>
                <td><?= esc($pegawai['nip']) ?></td>
                <td><?= esc($pegawai['jabatan']) ?></td>
                <td><?= esc($pegawai['nama_lokasi'] ?: $pegawai['lokasi_presensi']) ?></td>
                <td><span class="badge bg-light text-dark border"><?= esc($pegawai['role'] ?: '-') ?></span></td>
                <td><?= badge_kehadiran($pegawai['status'] ?: 'Tidak Aktif') ?></td>
                <td class="text-nowrap">
                  <a href="<?= base_url('admin/data_pegawai/detail/' . $pegawai['id']) ?>" class="btn btn-sm btn-outline-success" title="Detail">
                    <i class="fas fa-eye"></i>
                  </a>
                  <a href="<?= base_url('admin/data_pegawai/edit/' . $pegawai['id']) ?>" class="btn btn-sm btn-outline-warning" title="Edit">
                    <i class="fas fa-pen"></i>
                  </a>
                  <a href="<?= base_url('admin/data_pegawai/delete/' . $pegawai['id']) ?>" class="btn btn-sm btn-outline-danger tombol-hapus" title="Hapus">
                    <i class="fas fa-trash"></i>
                  </a>
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
