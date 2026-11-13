<?= $this->extend('pegawai/layout.php') ?>

<?= $this->section('content') ?>
<div class="app-page-head">
  <div>
    <h2 class="app-title">Pengajuan Ketidakhadiran</h2>
    <p class="app-subtitle">Ajukan izin, sakit, atau cuti dan pantau status persetujuannya.</p>
  </div>
  <a href="<?= base_url('pegawai/ketidakhadiran/create') ?>" class="app-btn-dark">
    <i class="fa-solid fa-plus"></i> Ajukan Baru
  </a>
</div>

<div class="app-card overflow-hidden">
  <div class="app-card-header">
    <div class="flex items-center gap-2.5">
      <span class="grid h-8 w-8 place-items-center rounded-lg bg-brand-50 text-brand-600"><i class="fa-solid fa-calendar-xmark text-[11px]"></i></span>
      <div>
        <h3 class="text-[14px] font-bold text-slate-900">Riwayat Pengajuan</h3>
        <p class="text-[11px] text-slate-400"><?= count($data) ?> pengajuan</p>
      </div>
    </div>
  </div>
  <div class="p-3 sm:p-4">
    <?php if (empty($data)): ?>
      <div class="app-empty">
        <i class="fa-regular fa-calendar-xmark"></i>
        <div>Belum ada pengajuan ketidakhadiran.</div>
        <a href="<?= base_url('pegawai/ketidakhadiran/create') ?>" class="app-btn-dark app-btn-sm mt-1">Buat pengajuan pertama</a>
      </div>
    <?php else: ?>
        <table id="datatables" class="app-table">
          <thead>
            <tr>
              <th>No</th>
              <th>Tanggal</th>
              <th>Keterangan</th>
              <th>Deskripsi</th>
              <th>Lampiran</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; foreach ($data as $row): ?>
              <tr>
                <td class="text-slate-400"><?= $no++ ?></td>
                <td class="font-semibold text-slate-800"><?= tanggal_indo($row['tanggal']) ?></td>
                <td>
                  <span class="inline-flex rounded-md bg-slate-100 px-2 py-0.5 text-[11px] font-semibold text-slate-600 ring-1 ring-inset ring-slate-200"><?= esc($row['keterangan']) ?></span>
                </td>
                <td class="max-w-[300px] truncate text-[11.5px] text-slate-500" title="<?= esc($row['deskripsi']) ?>"><?= esc($row['deskripsi']) ?></td>
                <td>
                  <?php if (! empty($row['file'])): ?>
                    <a href="<?= base_url('uploads/ketidakhadiran/' . $row['file']) ?>" target="_blank" class="app-btn-outline app-btn-sm h-8">
                      <i class="fa-solid fa-paperclip text-[10px]"></i> Lihat
                    </a>
                  <?php else: ?><span class="text-slate-400">-</span><?php endif; ?>
                </td>
                <td><?= badge_kehadiran($row['status_pengajuan']) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
    <?php endif; ?>
  </div>
</div>
<?= $this->endSection() ?>
