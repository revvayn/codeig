<?= $this->extend('admin/layout.php') ?>
<?= $this->section('content') ?>

<div class="app-page-head">
  <div>
    <h2 class="app-title">Import Pegawai (CSV)</h2>
    <p class="app-subtitle">Unggah file CSV sesuai template yang tersedia.</p>
  </div>
  <a href="<?= base_url('admin/data_pegawai') ?>" class="app-btn-outline"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
</div>

<div class="grid grid-cols-1 gap-[26px] lg:grid-cols-8">
  <div class="lg:col-span-5">
    <div class="app-card p-6">
      <?php if (session()->getFlashdata('success')): ?>
        <div class="mb-5 rounded-xl bg-emerald-50 px-4 py-3 text-[12.5px] text-emerald-700 ring-1 ring-inset ring-emerald-600/10"><?= esc(session()->getFlashdata('success')) ?></div>
      <?php endif; ?>
      <?php if (session()->getFlashdata('error')): ?>
        <div class="mb-5 rounded-xl bg-rose-50 px-4 py-3 text-[12.5px] text-rose-700 ring-1 ring-inset ring-rose-600/10"><?= esc(session()->getFlashdata('error')) ?></div>
      <?php endif; ?>

      <form action="<?= base_url('admin/data_pegawai/import/store') ?>" method="POST" enctype="multipart/form-data" class="space-y-5">
        <?= csrf_field() ?>
        <div>
          <label class="app-label">File CSV</label>
          <input type="file" name="file" class="app-input pt-2.5 text-[12px] file:mr-3 file:rounded-md file:border-0 file:bg-brand-50 file:px-2.5 file:py-1 file:text-[11px] file:font-semibold file:text-brand-700" accept=".csv" required>
          <p class="app-help">Format: CSV dengan pemisah koma, sesuai template resmi.</p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
          <button type="submit" class="app-btn-primary"><i class="fa-solid fa-upload"></i> Import</button>
          <a href="<?= base_url('admin/data_pegawai/import/template') ?>" class="app-btn-outline"><i class="fa-solid fa-download"></i> Download Template</a>
        </div>
      </form>
    </div>
  </div>

  <div class="lg:col-span-3">
    <div class="app-card p-6">
      <h3 class="mb-4 flex items-center gap-2 text-[13px] font-bold text-slate-800">
        <span class="grid h-7 w-7 place-items-center rounded-lg bg-amber-50 text-amber-600"><i class="fa-solid fa-lightbulb text-[10px]"></i></span>
        Panduan
      </h3>
      <ul class="space-y-3 text-[12.5px] leading-relaxed text-slate-500">
        <li class="flex gap-2.5"><i class="fa-solid fa-check mt-1 text-[9px] text-emerald-500"></i> Unduh template terlebih dahulu.</li>
        <li class="flex gap-2.5"><i class="fa-solid fa-check mt-1 text-[9px] text-emerald-500"></i> Isi data sesuai urutan kolom template.</li>
        <li class="flex gap-2.5"><i class="fa-solid fa-check mt-1 text-[9px] text-emerald-500"></i> Pastikan username unik untuk setiap pegawai.</li>
        <li class="flex gap-2.5"><i class="fa-solid fa-check mt-1 text-[9px] text-emerald-500"></i> Simpan file dengan encoding UTF-8.</li>
      </ul>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
