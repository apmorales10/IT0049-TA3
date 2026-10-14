# POS Forms, Validation, and File Upload

This CodeIgniter 4 project continues the simple POS pages from TA1 and TA2. The customer and user lists now read from MySQL. You can add and edit both record types, and upload a profile picture when editing a user.

## Pages

- `/customers` - list customers
- `/customers/new` - add a customer
- `/customers/{id}/edit` - edit a customer
- `/users` - list users and their avatars
- `/users/new` - add a user
- `/users/{id}/edit` - edit a user and optionally upload an avatar

## Run locally with XAMPP

1. Extract this folder as `C:\xampp\htdocs\pos-tfa3`.
2. Start Apache and MySQL in XAMPP.
3. In phpMyAdmin, create a new, empty database named `pos_tfa3`.
4. Select that database and import `database/pos_tfa3.sql` once. The SQL creates the customer and user tables and copies the TA sample records into them.
5. Open `http://localhost/pos-tfa3/`.

The included `.env` is set for the usual local XAMPP database (`root` with a blank password). If your local MySQL account differs, edit `.env`.

## Upload to a web host

1. Upload the **contents** of `pos-tfa3` so that `index.php`, `app`, `vendor`, and `uploads` are directly inside the host's `htdocs` folder.
2. Create a new, empty database using the hosting panel. Import `database/pos_tfa3.sql` into that database once.
3. Edit the hosted `.env`: set `app.baseURL` to the hosted URL with a trailing slash, set `CI_ENVIRONMENT = production`, and replace the database hostname, name, username, and password with the hosting panel's actual values.
4. Make sure the public `uploads` folder can be written by PHP. PHP also needs the GD image extension for the 300 by 300 avatar preparation.

If `/about` works but `/customers` or `/users` does not, check the hosted database settings and imported tables. If every page fails, check the host's error log and `writable/logs`.

## Before submission

- Test invalid forms, duplicate usernames, edits, and a JPG or PNG upload under 2 MB.
- Submit the project files and `database/pos_tfa3.sql` to GitHub.
- Keep `.env` and uploaded personal images out of public GitHub. `.env.example` shows the required settings without a real password.
- Submit the link to the hosted working site.
