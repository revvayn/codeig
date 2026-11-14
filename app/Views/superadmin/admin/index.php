<?= $this->extend('superadmin/layout.php') ?>
<?= $this->section('content') ?>

<div class="app-page-head">
  <div>
    <h2 class="app-title">Data Admin</h2>
    <p class="app-subtitle">Kelola akun admin dan superadmin pada seluruh perusahaan.</p>
  </div>
  <a href="<?= base_url('superadmin/admin/create') ?>" class="app-btn-primary"><i class="fa-solid fa-user-plus"></i> Tambah Admin</a>
</div>

<div class="app-card overflow-hidden">
  <div class="app-card-header">
    <div class="flex items-center gap-2.5">
      <span class="grid h-8 w-8 place-items-center rounded-lg bg-brand-50 text-brand-600"><i class="fa-solid fa-user-shield text-[11px]"></i></span>
      <div>
        <h3 class="text-[14px] font-bold text-slate-900">Daftar Admin</h3>
        <p class="text-[11px] text-slate-400"><?= count($data ?? []) ?> akun terdaftar</p>
      </div>
    </div>
  </div>
  <div class="p-3 sm:p-4">
    <?php if (empty($data)): ?>
      <div class="app-empty">
        <i class="fa-solid fa-user-shield"></i>
        <div>Belum ada akun admin.</div>
        <a href="<?= base_url('superadmin/admin/create') ?>" class="app-btn-primary app-btn-sm mt-1">Tambah Admin</a>
      </div>
    <?php else: ?>
        <table id="datatables" class="app-table">
          <thead>
            <tr>
              <th>No</th>
              <th>Username</th>
              <th>Role</th>
              <th>Perusahaan</th>
              <th>Status</th>
              <th class="text-right">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; foreach ($data as $row): ?>
              <tr>
                <td class="text-slate-400"><?= $no++ ?></td>
                <td>
                  <div class="flex items-center gap-2.5">
                    <span class="grid h-8 w-8 place-items-center rounded-lg bg-slate-100 text-slate-500"><i class="fa-solid fa-user text-[11px]"></i></span>
                    <span class="font-semibold text-slate-800"><?= esc($row['username']) ?></span>
                  </div>
                </td>
                <td><?= badge_role($row['role']) ?></td>
                <td><?= esc($row['nama_perusahaan'] ?? '-') ?></td>
                <td><?= badge_kehadiran($row['status'] ?: 'Tidak Aktif') ?></td>
                <td>
                  <div class="flex items-center justify-end gap-1.5">
                    <a href="<?= base_url('superadmin/admin/edit/' . $row['id']) ?>" class="app-icon-btn border-amber-200 text-amber-600 hover:bg-amber-50" title="Edit">
                      <i class="fa-solid fa-pen text-[11px]"></i>
                    </a>
                    <a href="<?= base_url('superadmin/admin/delete/' . $row['id']) ?>" class="app-icon-btn border-rose-200 text-rose-600 hover:bg-rose-50 tombol-hapus" title="Hapus">
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
