<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row mb-12">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?= $title ?></h6>
            </div>
            <div class="card-body">
            <form action="<?= isset($product) ? base_url('/product/update/'.$product['id']) : base_url('/product/store'); ?>" method="POST">
            <?= csrf_field(); ?>
                <div class="form-group">
                    <label for="exampleInputName1">Nama Product</label>
                    <input type="text" class="form-control" name="name" id="exampleInputName1" aria-describedby="emailHelp"
                    placeholder="Nama Product" value="<?= old('name', isset($product) ? $product['name'] : ''); ?>">
                    <?php if (session()->getFlashdata('errors')['name'] ?? null): ?>
                        <div style="color: red;">
                            <?= session()->getFlashdata('errors')['name']; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Volume</label>
                    <input type="text" class="form-control" name="volume" id="exampleInputEmail1" aria-describedby="emailHelp"
                    placeholder="Volume" value="<?= old('volume', isset($product) ? $product['volume'] : ''); ?>">
                    <?php if (session()->getFlashdata('errors')['volume'] ?? null): ?>
                        <div style="color: red;">
                            <?= session()->getFlashdata('errors')['volume']; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="exampleInputHP1">Price</label>
                    <input type="number" class="form-control" name="price" id="exampleInputHP1" aria-describedby="emailHelp"
                    placeholder="Price" value="<?= old('price', isset($product) ? $product['price'] : ''); ?>">
                    <?php if (session()->getFlashdata('errors')['price'] ?? null): ?>
                        <div style="color: red;">
                            <?= session()->getFlashdata('errors')['price']; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="exampleInputHP1">Stock</label>
                    <input type="number" class="form-control" name="stock" id="exampleInputHP1" aria-describedby="emailHelp"
                    placeholder="stock" value="<?= old('stock', isset($product) ? $product['stock'] : ''); ?>">
                    <?php if (session()->getFlashdata('errors')['stock'] ?? null): ?>
                        <div style="color: red;">
                            <?= session()->getFlashdata('errors')['stock']; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Keterangan</label>
                    <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3"><?= old('description', isset($product) ? $product['description'] : ''); ?></textarea>

                </div>
                <button type="submit" class="btn btn-primary"><?= isset($product) ? 'Update' : 'Create'; ?></button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>