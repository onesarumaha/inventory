<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row mb-12">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?= $title ?></h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Profile Details -->
                    <div class="col-md-8">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <th scope="row">Full Name</th>
                                    <td><?= $user->username ?></td>
                                </tr>
                                <tr>
                                    <th scope="row">Email</th>
                                    <td><?= $user->email ?></td>
                                </tr>
                              
                                <tr>
                                    <th scope="row">Active</th>
                                    <td><?= $user->active ? '<span class="badge badge-success"> Aktif</span>' : '<span class="badge badge-danger">Tidak Aktif</span>' ?></td>
                                    </tr>
                                <tr>
                                    <th scope="row">Role</th>
                                    <td><?= $user->role ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-4 text-center">
                        <img id="profile-photo" src="<?= base_url('uploads/' . (!empty($user->photos) ? $user->photos : 'default.png')) ?>" alt="Profile Photo" class="img-thumbnail mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                        
                        <form id="photo-upload-form" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <input type="file" name="photos" class="form-control-file mb-3" accept="image/*" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Ganti Profile</button>
                        </form>
                    </div>
                </div>
               
            </div>
        </div>
    </div>
</div>



<script>
 document.getElementById('photo-upload-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    let formData = new FormData(this);
    
    $.ajax({
        url: '<?= base_url('/update-photo') ?>',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
        },
        success: function(response) {
            if (response.success) {
                document.getElementById('profile-photo').src = '<?= base_url('uploads/') ?>' + response.photos;
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Photo Profile berhasil di perbaharui.',
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Gagal memperbarui foto: ' + response.message,
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            
            let errorMessage = 'Terjadi kesalahan pada pengunggahan. Silakan coba lagi.';
            
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = 'Error: ' + xhr.responseJSON.message;
            } else if (xhr.responseText) {
                errorMessage = 'Error: ' + xhr.responseText;
            }
            
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan!',
                text: errorMessage,
            });
        }
    });
});

</script>

<?= $this->endSection() ?>
