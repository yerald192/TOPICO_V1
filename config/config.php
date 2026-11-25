<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// DEFINICIÓN DE RUTAS BASE
define('ROOT_PATH', dirname(__DIR__));
define('DB_PATH', ROOT_PATH . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'topico.db');
define('SCHEMA_PATH', ROOT_PATH . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'schema.sql');

// DETECCIÓN DINÁMICA DE LA URL BASE
$scheme = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https" : "http";
$host = $_SERVER['HTTP_HOST'] ?? '127.0.0.1:8095';
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
$scriptDir = trim(str_replace('\\', '/', dirname($scriptName)), '/.');
$baseUrl = $scriptDir ? "$scheme://$host/$scriptDir" : "$scheme://$host";

define('BASE_URL', rtrim($baseUrl, '/'));
define('APP_NAME', 'Tópico Médico Institucional');
define('APP_VERSION', '2.0.0');

// ZONA HORARIA
date_default_timezone_set('America/Lima');
