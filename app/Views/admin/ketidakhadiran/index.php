<?= $this->extend('admin/layout.php') ?>
<?= $this->section('content') ?>

<div class="app-page-head">
  <div>
    <h2 class="app-title">Data Ketidakhadiran</h2>
    <p class="app-subtitle">Tinjau dan setujui pengajuan izin, sakit, atau cuti karyawan.</p>
  </div>
  <form method="GET" action="<?= base_url('admin/ketidakhadiran') ?>" class="flex items-end gap-2">
    <div>
      <label class="app-label">Status</label>
      <select name="status" class="app-select h-10 w-[160px] text-[12.5px]">
        <option value="">Semua Status</option>
        <?php foreach (['Menunggu', 'Disetujui', 'Ditolak'] as $opsi): ?>
          <option value="<?= $opsi ?>" <?= $status === $opsi ? 'selected' : '' ?>><?= $opsi ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <button type="submit" class="app-btn-dark"><i class="fa-solid fa-filter"></i> Filter</button>
  </form>
</div>

<div class="app-card overflow-hidden">
  <div class="app-card-header">
    <div>
      <h3 class="text-[15px] font-bold text-slate-900">Pengajuan Ketidakhadiran</h3>
      <p class="mt-0.5 text-[11.5px] text-slate-400"><?= count($data) ?> pengajuan ditemukan</p>
    </div>
  </div>
  <div class="p-3 sm:p-4">
    <?php if (empty($data)): ?>
      <div class="app-empty">
        <i class="fa-regular fa-calendar-xmark"></i>
        <div>Belum ada pengajuan ketidakhadiran.</div>
      </div>
    <?php else: ?>
        <table id="datatables" class="app-table">
          <thead>
            <tr>
              <th>No</th>
              <th>Pegawai</th>
              <th>Keterangan</th>
              <th>Tanggal</th>
              <th>Deskripsi</th>
              <th>Lampiran</th>
              <th>Status</th>
              <th class="text-right">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; foreach ($data as $row): ?>
              <tr>
                <td class="text-slate-400"><?= $no++ ?></td>
                <td>
                  <div class="font-semibold text-slate-800"><?= esc($row['nama']) ?></div>
                  <div class="text-[11px] text-slate-400"><?= esc($row['nip']) ?></div>
                </td>
                <td>
                  <span class="inline-flex rounded-md bg-slate-100 px-2 py-0.5 text-[11px] font-semibold text-slate-600 ring-1 ring-inset ring-slate-200"><?= esc($row['keterangan']) ?></span>
                </td>
                <td class="font-medium"><?= tanggal_indo($row['tanggal']) ?></td>
                <td class="max-w-[220px] truncate text-[11.5px] text-slate-500" title="<?= esc($row['deskripsi']) ?>"><?= esc($row['deskripsi']) ?></td>
                <td>
                  <?php if (! empty($row['file'])): ?>
                    <a href="<?= base_url('uploads/ketidakhadiran/' . $row['file']) ?>" target="_blank" class="app-btn-outline app-btn-sm h-8">
                      <i class="fa-solid fa-paperclip text-[10px]"></i> Lihat
                    </a>
                  <?php else: ?>
                    <span class="text-slate-400">-</span>
                  <?php endif; ?>
                </td>
                <td><?= badge_kehadiran($row['status_pengajuan']) ?></td>
                <td>
                  <?php if ($row['status_pengajuan'] === 'Menunggu'): ?>
                    <div class="flex items-center justify-end gap-1.5">
                      <form action="<?= base_url('admin/ketidakhadiran/status/' . $row['id']) ?>" method="POST">
                        <?= csrf_field() ?>
                        <input type="hidden" name="status" value="Disetujui">
                        <button type="submit" class="app-icon-btn border-emerald-200 bg-emerald-500 text-white hover:bg-emerald-600" title="Setujui"><i class="fa-solid fa-check text-[11px]"></i></button>
                      </form>
                      <form action="<?= base_url('admin/ketidakhadiran/status/' . $row['id']) ?>" method="POST">
                        <?= csrf_field() ?>
                        <input type="hidden" name="status" value="Ditolak">
                        <button type="submit" class="app-icon-btn border-rose-200 bg-rose-500 text-white hover:bg-rose-600" title="Tolak"><i class="fa-solid fa-xmark text-[11px]"></i></button>
                      </form>
                    </div>
                  <?php else: ?>
                    <div class="text-right text-[11px] text-slate-400">Sudah diproses</div>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
    <?php endif; ?>
  </div>
</div>

<?= $this->endSection() ?>
