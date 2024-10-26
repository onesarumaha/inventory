<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row mb-12">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?= $title ?></h6>
            </div>
            <div class="card-body">
            <form action="<?= isset($users) ? base_url('/users/update/'.$users['id']) : base_url('/users/store'); ?>" method="POST">
            <?= csrf_field(); ?>
                <div class="form-group">
                    <label for="exampleInputName1">Nama User</label>
                    <input type="text" class="form-control" name="username" id="exampleInputName1" aria-describedby="emailHelp"
                    placeholder="Nama User" value="<?= old('username', isset($users) ? $users['username'] : ''); ?>">
                    <?php if (session()->getFlashdata('errors')['username'] ?? null): ?>
                        <div style="color: red;">
                            <?= session()->getFlashdata('errors')['username']; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                    <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp"
                    placeholder="Email" value="<?= old('email', isset($users) ? $users['email'] : ''); ?>">
                    <?php if (session()->getFlashdata('errors')['email'] ?? null): ?>
                        <div style="color: red;">
                            <?= session()->getFlashdata('errors')['email']; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Role</label>
                    <select class="form-control" id="exampleFormControlSelect1" name="role">
                        <option value="admin" <?= old('role', isset($users) && $users['role'] === 'admin' ? 'selected' : ''); ?>>Admin</option>
                        <option value="petugas" <?= old('role', isset($users) && $users['role'] === 'petugas' ? 'selected' : ''); ?>>Petugas</option>
                    </select>
                    <?php if (session()->getFlashdata('errors')['role'] ?? null): ?>
                        <div style="color: red;">
                            <?= session()->getFlashdata('errors')['role']; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="hidden" name="active" value="0">
                        <input type="checkbox" class="custom-control-input" name="active" id="customSwitch1" 
                            value="1" <?= old('active', isset($users) && $users['active'] ? 'checked' : ''); ?>>
                        <label class="custom-control-label" for="customSwitch1">User Active</label>
                    </div>
                </div>
            
                <button type="submit" class="btn btn-primary"><?= isset($users) ? 'Update' : 'Create'; ?></button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>