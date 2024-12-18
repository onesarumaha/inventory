<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row mb-12">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?= $title ?></h6>
                <a href="<?= base_url('/product/create') ?>" type="button" class="btn btn-primary mb-1">Tambah Product</a>
            </div>
            <div class="table-responsive p-3">
            <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                <thead class="thead-light">
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Volume</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Volume</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Action</th>
                </tr>
                </tfoot>
                <tbody>
                <?php 
                $no = 1;
                foreach($products as $product ) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $product['name'] ?></td>
                    <td><?= $product['volume'] ?></td>
                    <td>Rp. <?= number_format($product['price'] ) ?></td>
                    <td><?= $product['stock'] ?></td>
                    <td style="display: flex; align-items: center;">
                        <a href="<?= base_url('/product/edit') ?>/<?= $product['id'] ?>" class="btn btn-warning" style="margin-right: 5px;">
                            <i class="fas fa-pen"></i>
                        </a>
                        <a href="javascript:void(0);" class="btn btn-danger" onclick="confirmDeleteProduct(<?= $product['id'] ?>)">
                                <i class="fas fa-trash"></i>
                        </a>

                    </td>

                </tr>
                <?php endforeach; ?>
                
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

