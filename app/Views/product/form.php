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
                    <label for="exampleFormControlSelect1">Volume</label>
                    <select class="form-control" id="exampleFormControlSelect1" name="volume">
                        <option value="">Pilih Volume</option>
                        <option value="0,12 Liter" <?= (old('volume', isset($product) ? $product['volume'] : '') == '0,12 Liter') ? 'selected' : ''; ?>>0,12 Liter</option>
                        <option value="0,8 Liter" <?= (old('volume', isset($product) ? $product['volume'] : '') == '0,8 Liter') ? 'selected' : ''; ?>>0,8 Liter</option>
                        <option value="1 Liter" <?= (old('volume', isset($product) ? $product['volume'] : '') == '1 Liter') ? 'selected' : ''; ?>>1 Liter</option>
                        <option value="3,5 Liter" <?= (old('volume', isset($product) ? $product['volume'] : '') == '3,5 Liter') ? 'selected' : ''; ?>>3,5 Liter</option>
                        <option value="4 Liter" <?= (old('volume', isset($product) ? $product['volume'] : '') == '4 Liter') ? 'selected' : ''; ?>>4 Liter</option>
                        <option value="5 Liter" <?= (old('volume', isset($product) ? $product['volume'] : '') == '5 Liter') ? 'selected' : ''; ?>>5 Liter</option>
                        <option value="10 Liter" <?= (old('volume', isset($product) ? $product['volume'] : '') == '10 Liter') ? 'selected' : ''; ?>>10 Liter</option>
                    </select>
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