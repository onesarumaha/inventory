<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row mb-12">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?= $title ?></h6>
            </div>
            <div class="card-body">

            <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>


            <form action="<?= base_url('/profile/update-password/') ?>" method="POST">
            <?= csrf_field(); ?>

                 <div class="row">
                    <div class="form-group col-md-12">
                        <div class="row">
                            <div class="form-group col-md-5">
                                    <div class="form-group">
                                    <label for="current_password">Password Sekarang</label>
                                    <input type="password" name="current_password" id="current_password" class="form-control" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="new_password">Password Baru</label>
                                    <input type="password" name="new_password" id="new_password" class="form-control" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="confirm_password">Ulangi Password</label>
                                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                                </div>
                            </div>

                        </div>
                    </div>
                 </div>
              
                <button type="submit" class="btn btn-primary">Ganti</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>