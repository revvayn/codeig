<?= $this->extend($layout) ?>
<?= $this->section('content') ?>
<?php
$errors     = session()->getFlashdata('errors') ?? [];
$fotoName   = $pegawai['foto'] ?? session()->get('foto_pegawai');
$avatar     = foto_profil_url($fotoName);
$namaTampil = $pegawai['nama'] ?? session()->get('nama_pegawai') ?? $user['username'];
$prefix     = $user['role'] === 'Superadmin' ? 'superadmin' : ($user['role'] === 'Pegawai' ? 'pegawai' : 'admin');
?>

<div class="app-page-head">
  <div>
    <h2 class="app-title">Profil Saya</h2>
    <p class="app-subtitle">Perbarui data akun dan informasi pribadi Anda.</p>
  </div>
  <span class="inline-flex items-center gap-2 self-start rounded-full border border-brand-100 bg-brand-50 px-3.5 py-2 text-[11.5px] font-bold text-brand-700 sm:self-auto">
    <i class="fa-solid fa-user-shield"></i> <?= esc($user['role']) ?>
  </span>
</div>

<?php if (! empty($errors)): ?>
  <div class="mb-[26px] rounded-xl bg-rose-50 px-4 py-3 text-[12.5px] text-rose-700 ring-1 ring-inset ring-rose-600/10">
    <?php foreach ($errors as $error): ?><div><?= esc($error) ?></div><?php endforeach; ?>
  </div>
<?php endif; ?>

