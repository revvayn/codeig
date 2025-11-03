<?= $this->extend('admin/layout.php') ?>

<?= $this->section('content') ?>
<h2><?= $title ?></h2>
<div class="row">
    <div class="col-xl-4 col-md-6 d-flex flex-column mx-auto">
        <div class="card card-plain mt-0">
            <div class="card-body">
                <form role="form" method="POST" action="<?= base_url('admin/data_pegawai/update/' . $pegawai['id']) ?>" enctype="multipart/form-data">
                    <?=csrf_field()?>
                    <label>Nama</label>
                    <div class="mb-1">
                        <input type="text" value="<?= $pegawai['nama'] ?>" class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : '' ?>" name="nama" placeholder="Nama Pegawai" aria-label="nama" aria-describedby="name-addon">
                        <div class="invalid-feedback"><?= $validation->getError('nama') ?></div>
                    </div>
                    <label>Jenis Kelamin</label>
                    <div class="mb-1">
                        <select class=" form-select <?= ($validation->hasError('jenis_kelamin')) ? 'is-invalid' : '' ?>"
                            name="jenis_kelamin" aria-label="jenis_kelamin">
                            <option value="<?= $pegawai['jenis_kelamin'] ?>"><?= $pegawai['jenis_kelamin'] ?></option>
                            <option value="">--Pilih Jenis Kelamin--</option>
                            <option value="laki-laki" <?= $pegawai['jenis_kelamin'] == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                            <option value="Perempuan" <?= $pegawai['jenis_kelamin'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                        <div class="invalid-feedback"><?= $validation->getError('jenis_kelamin') ?></div>
                    </div>
                    <label>Alamat</label>
                    <div class="mb-1">
                        <textarea type="text" class="form-control <?= ($validation->hasError('alamat')) ? 'is-invalid' : '' ?>" name="alamat" placeholder="Alamat" aria-label="alamat" aria-describedby="name-addon"><?= $pegawai['alamat'] ?></textarea>
                        <div class="invalid-feedback"><?= $validation->getError('alamat') ?></div>
                    </div>
                    <label>No Handphone</label>
                    <div class="mb-1">
                        <input type="text" value="<?= $pegawai['no_handphone'] ?>" class="form-control <?= ($validation->hasError('no_handphone')) ? 'is-invalid' : '' ?>" name="no_handphone" placeholder="No Handphone" aria-label="no_handphone" aria-describedby="name-addon">
                        <div class="invalid-feedback"><?= $validation->getError('no_handphone') ?></div>
                    </div>
                    <label>Jabatan</label>
                    <div class="mb-1">
                        <select class="form-select <?= ($validation->hasError('jabatan')) ? 'is-invalid' : '' ?>"
                            name="jabatan"
                            aria-label="jabatan"
                            aria-describedby="zona-addon">
                            <option value="<?= $pegawai['jabatan'] ?>"><?= $pegawai['jabatan'] ?></option>
                            <option value="">--Pilih Jabatan--</option>
                            <option value="<?= $pegawai['jabatan'] ?>"><?= $pegawai['jabatan'] ?></option>
                        </select>
                        <div class="invalid-feedback">
                            <?= $validation->getError('jabatan') ?>
                        </div>
                    </div>
                    <label>Lokasi Presensi</label>
                    <div class="mb-1">
                        <select class="form-select <?= ($validation->hasError('lokasi_presensi')) ? 'is-invalid' : '' ?>"
                            name="lokasi_presensi"
                            aria-label="lokasi_presensi"
                            aria-describedby="zona-addon">
                            <option value="<?= $pegawai['lokasi_presensi'] ?>"><?= $pegawai['lokasi_presensi'] ?></option>
                            <option value="">--Pilih Lokasi Presensi--</option>
                            <?php foreach ($lokasi_presensi as $lok): ?>
                                <option value="<?= $lok['nama_lokasi'] ?>"><?= $lok['nama_lokasi'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">
                            <?= $validation->getError('lokasi_presensi') ?>
                        </div>
                    </div>
                    <label>Foto</label>
                    <div class="mb-1">
                        <input type="hidden" value="<?= $pegawai['foto'] ?>" name="foto_lama">
                        <input type="file" class="form-control <?= ($validation->hasError('foto')) ? 'is-invalid' : '' ?>" name="foto" aria-label="foto" aria-describedby="name-addon">
                        <div class="invalid-feedback"><?= $validation->getError('foto') ?></div>
                    </div>

                    <label>Username</label>
                    <div class="mb-1">
                        <input type="text" value="<?= $pegawai['username'] ?>" class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : '' ?>" name="username" placeholder="Username" aria-label="username" aria-describedby="name-addon">
                        <div class="invalid-feedback"><?= $validation->getError('username') ?></div>
                    </div>
                    <label>Password</label>
                    <div class="mb-1">
                        <input type="hidden" value="<?= $pegawai['password'] ?>" name="password_lama" placeholder="Password" aria-label="password" aria-describedby="name-addon">
                        <input type="password" name="password" class="form-control <?= ($validation->hasError('password')) ? 'is-invalid' : '' ?>" placeholder="Password" aria-label="password" aria-describedby="name-addon">
                        <div class="invalid-feedback"><?= $validation->getError('password') ?></div>
                    </div>
                    <label>Konfirmasi Password</label>
                    <div class="mb-1">
                        <input type="password" class="form-control <?= ($validation->hasError('konfirmasi_password')) ? 'is-invalid' : '' ?>" name="konfirmasi_password" placeholder="Konfirmasi Password" aria-label="konfirmasi_password" aria-describedby="name-addon">
                        <div class="invalid-feedback"><?= $validation->getError('konfirmasi_password') ?></div>
                    </div>
                    <label>Role</label>
                    <div class="mb-1">
                        <input type="text" value="<?= $pegawai['role'] ?>" class="form-control <?= ($validation->hasError('role')) ? 'is-invalid' : '' ?>" name="role" placeholder="Role" aria-label="role" aria-describedby="name-addon">
                        <div class="invalid-feedback"><?= $validation->getError('role') ?></div>
                    </div>
                    <div class="mb-1">
                        <input type="hidden" value="<?= $pegawai['status'] ?>" class="form-control <?= ($validation->hasError('status')) ? 'is-invalid' : '' ?>" name="status" placeholder="status" aria-label="status" aria-describedby="name-addon">
                        <div class="invalid-feedback"><?= $validation->getError('status') ?></div>
                    </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-dark w-100 mt-4 mb-3">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>
</div>
<?= $this->endSection() ?>