<?= $this->extend('Templates/app_layout'); ?>

<?= $this->section('header'); ?>

<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<div class="wrapper">
  <?= $this->include('Templates/sidemenu') ?>
  <div class="page-wrapper">
    <div class="container-xl">
      <!-- Page title -->
      <div class="page-header d-print-none">
        <div class="row align-items-center">
          <div class="row">
            <h2 class="page-title">
              Profil
            </h2>
          </div>
          <div class="row row-deck">
            <div class="col-md-6">
              <div class="card">
                <div class="card-body">
                  <p><h3><? echo session('nm_pegawai');?></h3></p>
                  <p><? echo session('nm_jabatan')." ".ucwords(strtolower(session('nm_sub_divisi')))." - ".ucwords(session('nm_unit'));?></p>
                  <p><? var_dump(json_decode(session('akses_modul')));?></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>

<?= $this->include('Scripts/script_profil'); ?>

<?= $this->endSection(); ?>
