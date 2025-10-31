<?= $this->extend('admin/layout.php') ?>

<?= $this->section('content') ?>
<h2><?= $title ?></h2>
<div class="row">
    <div class="col-12">
        <div class="card border shadow-xs mb-4">
            <div class="card-header border-bottom pb-0">
                <div class="d-sm-flex align-items-center">
                    <div class="ms-auto d-flex">
                        <a href="<?= base_url('admin/jabatan/create') ?>" type="button" class="btn btn-sm btn-dark btn-icon d-flex align-items-center me-2">
                            <span class="btn-inner--icon">
                                <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="d-block me-2">
                                    <path d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z" />
                                </svg>
                            </span>
                            <span class="btn-inner--text">Add member</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card p-4 shadow-sm border-0 rounded-3">
                <div class="table-responsive p-0">
                    <table id="datatables" class="table align-items-center justify-content-center mb-0">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="text-start text-secondary text-xs font-weight-semibold opacity-7">No</th>
                                <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Nama Jabatan</th>
                                <th class="px-3 text-secondary text-xs font-weight-semibold opacity-7">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $no = 1;
                            foreach ($jabatan as $jab): ?>
                                <tr>
                                    <td>
                                        <p class="d-flex px-3 text-sm text-dark font-weight-semibold mb-0"><?= $no++ ?></p>
                                    </td>
                                    <td>
                                        <p class="text-sm text-dark font-weight-semibold mb-0"><?= $jab['jabatan'] ?></p>
                                    </td>
                                    <td class="align-middle">
                                        <a href="<?= base_url('admin/jabatan/edit/' . $jab['id']) ?>" class="text-secondary font-weight-bold text-xs" data-bs-toggle="tooltip" data-bs-title="Edit">
                                            <span class="badge badge-m border border-warning text-warning bg-warning ">Edit</span>
                                        </a>
                                        <a href="<?= base_url('admin/jabatan/delete/' . $jab['id']) ?>" class="text-secondary font-weight-bold text-xs tombol-hapus" data-bs-toggle="tooltip" data-bs-title="Delete">
                                            <span class="badge badge-m border border-danger text-danger bg-danger">Hapus</span>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>