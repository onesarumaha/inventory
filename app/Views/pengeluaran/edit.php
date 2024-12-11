<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row mb-12">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?= $title ?></h6>
            </div>
            <div class="card-body">
                <form id="pengeluaranForm"  action="<?= base_url('pengeluaran/update/'.$transaksi['no_transaksi']); ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="select2Single">Nama Pelanggan</label>
                            <select class="select2-single form-control" name="customer_id" id="select2Single">
                                <option value="">Pilih pelanggan</option>
                                <?php foreach($customer as $cus): ?>
                                    <option value="<?= $cus['id']; ?>" 
                                        <?= (isset($transaksi) && $cus['id'] == $transaksi['customer_id']) ? 'selected' : ''; ?>>
                                        <?= $cus['name']; ?>
                                    </option>
                                <?php endforeach; ?>
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
                                <input type="text" name="date" class="form-control form-control-sm" id="simpleDataInput" value="<?= isset($transaksi) ? $transaksi['date'] : ''; ?>" disabled>
                            </div>
                        </div>

                    </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <div class="row" id="productContainer">
                            <?php if (isset($transaksiItems) && !empty($transaksiItems)): ?>
                                <?php foreach ($transaksiItems as $key => $item): ?>
                                <div class="row form-item ml-0" id="product_<?= $key ?>">

                                    <div class="form-group col-md-4">
                                        <label for="select2SingleProduct_<?= $key ?>">Nama Product</label>
                                        <select class="select2-single form-control product-select" name="product_id[]" id="select2SingleProduct_<?= $key ?>">
                                            <option value="">Pilih Product</option>
                                            <?php foreach ($product as $pro): ?>
                                                <option value="<?= $pro['id']; ?>" 
                                                    <?= ($item['product_id'] == $pro['id']) ? 'selected' : ''; ?>>
                                                    <?= $pro['name']; ?> | <?= $pro['volume']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label for="price_<?= $key ?>">Harga</label>
                                        <input type="text" class="form-control form-control-sm" name="price[]" id="price_<?= $key ?>" value="<?= $item['price'] ?>" readonly>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="stock_<?= $key ?>">Stock</label>
                                        <input type="number" class="form-control form-control-sm" id="stock_<?= $key ?>" placeholder="Stock" readonly>
                                    </div>

                                    <div class="form-group col-md-2">
                                        <label for="quantity_<?= $key ?>">Quantity</label>
                                        <input type="number" class="form-control form-control-sm" name="quantity[]" id="quantity_<?= $key ?>" value="<?= $item['quantity'] ?>">
                                    </div>

                                    <div class="form-group col-md-2 d-flex align-items-center">
                                        <button type="button" class="btn btn-danger btn-sm remove-item">-</button>
                                        <button type="button" class="btn btn-success btn-sm add-item mr-1">+</button>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php endif; ?>
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

                        <button type="submit" class="btn btn-warning">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script>

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

    $('#productContainer .form-item').each(function() {
        const index = $(this).attr('id').split('_')[1]; 
        const productId = $(`#select2SingleProduct_${index}`).val();

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
                        alert('Detail produk tidak ditemukan.');
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan saat mengambil data produk.');
                }
            });
        }
    });

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
                        alert('Detail produk tidak ditemukan.');
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan saat mengambil data produk.');
                }
            });
        } else {
            $(`#price_${index}`).val('');
            $(`#stock_${index}`).val('');
        }
    });


    $(document).on('click', '.add-item', function() {
        const index = $('#productContainer .form-item').length;
        let newItem = `
        <div class="row form-item mb-2 offset-md-0" id="product_${index}">
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
        calculateGrandTotal();
    });

    $(document).on('input', 'input[name="price[]"], input[name="quantity[]"]', function() {
        calculateGrandTotal();
    });

    $(document).on('click', '.add-item, .remove-item', function() {
        calculateGrandTotal();
    });

    document.getElementById('pengeluaranForm').addEventListener('submit', function(e) {
        let isValid = true;
        let errorMessage = "";

        const customerId = document.querySelector('select[name="customer_id"]').value;
        if (!customerId) {
            isValid = false;
            errorMessage += "Nama pelanggan harus dipilih.\n";
        }

        const productIds = document.querySelectorAll('select[name="product_id[]"]');
        const quantities = document.querySelectorAll('input[name="quantity[]"]');
        productIds.forEach((productId, index) => {
            if (!productId.value) {
                isValid = false;
                errorMessage += `Produk pada baris ${index + 1} harus dipilih.\n`;
            }
            if (!quantities[index].value || parseInt(quantities[index].value) <= 0) {
                isValid = false;
                errorMessage += `Kuantitas pada baris ${index + 1} harus diisi dengan angka valid.\n`;
            }
        });

        if (!isValid) {
            e.preventDefault(); 
            alert(errorMessage); 
        }
    });

    calculateGrandTotal();
});

</script>


<?= $this->endSection() ?>
