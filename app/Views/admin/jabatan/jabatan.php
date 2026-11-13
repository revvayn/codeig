<?= $this->extend('admin/layout.php') ?>
<?= $this->section('content') ?>

<div class="app-page-head">
  <div>
    <h2 class="app-title">Data Jabatan</h2>
    <p class="app-subtitle">Kelola daftar jabatan yang tersedia pada perusahaan Anda.</p>
  </div>
  <a href="<?= base_url('admin/jabatan/create') ?>" class="app-btn-dark"><i class="fa-solid fa-plus"></i> Tambah Jabatan</a>
</div>

<div class="app-card overflow-hidden">
  <div class="app-card-header">
    <div>
      <h3 class="text-[15px] font-bold text-slate-900">Daftar Jabatan</h3>
      <p class="mt-0.5 text-[11.5px] text-slate-400"><?= count($jabatan) ?> jabatan terdaftar</p>
    </div>
  </div>
  <div class="p-3 sm:p-4">
    <?php if (empty($jabatan)): ?>
      <div class="app-empty">
        <i class="fa-solid fa-sitemap"></i>
        <div>Belum ada data jabatan.</div>
        <a href="<?= base_url('admin/jabatan/create') ?>" class="app-btn-dark app-btn-sm mt-1">Tambah Jabatan</a>
      </div>
    <?php else: ?>
        <table id="datatables" class="app-table">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Jabatan</th>
              <th class="text-right">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; foreach ($jabatan as $jab): ?>
              <tr>
                <td class="text-slate-400"><?= $no++ ?></td>
                <td class="font-semibold text-slate-800"><?= esc($jab['jabatan']) ?></td>
                <td>
                  <div class="flex items-center justify-end gap-1.5">
                    <a href="<?= base_url('admin/jabatan/edit/' . $jab['id']) ?>" class="app-icon-btn border-amber-200 text-amber-600 hover:bg-amber-50" title="Edit"><i class="fa-solid fa-pen text-[11px]"></i></a>
                    <a href="<?= base_url('admin/jabatan/delete/' . $jab['id']) ?>" class="app-icon-btn border-rose-200 text-rose-600 hover:bg-rose-50 tombol-hapus" title="Hapus"><i class="fa-solid fa-trash text-[11px]"></i></a>
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
