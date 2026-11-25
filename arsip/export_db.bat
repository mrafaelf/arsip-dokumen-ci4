@echo off
set OUT=%~dp0backup_arsip_db.sql
set MD=
if exist "C:\xampp\mysql\bin\mysqldump.exe" set MD=C:\xampp\mysql\bin\mysqldump.exe
if exist "D:\xampp\mysql\bin\mysqldump.exe" set MD=D:\xampp\mysql\bin\mysqldump.exe
if "%MD%"=="" (echo mysqldump tidak ditemukan. Gunakan phpMyAdmin ^> Export. & pause & exit /b)
"%MD%" -u root --databases arsip_db > "%OUT%"
echo Backup tersimpan di: %OUT%
pause
