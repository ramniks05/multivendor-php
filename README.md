# Multi-Vendor Marketplace (Modesy 1.8.1)

PHP / CodeIgniter marketplace for Digital Creatorss. Deploy this repo to Hostinger (Apache + PHP 8.2 + MySQL/MariaDB).

## Hostinger deploy

1. Create a MySQL database in hPanel and note **host**, **database name**, **username**, and **password**.
2. Import your current local database (`modesy_db`) via phpMyAdmin. The stock installer dump is `install/sql/install_modesy.sql` (empty catalog). To keep products, brands, and vendors, export `modesy_db` from local phpMyAdmin and import that file instead.
3. In Hostinger **Git**, connect [https://github.com/ramniks05/multivendor-php.git](https://github.com/ramniks05/multivendor-php.git) and deploy into `public_html` (or the domain document root).
4. Edit `application/config/database.php` on the server:

```php
'hostname' => 'localhost',
'username' => 'YOUR_HOSTINGER_DB_USER',
'password' => 'YOUR_HOSTINGER_DB_PASSWORD',
'database' => 'YOUR_HOSTINGER_DB_NAME',
```

5. Confirm `.htaccess` is in the site root (Hostinger file manager may hide it). PHP `mod_rewrite` must be on.
6. Set folder permissions so PHP can write: `uploads/`, `application/cache/`, `application/logs/`.
7. Open the domain. Admin: `/admin/login`.

Local XAMPP stays on `127.0.0.1` / `root` / empty password / `modesy_db`. Hostinger credentials belong only on the server, not in this repo.

## Local (XAMPP)

PHP 8.2, MariaDB database `modesy_db`, then:

```text
C:\xampp\php\php.exe -S 127.0.0.1:8080 router.php
```

Site: http://127.0.0.1:8080/
