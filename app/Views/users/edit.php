<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>
<body>
    <p><a href="<?= site_url('users') ?>">Back to Users</a></p>
    <h1>Edit User</h1>

    <form method="post" action="<?= site_url('users/' . $user['id'] . '/update') ?>" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <p>
            <label for="username">Username</label><br>
            <input id="username" name="username" type="text" maxlength="50" value="<?= esc(old('username', $user['username'], 'raw'), 'attr') ?>" required>
            <?= validation_show_error('username') ?>
        </p>

        <p>
            <label for="full_name">Full Name</label><br>
            <input id="full_name" name="full_name" type="text" maxlength="100" value="<?= esc(old('full_name', $user['full_name'], 'raw'), 'attr') ?>" required>
            <?= validation_show_error('full_name') ?>
        </p>

        <?php $selectedRole = old('role', $user['role'], 'raw'); ?>
        <p>
            <label for="role">Role</label><br>
            <select id="role" name="role" required>
                <?php foreach (['Administrator', 'Cashier', 'Manager', 'Staff'] as $role): ?>
                    <option value="<?= esc($role, 'attr') ?>" <?= $selectedRole === $role ? 'selected' : '' ?>><?= esc($role) ?></option>
                <?php endforeach; ?>
            </select>
            <?= validation_show_error('role') ?>
        </p>

        <p>
            <label for="avatar">Profile Picture (JPG or PNG, up to 2 MB)</label><br>
            <input id="avatar" name="avatar" type="file" accept="image/jpeg,image/png">
            <?= validation_show_error('avatar') ?>
        </p>

        <?php if (session()->getFlashdata('upload_error')): ?>
            <p><?= esc(session()->getFlashdata('upload_error')) ?></p>
        <?php endif; ?>

        <?php if (! empty($user['avatar'])): ?>
            <p>Current picture:<br><img src="<?= esc(base_url('uploads/' . $user['avatar']), 'attr') ?>" alt="Current avatar" width="100" height="100"></p>
        <?php endif; ?>

        <button type="submit">Update User</button>
    </form>
</body>
</html>
