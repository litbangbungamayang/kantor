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
                    <div class="col">
                        <h2 class="page-title">
                            PRESENSI
                        </h2>
                    </div>
                </div>
            </div>
            <div class="row col-lg-12">
                <div class="row row-cards">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-status-top bg-lime"></div>
                            <div class="card-body">
                                <h3 class="card-title" id='lblDateTime'></h3>
                                <div class="alert alert-success" role="alert">
                                    <h4 class="alert-title">Jam datang</h4>
                                    <div class="text-muted" id="lblCekIn"></div>
                                </div>
                                <div class="alert alert-info" role="alert">
                                    <h4 class="alert-title">Jam pulang</h4>
                                    <div class="text-muted" id="lblCekOut"></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="chkDinas">
                                        <span class="form-check-label">Dinas luar</span>
                                    </label>
                                    <div class="text-muted" id="lblAkurasi">Akurasi GPS Anda : N/A</div>
                                </div>
                                <div class="col text-center">
                                    <button id="btnSubmitPresensi" onClick="konfirmasiPresensi();" class="btn btn-pill btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row col-lg-12">
                <div class="row row-cards">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-status-top bg-lime"></div>
                            <div class="card-body">
                                <h3 class="card-title"> Laporan Presensi</h3>
                                <div class="form-group row mb-3">
                                    <label class="col-sm-4 col-form-label">Periode Laporan</label>
                                    <div class="col-sm-4">
                                        <!-- <select class="" name="bulan" id="bulan"></select> -->
                                        <input type="month" class="form-control" name="bulan_laporan" id="bulan_laporan" placeholder="Periode">
                                    </div>
                                </div>
                                <div class="col text-center">
                                    <button id="btnSubmitPresensi" onClick="viewLaporan();" class="btn btn-pill btn-primary">Submit</button>
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

<?= $this->include('Scripts/script_presensi'); ?>

<?= $this->endSection(); ?>
