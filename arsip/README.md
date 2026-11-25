# Sistem Arsip Dokumen (CodeIgniter 4 + MySQL)

## Cara tercepat (Windows)
1. Pasang XAMPP (PHP 8.1+) dan Composer. Start **MySQL** di XAMPP Control Panel.
2. Ekstrak ZIP, lalu klik dua kali **setup.bat**.
3. Klik dua kali **jalankan.bat**, browser terbuka di http://localhost:8080
4. Login: admin@arsip.test / admin123
- Backup database: klik dua kali **export_db.bat**.
- Jika import otomatis gagal: phpMyAdmin > Import > database/arsip_db.sql.

## Cara manual

Login: **admin@arsip.test** / **admin123** (segera ganti setelah deploy).

## Instalasi
1. `composer create-project codeigniter4/appstarter arsip-dokumen` lalu masuk ke foldernya.
2. Salin isi folder `app/` dari project ini ke `app/` CodeIgniter (Controllers, Models, Filters, Views).
3. Import `database/arsip_db.sql` lewat phpMyAdmin / `mysql -u root -p < database/arsip_db.sql`.
4. `cp env .env` lalu isi:
   ```
   CI_ENVIRONMENT = production
   app.baseURL = 'https://domain-anda.com/'
   database.default.hostname = localhost
   database.default.database = arsip_db
   database.default.username = USER_DB
   database.default.password = PASS_DB
   database.default.DBDriver = MySQLi
   ```
5. `app/Config/Routes.php`: salin isi `Routes_tempelkan_ke_Config_Routes.php`.
6. `app/Config/Filters.php`:
   - di `$aliases` tambahkan `'auth' => \App\Filters\AuthFilter::class,`
   - di `$globals['before']` aktifkan `'csrf'`.
7. `app/Config/App.php`: set `public string $indexPage = '';`
8. Buat folder upload: `mkdir -p writable/uploads/archives && chmod -R 775 writable`
9. Jalankan lokal: `php spark serve` → http://localhost:8080

## Deploy hosting
- Arahkan document root domain/subdomain ke folder `public/`.
- Jika tidak bisa, pindahkan isi `public/` ke `public_html` dan ubah path `FCPATH`/`Paths.php` di `index.php`.
- Pastikan PHP >= 8.1 dengan ekstensi intl, mbstring, mysqlnd, fileinfo.
- File dokumen disimpan di `writable/uploads/archives` (tidak bisa diakses langsung, hanya lewat login).
