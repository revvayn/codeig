<?= $this->extend('pegawai/layout.php') ?>

<?= $this->section('content') ?>
<?php $errors = session()->getFlashdata('errors') ?? []; ?>
<div class="content-header">
  <div>
    <h3>Ajukan Ketidakhadiran</h3>
    <p>Lengkapi formulir di bawah ini dengan keterangan yang jelas.</p>
  </div>
  <a href="<?= base_url('pegawai/ketidakhadiran') ?>" class="btn btn-sm btn-outline-dark">
    <i class="fas fa-arrow-left me-1"></i> Kembali
  </a>
</div>

<div class="row">
  <div class="col-lg-7">
    <div class="card">
      <div class="card-body p-4">
        <?php if (! empty($errors)): ?>
          <div class="alert alert-danger">
            <?php foreach ($errors as $error): ?><div><?= esc($error) ?></div><?php endforeach; ?>
          </div>
        <?php endif; ?>

        <form action="<?= base_url('pegawai/ketidakhadiran/store') ?>" method="POST" enctype="multipart/form-data">
          <?= csrf_field() ?>
          <div class="mb-3">
            <label class="form-label">Keterangan <span class="text-danger">*</span></label>
            <select name="keterangan" class="form-select" required>
              <option value="">-- Pilih Keterangan --</option>
              <?php foreach (['Izin', 'Sakit', 'Cuti'] as $opsi): ?>
                <option value="<?= $opsi ?>" <?= old('keterangan') === $opsi ? 'selected' : '' ?>><?= $opsi ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Tanggal <span class="text-danger">*</span></label>
            <input type="date" name="tanggal" class="form-control" value="<?= old('tanggal', date('Y-m-d')) ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Deskripsi / Alasan <span class="text-danger">*</span></label>
            <textarea name="deskripsi" class="form-control" rows="4" placeholder="Jelaskan alasan ketidakhadiran Anda" required><?= old('deskripsi') ?></textarea>
          </div>
          <div class="mb-4">
            <label class="form-label">Lampiran <span class="text-secondary font-weight-normal">(opsional, JPG/PNG/PDF, maks. 5 MB)</span></label>
            <input type="file" name="file" class="form-control" accept="image/jpeg,image/png,application/pdf">
          </div>
          <button type="submit" class="btn btn-dark">
            <i class="fas fa-paper-plane me-1"></i> Kirim Pengajuan
          </button>
        </form>
      </div>
    </div>
  </div>

  <div class="col-lg-5">
    <div class="card">
      <div class="card-body p-4">
        <h6 class="font-weight-bold mb-3">Informasi</h6>
        <ul class="text-sm text-secondary ps-3 mb-0" style="line-height:1.9;">
          <li>Pengajuan akan berstatus <strong>Menunggu</strong> sampai admin menyetujui.</li>
          <li>Pastikan tanggal pengajuan sesuai dengan tanggal tidak hadir.</li>
          <li>Lampiran seperti surat dokter atau surat izin akan membantu proses persetujuan.</li>
          <li>Pengajuan yang disetujui akan dihitung pada rekap kehadiran.</li>
        </ul>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
