<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row mb-12">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?= $title ?></h6>
            </div>
            <div class="card-body">
            <form action="<?= isset($customer) ? base_url('/customer/update/'.$customer['id']) : base_url('/customer/store'); ?>" method="POST">
            <?= csrf_field(); ?>
                <div class="form-group">
                    <label for="exampleInputName1">Nama customer</label>
                    <input type="text" class="form-control" name="name" id="exampleInputName1" aria-describedby="emailHelp"
                    placeholder="Nama customer" value="<?= old('name', isset($customer) ? $customer['name'] : ''); ?>">
                    <?php if (session()->getFlashdata('errors')['name'] ?? null): ?>
                        <div style="color: red;">
                            <?= session()->getFlashdata('errors')['name']; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                    <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp"
                    placeholder="Email" value="<?= old('email', isset($customer) ? $customer['email'] : ''); ?>">
                    <?php if (session()->getFlashdata('errors')['email'] ?? null): ?>
                        <div style="color: red;">
                            <?= session()->getFlashdata('errors')['email']; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Alamat</label>
                    <textarea class="form-control" name="address" id="exampleFormControlTextarea1" rows="3"><?= old('address', isset($customer) ? $customer['address'] : ''); ?></textarea>
                    <?php if (session()->getFlashdata('errors')['address'] ?? null): ?>
                        <div style="color: red;">
                            <?= session()->getFlashdata('errors')['address']; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-primary"><?= isset($customer) ? 'Update' : 'Create'; ?></button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>