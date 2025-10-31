<?= $this->extend('layout.php') ?>

<?= $this->section('content') ?>
    <h2><?php echo session()->get('role_id')?></h2>
<?= $this->endSection() ?>