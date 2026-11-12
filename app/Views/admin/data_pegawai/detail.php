<?= $this->extend('admin/layout.php') ?>

<?= $this->section('content') ?>
<div class="content-header">
  <div>
    <h3>Detail Data Pegawai</h3>
    <p>Informasi lengkap pegawai dan akun login.</p>
  </div>
  <div class="d-flex gap-2">
    <a href="<?= base_url('admin/data_pegawai') ?>" class="btn btn-sm btn-outline-dark">
      <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>
    <a href="<?= base_url('admin/data_pegawai/edit/' . $data_pegawai['id']) ?>" class="btn btn-sm btn-dark">
      <i class="fas fa-pen me-1"></i> Edit
    </a>
  </div>
</div>

<div class="row g-3">
  <div class="col-lg-4">
    <div class="card h-100">
      <div class="card-body p-4 text-center">
        <?php $foto = $data_pegawai['foto'] ?: ''; ?>
        <img src="<?= $foto && is_file(FCPATH . 'profile/' . $foto) ? base_url('profile/' . $foto) : base_url('assets/img/team-1.jpg') ?>" class="avatar avatar-lg mb-3" alt="Foto pegawai">
        <h5 class="font-weight-bold mb-1"><?= esc($data_pegawai['nama']) ?></h5>
        <div class="text-sm text-secondary mb-2"><?= esc($data_pegawai['nip']) ?></div>
        <?= badge_kehadiran($data_pegawai['status'] ?: 'Tidak Aktif') ?>
      </div>
    </div>
  </div>

  <div class="col-lg-8">
    <div class="card h-100">
      <div class="card-header py-3"><h6 class="mb-0">Informasi Pegawai</h6></div>
      <div class="card-body p-4">
        <div class="row">
          <div class="col-md-6 mb-3">
            <div class="text-xs text-secondary text-uppercase font-weight-bold">Nama Lengkap</div>
            <div class="font-weight-semibold"><?= esc($data_pegawai['nama']) ?></div>
          </div>
          <div class="col-md-6 mb-3">
            <div class="text-xs text-secondary text-uppercase font-weight-bold">NIP</div>
            <div class="font-weight-semibold"><?= esc($data_pegawai['nip']) ?></div>
          </div>
          <div class="col-md-6 mb-3">
            <div class="text-xs text-secondary text-uppercase font-weight-bold">Jenis Kelamin</div>
            <div class="font-weight-semibold"><?= esc($data_pegawai['jenis_kelamin']) ?></div>
          </div>
          <div class="col-md-6 mb-3">
            <div class="text-xs text-secondary text-uppercase font-weight-bold">No. Handphone</div>
            <div class="font-weight-semibold"><?= esc($data_pegawai['no_handphone']) ?></div>
          </div>
          <div class="col-12 mb-3">
            <div class="text-xs text-secondary text-uppercase font-weight-bold">Alamat</div>
            <div class="font-weight-semibold"><?= esc($data_pegawai['alamat']) ?></div>
          </div>
          <div class="col-md-6 mb-3">
            <div class="text-xs text-secondary text-uppercase font-weight-bold">Jabatan</div>
            <div class="font-weight-semibold"><?= esc($data_pegawai['jabatan']) ?></div>
          </div>
          <div class="col-md-6 mb-3">
            <div class="text-xs text-secondary text-uppercase font-weight-bold">Lokasi Presensi</div>
            <div class="font-weight-semibold"><?= esc($data_pegawai['nama_lokasi'] ?: $data_pegawai['lokasi_presensi']) ?></div>
          </div>
        </div>

        <hr>
        <h6 class="font-weight-bold mb-3">Akun Login</h6>
        <div class="row">
          <div class="col-md-4 mb-2">
            <div class="text-xs text-secondary text-uppercase font-weight-bold">Username</div>
            <div class="font-weight-semibold"><?= esc($data_pegawai['username'] ?: '-') ?></div>
          </div>
          <div class="col-md-4 mb-2">
            <div class="text-xs text-secondary text-uppercase font-weight-bold">Role</div>
            <div class="font-weight-semibold"><?= esc($data_pegawai['role'] ?: '-') ?></div>
          </div>
          <div class="col-md-4 mb-2">
            <div class="text-xs text-secondary text-uppercase font-weight-bold">Perusahaan</div>
            <div class="font-weight-semibold"><?= esc($data_pegawai['nama_perusahaan'] ?: session()->get('nama_perusahaan')) ?></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
