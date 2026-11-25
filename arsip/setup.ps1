# Instalasi otomatis Sistem Arsip Dokumen (CodeIgniter 4)
$ErrorActionPreference = 'Stop'
$src    = $PSScriptRoot
$target = Join-Path (Split-Path $src -Parent) 'arsip-dokumen'

# Cari PHP bawaan XAMPP jika belum ada di PATH
if (-not (Get-Command php -ErrorAction SilentlyContinue)) {
    foreach ($p in 'C:\xampp\php','D:\xampp\php','E:\xampp\php') {
        if (Test-Path "$p\php.exe") { $env:Path = "$p;$env:Path"; break }
    }
}
if (-not (Get-Command php -ErrorAction SilentlyContinue))      { Write-Host 'PHP tidak ditemukan. Pasang XAMPP dulu.' -ForegroundColor Red; exit 1 }
if (-not (Get-Command composer -ErrorAction SilentlyContinue)) { Write-Host 'Composer belum terpasang. Pasang dari getcomposer.org lalu jalankan ulang.' -ForegroundColor Red; exit 1 }

Write-Host '[1/6] Memasang CodeIgniter 4...' -ForegroundColor Cyan
if (-not (Test-Path $target)) { composer create-project codeigniter4/appstarter $target }

Write-Host '[2/6] Menyalin file aplikasi...' -ForegroundColor Cyan
foreach ($d in 'Controllers','Models','Filters','Views') {
    Copy-Item "$src\app\$d" "$target\app\" -Recurse -Force
}

Write-Host '[3/6] Mengatur Routes, Filters, dan App.php...' -ForegroundColor Cyan
$routes = "$target\app\Config\Routes.php"
$r = Get-Content $routes -Raw
if ($r -notmatch 'Auth::attempt') {
    $r = $r -replace "\`$routes->get\('/', 'Home::index'\);", ''
    $r = $r + "`r`n" + (Get-Content "$src\app\routes_append.txt" -Raw)
    Set-Content $routes $r -Encoding UTF8
}
$filters = "$target\app\Config\Filters.php"
$t = Get-Content $filters -Raw
if ($t -notmatch 'AuthFilter') {
    $t = $t -replace "('toolbar'\s*=>\s*DebugToolbar::class,)", ('$1' + "`r`n        'auth' => \App\Filters\AuthFilter::class,")
}
$t = $t -replace "//\s*'csrf',", "'csrf',"
Set-Content $filters $t -Encoding UTF8
$appCfg = "$target\app\Config\App.php"
$a = Get-Content $appCfg -Raw
$a = $a -replace 'public string \$indexPage = ''index.php'';', 'public string $$indexPage = '''';'
Set-Content $appCfg $a -Encoding UTF8

Write-Host '[4/6] Membuat file .env...' -ForegroundColor Cyan
$envText = @"
CI_ENVIRONMENT = development
app.baseURL = 'http://localhost:8080/'
database.default.hostname = localhost
database.default.database = arsip_db
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.port = 3306
"@
Set-Content "$target\.env" $envText -Encoding ASCII

Write-Host '[5/6] Membuat folder upload...' -ForegroundColor Cyan
New-Item -ItemType Directory "$target\writable\uploads\archives" -Force | Out-Null

Write-Host '[6/6] Import database (jika MySQL aktif)...' -ForegroundColor Cyan
$mysql = 'C:\xampp\mysql\bin\mysql.exe','D:\xampp\mysql\bin\mysql.exe','E:\xampp\mysql\bin\mysql.exe' | Where-Object { Test-Path $_ } | Select-Object -First 1
if ($mysql) {
    cmd /c "`"$mysql`" -u root < `"$src\database\arsip_db.sql`""
    if ($LASTEXITCODE -eq 0) { Write-Host 'Database arsip_db berhasil diimport.' -ForegroundColor Green }
    else { Write-Host 'Import gagal. Import manual lewat phpMyAdmin (lihat README).' -ForegroundColor Yellow }
} else {
    Write-Host 'mysql.exe tidak ditemukan. Import manual lewat phpMyAdmin (lihat README).' -ForegroundColor Yellow
}

Write-Host "`nSELESAI. Jalankan jalankan.bat atau ketik: cd `"$target`" lalu php spark serve" -ForegroundColor Green
Write-Host 'Buka http://localhost:8080  |  Login: admin@arsip.test / admin123'
