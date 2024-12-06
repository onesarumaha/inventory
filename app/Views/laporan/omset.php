<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row mb-12">
    <div class="col-lg-12">
        <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary"><?= $title ?></h6>
            <div class="d-flex align-items-center">
                <h6 class="m-0 font-weight-bold text-primary mr-3">
                    Total Omset: Rp. <span id="totalOmset"><?= number_format($totalOmset) ?></span>
                </h6>
                <div class="dropdown mr-3">
                    <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Export
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="#" id="exportPdf">Export PDF</a>
                        <a class="dropdown-item" href="#" id="exportExcel">Export Excel</a>
                    </div>
                </div>
                <a href="<?= base_url('/supplier/create') ?>" type="button" class="btn btn-primary"
                data-toggle="modal" data-target="#exampleModalLaporan" id="#myBtn">
                Advance Filter
                </a>
            </div>
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
                    <?php if (empty($omsets)) : ?>
                        <tr>
                            <td colspan="5" class="text-center">No Data</td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($omsets as $omset) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= date('d-m-Y H:i:s', strtotime($omset['date'])) ?></td>
                                <td><?= $omset['name'] ?? '-' ?></td>
                                <td><?= $omset['quantity'] ?></td>
                                <td>Rp. <?= number_format($omset['omset']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        </div>
    </div>
</div>


<div class="modal fade" id="exampleModalLaporan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Filter Laporan Omset</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
                <div class="form-group">
                      <label for="exampleFormControlInputStartDate">Start Date</label>
                      <input type="date" class="form-control" id="exampleFormControlInputStartDate">
                </div>
                <div class="form-group">
                      <label for="exampleFormControlInputEndDate">End Date</label>
                      <input type="date" class="form-control" id="exampleFormControlInputEndDate">
                </div>
                <?php $role = session()->get('role');  ?>
                <div class="form-group">
                    <label for="exampleFormControlSelect1Petugas"></label>
                    <?php if ($role === 'petugas'): ?>
                        <input type="hidden" name="petugas_id" id="exampleFormControlSelect1Petugas" value="<?= session()->get('id') ?>">
                    <?php else: ?>
                        <select class="form-control" id="exampleFormControlSelect1Petugas" name="petugas_id">
                            <option value="">Pilih Petugas</option>
                            <?php foreach ($petugas as $data): ?>
                                <option value="<?= $data['id'] ?>"><?= $data['username'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    <?php endif; ?>
                </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="filterButton">Filter</button>
            </div>
        </div>
    </div>
</div>


<script>
document.getElementById('filterButton').addEventListener('click', function () {
    const startDate = document.getElementById('exampleFormControlInputStartDate').value;
    const endDate = document.getElementById('exampleFormControlInputEndDate').value;
    const petugasId = document.getElementById('exampleFormControlSelect1Petugas').value;

    const url = new URL('<?= base_url('/filter-omset') ?>');
    url.searchParams.append('startDate', startDate);
    url.searchParams.append('endDate', endDate);
    url.searchParams.append('petugasId', petugasId);

    fetch(url, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
        },
    })
    .then(response => response.json())
    .then(data => {
        let tableBody = '';
        data.data.forEach((stock, index) => {
            const date = new Date(stock.date);
            const formattedDate = date.toLocaleDateString('id-ID', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
            });
            tableBody += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${formattedDate}</td>
                    <td>${stock.product_name}</td>
                    <td>${stock.quantity}</td>
                    <td>Rp. ${new Intl.NumberFormat('id-ID').format(stock.omset)}</td>
                </tr>
            `;
        });
        document.querySelector('tbody').innerHTML = tableBody;

        document.getElementById('totalOmset').innerText = new Intl.NumberFormat('id-ID').format(data.totalOmset);

        $('#exampleModalLaporan').modal('hide');
    })
    .catch(error => console.error('Error:', error));
});


document.getElementById('exportExcel').addEventListener('click', function () {
    const startDate = document.getElementById('exampleFormControlInputStartDate').value;
    const endDate = document.getElementById('exampleFormControlInputEndDate').value;
    const petugasId = document.getElementById('exampleFormControlSelect1Petugas').value;

    const url = new URL('<?= base_url('/export-data-omset') ?>');
    url.searchParams.append('startDate', startDate);
    url.searchParams.append('endDate', endDate);
    url.searchParams.append('petugasId', petugasId);
    url.searchParams.append('action', 'excel'); 

    window.location.href = url;
});

document.getElementById('exportPdf').addEventListener('click', function () {
    const startDate = document.getElementById('exampleFormControlInputStartDate').value;
    const endDate = document.getElementById('exampleFormControlInputEndDate').value;
    const petugasId = document.getElementById('exampleFormControlSelect1Petugas').value;

    const url = new URL('<?= base_url('/export-data-omset') ?>');
    url.searchParams.append('startDate', startDate);
    url.searchParams.append('endDate', endDate);
    url.searchParams.append('petugasId', petugasId);
    url.searchParams.append('action', 'pdf'); 

    window.location.href = url;
});


</script>



<?= $this->endSection() ?>

