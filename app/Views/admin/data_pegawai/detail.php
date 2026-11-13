<?= $this->extend('admin/layout.php') ?>
<?= $this->section('content') ?>

<div class="app-page-head">
  <div>
    <h2 class="app-title">Detail Data Pegawai</h2>
    <p class="app-subtitle">Informasi lengkap pegawai dan akun login.</p>
  </div>
  <div class="flex flex-wrap items-center gap-2">
    <a href="<?= base_url('admin/data_pegawai') ?>" class="app-btn-outline"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
    <a href="<?= base_url('admin/data_pegawai/edit/' . $data_pegawai['id']) ?>" class="app-btn-dark"><i class="fa-solid fa-pen"></i> Edit</a>
  </div>
</div>

<div class="grid grid-cols-1 gap-[26px] lg:grid-cols-8">
  <div class="lg:col-span-3">
    <div class="app-card h-full p-6 text-center">
      <?php $foto = $data_pegawai['foto'] ?: ''; ?>
      <img src="<?= $foto && is_file(FCPATH . 'profile/' . $foto) ? base_url('profile/' . $foto) : base_url('assets/img/team-1.jpg') ?>" class="mx-auto mb-4 h-24 w-24 rounded-2xl object-cover ring-4 ring-slate-50 shadow-sm" alt="Foto pegawai">
      <h3 class="text-[17px] font-bold text-slate-900"><?= esc($data_pegawai['nama']) ?></h3>
      <div class="mt-1 text-[11.5px] text-slate-400"><?= esc($data_pegawai['nip']) ?></div>
      <div class="mt-3"><?= badge_kehadiran($data_pegawai['status'] ?: 'Tidak Aktif') ?></div>

      <div class="mt-6 grid grid-cols-2 gap-3 text-left">
        <div class="rounded-xl bg-slate-50 p-3">
          <div class="text-[10px] font-bold uppercase tracking-wide text-slate-400">Role</div>
          <div class="mt-0.5 text-[12.5px] font-semibold text-slate-700"><?= esc($data_pegawai['role'] ?: '-') ?></div>
        </div>
        <div class="rounded-xl bg-slate-50 p-3">
          <div class="text-[10px] font-bold uppercase tracking-wide text-slate-400">Jabatan</div>
          <div class="mt-0.5 truncate text-[12.5px] font-semibold text-slate-700"><?= esc($data_pegawai['jabatan']) ?></div>
        </div>
      </div>
    </div>
  </div>

  <div class="lg:col-span-5">
    <div class="app-card h-full overflow-hidden">
      <div class="app-card-header">
        <h3 class="text-[14px] font-bold text-slate-900">Informasi Pegawai</h3>
      </div>
      <div class="p-6">
        <div class="grid grid-cols-1 gap-x-6 gap-y-5 sm:grid-cols-2">
          <div>
            <div class="text-[10px] font-bold uppercase tracking-[0.08em] text-slate-400">Nama Lengkap</div>
            <div class="mt-1 text-[13px] font-semibold text-slate-800"><?= esc($data_pegawai['nama']) ?></div>
          </div>
          <div>
            <div class="text-[10px] font-bold uppercase tracking-[0.08em] text-slate-400">NIP</div>
            <div class="mt-1 text-[13px] font-semibold text-slate-800"><?= esc($data_pegawai['nip']) ?></div>
          </div>
          <div>
            <div class="text-[10px] font-bold uppercase tracking-[0.08em] text-slate-400">Jenis Kelamin</div>
            <div class="mt-1 text-[13px] font-semibold text-slate-800"><?= esc($data_pegawai['jenis_kelamin']) ?></div>
          </div>
          <div>
            <div class="text-[10px] font-bold uppercase tracking-[0.08em] text-slate-400">No. Handphone</div>
            <div class="mt-1 text-[13px] font-semibold text-slate-800"><?= esc($data_pegawai['no_handphone']) ?></div>
          </div>
          <div class="sm:col-span-2">
            <div class="text-[10px] font-bold uppercase tracking-[0.08em] text-slate-400">Alamat</div>
            <div class="mt-1 text-[13px] font-semibold text-slate-800"><?= esc($data_pegawai['alamat']) ?></div>
          </div>
          <div>
            <div class="text-[10px] font-bold uppercase tracking-[0.08em] text-slate-400">Jabatan</div>
            <div class="mt-1 text-[13px] font-semibold text-slate-800"><?= esc($data_pegawai['jabatan']) ?></div>
          </div>
          <div>
            <div class="text-[10px] font-bold uppercase tracking-[0.08em] text-slate-400">Lokasi Presensi</div>
            <div class="mt-1 text-[13px] font-semibold text-slate-800"><?= esc($data_pegawai['nama_lokasi'] ?: $data_pegawai['lokasi_presensi']) ?></div>
          </div>
        </div>

        <hr class="my-6 border-slate-100">

        <h4 class="mb-4 text-[13px] font-bold text-slate-800">Akun Login</h4>
        <div class="grid grid-cols-1 gap-x-6 gap-y-5 sm:grid-cols-3">
          <div>
            <div class="text-[10px] font-bold uppercase tracking-[0.08em] text-slate-400">Username</div>
            <div class="mt-1 text-[13px] font-semibold text-slate-800"><?= esc($data_pegawai['username'] ?: '-') ?></div>
          </div>
          <div>
            <div class="text-[10px] font-bold uppercase tracking-[0.08em] text-slate-400">Role</div>
            <div class="mt-1 text-[13px] font-semibold text-slate-800"><?= esc($data_pegawai['role'] ?: '-') ?></div>
          </div>
          <div>
            <div class="text-[10px] font-bold uppercase tracking-[0.08em] text-slate-400">Perusahaan</div>
            <div class="mt-1 text-[13px] font-semibold text-slate-800"><?= esc($data_pegawai['nama_perusahaan'] ?: session()->get('nama_perusahaan')) ?></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
