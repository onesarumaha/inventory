<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row mb-12">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?= $title ?></h6>
                <a href="<?= base_url('/pemasukan/create') ?>" type="button" class="btn btn-primary mb-1">Tambah</a>
            </div>
            <div class="table-responsive p-3">
            <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                <thead class="thead-light">
                <tr>
                    <th>No</th>
                    <th>Product</th>
                    <th>Harga</th>
                    <th>Quantity</th>
                    <th>Supplier</th>
                    <th>Status</th>
                    <th>Upload</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>No</th>
                    <th>Product</th>
                    <th>Harga</th>
                    <th>Quantity</th>
                    <th>Supplier</th>
                    <th>Status</th>
                    <th>Upload</th>
                    <th>Action</th>
                </tr>
                </tfoot>
                <tbody>
                <?php 
                $no = 1;
                foreach($pemasukans as $pemasukan ) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $pemasukan['nama_product'] ?? '-'; ?></td> 
                    <td>Rp. <?= number_format( $pemasukan['price'] ) ?></td>
                    <td><?= $pemasukan['quantity'] ?></td>
                    <td><?= $pemasukan['nama_supplier'] ?></td>
                    <td>
                    <?php 
                        if ($pemasukan['status'] == 0) {
                            echo '<span class="badge bg-warning text-light">Menunggu di approve admin</span>';
                        } elseif ($pemasukan['status'] == 1) {
                            echo '<span class="badge bg-primary text-light">Menunggu di approve owner</span>';
                        } elseif ($pemasukan['status'] == 2) {
                            echo '<span class="badge bg-success text-light">Selesai</span>';
                        } else {
                            echo 'Status tidak diketahui';
                        }
                        ?>
                    </td>
                    <td>
                        <a href="<?= site_url('pemasukan/download/' . $pemasukan['upload']) ?>">
                            Download
                        </a>
                    </td>

                    <td style="display: flex; align-items: center;">
                    <?php if (session()->get('role') === 'petugas'): ?>
   
                    <a href="<?= base_url('/pemasukan/edit') ?>/<?= $pemasukan['id'] ?>" class="btn btn-warning" style="margin-right: 5px;">
                            <i class="fas fa-pen"></i>
                        </a>
                        <form id="delete-form" action="<?= base_url('/pemasukan') ?>/<?= $pemasukan['id'] ?>" method="post" style="margin: 0;">
                            <input type="hidden" name="_method" value="DELETE">
                            <?= csrf_field(); ?>
                            <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        <?php endif; ?>


                        <?php if (session()->get('role') === 'admin'): ?>
                            <form id="approve-admin" action="<?= base_url('/pemasukan/approve-admin') ?>/<?= $pemasukan['id'] ?>" method="post" style="margin: 0;">
                                <input type="hidden" name="_method" value="POST">
                                <?= csrf_field(); ?>
                                <button type="button" class="btn btn-warning" onclick="confirmAdmin()">
                                    <i class="fas fa-check"></i>

                                </button>
                            </form>
                        <?php elseif (session()->get('role') === 'owner'): ?>
                            <form id="approve-owner" action="<?= base_url('/pemasukan/approve-owner') ?>/<?= $pemasukan['id'] ?>" method="post" style="margin: 0;">
                                <input type="hidden" name="_method" value="POST">
                                <?= csrf_field(); ?>
                                <button type="button" class="btn btn-success" onclick="confirmOwner()">
                                    <i class="fas fa-solid fa-thumbs-up"></i>
                                 </button>
                            </form>
                        <?php endif; ?>

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

