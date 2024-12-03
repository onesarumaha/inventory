<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row mb-12">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?= $title ?></h6>
            </div>
            <div class="card-body">
                <p><strong>Tanggal:</strong> <?= date('d-m-Y H:s:i', strtotime($pemasukan['date'])) ?></p>
                <p><strong>Supplier :</strong> <?= $supplier['name'] ?? 'Unknown' ?></p>
                <p><strong>Lampiran:</strong> 
                    <?php if (!empty($pemasukan['upload'])): ?>
                        <a href="<?= site_url('pemasukan/download/' . $pemasukan['upload']) ?>">Download</a>
                    <?php else: ?>
                        Tidak ada lampiran
                    <?php endif; ?>
                </p>
                <p><strong>Alasan Reject :</strong> <?= $pemasukan['ket'] ?? '-' ?></p>
                <p><strong>Dibuat :</strong> <?= $user['username'] ?? '-' ?></p>

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
                        <th>Nama Product</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Total</th>
                      </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><?= $product['name'] ?></td>
                        <td><?= $pemasukan['quantity'] ?></td>
                        <td>Rp. <?= number_format($pemasukan['price']) ?></td>
                        <td>Rp. <?= number_format($pemasukan['price'] * $pemasukan['quantity'], 0, ',', '.') ?></td>
                        </tr>
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