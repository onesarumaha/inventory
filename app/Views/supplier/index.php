<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row mb-12">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?= $title ?></h6>
                <a href="<?= base_url('/supplier/create') ?>" type="button" class="btn btn-primary mb-1">Tambah Supplier</a>
            </div>
            <div class="table-responsive p-3">
            <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                <thead class="thead-light">
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>No HP</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>No HP</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
                </tfoot>
                <tbody>
                <?php 
                $no = 1;
                foreach($suppliers as $supplier ) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $supplier['name'] ?></td>
                    <td><?= $supplier['email'] ?></td>
                    <td><?= $supplier['phone'] ?></td>
                    <td><?= $supplier['address'] ?></td>
                    <td style="display: flex; align-items: center;">
                        <a href="<?= base_url('/supplier/edit') ?>/<?= $supplier['id'] ?>" class="btn btn-warning" style="margin-right: 5px;">
                            <i class="fas fa-pen"></i>
                        </a>

                        <form id="delete-form" action="<?= base_url('/supplier') ?>/<?= $supplier['id'] ?>" method="post" style="margin: 0;">
                            <input type="hidden" name="_method" value="DELETE">
                            <?= csrf_field(); ?>
                            <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>

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

