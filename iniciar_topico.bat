@echo off
title Topico Medico - Sistema Autonomo
echo ==========================================================
echo   TOPICO MEDICO INSTITUCIONAL - IESP HUANTA (V2 MVC)
echo   Iniciando con Base de Datos Integrada (SQLite)
echo   [Cero servidores externos - Sin XAMPP / Sin MySQL]
echo ==========================================================
echo.

REM 1. Comprobar si existe la base de datos o inicializarla
php -r "require 'config/config.php'; require 'config/Database.php'; Database::getInstance();" >nul 2>&1

REM 2. Comprobar si Electron esta disponible
if exist "electron\node_modules\electron\dist\electron.exe" (
    echo Iniciando interfaz de escritorio con Electron...
    start "" "electron\node_modules\electron\dist\electron.exe" "electron"
    exit
)

REM 3. Alternativa directa: Iniciar servidor PHP integrado y abrir en navegador
echo Iniciando servidor integrado en http://127.0.0.1:8095 ...
start http://127.0.0.1:8095
php -S 127.0.0.1:8095 index.php
pause
