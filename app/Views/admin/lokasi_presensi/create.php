<?= $this->extend('admin/layout.php') ?>

<?= $this->section('content') ?>
<h2><?= $title ?></h2>
<div class="row">
    <div class="col-xl-5 col-md-6 d-flex flex-column mx-auto">
        <div class="card card-plain mt-0">
            <div class="card-body">
                <form role="form" method="POST" action="<?= base_url('admin/lokasi_presensi/store') ?>">
                    <label>Nama Lokasi</label>
                    <div class="mb-1">
                        <input type="text" class="form-control <?= ($validation->hasError('nama_lokasi')) ? 'is-invalid' : '' ?>" name="nama_lokasi" placeholder="Nama Jabatan" aria-label="nama_lokasi" aria-describedby="name-addon">
                        <div class="invalid-feedback"><?= $validation->getError('nama_lokasi') ?></div>
                    </div>
                    <label>Alamat Lokasi</label>
                    <div class="mb-1">
                        <textarea type="text" class="form-control <?= ($validation->hasError('alamat_lokasi')) ? 'is-invalid' : '' ?>" name="alamat_lokasi" placeholder="Alamat Lokasi" aria-label="alamat_lokasi" aria-describedby="name-addon"></textarea>
                        <div class="invalid-feedback"><?= $validation->getError('alamat_lokasi') ?></div>
                    </div>
                    <label>Tipe Lokasi</label>
                    <div class="mb-1">
                        <input type="text" class="form-control <?= ($validation->hasError('tipe_lokasi')) ? 'is-invalid' : '' ?>" name="tipe_lokasi" placeholder="tipe Jabatan" aria-label="tipe_lokasi" aria-describedby="name-addon">
                        <div class="invalid-feedback"><?= $validation->getError('tipe_lokasi') ?></div>
                    </div>
                    <label>Latitude</label>
                    <div class="mb-1">
                        <input type="text" class="form-control <?= ($validation->hasError('latitude')) ? 'is-invalid' : '' ?>" name="latitude" placeholder="latitude" aria-label="latitude" aria-describedby="name-addon">
                        <div class="invalid-feedback"><?= $validation->getError('latitude') ?></div>
                    </div>
                    <label>Longitude</label>
                    <div class="mb-1">
                        <input type="text" class="form-control <?= ($validation->hasError('longitude')) ? 'is-invalid' : '' ?>" name="longitude" placeholder="Longitude" aria-label="longitude" aria-describedby="name-addon">
                        <div class="invalid-feedback"><?= $validation->getError('longitude') ?></div>
                    </div>
                    <label>Radius</label>
                    <div class="mb-1">
                        <input type="text" class="form-control <?= ($validation->hasError('radius')) ? 'is-invalid' : '' ?>" name="radius" placeholder="Radius" aria-label="radius" aria-describedby="name-addon">
                        <div class="invalid-feedback"><?= $validation->getError('radius') ?></div>
                    </div>
                    <label>Zona Waktu</label>
                    <div class="mb-1">
                        <select class="form-select <?= ($validation->hasError('zona_waktu')) ? 'is-invalid' : '' ?>"
                            name="zona_waktu"
                            aria-label="zona_waktu"
                            aria-describedby="zona-addon">
                            <option value="">Pilih Zona Waktu</option>
                            <option value="WIB">WIB (Waktu Indonesia Barat)</option>
                            <option value="WITA">WITA (Waktu Indonesia Tengah)</option>
                            <option value="WIT">WIT (Waktu Indonesia Timur)</option>
                        </select>
                        <div class="invalid-feedback">
                            <?= $validation->getError('zona_waktu') ?>
                        </div>
                    </div>

                    <label>Jam Masuk</label>
                    <div class="mb-1">
                        <input type="time" class="form-control <?= ($validation->hasError('jam_masuk')) ? 'is-invalid' : '' ?>" name="jam_masuk" placeholder="Jam Masuk" aria-label="jam_masuk" aria-describedby="name-addon">
                        <div class="invalid-feedback"><?= $validation->getError('jam_masuk') ?></div>
                    </div>
                    <label>Jam Pulang</label>
                    <div class="mb-1">
                        <input type="time" class="form-control <?= ($validation->hasError('jam_pulang')) ? 'is-invalid' : '' ?>" name="jam_pulang" placeholder="Jam Pulang" aria-label="jam_pulang" aria-describedby="name-addon">
                        <div class="invalid-feedback"><?= $validation->getError('jam_pulang') ?></div>
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