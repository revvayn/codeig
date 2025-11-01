<?= $this->extend('admin/layout.php') ?>

<?= $this->section('content') ?>
<h2><?= $title ?></h2>
<div class="row">
    <div class="col-xl-4 col-md-6 d-flex flex-column mx-auto">
        <div class="card card-plain mt-0">
            <img width="120px"
                style="border-radius: 10px; display: block; margin: 0 auto;"
                src="<?= base_url('profile/' . $data_pegawai['foto']) ?>"
                alt="Foto Profil">

            <div class="card-body">
                <form role="form">
                    <label>NIP</label>
                    <div class="mb-1">
                        <input type="text" class="form-control" name="nip" aria-label="nip" disabled
                            value="<?= $data_pegawai['nip'] ?>">
                        <div class="invalid-feedback"></div>
                    </div>

                    <label>Nama</label>
                    <div class="mb-1">
                        <input type="text" class="form-control" name="nama" aria-label="nama" disabled
                            value="<?= $data_pegawai['nama'] ?>">
                        <div class="invalid-feedback"></div>
                    </div>

                    <label>Jenis Kelamin</label>
                    <div class="mb-1">
                        <input type="text" class="form-control" name="jenis_kelamin" aria-label="jenis_kelamin" disabled
                            value="<?= $data_pegawai['jenis_kelamin'] ?>">
                        <div class="invalid-feedback"></div>
                    </div>

                    <label>Alamat</label>
                    <div class="mb-1">
                        <input type="text" class="form-control" name="alamat" aria-label="alamat" disabled
                            value="<?= $data_pegawai['alamat'] ?>">
                        <div class="invalid-feedback"></div>
                    </div>

                    <label>No Handphone</label>
                    <div class="mb-1">
                        <input type="text" class="form-control" name="no_handphone" aria-label="no_handphone" disabled
                            value="<?= $data_pegawai['no_handphone'] ?>">
                        <div class="invalid-feedback"></div>
                    </div>

                    <label>Jabatan</label>
                    <div class="mb-1">
                        <input type="text" class="form-control" name="jabatan" aria-label="jabatan" disabled
                            value="<?= $data_pegawai['jabatan'] ?>">
                        <div class="invalid-feedback"></div>
                    </div>

                    <label>Lokasi Presensi</label>
                    <div class="mb-1">
                        <input type="text" class="form-control" name="lokasi_presensi" aria-label="lokasi_presensi" disabled
                            value="<?= $data_pegawai['lokasi_presensi'] ?>">
                        <div class="invalid-feedback"></div>
                    </div>

                    <label>Username</label>
                    <div class="mb-1">
                        <input type="text" class="form-control" name="username" aria-label="username" disabled
                            value="<?= $data_pegawai['username'] ?>">
                        <div class="invalid-feedback"></div>
                    </div>

                    <label>Role</label>
                    <div class="mb-1">
                        <input type="text" class="form-control" name="role" aria-label="role" disabled
                            value="<?= $data_pegawai['role'] ?>">
                        <div class="invalid-feedback"></div>
                    </div>

                    <label>Status</label>
                    <div class="mb-1">
                        <input type="text" class="form-control" name="status" aria-label="status" disabled
                            value="<?= $data_pegawai['status'] ?>">
                        <div class="invalid-feedback"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>