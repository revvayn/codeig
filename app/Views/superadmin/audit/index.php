<?= $this->extend('superadmin/layout.php') ?>
<?= $this->section('content') ?>

<div class="app-page-head">
  <div>
    <h2 class="app-title">Audit Log</h2>
    <p class="app-subtitle">Jejak aktivitas pengguna pada sistem presensi.</p>
  </div>
  <span class="self-start rounded-full border border-slate-200 bg-white px-3.5 py-2 text-[11.5px] font-semibold text-slate-500 sm:self-auto">
    <i class="fa-solid fa-clock-rotate-left mr-1 text-brand-500"></i> <?= count($data ?? []) ?> catatan
  </span>
</div>

<div class="app-card overflow-hidden">
  <div class="app-card-header">
    <div class="flex items-center gap-2.5">
      <span class="grid h-8 w-8 place-items-center rounded-lg bg-brand-50 text-brand-600"><i class="fa-solid fa-clipboard-list text-[11px]"></i></span>
      <div>
        <h3 class="text-[14px] font-bold text-slate-900">Riwayat Aktivitas</h3>
        <p class="text-[11px] text-slate-400">Terbaru ditampilkan lebih dahulu.</p>
      </div>
    </div>
  </div>
  <div class="p-3 sm:p-4">
    <?php if (empty($data)): ?>
      <div class="app-empty">
        <i class="fa-solid fa-clipboard-list"></i>
        <div>Belum ada aktivitas tercatat.</div>
      </div>
    <?php else: ?>
        <table id="datatables" class="app-table">
          <thead>
            <tr>
              <th>Waktu</th>
              <th>User</th>
              <th>Role</th>
              <th>Aksi</th>
              <th>Entitas</th>
              <th>Deskripsi</th>
              <th>IP</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($data as $row): ?>
              <tr>
                <td class="whitespace-nowrap font-medium text-slate-700"><?= esc(waktu_indo($row['created_at'])) ?></td>
                <td class="font-semibold text-slate-800"><?= esc($row['username'] ?? '-') ?></td>
                <td><?= badge_role($row['role'] ?? '-') ?></td>
                <td class="whitespace-nowrap font-semibold text-slate-700"><?= esc(label_aksi($row['action'])) ?></td>
                <td><?= esc($row['entity'] ?? '-') ?><?= $row['entity_id'] ? ' #' . (int) $row['entity_id'] : '' ?></td>
                <td class="max-w-[280px] truncate text-[11.5px] text-slate-500" title="<?= esc($row['description'] ?? '-') ?>"><?= esc($row['description'] ?? '-') ?></td>
                <td class="font-mono text-[11px] text-slate-400"><?= esc($row['ip_address'] ?? '-') ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
    <?php endif; ?>
  </div>
</div>

<?= $this->endSection() ?>
