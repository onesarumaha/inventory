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
                                    <th scope="row">Status</th>
                                    <td><?= $user->status ?></td>
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
                </div>
               
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
