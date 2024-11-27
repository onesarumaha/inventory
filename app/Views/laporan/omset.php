<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row mb-12">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?= $title ?></h6>
                <h6 class="m-0 font-weight-bold text-primary text-left">
                    Total Omset : Rp. <span id="totalOmset"><?= number_format($totalOmset) ?></span>
                </h6>
                <a href="<?= base_url('/supplier/create') ?>" type="button" class="btn btn-primary mb-1" data-toggle="modal" data-target="#exampleModalLaporan"
                id="#myBtn">Advance Filter</a>
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
                    <td><?= date('d-m-Y H:s:i', strtotime($omset['date'])) ?></td>
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
                <div class="form-group">
                      <label for="exampleFormControlSelect1Petugas">Petugas</label>
                      <select class="form-control" id="exampleFormControlSelect1Petugas">
                        <option>Pilih Petugas</option>
                        <?php foreach($petugas as $data) : ?>
                            <option value="<?= $data['id'] ?>"><?= $data['username'] ?></option>
                        <?php endforeach; ?>                        
                      </select>
                </div>

                <div class="form-group">
                      <label for="exampleFormControlSelectType">Type</label>
                      <select class="form-control" id="exampleFormControlSelectType">
                        <option>Pilih Type</option>
                            <option value="in">In</option>
                            <option value="out">Out</option>
                      </select>
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
    const type = document.getElementById('exampleFormControlSelectType').value;

    const url = new URL('<?= base_url('/filter-omset') ?>');
    url.searchParams.append('startDate', startDate);
    url.searchParams.append('endDate', endDate);
    url.searchParams.append('petugasId', petugasId);
    url.searchParams.append('type', type);

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
            tableBody += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${new Date(stock.date).toLocaleDateString('id-ID')}</td>
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
</script>



<?= $this->endSection() ?>

