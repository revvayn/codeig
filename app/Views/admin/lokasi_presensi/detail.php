<?= $this->extend('admin/layout.php') ?>

<?= $this->section('content') ?>
<h2><?= $title ?></h2>
<div class="row">
    <div class="col-xl-4 col-md-6 d-flex flex-column mx-auto">
        <div class="card card-plain mt-0">
            <div class="card-body">
                <form role="form">
                    <label>Nama Lokasi</label>
                    <div class="mb-1">
                        <input type="text"
                            value="<?= $lokasi_presensi['nama_lokasi'] ?>"
                            class="form-control" disabled
                            name="nama_lokasi" placeholder="Nama Lokasi" aria-label="nama_lokasi">
                        <div class="invalid-feedback"></div>
                    </div>

                    <label>Alamat Lokasi</label>
                    <div class="mb-1">
                        <textarea class="form-control" disabled
                            name="alamat_lokasi" placeholder="Alamat Lokasi" aria-label="alamat_lokasi"><?= $lokasi_presensi['alamat_lokasi'] ?></textarea>
                        <div class="invalid-feedback"></div>
                    </div>

                    <label>Tipe Lokasi</label>
                    <div class="mb-1">
                        <input type="text"
                            value="<?= $lokasi_presensi['tipe_lokasi'] ?>"
                            class="form-control" disabled
                            name="tipe_lokasi" placeholder="Tipe Lokasi" aria-label="tipe_lokasi">
                        <div class="invalid-feedback"></div>
                    </div>

                    <label>Latitude</label>
                    <div class="mb-1">
                        <input type="text"
                            value="<?= $lokasi_presensi['latitude'] ?>"
                            class="form-control" disabled
                            name="latitude" placeholder="Latitude" aria-label="latitude">
                        <div class="invalid-feedback"></div>
                    </div>

                    <label>Longitude</label>
                    <div class="mb-1">
                        <input type="text"
                            value="<?= $lokasi_presensi['longitude'] ?>"
                            class="form-control" disabled
                            name="longitude" placeholder="Longitude" aria-label="longitude">
                        <div class="invalid-feedback"></div>
                    </div>

                    <label>Radius</label>
                    <div class="mb-1">
                        <input type="text"
                            value="<?= $lokasi_presensi['radius'] ?>"
                            class="form-control" disabled
                            name="radius" placeholder="Radius" aria-label="radius">
                        <div class="invalid-feedback"></div>
                    </div>

                    <label>Zona Waktu</label>
                    <div class="mb-1">
                        <input class="form-control" disabled
                            name="zona_waktu" aria-label="zona_waktu" value="<?= $lokasi_presensi['zona_waktu'] ?>">
                    </div>

                    <label>Jam Masuk</label>
                    <div class="mb-1">
                        <input type="time"
                            value="<?= $lokasi_presensi['jam_masuk'] ?>"
                            class="form-control" disabled
                            name="jam_masuk" placeholder="Jam Masuk" aria-label="jam_masuk">
                        <div class="invalid-feedback"></div>
                    </div>

                    <label>Jam Pulang</label>
                    <div class="mb-1">
                        <input type="time"
                            value="<?= $lokasi_presensi['jam_pulang'] ?>"
                            class="form-control" disabled
                            name="jam_pulang" placeholder="Jam Pulang" aria-label="jam_pulang">
                        <div class="invalid-feedback"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>