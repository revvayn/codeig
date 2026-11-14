<?= $this->extend('superadmin/layout.php') ?>

<?= $this->section('content') ?>
<div class="app-page-head">
  <div>
    <h2 class="app-title">Data Perusahaan</h2>
    <p class="app-subtitle">Kelola daftar perusahaan yang terdaftar pada sistem presensi.</p>
  </div>
  <a href="<?= base_url('superadmin/perusahaan/create') ?>" class="app-btn-primary">
    <i class="fa-solid fa-plus"></i> Tambah Perusahaan
  </a>
</div>

<div class="app-card overflow-hidden">
  <div class="app-card-header">
    <div class="flex items-center gap-2.5">
      <span class="grid h-8 w-8 place-items-center rounded-lg bg-brand-50 text-brand-600"><i class="fa-solid fa-building text-[11px]"></i></span>
      <div>
        <h3 class="text-[14px] font-bold text-slate-900">Daftar Perusahaan</h3>
        <p class="text-[11px] text-slate-400"><?= count($perusahaan) ?> perusahaan terdaftar</p>
      </div>
    </div>
  </div>
  <div class="p-3 sm:p-4">
    <?php if (empty($perusahaan)): ?>
      <div class="app-empty">
        <i class="fa-regular fa-building"></i>
        <div>Belum ada perusahaan terdaftar.</div>
        <a href="<?= base_url('superadmin/perusahaan/create') ?>" class="app-btn-primary app-btn-sm mt-1">Tambah Perusahaan</a>
      </div>
    <?php else: ?>
        <table id="datatables" class="app-table">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Perusahaan</th>
              <th>Alamat</th>
              <th>Kontak</th>
              <th>Status</th>
              <th class="text-right">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; foreach ($perusahaan as $row): ?>
              <tr>
                <td class="text-slate-400"><?= $no++ ?></td>
                <td>
                  <div class="flex items-center gap-2.5">
                    <span class="grid h-8 w-8 place-items-center rounded-lg bg-brand-50 text-brand-600"><i class="fa-solid fa-building text-[11px]"></i></span>
                    <span class="font-semibold text-slate-800"><?= esc($row['nama_perusahaan']) ?></span>
                  </div>
                </td>
                <td class="max-w-[240px] truncate"><?= esc($row['alamat'] ?: '-') ?></td>
                <td>
                  <div class="font-medium text-slate-700"><?= esc($row['telepon'] ?: '-') ?></div>
                  <div class="text-[11px] text-slate-400"><?= esc($row['email'] ?: '-') ?></div>
                </td>
                <td><?= badge_kehadiran($row['status']) ?></td>
                <td>
                  <div class="flex items-center justify-end gap-1.5">
                    <a href="<?= base_url('superadmin/perusahaan/edit/' . $row['id']) ?>" class="app-icon-btn border-amber-200 text-amber-600 hover:bg-amber-50" title="Edit">
                      <i class="fa-solid fa-pen text-[11px]"></i>
                    </a>
                    <a href="<?= base_url('superadmin/perusahaan/delete/' . $row['id']) ?>" class="app-icon-btn border-rose-200 text-rose-600 hover:bg-rose-50 tombol-hapus" title="Hapus">
                      <i class="fa-solid fa-trash text-[11px]"></i>
                    </a>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
    <?php endif; ?>
  </div>
</div>
<?= $this->endSection() ?>
