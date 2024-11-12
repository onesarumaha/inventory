<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row mb-12">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?= $title ?></h6>
            </div>
            <div class="card-body">
                <form action="<?= isset($pengeluaran) ? base_url('/pengeluaran/update/'.$pengeluaran['id']) : base_url('/pengeluaran/store'); ?>" method="POST">
                    <?= csrf_field(); ?>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="select2Single">Nama Pelanggan</label>
                            <select class="select2-single form-control" name="customer_id" id="select2Single">
                                <option value="">Pilih pelanggan</option>
                                <?php foreach($customer as $cus): ?>
                                    <option value="<?= $cus['id']; ?>"><?= $cus['name']; ?></option>
                                <?php endforeach ?>
                            </select>
                            <?php if (session()->getFlashdata('errors')['customer_id'] ?? null): ?>
                                <div style="color: red;">
                                    <?= session()->getFlashdata('errors')['customer_id']; ?>
                                </div>
                            <?php endif; ?>
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

                    </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <div class="row" id="productContainer">
                            <div class="row form-item ml-0" id="product_0">

                            <div class="form-group col-md-4">
                                <label for="select2SingleProduct_0">Nama Product</label>
                                <div class="input-group">
                                    <select class="select2-single form-control product-select" name="product_id[]" id="select2SingleProduct_0">
                                        <option value="">Pilih Product</option>
                                        <?php foreach ($product as $pro): ?>
                                            <option value="<?= $pro['id']; ?>" 
                                                <?= (isset($pemasukan) && $pro['id'] == $pemasukan['product_id']) ? 'selected' : ''; ?>>
                                                <?= $pro['name']; ?> | <?= $pro['volume']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <?php if (session()->getFlashdata('errors')['product_id'] ?? null): ?>
                                    <div style="color: red;">
                                        <?= session()->getFlashdata('errors')['product_id']; ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="form-group col-md-2">
                                <label for="price_0">Harga</label>
                                <input type="text" class="form-control form-control-sm" name="price[]" id="price_0" placeholder="Price" readonly>
                            </div>

                            <div class="form-group col-md-2">
                                <label for="stock_0">Stock</label>
                                <input type="number" class="form-control form-control-sm" id="stock_0" placeholder="Stock" readonly>
                            </div>

                            <div class="form-group col-md-2">
                                <label for="quantity_0">Quantity</label>
                                <input type="number" class="form-control form-control-sm" name="quantity[]" id="quantity_0" placeholder="Quantity" value="<?= old('quantity', isset($pemasukan) ? $pemasukan['quantity'] : ''); ?>">
                            </div>

                            <div class="form-group col-md-2 d-flex align-items-center">
                                <button type="button" class="btn btn-danger btn-sm remove-item">-</button>
                                <button type="button" class="btn btn-success btn-sm add-item mr-1">+</button>

                            </div>
                            </div>
                            </div>


                            </div>

                            <div class="form-group col-md-6">
                                    <div class="card bg-success text-white">
                                        <div class="card-body">
                                        Grand Total
                                        <div class="text-white-90 small grand-total"></div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <input type="hidden" name="user_id" value="<?= session()->get('id') ?>">

                        <button type="submit" class="btn btn-primary"><?= isset($pengeluaran) ? 'Update' : 'Create'; ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script>
$(document).ready(function() {
    $('.select2-single').select2();

    $(document).on('change', '.product-select', function() {
        const index = $(this).attr('id').split('_')[1]; 
        const productId = $(this).val();
        
        if (productId) {
            $.ajax({
                url: `<?= base_url('pengeluaran/details'); ?>/${productId}`,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $(`#price_${index}`).val(formatRupiah(response.price));
                        $(`#stock_${index}`).val(response.stock);
                    } else {
                        alert('Product details not found.');
                    }
                },
                error: function() {
                    alert('Error retrieving product details.');
                }
            });
        } else {
            $(`#price_${index}`).val('');
            $(`#stock_${index}`).val('');
        }
    });

    function formatRupiah(angka) {
        return 'Rp. ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }

    $(document).on('click', '.add-item', function() {
        const index = $('#productContainer .form-item').length;
        let newItem = `
        <div class="row form-item mb-2" id="product_${index}">
            <div class="form-group col-md-4">
                <label for="select2SingleProduct_${index}">Nama Product</label>
                <select class="select2-single form-control product-select" name="product_id[]" id="select2SingleProduct_${index}">
                    <option value="">Pilih Product</option>
                    <?php foreach ($product as $pro): ?>
                        <option value="<?= $pro['id']; ?>"><?= $pro['name']; ?> | <?= $pro['volume']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group col-md-2">
                <label for="price_${index}">Harga</label>
                <input type="text" class="form-control form-control-sm" name="price[]" id="price_${index}" placeholder="Price" readonly>
            </div>
            <div class="form-group col-md-2">
                <label for="stock_${index}">Stock</label>
                <input type="number" class="form-control form-control-sm" id="stock_${index}" placeholder="Stock" readonly>
            </div>
            <div class="form-group col-md-2">
                <label for="quantity_${index}">Quantity</label>
                <input type="number" class="form-control form-control-sm" name="quantity[]" id="quantity_${index}" placeholder="Quantity">
            </div>
            <div class="form-group col-md-2 d-flex align-items-center">
                <button type="button" class="btn btn-danger btn-sm remove-item">-</button>
                <button type="button" class="btn btn-success btn-sm add-item mr-1">+</button>

            </div>
        </div>`;
        
        $('#productContainer').append(newItem);
        $(`#select2SingleProduct_${index}`).select2();
    });
    

    $(document).on('click', '.remove-item', function() {
        $(this).closest('.form-item').remove();
    });
});


$(document).ready(function() {
    $('.select2-single').select2();

    function formatRupiah(angka) {
        return 'Rp. ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }

    function calculateGrandTotal() {
        let grandTotal = 0;
        $('#productContainer .form-item').each(function() {
            const price = parseInt($(this).find('input[name="price[]"]').val().replace(/[^0-9]/g, '')) || 0;
            const quantity = parseInt($(this).find('input[name="quantity[]"]').val()) || 0;
            
            const subtotal = price * quantity;
            
            grandTotal += subtotal;
        });
        
        $('.grand-total').text(formatRupiah(grandTotal));
    }

    $(document).on('input', 'input[name="price[]"], input[name="quantity[]"]', function() {
        calculateGrandTotal();
    });

    $(document).on('click', '.add-item, .remove-item', function() {
        calculateGrandTotal();
    });

    calculateGrandTotal();
});

</script>

<?= $this->endSection() ?>
