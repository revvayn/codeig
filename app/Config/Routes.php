<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::index');
$routes->post('login', 'Login::login_action');
$routes->get('logout', 'Login::logout');

// ---------------------------------------------------------------------------
// Area Admin
// ---------------------------------------------------------------------------
$routes->group('admin', ['filter' => 'adminfilter'], static function ($routes) {
    $routes->get('home', 'Admin\Home::index');

    // Data Pegawai
    $routes->get('data_pegawai', 'Admin\DataPegawai::index');
    $routes->get('data_pegawai/create', 'Admin\DataPegawai::create');
    $routes->post('data_pegawai/store', 'Admin\DataPegawai::store');
    $routes->get('data_pegawai/edit/(:segment)', 'Admin\DataPegawai::edit/$1');
    $routes->post('data_pegawai/update/(:segment)', 'Admin\DataPegawai::update/$1');
    $routes->get('data_pegawai/delete/(:num)', 'Admin\DataPegawai::delete/$1');
    $routes->get('data_pegawai/detail/(:segment)', 'Admin\DataPegawai::detail/$1');

    // Jabatan
    $routes->get('jabatan', 'Admin\Jabatan::index');
    $routes->get('jabatan/create', 'Admin\Jabatan::create');
    $routes->post('jabatan/store', 'Admin\Jabatan::store');
    $routes->get('jabatan/edit/(:segment)', 'Admin\Jabatan::edit/$1');
    $routes->post('jabatan/update/(:segment)', 'Admin\Jabatan::update/$1');
    $routes->get('jabatan/delete/(:num)', 'Admin\Jabatan::delete/$1');

    // Lokasi Presensi
    $routes->get('lokasi_presensi', 'Admin\LokasiPresensi::index');
    $routes->get('lokasi_presensi/create', 'Admin\LokasiPresensi::create');
    $routes->post('lokasi_presensi/store', 'Admin\LokasiPresensi::store');
    $routes->get('lokasi_presensi/edit/(:segment)', 'Admin\LokasiPresensi::edit/$1');
    $routes->post('lokasi_presensi/update/(:segment)', 'Admin\LokasiPresensi::update/$1');
    $routes->get('lokasi_presensi/delete/(:num)', 'Admin\LokasiPresensi::delete/$1');
    $routes->get('lokasi_presensi/detail/(:segment)', 'Admin\LokasiPresensi::detail/$1');

    // Perusahaan
    $routes->get('perusahaan', 'Admin\Perusahaan::index');
    $routes->get('perusahaan/create', 'Admin\Perusahaan::create');
    $routes->post('perusahaan/store', 'Admin\Perusahaan::store');
    $routes->get('perusahaan/edit/(:segment)', 'Admin\Perusahaan::edit/$1');
    $routes->post('perusahaan/update/(:segment)', 'Admin\Perusahaan::update/$1');
    $routes->get('perusahaan/delete/(:num)', 'Admin\Perusahaan::delete/$1');

    // Rekap Kehadiran
    $routes->get('rekap/harian', 'Admin\Rekap::harian');
    $routes->get('rekap/bulanan', 'Admin\Rekap::bulanan');

    // Ketidakhadiran
    $routes->get('ketidakhadiran', 'Admin\Ketidakhadiran::index');
    $routes->post('ketidakhadiran/status/(:num)', 'Admin\Ketidakhadiran::updateStatus/$1');
});

// ---------------------------------------------------------------------------
// Area Superadmin
// ---------------------------------------------------------------------------
$routes->group('superadmin', ['filter' => 'superadminfilter'], static function ($routes) {
    $routes->get('home', 'Superadmin\Home::index');

    // Perusahaan
    $routes->get('perusahaan', 'Superadmin\Perusahaan::index');
    $routes->get('perusahaan/create', 'Superadmin\Perusahaan::create');
    $routes->post('perusahaan/store', 'Superadmin\Perusahaan::store');
    $routes->get('perusahaan/edit/(:segment)', 'Superadmin\Perusahaan::edit/$1');
    $routes->post('perusahaan/update/(:segment)', 'Superadmin\Perusahaan::update/$1');
    $routes->get('perusahaan/delete/(:num)', 'Superadmin\Perusahaan::delete/$1');

    // Admin
    $routes->get('admin', 'Superadmin\Admin::index');
    $routes->get('admin/create', 'Superadmin\Admin::create');
    $routes->post('admin/store', 'Superadmin\Admin::store');
    $routes->get('admin/edit/(:segment)', 'Superadmin\Admin::edit/$1');
    $routes->post('admin/update/(:segment)', 'Superadmin\Admin::update/$1');
    $routes->get('admin/delete/(:num)', 'Superadmin\Admin::delete/$1');
});

// ---------------------------------------------------------------------------
// Area Pegawai
// ---------------------------------------------------------------------------
$routes->group('pegawai', ['filter' => 'pegawaifilter'], static function ($routes) {
    $routes->get('home', 'Pegawai\Home::index');
    $routes->post('presensi_masuk', 'Pegawai\Home::presensi_masuk');
    $routes->post('presensi_pulang', 'Pegawai\Home::presensi_pulang');

    $routes->get('rekap', 'Pegawai\Rekap::index');

    $routes->get('ketidakhadiran', 'Pegawai\Ketidakhadiran::index');
    $routes->get('ketidakhadiran/create', 'Pegawai\Ketidakhadiran::create');
    $routes->post('ketidakhadiran/store', 'Pegawai\Ketidakhadiran::store');
});
