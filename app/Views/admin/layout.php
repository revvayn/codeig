<?php
$uri        = uri_string();
$flashError = session()->getFlashdata('error');
$flashSuccess = session()->getFlashdata('success');
$foto       = session()->get('foto_pegawai');
$avatar     = (! empty($foto) && is_file(FCPATH . 'profile/' . $foto))
    ? base_url('profile/' . $foto)
    : base_url('assets/img/team-1.jpg');
$is = static fn (string $prefix): string => str_starts_with($uri, $prefix) ? 'active' : '';
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('assets/img/apple-icon.png') ?>">
  <link rel="icon" type="image/png" href="<?= base_url('assets/img/favicon.png') ?>">
  <title><?= esc($title ?? 'Dashboard') ?> - PresensiKu</title>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Noto+Sans:300,400,500,600,700,800|PT+Mono:300,400,500,600,700" rel="stylesheet" />
  <link href="<?= base_url('assets/css/nucleo-icons.css') ?>" rel="stylesheet" />
  <link href="<?= base_url('assets/css/nucleo-svg.css') ?>" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
  <link id="pagestyle" href="<?= base_url('assets/css/corporate-ui-dashboard.css?v=1.0.0') ?>" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.css" />
  <style>
    :root {
      --brand: #111827;
      --brand-soft: #1f2937;
      --accent: #4f46e5;
      --accent-soft: #eef2ff;
    }

    body {
      background: #f4f6fb;
    }

    .app-sidenav {
      background: linear-gradient(180deg, #111827 0%, #1e293b 100%);
      width: 250px;
      box-shadow: 4px 0 24px rgba(15, 23, 42, .08);
    }

    .app-sidenav .sidenav-header {
      padding: 22px 20px 18px;
      border-bottom: 1px solid rgba(255, 255, 255, .08);
    }

    .brand-icon {
      width: 42px;
      height: 42px;
      border-radius: 12px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, #6366f1, #8b5cf6);
      color: #fff;
      font-weight: 800;
      font-size: 18px;
      margin-right: 12px;
      box-shadow: 0 8px 18px rgba(99, 102, 241, .35);
    }

    .brand-title {
      display: block;
      color: #fff;
      font-weight: 700;
      font-size: 16px;
      line-height: 1.2;
      letter-spacing: .2px;
    }

    .brand-company {
      display: block;
      color: #94a3b8;
      font-size: 11px;
      max-width: 160px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .app-sidenav .nav-link {
      color: #cbd5e1;
      border-radius: 10px;
      margin: 2px 0;
      padding: 10px 12px;
      font-size: 13.5px;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 10px;
      transition: all .18s ease;
    }

    .app-sidenav .nav-link:hover {
      background: rgba(255, 255, 255, .07);
      color: #fff;
    }

    .app-sidenav .nav-link.active {
      background: linear-gradient(90deg, rgba(99, 102, 241, .95), rgba(139, 92, 246, .85));
      color: #fff;
      box-shadow: 0 8px 18px rgba(79, 70, 229, .28);
    }

    .app-sidenav .nav-link svg {
      width: 18px;
      height: 18px;
      flex: 0 0 18px;
    }

    .app-sidenav .sidenav-label {
      color: #64748b;
      font-size: 10.5px;
      letter-spacing: 1.2px;
      text-transform: uppercase;
      font-weight: 700;
      margin: 18px 10px 8px;
    }

    .app-sidenav .collapse .nav-link {
      font-size: 12.8px;
      padding: 8px 12px 8px 20px;
      color: #94a3b8;
    }

    .app-sidenav .collapse .nav-link.active {
      background: rgba(99, 102, 241, .18);
      color: #fff;
      box-shadow: none;
    }

    .nav-chevron {
      margin-left: auto;
      font-size: 10px;
      opacity: .6;
      transition: transform .2s ease;
    }

    .nav-link[aria-expanded="true"] .nav-chevron {
      transform: rotate(180deg);
    }

    .main-content {
      margin-left: 250px;
    }

    @media (max-width: 1199.98px) {
      .main-content {
        margin-left: 0;
      }
    }

    .navbar-main {
      background: transparent;
    }

    .company-pill {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: #fff;
      border: 1px solid #e5e7eb;
      border-radius: 999px;
      padding: 7px 14px;
      font-size: 12px;
      font-weight: 600;
      color: #334155;
      box-shadow: 0 4px 12px rgba(15, 23, 42, .04);
    }

    .company-pill svg {
      width: 14px;
      height: 14px;
      color: #6366f1;
    }

    .content-header {
      display: flex;
      align-items: flex-end;
      justify-content: space-between;
      gap: 16px;
      flex-wrap: wrap;
      margin-bottom: 18px;
    }

    .content-header h3 {
      font-size: 22px;
      font-weight: 800;
      color: #0f172a;
      margin: 0;
    }

    .content-header p {
      margin: 4px 0 0;
      color: #64748b;
      font-size: 13px;
    }

    .card {
      border: 1px solid #e8ecf3;
      border-radius: 16px;
      box-shadow: 0 8px 24px rgba(15, 23, 42, .04);
    }

    .stat-card .icon {
      width: 46px;
      height: 46px;
      border-radius: 12px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 14px;
    }

    .stat-card .icon svg {
      width: 22px;
      height: 22px;
    }

    .stat-card .stat-value {
      font-size: 26px;
      font-weight: 800;
      color: #0f172a;
      line-height: 1;
    }

    .stat-card .stat-label {
      color: #64748b;
      font-size: 12.5px;
      font-weight: 600;
    }

    .table thead th {
      background: #f8fafc;
      color: #64748b;
      font-size: 11px;
      text-transform: uppercase;
      letter-spacing: .5px;
      border-bottom: 1px solid #e8ecf3;
      white-space: nowrap;
    }

    .table tbody td {
      vertical-align: middle;
      font-size: 13px;
      color: #334155;
      border-bottom: 1px solid #f1f5f9;
    }

    .table tbody tr:hover {
      background: #fafbff;
    }

    .avatar {
      object-fit: cover;
      border-radius: 50%;
    }

    .avatar-sm {
      width: 38px;
      height: 38px;
    }

    .avatar-lg {
      width: 96px;
      height: 96px;
    }

    .btn {
      border-radius: 10px;
      font-weight: 600;
      font-size: 13px;
    }

    .btn-dark {
      background: #111827;
      border-color: #111827;
    }

    .btn-dark:hover {
      background: #1f2937;
      border-color: #1f2937;
    }

    .badge {
      padding: 6px 10px;
      border-radius: 999px;
      font-weight: 600;
      font-size: 11px;
    }

    .form-control,
    .form-select {
      border-radius: 10px;
      border-color: #dfe5ef;
      font-size: 13.5px;
      padding: 10px 12px;
    }

    .form-control:focus,
    .form-select:focus {
      border-color: #6366f1;
      box-shadow: 0 0 0 3px rgba(99, 102, 241, .12);
    }

    .form-label {
      font-size: 12.5px;
      font-weight: 700;
      color: #475569;
      margin-bottom: 6px;
    }

    .page-footer {
      color: #94a3b8;
      font-size: 12px;
      padding: 20px 0 8px;
      text-align: center;
    }

    .empty-state {
      padding: 36px 16px;
      text-align: center;
      color: #94a3b8;
    }

    .empty-state svg {
      width: 42px;
      height: 42px;
      margin-bottom: 10px;
      opacity: .5;
    }

    .progress-soft {
      height: 8px;
      border-radius: 999px;
      background: #eef2ff;
    }
  </style>
  <?= $this->renderSection('styles') ?>
</head>

<body class="g-sidenav-show bg-gray-100">
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 fixed-start app-sidenav" id="sidenav-main">
    <div class="sidenav-header d-flex align-items-center">
      <a class="navbar-brand m-0 d-flex align-items-center" href="<?= base_url('admin/home') ?>">
        <span class="brand-icon">P</span>
        <span class="brand-text">
          <span class="brand-title">PresensiKu</span>
          <span class="brand-company"><?= esc(session()->get('nama_perusahaan') ?? 'Perusahaan') ?></span>
        </span>
      </a>
    </div>

    <div class="px-3 pt-2 pb-4 w-auto">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link <?= $is('admin/home') ?>" href="<?= base_url('admin/home') ?>">
            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h3.75c.621 0 1.125-.504 1.125-1.125V9.75" />
            </svg>
            <span>Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $is('admin/data_pegawai') ?>" href="<?= base_url('admin/data_pegawai') ?>">
            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
            </svg>
            <span>Data Pegawai</span>
          </a>
        </li>

        <li class="sidenav-label">Kehadiran</li>
        <li class="nav-item">
          <a class="nav-link <?= ($is('admin/rekap')) ? 'active' : '' ?>" data-bs-toggle="collapse" href="#menuRekap" role="button" aria-expanded="<?= $is('admin/rekap') ? 'true' : 'false' ?>" aria-controls="menuRekap">
            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
            </svg>
            <span>Rekap Kehadiran</span>
            <span class="nav-chevron">â–¼</span>
          </a>
          <div class="collapse <?= $is('admin/rekap') ? 'show' : '' ?>" id="menuRekap">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link <?= $is('admin/rekap/harian') ?>" href="<?= base_url('admin/rekap/harian') ?>">Rekap Harian</a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?= $is('admin/rekap/bulanan') ?>" href="<?= base_url('admin/rekap/bulanan') ?>">Rekap Bulanan</a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $is('admin/ketidakhadiran') ?>" href="<?= base_url('admin/ketidakhadiran') ?>">
            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z" />
            </svg>
            <span>Ketidakhadiran</span>
          </a>
        </li>

        <li class="sidenav-label">Master Data</li>
        <li class="nav-item">
          <a class="nav-link <?= $is('admin/jabatan') || $is('admin/lokasi_presensi') || $is('admin/perusahaan') ? 'active' : '' ?>" data-bs-toggle="collapse" href="#menuMaster" role="button" aria-expanded="<?= ($is('admin/jabatan') || $is('admin/lokasi_presensi') || $is('admin/perusahaan')) ? 'true' : 'false' ?>" aria-controls="menuMaster">
            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 5.625c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
            </svg>
            <span>Master Data</span>
            <span class="nav-chevron">â–¼</span>
          </a>
          <div class="collapse <?= ($is('admin/jabatan') || $is('admin/lokasi_presensi') || $is('admin/perusahaan')) ? 'show' : '' ?>" id="menuMaster">
            <ul class="navbar-nav">
              <li class="nav-item"><a class="nav-link <?= $is('admin/jabatan') ?>" href="<?= base_url('admin/jabatan') ?>">Data Jabatan</a></li>
              <li class="nav-item"><a class="nav-link <?= $is('admin/lokasi_presensi') ?>" href="<?= base_url('admin/lokasi_presensi') ?>">Lokasi Presensi</a></li>
              <li class="nav-item"><a class="nav-link <?= $is('admin/perusahaan') ?>" href="<?= base_url('admin/perusahaan') ?>">Data Perusahaan</a></li>
            </ul>
          </div>
        </li>
      </ul>
    </div>
  </aside>

  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <nav class="navbar navbar-main navbar-expand-lg mx-3 mx-lg-4 px-0 shadow-none rounded" id="navbarBlur">
      <div class="container-fluid py-2 px-2">
        <div class="d-flex align-items-center gap-2">
          <i class="fas fa-bars cursor-pointer d-xl-none me-1" id="iconSidenav" aria-hidden="true"></i>
          <div>
            <h6 class="mb-0 font-weight-bold text-dark"><?= esc($title ?? 'Dashboard') ?></h6>
            <small class="text-secondary d-none d-sm-block">Sistem Presensi Karyawan</small>
          </div>
        </div>
        <div class="ms-auto d-flex align-items-center gap-3">
          <span class="company-pill d-none d-md-inline-flex">
            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m1.5-6H13.5m-1.5 3H13.5m-1.5 3H13.5M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
            </svg>
            <?= esc(session()->get('nama_perusahaan') ?? '-') ?>
          </span>
          <div class="dropdown">
            <a href="#" class="d-flex align-items-center gap-2 text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false">
              <img src="<?= $avatar ?>" class="avatar avatar-sm" alt="avatar" />
              <span class="d-none d-md-block text-start">
                <span class="d-block text-sm font-weight-bold text-dark"><?= esc(session()->get('nama_pegawai') ?? session()->get('username')) ?></span>
                <span class="d-block text-xs text-secondary"><?= esc(session()->get('role_id')) ?></span>
              </span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end mt-2 shadow border-0">
              <li class="px-3 py-2">
                <div class="text-xs text-secondary">Login sebagai</div>
                <div class="text-sm font-weight-bold"><?= esc(session()->get('username')) ?></div>
              </li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <a class="dropdown-item text-danger" href="<?= base_url('logout') ?>">
                  <i class="fas fa-sign-out-alt me-2"></i>Logout
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>

    <div class="container-fluid py-3 px-3 px-lg-4">
      <?php if ($flashError): ?>
        <div class="alert alert-danger alert-dismissible fade show border-0" role="alert">
          <i class="fas fa-exclamation-circle me-2"></i><?= esc($flashError) ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>
      <?= $this->renderSection('content') ?>
      <div class="page-footer">PresensiKu &copy; <?= date('Y') ?> - <?= esc(session()->get('nama_perusahaan') ?? '') ?></div>
    </div>
  </main>

  <script src="<?= base_url('assets/js/core/popper.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/core/bootstrap.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/plugins/perfect-scrollbar.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/plugins/smooth-scrollbar.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/corporate-ui-dashboard.min.js?v=1.0.0') ?>"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdn.datatables.net/2.3.4/js/dataTables.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    $(function() {
      if ($.fn.dataTable) {
        $.fn.dataTable.ext.errMode = 'none';
      }
      if ($.fn.DataTable && $('#datatables').length) {
        $('#datatables').DataTable({
          responsive: true,
          pagingType: 'simple_numbers',
          language: {
            search: 'Cari:',
            lengthMenu: 'Tampilkan _MENU_ data',
            info: 'Menampilkan _START_ - _END_ dari _TOTAL_ data',
            infoEmpty: 'Tidak ada data',
            zeroRecords: 'Data tidak ditemukan',
            paginate: {
              previous: 'Sebelumnya',
              next: 'Berikutnya'
            }
          }
        });
      }

      <?php if ($flashSuccess): ?>
        Swal.fire({
          toast: true,
          position: 'top-end',
          icon: 'success',
          title: <?= json_encode($flashSuccess) ?>,
          showConfirmButton: false,
          timer: 3200,
          timerProgressBar: true
        });
      <?php endif; ?>

      <?php if ($flashError): ?>
        Swal.fire({
          toast: true,
          position: 'top-end',
          icon: 'error',
          title: <?= json_encode($flashError) ?>,
          showConfirmButton: false,
          timer: 4200,
          timerProgressBar: true
        });
      <?php endif; ?>

      $('.tombol-hapus').on('click', function(e) {
        e.preventDefault();
        var link = $(this).attr('href');
        Swal.fire({
          title: 'Apakah Anda yakin?',
          text: 'Data akan dihapus secara permanen!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#dc2626',
          cancelButtonColor: '#64748b',
          confirmButtonText: 'Ya, hapus',
          cancelButtonText: 'Batal'
        }).then(function(result) {
          if (result.isConfirmed) {
            window.location.href = link;
          }
        });
      });
    });
  </script>
  <?= $this->renderSection('scripts') ?>
</body>

</html>
