<?php
helper('form');

$errors      = session()->getFlashdata('errors') ?? [];
$pesan       = session()->getFlashdata('pesan');
$idTerpilih  = old('id_perusahaan');
$username    = old('username');
?>
<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="theme-color" content="#4f46e5" />
  <link rel="icon" type="image/png" href="<?= base_url('assets/img/favicon.png') ?>">
  <title>Login - PresensiKu</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['"Plus Jakarta Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
          },
          colors: {
            brand: {
              50: '#eef2ff', 100: '#e0e7ff', 200: '#c7d2fe', 300: '#a5b4fc',
              400: '#818cf8', 500: '#6366f1', 600: '#4f46e5', 700: '#4338ca',
              800: '#3730a3', 900: '#312e81', 950: '#1e1b4b',
            },
          },
          boxShadow: {
            card: '0 1px 2px rgba(15,23,42,.04), 0 18px 40px -24px rgba(15,23,42,.18)',
          },
          transitionTimingFunction: {
            'out-expo': 'cubic-bezier(.16,1,.3,1)',
          },
        },
      },
    }
  </script>
</head>

<body class="min-h-full bg-[#f5f6fb] font-sans text-slate-800 antialiased">
  <div class="flex min-h-screen flex-col lg:flex-row">

    <!-- Brand panel -->
    <section class="relative hidden overflow-hidden bg-[#0b1220] p-[68px] text-white lg:flex lg:w-[45%] lg:flex-col lg:justify-between">
      <div class="pointer-events-none absolute -right-32 -top-28 h-96 w-96 rounded-full bg-brand-600/30 blur-2xl"></div>
      <div class="pointer-events-none absolute -left-24 bottom-0 h-72 w-72 rounded-full bg-violet-500/20 blur-2xl"></div>

      <div class="relative">
        <div class="flex items-center gap-3">
          <span class="grid h-12 w-12 place-items-center rounded-2xl bg-gradient-to-br from-brand-500 to-violet-500 text-xl font-extrabold shadow-lg shadow-brand-950/50">P</span>
          <div>
            <div class="text-[16px] font-bold leading-tight">PresensiKu</div>
            <div class="text-[10.5px] text-slate-400">Sistem Presensi Karyawan</div>
          </div>
        </div>

        <h1 class="mt-[68px] max-w-md text-[42px] font-extrabold leading-[1.12] tracking-tight">
          Presensi karyawan<br><span class="text-brand-300">lebih mudah.</span>
        </h1>
        <p class="mt-4 max-w-md text-[14px] leading-relaxed text-slate-400">
          Kelola kehadiran, rekap, dan pengajuan cuti seluruh karyawan dalam satu dashboard yang rapi dan real-time.
        </p>

        <ul class="mt-[42px] space-y-3 text-[13px] text-slate-300">
          <li class="flex items-center gap-3">
            <span class="grid h-8 w-8 place-items-center rounded-lg bg-white/5 text-brand-300 ring-1 ring-inset ring-white/10"><i class="fa-solid fa-location-crosshairs text-[12px]"></i></span>
            Presensi masuk &amp; pulang berbasis lokasi
          </li>
          <li class="flex items-center gap-3">
            <span class="grid h-8 w-8 place-items-center rounded-lg bg-white/5 text-brand-300 ring-1 ring-inset ring-white/10"><i class="fa-solid fa-chart-column text-[12px]"></i></span>
            Rekap harian dan bulanan otomatis
          </li>
          <li class="flex items-center gap-3">
            <span class="grid h-8 w-8 place-items-center rounded-lg bg-white/5 text-brand-300 ring-1 ring-inset ring-white/10"><i class="fa-solid fa-calendar-check text-[12px]"></i></span>
            Pengajuan izin, sakit, dan cuti
          </li>
        </ul>
      </div>

      <div class="relative text-[11px] text-slate-500">&copy; <?= date('Y') ?> PresensiKu. Semua hak dilindungi.</div>
    </section>

    <!-- Form panel -->
    <section class="flex flex-1 items-center justify-center px-6 py-10 sm:px-10 lg:px-[68px]">
      <div class="w-full max-w-md">
        <!-- Mobile brand -->
        <div class="mb-6 flex items-center gap-3 lg:hidden">
          <span class="grid h-11 w-11 place-items-center rounded-2xl bg-gradient-to-br from-brand-500 to-violet-500 text-lg font-extrabold text-white shadow-lg shadow-brand-600/25">P</span>
          <div>
            <div class="text-[15px] font-bold leading-tight text-slate-900">PresensiKu</div>
            <div class="text-[10.5px] text-slate-400">Sistem Presensi Karyawan</div>
          </div>
        </div>

        <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-card sm:p-9">
          <h2 class="text-[26px] font-extrabold leading-tight tracking-tight text-slate-900">Selamat datang</h2>
          <p class="mt-1.5 text-[13px] text-slate-500">Masuk dengan perusahaan, username, dan password Anda.</p>

          <?php if ($pesan): ?>
            <div class="mt-5 rounded-xl bg-rose-50 px-4 py-3 text-[12.5px] text-rose-700 ring-1 ring-inset ring-rose-600/10"><?= esc($pesan) ?></div>
          <?php endif; ?>

          <?php if (! empty($errors)): ?>
            <div class="mt-5 space-y-1 rounded-xl bg-rose-50 px-4 py-3 text-[12.5px] text-rose-700 ring-1 ring-inset ring-rose-600/10">
              <?php foreach ($errors as $error): ?>
                <div><?= esc($error) ?></div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>

          <form action="<?= base_url('login') ?>" method="POST" autocomplete="off" class="mt-6 space-y-4">
            <?= csrf_field() ?>

            <div>
              <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.08em] text-slate-500" for="id_perusahaan">Nama Perusahaan</label>
              <div class="relative">
                <span class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400">
                  <i class="fa-regular fa-building text-[14px]"></i>
                </span>
                <select name="id_perusahaan" id="id_perusahaan"
                  class="h-11 w-full appearance-none rounded-xl border border-slate-200 bg-white pl-10 pr-10 text-[13.5px] text-slate-800 outline-none transition focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10">
                  <option value="">-- Pilih Perusahaan --</option>
                  <?php foreach ($perusahaan as $row): ?>
                    <option value="<?= $row['id'] ?>" <?= (string) $idTerpilih === (string) $row['id'] ? 'selected' : '' ?>>
                      <?= esc($row['nama_perusahaan']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
                <span class="pointer-events-none absolute right-3.5 top-1/2 -translate-y-1/2 text-[10px] text-slate-400"><i class="fa-solid fa-chevron-down"></i></span>
              </div>
              <?php if (isset($errors['id_perusahaan'])): ?>
                <div class="mt-1.5 text-[11.5px] font-medium text-rose-600"><?= esc($errors['id_perusahaan']) ?></div>
              <?php endif; ?>
            </div>

            <div>
              <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.08em] text-slate-500" for="username">Username</label>
              <div class="relative">
                <span class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400">
                  <i class="fa-regular fa-user text-[14px]"></i>
                </span>
                <input type="text" name="username" id="username" value="<?= esc($username) ?>"
                  class="h-11 w-full rounded-xl border border-slate-200 bg-white pl-10 pr-3.5 text-[13.5px] text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10"
                  placeholder="Masukkan username" autocomplete="username">
              </div>
              <?php if (isset($errors['username'])): ?>
                <div class="mt-1.5 text-[11.5px] font-medium text-rose-600"><?= esc($errors['username']) ?></div>
              <?php endif; ?>
            </div>

            <div>
              <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.08em] text-slate-500" for="password">Password</label>
              <div class="relative">
                <span class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400">
                  <i class="fa-solid fa-lock text-[14px]"></i>
                </span>
                <input type="password" name="password" id="password"
                  class="h-11 w-full rounded-xl border border-slate-200 bg-white pl-10 pr-11 text-[13.5px] text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10"
                  placeholder="Masukkan password" autocomplete="current-password">
                <button type="button" id="togglePassword" aria-label="Tampilkan password"
                  class="absolute right-2.5 top-1/2 grid h-7 w-7 -translate-y-1/2 place-items-center rounded-md text-slate-400 transition hover:bg-slate-100 hover:text-slate-600 focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                  <i class="fa-regular fa-eye text-[13px]"></i>
                </button>
              </div>
              <?php if (isset($errors['password'])): ?>
                <div class="mt-1.5 text-[11.5px] font-medium text-rose-600"><?= esc($errors['password']) ?></div>
              <?php endif; ?>
            </div>

            <button type="submit"
              class="mt-2 inline-flex h-12 w-full items-center justify-center gap-2 rounded-xl bg-brand-600 text-[13.5px] font-bold text-white shadow-lg shadow-brand-600/25 transition duration-200 hover:bg-brand-700 focus:outline-none focus:ring-4 focus:ring-brand-500/20">
              <i class="fa-solid fa-arrow-right-to-bracket"></i> Masuk ke Dashboard
            </button>
          </form>

          <div class="mt-6 border-t border-slate-100 pt-4 text-center text-[11.5px] text-slate-400">
            Hubungi admin perusahaan jika lupa password atau akun belum aktif.
          </div>
        </div>
      </div>
    </section>
  </div>

  <script>
    (function () {
      var btn   = document.getElementById('togglePassword');
      var input = document.getElementById('password');
      if (!btn || !input) return;

      btn.addEventListener('click', function () {
        var show = input.type === 'password';
        input.type = show ? 'text' : 'password';
        btn.setAttribute('aria-label', show ? 'Sembunyikan password' : 'Tampilkan password');
        btn.innerHTML = '<i class="fa-regular ' + (show ? 'fa-eye-slash' : 'fa-eye') + ' text-[13px]"></i>';
        input.focus();
      });
    })();
  </script>
</body>

</html>
