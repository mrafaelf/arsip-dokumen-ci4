@echo off
set TARGET=%~dp0..\arsip-dokumen
if exist "C:\xampp\php\php.exe" set PATH=C:\xampp\php;%PATH%
if exist "D:\xampp\php\php.exe" set PATH=D:\xampp\php;%PATH%
cd /d "%TARGET%"
start http://localhost:8080
php spark serve
