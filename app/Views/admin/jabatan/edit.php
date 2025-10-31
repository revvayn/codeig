<?= $this->extend('admin/layout.php') ?>

<?= $this->section('content') ?>
<h2><?= $title ?></h2>
<div class="row">
    <div class="col-xl-4 col-md-6 d-flex flex-column mx-auto">
        <div class="card card-plain mt-0">
            <div class="card-body">
                <form role="form" method="POST" action="<?=base_url('admin/jabatan/update/'.$jabatan['id'])?>">
                    <label>Nama Jabatan</label>
                    <div class="mb-3">
                        <input type="text" value="<?= $jabatan['jabatan']?>" class="form-control <?=($validation->hasError('jabatan')) ?'is-invalid':'' ?>" name="jabatan" placeholder="Nama Jabatan" aria-label="Jabatan" aria-describedby="name-addon">
                        <div class="invalid-feedback"><?=$validation->getError('jabatan')?></div>
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