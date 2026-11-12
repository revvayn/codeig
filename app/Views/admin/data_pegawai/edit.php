<?= $this->extend('admin/layout.php') ?>

<?= $this->section('content') ?>
<?php $errors = session()->getFlashdata('errors') ?? []; ?>
<div class="content-header">
  <div>
    <h3>Edit Data Pegawai</h3>
    <p>Perbarui data pribadi, kepegawaian, dan akun login.</p>
  </div>
  <a href="<?= base_url('admin/data_pegawai') ?>" class="btn btn-sm btn-outline-dark">
    <i class="fas fa-arrow-left me-1"></i> Kembali
  </a>
</div>

<div class="row">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-body p-4">
        <?php if (! empty($errors)): ?>
          <div class="alert alert-danger">
            <?php foreach ($errors as $error): ?><div><?= esc($error) ?></div><?php endforeach; ?>
          </div>
        <?php endif; ?>

        <form action="<?= base_url('admin/data_pegawai/update/' . $pegawai['id']) ?>" method="POST" enctype="multipart/form-data">
          <?= csrf_field() ?>
          <input type="hidden" name="foto_lama" value="<?= esc($pegawai['foto']) ?>">

          <h6 class="font-weight-bold text-dark mb-3">Data Pribadi</h6>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
              <input type="text" name="nama" class="form-control" value="<?= esc(old('nama', $pegawai['nama'])) ?>" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
              <select name="jenis_kelamin" class="form-select" required>
                <option value="Laki-laki" <?= old('jenis_kelamin', $pegawai['jenis_kelamin']) === 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                <option value="Perempuan" <?= old('jenis_kelamin', $pegawai['jenis_kelamin']) === 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
              </select>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Alamat <span class="text-danger">*</span></label>
            <textarea name="alamat" class="form-control" rows="2" required><?= esc(old('alamat', $pegawai['alamat'])) ?></textarea>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">No. Handphone <span class="text-danger">*</span></label>
              <input type="text" name="no_handphone" class="form-control" value="<?= esc(old('no_handphone', $pegawai['no_handphone'])) ?>" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Foto Baru <span class="text-secondary font-weight-normal">(opsional)</span></label>
              <input type="file" name="foto" class="form-control" accept="image/jpeg,image/png,image/webp">
            </div>
          </div>

          <hr class="my-4">
          <h6 class="font-weight-bold text-dark mb-3">Data Kepegawaian</h6>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Jabatan <span class="text-danger">*</span></label>
              <select name="jabatan" class="form-select" required>
                <?php foreach ($jabatan as $jab): ?>
                  <option value="<?= esc($jab['jabatan']) ?>" <?= old('jabatan', $pegawai['jabatan']) === $jab['jabatan'] ? 'selected' : '' ?>><?= esc($jab['jabatan']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Lokasi Presensi <span class="text-danger">*</span></label>
              <select name="lokasi_presensi" class="form-select" required>
                <?php foreach ($lokasi_presensi as $lok): ?>
                  <option value="<?= $lok['id'] ?>" <?= (string) old('lokasi_presensi', $pegawai['lokasi_presensi']) === (string) $lok['id'] ? 'selected' : '' ?>><?= esc($lok['nama_lokasi']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <hr class="my-4">
          <h6 class="font-weight-bold text-dark mb-3">Akun Login</h6>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Username <span class="text-danger">*</span></label>
              <input type="text" name="username" class="form-control" value="<?= esc(old('username', $pegawai['username'])) ?>" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Role <span class="text-danger">*</span></label>
              <select name="role" class="form-select" required>
                <option value="Admin" <?= old('role', $pegawai['role']) === 'Admin' ? 'selected' : '' ?>>Admin</option>
                <option value="Pegawai" <?= old('role', $pegawai['role']) === 'Pegawai' ? 'selected' : '' ?>>Pegawai</option>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Password Baru <span class="text-secondary font-weight-normal">(kosongkan jika tidak diubah)</span></label>
              <input type="password" name="password" class="form-control" placeholder="Password baru">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Konfirmasi Password Baru</label>
              <input type="password" name="konfirmasi_password" class="form-control" placeholder="Ulangi password baru">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Status Akun <span class="text-danger">*</span></label>
              <select name="status" class="form-select" required>
                <option value="Aktif" <?= old('status', $pegawai['status']) === 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                <option value="Tidak Aktif" <?= old('status', $pegawai['status']) === 'Tidak Aktif' ? 'selected' : '' ?>>Tidak Aktif</option>
              </select>
            </div>
          </div>

          <button type="submit" class="btn btn-dark mt-2">
            <i class="fas fa-save me-1"></i> Perbarui Data
          </button>
        </form>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card">
      <div class="card-body p-4 text-center">
        <?php $foto = $pegawai['foto'] ?: ''; ?>
        <img src="<?= $foto && is_file(FCPATH . 'profile/' . $foto) ? base_url('profile/' . $foto) : base_url('assets/img/team-1.jpg') ?>" class="avatar avatar-lg mb-3" alt="Foto pegawai">
        <h6 class="font-weight-bold mb-1"><?= esc($pegawai['nama']) ?></h6>
        <div class="text-sm text-secondary mb-3"><?= esc($pegawai['nip']) ?></div>
        <div class="text-start text-sm">
          <div class="d-flex justify-content-between py-1 border-bottom">
            <span class="text-secondary">Perusahaan</span>
            <span class="font-weight-semibold"><?= esc(session()->get('nama_perusahaan')) ?></span>
          </div>
          <div class="d-flex justify-content-between py-1 border-bottom">
            <span class="text-secondary">Jabatan</span>
            <span class="font-weight-semibold"><?= esc($pegawai['jabatan']) ?></span>
          </div>
          <div class="d-flex justify-content-between py-1">
            <span class="text-secondary">Status</span>
            <?= badge_kehadiran($pegawai['status'] ?: 'Tidak Aktif') ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
