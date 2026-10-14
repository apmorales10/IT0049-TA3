<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Customer</title>
</head>
<body>
    <p><a href="<?= site_url('customers') ?>">Back to Customers</a></p>
    <h1>New Customer</h1>

    <form method="post" action="<?= site_url('customers/create') ?>">
        <?= csrf_field() ?>

        <p>
            <label for="full_name">Full Name</label><br>
            <input id="full_name" name="full_name" type="text" maxlength="100" value="<?= esc(old('full_name', '', 'raw'), 'attr') ?>" required>
            <?= validation_show_error('full_name') ?>
        </p>

        <p>
            <label for="email">Email Address</label><br>
            <input id="email" name="email" type="email" maxlength="100" value="<?= esc(old('email', '', 'raw'), 'attr') ?>" required>
            <?= validation_show_error('email') ?>
        </p>

        <p>
            <label for="phone">Phone Number</label><br>
            <input id="phone" name="phone" type="text" maxlength="20" value="<?= esc(old('phone', '', 'raw'), 'attr') ?>">
            <?= validation_show_error('phone') ?>
        </p>

        <button type="submit">Save Customer</button>
    </form>
</body>
</html>
