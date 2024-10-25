<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row mb-12">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?= $title ?></h6>
            </div>
            <div class="card-body">
            <form action="<?= isset($supplier) ? base_url('/supplier/update/'.$supplier['id']) : base_url('/supplier/store'); ?>" method="POST">
            <?= csrf_field(); ?>
                <div class="form-group">
                    <label for="exampleInputName1">Nama Supplier</label>
                    <input type="text" class="form-control" name="name" id="exampleInputName1" aria-describedby="emailHelp"
                    placeholder="Nama Supplier" value="<?= old('name', isset($supplier) ? $supplier['name'] : ''); ?>">
                    <?php if (session()->getFlashdata('errors')['name'] ?? null): ?>
                        <div style="color: red;">
                            <?= session()->getFlashdata('errors')['name']; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                    <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp"
                    placeholder="Email" value="<?= old('email', isset($supplier) ? $supplier['email'] : ''); ?>">
                    <?php if (session()->getFlashdata('errors')['email'] ?? null): ?>
                        <div style="color: red;">
                            <?= session()->getFlashdata('errors')['email']; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="exampleInputHP1">No HP</label>
                    <input type="number" class="form-control" name="phone" id="exampleInputHP1" aria-describedby="emailHelp"
                    placeholder="No HP" value="<?= old('phone', isset($supplier) ? $supplier['phone'] : ''); ?>">
                    <?php if (session()->getFlashdata('errors')['phone'] ?? null): ?>
                        <div style="color: red;">
                            <?= session()->getFlashdata('errors')['phone']; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Alamat</label>
                    <textarea class="form-control" name="address" id="exampleFormControlTextarea1" rows="3"><?= old('address', isset($supplier) ? $supplier['address'] : ''); ?></textarea>

                </div>
                <button type="submit" class="btn btn-primary"><?= isset($supplier) ? 'Update' : 'Create'; ?></button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>