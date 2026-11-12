<?= $this->extend('superadmin/layout.php') ?>
<?= $this->section('content') ?>

<div class="row g-3">
  <div class="col-md-3">
    <div class="card border-0 shadow-sm">
      <div class="card-body">
        <div class="text-secondary small">Perusahaan</div>
        <div class="h3 mb-0"><?= (int) ($total_perusahaan ?? 0) ?></div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card border-0 shadow-sm">
      <div class="card-body">
        <div class="text-secondary small">Admin</div>
        <div class="h3 mb-0"><?= (int) ($total_admin ?? 0) ?></div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card border-0 shadow-sm">
      <div class="card-body">
        <div class="text-secondary small">Superadmin</div>
        <div class="h3 mb-0"><?= (int) ($total_superadmin ?? 0) ?></div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card border-0 shadow-sm">
      <div class="card-body">
        <div class="text-secondary small">Pegawai</div>
        <div class="h3 mb-0"><?= (int) ($total_pegawai ?? 0) ?></div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card border-0 shadow-sm">
      <div class="card-body">
        <div class="text-secondary small">Plant / Lokasi</div>
        <div class="h3 mb-0"><?= (int) ($total_plant ?? 0) ?></div>
      </div>
    </div>
  </div>
</div>

<div class="card border-0 shadow-sm mt-3">
  <div class="card-header bg-white">
    <h6 class="mb-0">Daftar Perusahaan</h6>
  </div>
  <div class="card-body p-0">
    <table class="table table-sm mb-0">
      <thead class="table-light">
        <tr>
          <th>Nama Perusahaan</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach (($perusahaan ?? []) as $row): ?>
          <tr>
            <td><?= esc($row['nama_perusahaan']) ?></td>
            <td><?= esc($row['status']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?= $this->endSection() ?>