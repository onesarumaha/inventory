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
                        <div class="form-group">
                            <label for="select2Single">Nama Pelanggan</label>
                            <select class="select2-single form-control" name="customer_id" id="select2Single">
                            <option value="">Pilih pelanggan</option>
                                <?php foreach($customer as $cus ): ?>
                                    <option value="<?= $cus['id']; ?>"><?= $cus['name']; ?></option>
                                <?php endforeach ?>
                            </select>
                            <?php if (session()->getFlashdata('errors')['customer_id'] ?? null): ?>
                                <div style="color: red;">
                                    <?= session()->getFlashdata('errors')['customer_id']; ?>
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

                    </div>
                 </div>

                 <div class="row">
                    <div class="form-group col-md-12">
                    <div class="row">
                        <div class="form-group col-md-4">
                        <label for="select2SingleProduct">Nama Product</label>
                            <select class="select2-single form-control" name="product_id" id="select2SingleProduct">
                            <option value="">Pilih product</option>
                            <option value="Aceh">Aceh</option>
                            </select>
                            <?php if (session()->getFlashdata('errors')['product_id'] ?? null): ?>
                                <div style="color: red;">
                                    <?= session()->getFlashdata('errors')['product_id']; ?>
                                </div>
                            <?php endif; ?>
                        </div>


                        <div class="form-group col-md-2">
                        <label for="exampleInputHP1">Price</label>
                            <input type="number" class="form-control form-control-sm" id="exampleInputHP1" aria-describedby="emailHelp" placeholder="Price" readonly>
                        </div>
                   
                        <div class="form-group col-md-2">
                        <label for="exampleInputHP1">Stock</label>
                            <input type="number" class="form-control form-control-sm" id="exampleInputHP1" aria-describedby="emailHelp"
                            placeholder="Stock" readonly>
                        </div>

                        <div class="form-group col-md-2">
                        <label for="exampleInputHP1">Quantity</label>
                            <input type="number" class="form-control form-control-sm" name="quantity" id="exampleInputHP1" aria-describedby="emailHelp"
                            placeholder="Quantity" value="<?= old('quantity', isset($product) ? $product['quantity'] : ''); ?>">
                            <?php if (session()->getFlashdata('errors')['quantity'] ?? null): ?>
                                <div style="color: red;">
                                    <?= session()->getFlashdata('errors')['quantity']; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group col-md-2 mt-2"><br>
                            <a href="#" class="btn btn-danger btn-sm kurangi">
                                <b>-</b>
                            </a>

                            <a href="#" class="btn btn-primary btn-sm tambahi">
                                <b>+</b>
                            </a>
                        </div>
                    </div>

                    </div>
                 </div>
              
                <button type="submit" class="btn btn-primary"><?= isset($product) ? 'Update' : 'Create'; ?></button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>