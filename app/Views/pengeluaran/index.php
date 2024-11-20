<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row mb-12">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?= $title ?></h6>
                <a href="<?= base_url('/pengeluaran/create') ?>" type="button" class="btn btn-primary mb-1">Tambah</a>
            </div>
            <div class="table-responsive p-3">
            <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                <thead class="thead-light">
                <tr>
                    <th>No</th>
                    <th>No Transaksi</th>
                    <th>Tanggal</th>
                    <th>Nama Pelanggan</th>
                    <th>Total Harga</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>No</th>
                    <th>No Transaksi</th>
                    <th>Tanggal</th>
                    <th>Nama Pelanggan</th>
                    <th>Total Harga</th>
                    <th>Action</th>
                </tr>
                </tfoot>
                <tbody>
                <?php 
                $no = 1;
                foreach($pengeluarans as $pengeluaran ) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $pengeluaran['no_transaksi'] ?></td>
                    <td><?= date('d-m-Y', strtotime($pengeluaran['date'])) ?></td>
                    <td><?= $pengeluaran['name'] ?></td>
                    <td>Rp. <?= number_format( $pengeluaran['total_price']) ?></td>
                    <td style="display: flex; align-items: center; gap: 10px;">
                        <a href="<?= base_url('/pengeluaran/edit') ?>/<?= $pengeluaran['id'] ?>" class="btn btn-warning btn-sm" style="margin-right: 5px;">
                            <i class="fas fa-pen"></i>
                        </a>
                        <a href="<?= base_url('/pengeluaran/view') ?>/<?= $pengeluaran['id'] ?>" class="btn btn-info btn-sm">
                            <i class="fas fa-info-circle"></i>
                        </a>
                        <a href="<?= base_url('/pengeluaran/view') ?>/<?= $pengeluaran['id'] ?>" class="btn btn-danger btn-sm">
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

