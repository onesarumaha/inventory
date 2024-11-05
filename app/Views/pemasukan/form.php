<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row mb-12">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?= $title ?></h6>
            </div>
            <div class="card-body">
            <form action="<?= isset($pemasukan) ? base_url('/pemasukan/update/'.$pemasukan['id']) : base_url('/pemasukan/store'); ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field(); ?>
                 <div class="row">
                    <div class="form-group col-md-6">
                        <div class="form-group">
                            <label for="select2SingleProduct">Nama Product</label>
                            <select class="select2-single form-control" name="product_id" id="select2SingleProduct">
                                <option value="">Pilih Product</option>
                                <?php foreach ($product as $pro): ?>
                                    <option value="<?= $pro['id']; ?>" 
                                        <?= (isset($pemasukan) && $pro['id'] == $pemasukan['product_id']) ? 'selected' : ''; ?>>
                                        <?= $pro['name']; ?> | <?= $pro['volume']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            <?php if (session()->getFlashdata('errors')['product_id'] ?? null): ?>
                                <div style="color: red;">
                                    <?= session()->getFlashdata('errors')['product_id']; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName1">Harga</label>
                            <input type="text" class="form-control" name="price" id="exampleInputName1" aria-describedby="emailHelp"
                            placeholder="Harga" value="<?= old('price', isset($pemasukan) ? $pemasukan['price'] : ''); ?>">
                            <?php if (session()->getFlashdata('errors')['price'] ?? null): ?>
                                <div style="color: red;">
                                    <?= session()->getFlashdata('errors')['price']; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputName1">Quantity</label>
                            <input type="text" class="form-control" name="quantity" id="exampleInputName1" aria-describedby="emailHelp"
                            placeholder="Quantity" value="<?= old('quantity', isset($pemasukan) ? $pemasukan['quantity'] : ''); ?>">
                            <?php if (session()->getFlashdata('errors')['quantity'] ?? null): ?>
                                <div style="color: red;">
                                    <?= session()->getFlashdata('errors')['quantity']; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <div class="form-group" id="simple-date1">
                            <label for="simpleDataInput">Tanggal</label>
                            <div class="input-group date">
                                <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                </div>
                                <input type="text" name="date" class="form-control form-control-sm" id="simpleDataInput">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="select2Single">Nama Supplier</label>
                            <select class="select2-single form-control" name="supplier_id" id="select2Single">
                                <option value="">Pilih Supplier</option>
                                <?php foreach ($supplier as $supp): ?>
                                    <option value="<?= $supp['id']; ?>" 
                                        <?= (isset($pemasukan) && $supp['id'] == $pemasukan['supplier_id']) ? 'selected' : ''; ?>>
                                        <?= $supp['name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            <?php if (session()->getFlashdata('errors')['supplier_id'] ?? null): ?>
                                <div style="color: red;">
                                    <?= session()->getFlashdata('errors')['supplier_id']; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="select2Single">Lampiran</label>
                            <div class="custom-file mt-3">
                                <input type="file" name="upload" class="custom-file-input" id="customFile" accept="image/*">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>

                            <div id="imagePreview" class="mt-2" style="display: <?= isset($pemasukan['upload']) ? 'block' : 'none'; ?>;">
                                <img id="previewImage" 
                                    src="<?= isset($pemasukan['upload']) ? base_url('uploads/' . $pemasukan['upload']) : ''; ?>" 
                                    alt="Uploaded Image" 
                                    class="img-thumbnail" 
                                    style="max-width: 200px;"/>
                            </div>
                        </div>

                    </div>
                 </div>
                 <input type="hidden" name="user_id" value="<?= session()->get('id') ?>">
              
                    <button type="submit" class="btn <?= isset($pemasukan) ? 'btn-warning' : 'btn-primary'; ?>">
                        <?= isset($pemasukan) ? 'Update' : 'Create'; ?>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('customFile').addEventListener('change', function(event) {
    const file = event.target.files[0];
    const imagePreview = document.getElementById('imagePreview');
    const previewImage = document.getElementById('previewImage');

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            imagePreview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    } else {
        imagePreview.style.display = 'none'; 
    }
});
</script>

<?= $this->endSection() ?>