<?= $this->extend('admin/layout.php') ?>
<?= $this->section('content') ?>

<div class="app-page-head">
  <div>
    <h2 class="app-title">Lokasi Presensi</h2>
    <p class="app-subtitle">Kelola plant atau lokasi presensi beserta pengaturan GPS dan radiusnya.</p>
  </div>
  <a href="<?= base_url('admin/lokasi_presensi/create') ?>" class="app-btn-primary"><i class="fa-solid fa-plus"></i> Tambah Lokasi</a>
</div>

<div class="app-card overflow-hidden">
  <div class="app-card-header">
    <div class="flex items-center gap-2.5">
      <span class="grid h-8 w-8 place-items-center rounded-lg bg-brand-50 text-brand-600"><i class="fa-solid fa-location-dot text-[11px]"></i></span>
      <div>
        <h3 class="text-[14px] font-bold text-slate-900">Daftar Lokasi (Plant)</h3>
        <p class="text-[11px] text-slate-400"><?= count($lokasi_presensi) ?> lokasi terdaftar</p>
      </div>
    </div>
  </div>
  <div class="p-3 sm:p-4">
    <?php if (empty($lokasi_presensi)): ?>
      <div class="app-empty">
        <i class="fa-solid fa-location-dot"></i>
        <div>Belum ada lokasi presensi.</div>
        <a href="<?= base_url('admin/lokasi_presensi/create') ?>" class="app-btn-primary app-btn-sm mt-1">Tambah Lokasi</a>
      </div>
    <?php else: ?>
        <table id="datatables" class="app-table">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Lokasi</th>
              <th>Alamat</th>
              <th>Tipe</th>
              <th class="text-right">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; foreach ($lokasi_presensi as $lok): ?>
              <tr>
                <td class="text-slate-400"><?= $no++ ?></td>
                <td>
                  <div class="flex items-center gap-2.5">
                    <span class="grid h-8 w-8 place-items-center rounded-lg bg-brand-50 text-brand-600"><i class="fa-solid fa-location-dot text-[11px]"></i></span>
                    <span class="font-semibold text-slate-800"><?= esc($lok['nama_lokasi']) ?></span>
                  </div>
                </td>
                <td class="max-w-[280px] truncate"><?= esc($lok['alamat_lokasi']) ?></td>
                <td>
                  <span class="inline-flex rounded-md bg-slate-100 px-2 py-0.5 text-[11px] font-semibold text-slate-600 ring-1 ring-inset ring-slate-200"><?= esc($lok['tipe_lokasi']) ?></span>
                </td>
                <td>
                  <div class="flex items-center justify-end gap-1.5">
                    <a href="<?= base_url('admin/lokasi_presensi/detail/' . $lok['id']) ?>" class="app-icon-btn border-emerald-200 text-emerald-600 hover:bg-emerald-50" title="Detail"><i class="fa-solid fa-eye text-[11px]"></i></a>
                    <a href="<?= base_url('admin/lokasi_presensi/edit/' . $lok['id']) ?>" class="app-icon-btn border-amber-200 text-amber-600 hover:bg-amber-50" title="Edit"><i class="fa-solid fa-pen text-[11px]"></i></a>
                    <a href="<?= base_url('admin/lokasi_presensi/delete/' . $lok['id']) ?>" class="app-icon-btn border-rose-200 text-rose-600 hover:bg-rose-50 tombol-hapus" title="Hapus"><i class="fa-solid fa-trash text-[11px]"></i></a>
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
