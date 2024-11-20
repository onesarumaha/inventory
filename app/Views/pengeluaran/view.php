<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row mb-12">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?= $title ?></h6>
            </div>
            <div class="card-body">
                <p><strong>Tanggal Transaksi:</strong> <?= date('d-m-Y', strtotime($transaksi['date'])) ?></p>
                <p><strong>Customer :</strong> <?= $transaksi['nama_customer'] ?></p>
                <p><strong>Total:</strong> <?= number_format($transaksi['total_price'], 2, ',', '.') ?></p>
            </div>
        </div>
    </div>
</div>

<div class="row mb-12">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12 mb-4">
              <!-- Simple Tables -->
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">List product</h6>
                </div>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>No</th>
                        <th>Nama Product</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Total</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $no = 1;
                    foreach ($transaksiItems as $index => $item): ?>

                      <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $item['nama_product'] ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td><?= $item['price'] ?></td>
                        <td>Rp. <?= number_format($item['quantity'] * $item['price'] )?></td>
                      </tr>
                     <?php endforeach ?>
                    </tbody>
                  </table>
                </div>
                <div class="card-footer"></div>
              </div>
            </div>
          </div>
    </div>
</div>

<?= $this->endSection() ?>