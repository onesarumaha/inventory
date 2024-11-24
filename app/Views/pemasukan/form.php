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
                            <div class="input-group">
                                <select class="select2-single form-control" name="product_id" id="select2SingleProduct">
                                    <option value="">Pilih Product</option>
                                    <?php foreach ($product as $pro): ?>
                                        <option value="<?= $pro['id']; ?>" 
                                            <?= (isset($pemasukan) && $pro['id'] == $pemasukan['product_id']) ? 'selected' : ''; ?>>
                                            <?= $pro['name']; ?> | <?= $pro['volume']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal" id="#myBtn">
                                        [+] Tambah Product
                                    </button>
                                </div>
                            </div>

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
                                <input type="text" name="date" class="form-control form-control-sm" id="simpleDataInput" disabled>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="select2SingleSupplier">Nama Supplier</label>
                                <div class="input-group">
                                <select class="select2-single form-control" name="supplier_id" id="select2SingleSupplier">
                                    <option value="">Pilih Supplier</option>
                                    <?php foreach ($supplier as $supp): ?>
                                        <option value="<?= $supp['id']; ?>" 
                                            <?= (isset($pemasukan) && $supp['id'] == $pemasukan['supplier_id']) ? 'selected' : ''; ?>>
                                            <?= $supp['name']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="input-group-append">
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModalSupplier" id="#myBtnSupplier">
                                            [+] Tambah Supplier
                                        </button>
                                    </div>
                                </div>
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


<!-- modal tambah product -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addProductForm">
                    <div class="form-group">
                        <label for="name">Nama Product</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Nama Product" required>
                    </div>
                    <div class="form-group">
                        <label for="volume">Volume</label>
                        <input type="text" class="form-control" name="volume" id="volume" placeholder="Volume" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" class="form-control" name="price" id="price" placeholder="Price" required>
                    </div>
                    <div class="form-group">
                        <label for="stock">Stock</label>
                        <input type="number" class="form-control" name="stock" id="stock" placeholder="Stock" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveProductBtn">Simpan</button>
            </div>
        </div>
    </div>
</div>



<!-- modal tambah supplier -->
<div class="modal fade" id="exampleModalSupplier" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addSupplierForm">
                <div class="form-group">
                    <label for="exampleInputName1">Nama Supplier</label>
                    <input type="text" class="form-control" name="name" id="name" aria-describedby="emailHelp"
                    placeholder="Nama Supplier">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                    <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp"
                    placeholder="Email">
                </div>
                <div class="form-group">
                    <label for="exampleInputHP1">No HP</label>
                    <input type="number" class="form-control" name="phone" id="phone" aria-describedby="emailHelp"
                    placeholder="No HP">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Alamat</label>
                    <textarea class="form-control" name="address" id="address" rows="3"></textarea>
                  
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveSupplierBtn">Simpan</button>
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

    $(document).ready(function() {
        $('#saveProductBtn').on('click', function() {
            var formData = $('#addProductForm').serialize();

            $.ajax({
                url: '<?= base_url("product/tambah") ?>', 
                type: 'POST',
                data: formData,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': '<?= csrf_field() ?>' 
                },
                success: function(response) {
                    if (response.success) {
                        var newOption = $('<option>', {
                            value: response.data.id,
                            text: response.data.name + ' | ' + response.data.volume
                        });
                        $('#select2SingleProduct').append(newOption);

                        $('#select2SingleProduct').val(response.data.id).trigger('change');

                        $('#exampleModal').modal('hide');
                        $('#addProductForm')[0].reset();
                    } else {
                        alert('Failed to add product: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred: ' + error);
                }
            });
        });
    });

    $(document).ready(function() {
        $('#saveSupplierBtn').on('click', function() {
            var formData = $('#addSupplierForm').serialize();

            $.ajax({
                url: '<?= base_url("supplier/tambah") ?>', 
                type: 'POST',
                data: formData,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': '<?= csrf_field() ?>' 
                },
                success: function(response) {
                    if (response.success) {
                        var newOption = $('<option>', {
                            value: response.data.id,
                            text: response.data.name
                        });
                        $('#select2SingleSupplier').append(newOption);

                        $('#select2SingleSupplier').val(response.data.id).trigger('change');

                        $('#exampleModalSupplier').modal('hide');
                        $('#addSupplierForm')[0].reset();
                    } else {
                        alert('Failed to add Supplier: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred: ' + error);
                }
            });
        });
    });




</script>

<?= $this->endSection() ?>