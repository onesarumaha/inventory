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
                    <th>Tanggal</th>
                    <th>Harga</th>
                    <th>Quantity</th>
                    <th>Supplier</th>
                    <th>Status</th>
                    <th>Dibuat</th>
                    <th>Action</th>
                </tr>
                </thead>
             
                <tbody>
                <?php 
                $no = 1;
                foreach($pemasukans as $pemasukan ) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $pemasukan['nama_product'] ?? '-'; ?></td> 
                    <td><?= date('d-m-Y H:s:i', strtotime($pemasukan['date'])) ?></td>
                    <td>Rp. <?= number_format( $pemasukan['price'] ) ?></td>
                    <td><?= $pemasukan['quantity'] ?></td>
                    <td><?= $pemasukan['nama_supplier'] ?></td>
                    <td>
                    <?php 
                        if ($pemasukan['status'] == 0) {
                            echo '<span class="badge bg-warning text-light">Menunggu di approve admin</span>';
                        } elseif ($pemasukan['status'] == 1) {
                            echo '<span class="badge bg-primary text-light">Approve Admin</span>';
                        } elseif ($pemasukan['status'] == 2) {
                            echo '<span class="badge bg-success text-light">Approve</span>';
                        } elseif ($pemasukan['status'] == 3) {
                            echo '<span class="badge bg-success text-light">Selesai</span>';
                        } elseif ($pemasukan['status'] == 4) {
                            echo '<span class="badge bg-danger text-light">Reject</span>';
                        }else {
                            echo 'Status tidak diketahui';
                        }
                        ?>
                    </td>
                    <td><?= $pemasukan['nama_user'] ?? 'Tidak ada user'; ?></td>


                    <td style="display: flex; align-items: center; gap: 10px;">
                        <?php if (session()->get('role') === 'petugas'): ?>
                            <?php if($pemasukan['status'] != 3) : ?>
                                <a href="<?= base_url('/pemasukan/edit') ?>/<?= $pemasukan['id'] ?>" class="btn btn-warning btn-sm" style="margin-right: 5px;">
                                    <i class="fas fa-pen"></i>
                                </a>
                                
                            <a href="javascript:void(0);" class="btn btn-danger btn-sm" onclick="confirmDelete(<?= $pemasukan['id'] ?>)">
                                <i class="fas fa-trash"></i>
                            </a>
                            <?php endif; ?>
                            <a href="<?= base_url('/pemasukan/view/') ?><?= $pemasukan['id'] ?>" class="btn btn-success btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                            <?php if($pemasukan['status'] == 2) : ?>
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"  data-target="#exampleModal" data-id="<?= $pemasukan['id'] ?>"> <i class="fas fa-list"></i></button>
                            <?php endif; ?>

                           
                        <?php endif; ?>
                        

                        <?php if (session()->get('role') === 'admin'): ?>
                            <a href="javascript:void(0);" class="btn btn-warning btn-sm" onclick="confirmAdmin(<?= $pemasukan['id'] ?>)">
                                <i class="fas fa-check"></i>
                            </a>

                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"  data-target="#exampleModalReject" data-id="<?= $pemasukan['id'] ?>"> 
                             X
                            </button>


                        <?php elseif (session()->get('role') === 'owner'): ?>
                            <a href="javascript:void(0);" class="btn btn-success btn-sm" onclick="confirmOwner(<?= $pemasukan['id'] ?>)">
                                <i class="fas fa-thumbs-up"></i>
                            </a>
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"  data-target="#exampleModalReject" data-id="<?= $pemasukan['id'] ?>"> 
                             X
                            </button>
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


 <!-- Modal -->
 <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Check Quantity</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="modalForm">
                <div class="modal-body">
                    <input type="hidden" id="modalId" name="id">
                    <div class="form-group">
                        <label for="modalQuantityBiasa">Quantity </label>
                        <input type="number" class="form-control" id="modalQuantityBiasa"  readonly>
                    </div>
                    <div class="form-group">
                        <label for="modalQuantity">Quantity Real</label>
                        <input type="number" class="form-control" id="modalQuantity"  name="quantity_real" placeholder="Masukkan Quantity Real" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Cek</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModalReject" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Reject Pengadaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="modalFormReject">
                <div class="modal-body">
                    <input type="hidden" id="modalIdReject" name="id">
                    <div class="form-group">
                      <label for="exampleFormControlTextarea1">Keterangan</label>
                      <textarea class="form-control" id="exampleFormControlTextarea1" name="ket" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Reject</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#exampleModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); 
            var id = button.data('id'); 
            console.log(id);
            $('#modalId').val(id); 


        var row = button.closest('tr'); 
        var quantity = row.find('td:nth-child(5)').text(); 

        $('#modalId').val(id); 
        $('#modalQuantityBiasa').val(quantity.trim()); 


        });

        $('#modalForm').on('submit', function (e) {
        e.preventDefault(); 

        var currentQuantity = parseInt($('#modalQuantityBiasa').val(), 10); 
        var newQuantity = parseInt($('#modalQuantity').val(), 10); 

        if (newQuantity > currentQuantity) {
            Swal.fire({
                title: 'Error!',
                text: 'Quantity yang anda masukkan terlalu besar.',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            return; 
        }

        if (newQuantity < currentQuantity) {
            Swal.fire({
                title: 'Error!',
                text: 'Quantity yang anda masukkan terlalu kecil.',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            return; 
        }

        if (newQuantity <= 0) {
            Swal.fire({
                title: 'Error!',
                text: 'Quantity harus lebih dari 0.',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            return; 
        }

        var formData = $(this).serialize(); 

        $.ajax({
            url: '<?= base_url('/pemasukan/save-quantity') ?>', 
            method: 'POST',
            data: formData,
            success: function (response) {
                if (response.status === 'success') {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        $('#exampleModal').modal('hide'); 
                        location.reload(); 
                    });
                } else {
                    Swal.fire({
                        title: 'Gagal!',
                        text: response.message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function () {
                Swal.fire({
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat menyimpan data.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });


    // reject nya

    $('#exampleModalReject').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); 
        var id = button.data('id'); 
        $('#modalIdReject').val(id); 
    });

    $('#modalFormReject').on('submit', function (e) {
        e.preventDefault(); 
        var formData = $(this).serialize(); 

        $.ajax({
            url: '<?= base_url('/pemasukan/save-reject') ?>',
            method: 'POST',
            data: formData,
            success: function (response) {
                if (response.status === 'success') {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        $('#exampleModalReject').modal('hide'); 
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Gagal!',
                        text: response.message || 'Data gagal disimpan.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function () {
                Swal.fire({
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat menyimpan data.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });

});




</script>

<?= $this->endSection() ?>