<form action="<?= base_url($prefix . '/profile/update') ?>" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 gap-[26px] lg:grid-cols-12">
  <?= csrf_field() ?>

  <!-- Kartu foto -->
  <div class="lg:col-span-4">
    <div class="app-card flex h-full flex-col overflow-hidden">
      <div class="app-card-header">
        <div class="flex items-center gap-2.5">
          <span class="grid h-8 w-8 place-items-center rounded-lg bg-brand-50 text-brand-600"><i class="fa-solid fa-camera text-[11px]"></i></span>
          <div>
            <h3 class="text-[14px] font-bold text-slate-900">Foto Profil</h3>
            <p class="mt-0.5 text-[11px] text-slate-400">Dipakai juga untuk presensi</p>
          </div>
        </div>
      </div>
      <div class="flex flex-1 flex-col p-5">
        <div class="relative mx-auto w-full max-w-[220px] overflow-hidden rounded-2xl bg-slate-100 ring-1 ring-slate-200">
          <img id="previewFoto" src="<?= esc($avatar) ?>" alt="Foto profil" class="aspect-[4/5] w-full object-cover">
        </div>
        <div class="mt-4 text-center">
          <div class="text-[15px] font-bold text-slate-900"><?= esc($namaTampil) ?></div>
          <div class="mt-0.5 text-[11.5px] text-slate-400">
            <?= esc($pegawai['jabatan'] ?? $user['role']) ?>
            <?php if (! empty($pegawai['nip'])): ?> &middot; NIP <?= esc($pegawai['nip']) ?><?php endif; ?>
          </div>
        </div>
        <?php if ($pegawai): ?>
          <div class="mt-5">
            <label class="app-label">Ganti Foto <span class="font-medium normal-case text-slate-400">(opsional)</span></label>
            <input type="file" id="inputFoto" name="foto" class="app-input pt-2.5 text-[12px] file:mr-3 file:rounded-md file:border-0 file:bg-brand-50 file:px-2.5 file:py-1 file:text-[11px] file:font-semibold file:text-brand-700" accept="image/jpeg,image/png,image/webp">
            <p class="app-help">JPG, PNG, atau WEBP. Maksimal 10 MB.</p>
          </div>
        <?php else: ?>
          <p class="mt-5 rounded-xl bg-slate-50 px-3.5 py-3 text-[11.5px] leading-relaxed text-slate-400">
            Akun ini tidak terhubung ke data pegawai, jadi foto profil belum tersedia.
          </p>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Form data -->
  <div class="space-y-[26px] lg:col-span-8">
    <div class="app-card p-6">
      <section>
        <h3 class="mb-4 flex items-center gap-2 text-[13px] font-bold text-slate-800">
          <span class="grid h-7 w-7 place-items-center rounded-lg bg-brand-50 text-brand-600"><i class="fa-solid fa-key text-[10px]"></i></span>
          Data Akun
        </h3>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
          <div>
            <label class="app-label">Username <span class="text-rose-500">*</span></label>
            <input type="text" name="username" class="app-input" value="<?= esc(old('username', $user['username'])) ?>" required>
            <p class="app-help">Minimal 3 karakter, huruf dan angka.</p>
          </div>
          <div>
            <label class="app-label">Role</label>
            <input type="text" class="app-input bg-slate-50 text-slate-500" value="<?= esc($user['role']) ?>" readonly>
          </div>
          <div>
            <label class="app-label">Password Baru <span class="font-medium normal-case text-slate-400">(kosongkan jika tidak diubah)</span></label>
            <div class="relative">
              <input type="password" id="inputPassword" name="password" class="app-input pr-11" placeholder="Password baru" autocomplete="new-password">
              <button type="button" class="password-toggle absolute right-2 top-1/2 grid h-8 w-8 -translate-y-1/2 place-items-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-600" data-target="inputPassword" aria-label="Tampilkan password">
                <i class="fa-regular fa-eye text-[12px]"></i>
              </button>
            </div>
            <p class="app-help">Minimal 5 karakter.</p>
          </div>
          <div>
            <label class="app-label">Konfirmasi Password</label>
            <div class="relative">
              <input type="password" id="inputKonfirmasi" name="konfirmasi_password" class="app-input pr-11" placeholder="Ulangi password baru" autocomplete="new-password">
              <button type="button" class="password-toggle absolute right-2 top-1/2 grid h-8 w-8 -translate-y-1/2 place-items-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-600" data-target="inputKonfirmasi" aria-label="Tampilkan password">
                <i class="fa-regular fa-eye text-[12px]"></i>
              </button>
            </div>
          </div>
        </div>
      </section>

      <?php if ($pegawai): ?>
        <hr class="my-6 border-slate-100">

        <section>
          <h3 class="mb-4 flex items-center gap-2 text-[13px] font-bold text-slate-800">
            <span class="grid h-7 w-7 place-items-center rounded-lg bg-brand-50 text-brand-600"><i class="fa-solid fa-id-card text-[10px]"></i></span>
            Data Pribadi
          </h3>
          <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
              <label class="app-label">Nama Lengkap <span class="text-rose-500">*</span></label>
              <input type="text" name="nama" class="app-input" value="<?= esc(old('nama', $pegawai['nama'])) ?>" required>
            </div>
            <div>
              <label class="app-label">No. Handphone <span class="text-rose-500">*</span></label>
              <input type="text" name="no_handphone" class="app-input" value="<?= esc(old('no_handphone', $pegawai['no_handphone'])) ?>" required>
            </div>
            <div class="sm:col-span-2">
              <label class="app-label">Alamat <span class="text-rose-500">*</span></label>
              <textarea name="alamat" class="app-textarea" rows="2" required><?= esc(old('alamat', $pegawai['alamat'])) ?></textarea>
            </div>
            <div>
              <label class="app-label">NIP</label>
              <input type="text" class="app-input bg-slate-50 text-slate-500" value="<?= esc($pegawai['nip'] ?? '-') ?>" readonly>
            </div>
            <div>
              <label class="app-label">Jabatan</label>
              <input type="text" class="app-input bg-slate-50 text-slate-500" value="<?= esc($pegawai['jabatan'] ?? '-') ?>" readonly>
            </div>
          </div>
          <p class="app-help">NIP, jabatan, dan lokasi presensi hanya dapat diubah oleh admin perusahaan.</p>
        </section>
      <?php endif; ?>

      <div class="mt-6 flex flex-col-reverse gap-2 border-t border-slate-100 pt-5 sm:flex-row sm:items-center sm:justify-end">
        <a href="<?= base_url($prefix . '/home') ?>" class="app-btn-ghost">Batal</a>
        <button type="submit" class="app-btn-primary">
          <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
        </button>
      </div>
    </div>
  </div>
</form>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
  (function () {
    document.querySelectorAll('.password-toggle').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var input = document.getElementById(btn.dataset.target);
        if (!input) return;
        var show = input.type === 'password';
        input.type = show ? 'text' : 'password';
        btn.innerHTML = show
          ? '<i class="fa-regular fa-eye-slash text-[12px]"></i>'
          : '<i class="fa-regular fa-eye text-[12px]"></i>';
      });
    });

    var inputFoto = document.getElementById('inputFoto');
    var preview   = document.getElementById('previewFoto');
    inputFoto && inputFoto.addEventListener('change', function () {
      var file = inputFoto.files && inputFoto.files[0];
      if (!file || !preview) return;
      preview.src = URL.createObjectURL(file);
    });
  })();
</script>
<?= $this->endSection() ?>
