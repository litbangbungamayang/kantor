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
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Petak Kebun</h3>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="card">
              <div class="card-body">
                <table class="table table-bordered table-hover" id="tbl_petak" style="width: 100%; font-size:0.9em;">
                  <thead>
                    <tr>
                      <!-- <th class="text-center" style="width: 25px;">#</th> -->
                      <th style="width: 20%;">Kode Petak</th>
                      <th>Deskripsi</th>
                      <th style="width: 10%;">KTG</th>
                    </tr>
                  </thead>
                </table>
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

<?= $this->include('Scripts/script_front'); ?>

<?= $this->endSection(); ?>
