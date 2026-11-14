<?= $this->extend('admin/layout.php') ?>
<?= $this->section('content') ?>

<div class="app-page-head">
  <div>
    <h2 class="app-title">Data Pegawai</h2>
    <p class="app-subtitle">Daftar pegawai pada <?= esc(session()->get('nama_perusahaan')) ?>.</p>
  </div>
  <div class="flex flex-wrap items-center gap-2">
    <a href="<?= base_url('admin/data_pegawai/import') ?>" class="app-btn-outline">
      <i class="fa-solid fa-file-import"></i> Import CSV
    </a>
    <a href="<?= base_url('admin/data_pegawai/create') ?>" class="app-btn-primary">
      <i class="fa-solid fa-user-plus"></i> Tambah Pegawai
    </a>
  </div>
</div>

<div class="app-card overflow-hidden">
  <div class="app-card-header">
    <div class="flex items-center gap-2.5">
      <span class="grid h-8 w-8 place-items-center rounded-lg bg-brand-50 text-brand-600"><i class="fa-solid fa-users text-[11px]"></i></span>
      <div>
        <h3 class="text-[14px] font-bold text-slate-900">Daftar Pegawai</h3>
        <p class="text-[11px] text-slate-400"><?= count($data_pegawai) ?> pegawai terdaftar</p>
      </div>
    </div>
  </div>
  <div class="p-3 sm:p-4">
    <?php if (empty($data_pegawai)): ?>
      <div class="app-empty">
        <i class="fa-solid fa-user-group"></i>
        <div>Belum ada data pegawai. Tambahkan pegawai pertama Anda.</div>
        <a href="<?= base_url('admin/data_pegawai/create') ?>" class="app-btn-primary app-btn-sm mt-1">Tambah Pegawai</a>
      </div>
    <?php else: ?>
        <table id="datatables" class="app-table">
          <thead>
            <tr>
              <th>No</th>
              <th>Pegawai</th>
              <th>NIP</th>
              <th>Jabatan</th>
              <th>Lokasi Presensi</th>
              <th>Status</th>
              <th class="text-right">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; foreach ($data_pegawai as $pegawai): ?>
              <tr>
                <td class="text-slate-400"><?= $no++ ?></td>
                <td>
                  <div class="flex items-center gap-3">
                    <?php $foto = $pegawai['foto'] ?: ''; ?>
                    <img src="<?= $foto && is_file(FCPATH . 'profile/' . $foto) ? base_url('profile/' . $foto) : base_url('assets/img/team-1.jpg') ?>" class="h-9 w-9 rounded-xl object-cover ring-2 ring-white shadow-sm" alt="Foto">
                    <div class="min-w-0">
                      <div class="truncate font-semibold text-slate-800"><?= esc($pegawai['nama']) ?></div>
                      <div class="text-[11px] text-slate-400">@<?= esc($pegawai['username'] ?: '-') ?></div>
                    </div>
                  </div>
                </td>
                <td class="font-medium"><?= esc($pegawai['nip']) ?></td>
                <td><?= esc($pegawai['jabatan']) ?></td>
                <td><?= esc($pegawai['nama_lokasi'] ?: $pegawai['lokasi_presensi']) ?></td>
                <td><?= badge_kehadiran($pegawai['status'] ?: 'Tidak Aktif') ?></td>
                <td>
                  <div class="flex items-center justify-end gap-1.5">
                    <a href="<?= base_url('admin/data_pegawai/detail/' . $pegawai['id']) ?>" class="app-icon-btn border-emerald-200 text-emerald-600 hover:bg-emerald-50" title="Detail">
                      <i class="fa-solid fa-eye text-[11px]"></i>
                    </a>
                    <a href="<?= base_url('admin/data_pegawai/edit/' . $pegawai['id']) ?>" class="app-icon-btn border-amber-200 text-amber-600 hover:bg-amber-50" title="Edit">
                      <i class="fa-solid fa-pen text-[11px]"></i>
                    </a>
                    <a href="<?= base_url('admin/data_pegawai/delete/' . $pegawai['id']) ?>" class="app-icon-btn border-rose-200 text-rose-600 hover:bg-rose-50 tombol-hapus" title="Hapus">
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
