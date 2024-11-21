<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row mb-12">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?= $title ?></h6>
                <a href="<?= base_url('/supplier/create') ?>" type="button" class="btn btn-primary mb-1">Advance Search</a>
            </div>
            <div class="table-responsive">
                <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Date</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Omset</th>
                        </tr>
                    </thead>
                <tbody>
                <?php 
                $no = 1;
                foreach($omsets as $omset ) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $omset['date']?></td>
                    <td><?= $omset['name'] ?></td>
                    <td><?= $omset['quantity'] ?></td>
                    <td>Rp. <?= number_format($omset['omset']) ?></td>
                </tr>
                <?php endforeach; ?>
                
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

