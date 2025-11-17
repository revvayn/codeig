<?= $this->extend('pegawai/layout.php') ?>

<?= $this->section('content') ?>

<style>
    .parent-clock {
        display: flex;
        font-size: 40px;
        justify-content: center;
        align-items: center;
        gap: 5px;
    }
</style>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-4">
        <div class="card border shadow-xs mb-4">
            <h7 class="card-header border-bottom pb-3 ">
                Presensi Kehadiran Pegawai
            </h7>
            <div class="card-body text-center">
                <div class="tanggal fw-bold">
                    <?= date('d F Y') ?>
                </div>
                <div class="parent-clock">
                    <div id="jam-masuk"></div>
                    <div>:</div>
                    <div id="menit-masuk"></div>
                    <div>:</div>
                    <div id="detik-masuk"></div>
                </div>
                <form method="POST" action="<?=base_url('pegawai/presensi_masuk')?>">
                <input type="text" name="id_pegawai" value="<?= session()->get('id_pegawai') ?>">
                    <button type="submit" class="btn btn-sm btn-primary btn-icon d-flex align-items-center justify-content-center mx-auto mt-3">
                        <span class="btn-inner--text">Masuk</span></button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
    <div class="card border shadow-xs mb-4">
            <h7 class="card-header border-bottom pb-3 ">
                Presensi Pulang Pegawai
            </h7>
            <div class="card-body text-center">
                <div class="tanggal fw-bold">
                    <?= date('d F Y') ?>
                </div>
                <div class="parent-clock">
                    <div id="jam-keluar"></div>
                    <div>:</div>
                    <div id="menit-keluar"></div>
                    <div>:</div>
                    <div id="detik-keluar"></div>
                </div>
                <form method="POST" action="<?=base_url('pegawai/presensi_pulang')?>">
                <input type="text" name="id_pegawai" value="<?= session()->get('id_pegawai') ?>">    
                <button type="submit" class="btn btn-sm btn-danger btn-icon d-flex align-items-center justify-content-center mx-auto mt-3">
                        <span class="btn-inner--text">Pulang</span>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-2"></div>
</div>
<script>
    window.setInterval('waktu_masuk()', 1000);

    function waktu_masuk() {
        const waktu = new Date();
        document.getElementById('jam-masuk').innerHTML = format_waktu(waktu.getHours());
        document.getElementById('menit-masuk').innerHTML = format_waktu(waktu.getMinutes());
        document.getElementById('detik-masuk').innerHTML = format_waktu(waktu.getSeconds());
    }
    window.setInterval('waktu_keluar()', 1000);

    function waktu_keluar() {
        const waktu = new Date();
        document.getElementById('jam-keluar').innerHTML = format_waktu(waktu.getHours());
        document.getElementById('menit-keluar').innerHTML = format_waktu(waktu.getMinutes());
        document.getElementById('detik-keluar').innerHTML = format_waktu(waktu.getSeconds());
    }

    function format_waktu(waktu) {
        if (waktu < 10) {
            return '0' + waktu;
        } else {
            return waktu;
        }

    }
</script>
<?= $this->endSection() ?>