<?= $this->extend('admin/layout.php') ?>

<?= $this->section('content') ?>
<?php $errors = session()->getFlashdata('errors') ?? []; ?>
<div class="content-header">
  <div>
    <h3>Tambah Data Pegawai</h3>
    <p>Pegawai akan otomatis terdaftar pada <?= esc(session()->get('nama_perusahaan')) ?>.</p>
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

        <form action="<?= base_url('admin/data_pegawai/store') ?>" method="POST" enctype="multipart/form-data">
          <?= csrf_field() ?>

          <h6 class="font-weight-bold text-dark mb-3">Data Pribadi</h6>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
              <input type="text" name="nama" class="form-control" value="<?= old('nama') ?>" placeholder="Nama pegawai" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
              <select name="jenis_kelamin" class="form-select" required>
                <option value="">-- Pilih --</option>
                <option value="Laki-laki" <?= old('jenis_kelamin') === 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                <option value="Perempuan" <?= old('jenis_kelamin') === 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
              </select>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Alamat <span class="text-danger">*</span></label>
            <textarea name="alamat" class="form-control" rows="2" placeholder="Alamat lengkap" required><?= old('alamat') ?></textarea>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">No. Handphone <span class="text-danger">*</span></label>
              <input type="text" name="no_handphone" class="form-control" value="<?= old('no_handphone') ?>" placeholder="08xxxxxxxxxx" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Foto <span class="text-danger">*</span></label>
              <input type="file" name="foto" class="form-control" accept="image/jpeg,image/png,image/webp" required>
            </div>
          </div>

          <hr class="my-4">
          <h6 class="font-weight-bold text-dark mb-3">Data Kepegawaian</h6>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Jabatan <span class="text-danger">*</span></label>
              <select name="jabatan" class="form-select" required>
                <option value="">-- Pilih Jabatan --</option>
                <?php foreach ($jabatan as $jab): ?>
                  <option value="<?= esc($jab['jabatan']) ?>" <?= old('jabatan') === $jab['jabatan'] ? 'selected' : '' ?>><?= esc($jab['jabatan']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Lokasi Presensi <span class="text-danger">*</span></label>
              <select name="lokasi_presensi" class="form-select" required>
                <option value="">-- Pilih Lokasi --</option>
                <?php foreach ($lokasi_presensi as $lok): ?>
                  <option value="<?= $lok['id'] ?>" <?= (string) old('lokasi_presensi') === (string) $lok['id'] ? 'selected' : '' ?>><?= esc($lok['nama_lokasi']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <hr class="my-4">
          <h6 class="font-weight-bold text-dark mb-3">Akun Login</h6>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Username <span class="text-danger">*</span></label>
              <input type="text" name="username" class="form-control" value="<?= old('username') ?>" placeholder="Minimal 5 karakter, huruf/angka" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Role <span class="text-danger">*</span></label>
              <select name="role" class="form-select" required>
                <option value="">-- Pilih Role --</option>
                <option value="Admin" <?= old('role') === 'Admin' ? 'selected' : '' ?>>Admin</option>
                <option value="Pegawai" <?= old('role') === 'Pegawai' ? 'selected' : '' ?>>Pegawai</option>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Password <span class="text-danger">*</span></label>
              <input type="password" name="password" class="form-control" placeholder="Minimal 5 karakter" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
              <input type="password" name="konfirmasi_password" class="form-control" placeholder="Ulangi password" required>
            </div>
          </div>

          <button type="submit" class="btn btn-dark mt-2">
            <i class="fas fa-save me-1"></i> Simpan Data Pegawai
          </button>
        </form>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card">
      <div class="card-body p-4">
        <h6 class="font-weight-bold mb-3">Informasi</h6>
        <ul class="text-sm text-secondary ps-3 mb-0" style="line-height:1.9;">
          <li>NIP dibuat otomatis oleh sistem.</li>
          <li>Username harus unik dan hanya berisi huruf/angka.</li>
          <li>Role <strong>Admin</strong> dapat mengelola data, role <strong>Pegawai</strong> hanya dapat presensi.</li>
          <li>Pegawai langsung berstatus <strong>Aktif</strong> setelah disimpan.</li>
        </ul>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
