<?php
helper('form');

$errors      = session()->getFlashdata('errors') ?? [];
$pesan       = session()->getFlashdata('pesan');
$idTerpilih  = old('id_perusahaan');
$username    = old('username');
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('assets/img/apple-icon.png') ?>">
  <link rel="icon" type="image/png" href="<?= base_url('assets/img/favicon.png') ?>">
  <title>Login - PresensiKu</title>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Noto+Sans:300,400,500,600,700,800|PT+Mono:300,400,500,600,700" rel="stylesheet" />
  <link href="<?= base_url('assets/css/nucleo-icons.css') ?>" rel="stylesheet" />
  <link href="<?= base_url('assets/css/nucleo-svg.css') ?>" rel="stylesheet" />
  <link id="pagestyle" href="<?= base_url('assets/css/corporate-ui-dashboard.css?v=1.0.0') ?>" rel="stylesheet" />
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      min-height: 100vh;
      margin: 0;
      font-family: 'Noto Sans', sans-serif;
      background: #eef2ff;
    }

    .login-wrap {
      min-height: 100vh;
      display: flex;
      align-items: stretch;
    }

    .login-brand {
      position: relative;
      flex: 1 1 45%;
      background: linear-gradient(140deg, #111827 0%, #312e81 55%, #4f46e5 100%);
      color: #fff;
      padding: 56px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      overflow: hidden;
    }

    .login-brand::before,
    .login-brand::after {
      content: '';
      position: absolute;
      border-radius: 50%;
      background: rgba(255, 255, 255, .08);
    }

    .login-brand::before {
      width: 380px;
      height: 380px;
      right: -120px;
      top: -100px;
    }

    .login-brand::after {
      width: 260px;
      height: 260px;
      left: -90px;
      bottom: -80px;
      background: rgba(139, 92, 246, .22);
    }

    .brand-mark {
      width: 54px;
      height: 54px;
      border-radius: 16px;
      background: rgba(255, 255, 255, .14);
      border: 1px solid rgba(255, 255, 255, .18);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
      font-weight: 800;
      margin-bottom: 24px;
      backdrop-filter: blur(6px);
    }

    .login-brand h1 {
      font-size: 40px;
      font-weight: 800;
      line-height: 1.15;
      letter-spacing: -.5px;
      margin-bottom: 16px;
    }

    .login-brand p {
      color: #c7d2fe;
      font-size: 15px;
      max-width: 420px;
      line-height: 1.7;
    }

    .brand-features {
      display: flex;
      flex-direction: column;
      gap: 14px;
      margin-top: 32px;
    }

    .brand-feature {
      display: flex;
      align-items: center;
      gap: 12px;
      color: #e0e7ff;
      font-size: 13.5px;
    }

    .brand-feature span.dot {
      width: 30px;
      height: 30px;
      border-radius: 9px;
      background: rgba(255, 255, 255, .12);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 15px;
    }

    .login-panel {
      flex: 1 1 55%;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px 24px;
      background: #f8fafc;
    }

    .login-card {
      width: 100%;
      max-width: 430px;
      background: #fff;
      border: 1px solid #e8ecf3;
      border-radius: 22px;
      padding: 38px 34px;
      box-shadow: 0 24px 60px rgba(15, 23, 42, .10);
    }

    .login-card h3 {
      font-weight: 800;
      color: #0f172a;
      font-size: 25px;
      margin-bottom: 6px;
    }

    .login-card .subtitle {
      color: #64748b;
      font-size: 13.5px;
      margin-bottom: 26px;
    }

    .form-label {
      font-size: 12.5px;
      font-weight: 700;
      color: #334155;
      margin-bottom: 7px;
    }

    .input-icon {
      position: relative;
    }

    .input-icon .icon {
      position: absolute;
      left: 13px;
      top: 50%;
      transform: translateY(-50%);
      color: #94a3b8;
      pointer-events: none;
      display: inline-flex;
    }

    .input-icon .icon svg {
      width: 18px;
      height: 18px;
    }

    .input-icon .form-control,
    .input-icon .form-select {
      padding-left: 42px;
      height: 46px;
      border-radius: 11px;
      border-color: #dfe5ef;
      font-size: 14px;
    }

    .input-icon .toggle-password {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      border: 0;
      background: transparent;
      color: #94a3b8;
      cursor: pointer;
      padding: 4px;
    }

    .input-icon .form-select {
      appearance: none;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' fill='%2364748b' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 14px center;
    }

    .form-control:focus,
    .form-select:focus {
      border-color: #6366f1;
      box-shadow: 0 0 0 3px rgba(99, 102, 241, .13);
    }

    .btn-login {
      height: 48px;
      border-radius: 11px;
      background: linear-gradient(135deg, #4f46e5, #7c3aed);
      border: 0;
      color: #fff;
      font-weight: 700;
      font-size: 14.5px;
      letter-spacing: .2px;
      box-shadow: 0 12px 22px rgba(79, 70, 229, .28);
      transition: transform .15s ease, box-shadow .15s ease;
    }

    .btn-login:hover {
      transform: translateY(-1px);
      box-shadow: 0 16px 28px rgba(79, 70, 229, .34);
      color: #fff;
    }

    .btn-login:active {
      transform: translateY(0);
    }

    .alert {
      border-radius: 11px;
      font-size: 13px;
      border: 0;
    }

    .invalid-feedback {
      font-size: 12px;
      display: block;
    }

    .login-footer {
      margin-top: 26px;
      text-align: center;
      color: #94a3b8;
      font-size: 11.5px;
    }

    @media (max-width: 991.98px) {
      .login-brand {
        display: none;
      }

      .login-panel {
        background: linear-gradient(160deg, #111827 0%, #312e81 45%, #4f46e5 100%);
      }
    }
  </style>
</head>

<body>
  <div class="login-wrap">
    <section class="login-brand">
      <div>
        <div class="brand-mark">P</div>
        <h1>Presensi Karyawan<br>Lebih Mudah.</h1>
        <p>Kelola kehadiran, rekap, dan pengajuan cuti seluruh karyawan dalam satu dashboard yang rapi dan real-time.</p>
        <div class="brand-features">
          <div class="brand-feature"><span class="dot">&#10003;</span> Presensi masuk &amp; pulang berbasis lokasi</div>
          <div class="brand-feature"><span class="dot">&#10003;</span> Rekap harian dan bulanan otomatis</div>
          <div class="brand-feature"><span class="dot">&#10003;</span> Pengajuan izin, sakit, dan cuti</div>
        </div>
      </div>
      <div class="text-white-50 text-sm">&copy; <?= date('Y') ?> PresensiKu. Semua hak dilindungi.</div>
    </section>

    <section class="login-panel">
      <div class="login-card">
        <h3>Selamat datang</h3>
        <p class="subtitle">Masuk dengan perusahaan, username, dan password Anda.</p>

        <?php if ($pesan): ?>
          <div class="alert alert-danger py-2 px-3 mb-3"><?= esc($pesan) ?></div>
        <?php endif; ?>

        <?php if (! empty($errors)): ?>
          <div class="alert alert-danger py-2 px-3 mb-3">
            <?php foreach ($errors as $error): ?>
              <div><?= esc($error) ?></div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <form action="<?= base_url('login') ?>" method="POST" autocomplete="off">
          <?= csrf_field() ?>

          <div class="mb-3">
            <label class="form-label" for="id_perusahaan">Nama Perusahaan</label>
            <div class="input-icon">
              <span class="icon">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m1.5-6H13.5m-1.5 3H13.5m-1.5 3H13.5M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                </svg>
              </span>
              <select name="id_perusahaan" id="id_perusahaan" class="form-select <?= isset($errors['id_perusahaan']) ? 'is-invalid' : '' ?>">
                <option value="">-- Pilih Perusahaan --</option>
                <?php foreach ($perusahaan as $row): ?>
                  <option value="<?= $row['id'] ?>" <?= (string) $idTerpilih === (string) $row['id'] ? 'selected' : '' ?>>
                    <?= esc($row['nama_perusahaan']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <?php if (isset($errors['id_perusahaan'])): ?>
              <div class="text-danger small mt-1"><?= esc($errors['id_perusahaan']) ?></div>
            <?php endif; ?>
          </div>

          <div class="mb-3">
            <label class="form-label" for="username">Username</label>
            <div class="input-icon">
              <span class="icon">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
              </span>
              <input type="text" name="username" id="username" class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>" value="<?= esc($username) ?>" placeholder="Masukkan username">
            </div>
            <?php if (isset($errors['username'])): ?>
              <div class="text-danger small mt-1"><?= esc($errors['username']) ?></div>
            <?php endif; ?>
          </div>

          <div class="mb-4">
            <label class="form-label" for="password">Password</label>
            <div class="input-icon">
              <span class="icon">
                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                </svg>
              </span>
              <input type="password" name="password" id="password" class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" placeholder="Masukkan password">
              <button type="button" class="toggle-password" onclick="togglePassword()" aria-label="Tampilkan password">
                <svg id="eye-icon" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor" width="18" height="18">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
              </button>
            </div>
            <?php if (isset($errors['password'])): ?>
              <div class="text-danger small mt-1"><?= esc($errors['password']) ?></div>
            <?php endif; ?>
          </div>

          <button type="submit" class="btn btn-login w-100">Masuk ke Dashboard</button>
        </form>

        <div class="login-footer">
          Hubungi admin perusahaan jika lupa password atau akun belum aktif.
        </div>
      </div>
    </section>
  </div>

  <script>
    function togglePassword() {
      var input = document.getElementById('password');
      input.type = input.type === 'password' ? 'text' : 'password';
    }
  </script>
</body>

</html>
