<?= $this->extend('admin/layout.php') ?>

<?= $this->section('content') ?>
<div class="content-header">
  <div>
    <h3>Rekap Kehadiran Bulanan</h3>
    <p>Akumulasi kehadiran karyawan per bulan. Alpa dihitung dari hari kerja yang tidak memiliki presensi.</p>
  </div>
  <form method="GET" action="<?= base_url('admin/rekap/bulanan') ?>" class="d-flex gap-2">
    <input type="month" name="bulan" class="form-control form-control-sm" value="<?= esc($bulan) ?>">
    <button type="submit" class="btn btn-dark btn-sm"><i class="fas fa-search me-1"></i> Tampilkan</button>
  </form>
</div>

<div class="card mb-3">
  <div class="card-body p-4 d-flex flex-wrap gap-4 align-items-center">
    <div>
      <div class="text-xs text-secondary font-weight-bold text-uppercase">Periode</div>
      <div class="font-weight-bold text-dark"><?= esc($nama_bulan) ?></div>
    </div>
    <div>
      <div class="text-xs text-secondary font-weight-bold text-uppercase">Hari Kerja</div>
      <div class="font-weight-bold text-dark"><?= (int) $hari_kerja ?> hari</div>
    </div>
    <div>
      <div class="text-xs text-secondary font-weight-bold text-uppercase">Jumlah Pegawai</div>
      <div class="font-weight-bold text-dark"><?= count($rekap) ?> orang</div>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-body p-3">
    <div class="table-responsive">
      <table id="datatables" class="table align-items-center mb-0">
        <thead>
          <tr>
            <th>No</th>
            <th>Pegawai</th>
            <th>NIP</th>
            <th class="text-center">Hadir</th>
            <th class="text-center">Izin</th>
            <th class="text-center">Sakit</th>
            <th class="text-center">Cuti</th>
            <th class="text-center">Alpa</th>
            <th>Kehadiran</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1; foreach ($rekap as $row): ?>
            <?php $persen = $row['hari_kerja'] > 0 ? round(($row['hadir'] / $row['hari_kerja']) * 100) : 0; ?>
            <tr>
              <td><?= $no++ ?></td>
              <td>
                <div class="d-flex align-items-center gap-2">
                  <?php $foto = $row['pegawai']['foto'] ?: ''; ?>
                  <img src="<?= $foto && is_file(FCPATH . 'profile/' . $foto) ? base_url('profile/' . $foto) : base_url('assets/img/team-1.jpg') ?>" class="avatar avatar-sm" alt="Foto">
                  <span class="font-weight-semibold"><?= esc($row['pegawai']['nama']) ?></span>
                </div>
              </td>
              <td><?= esc($row['pegawai']['nip']) ?></td>
              <td class="text-center text-success font-weight-bold"><?= (int) $row['hadir'] ?></td>
              <td class="text-center"><?= (int) $row['izin'] ?></td>
              <td class="text-center"><?= (int) $row['sakit'] ?></td>
              <td class="text-center"><?= (int) $row['cuti'] ?></td>
              <td class="text-center text-danger font-weight-bold"><?= (int) $row['alpa'] ?></td>
              <td style="min-width:140px;">
                <div class="d-flex align-items-center gap-2">
                  <div class="progress progress-soft flex-grow-1">
                    <div class="progress-bar bg-success" style="width: <?= $persen ?>%"></div>
                  </div>
                  <span class="text-xs font-weight-bold"><?= $persen ?>%</span>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
