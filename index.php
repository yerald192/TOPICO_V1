<?php
// ==========================================================
// 1. ATENDER ARCHIVOS ESTÁTICOS EN EL SERVIDOR INTERNO PHP (CLI-SERVER)
// Si la petición corresponde a un archivo físico existente (CSS, JS, imágenes, fuentes),
// retornar false para que el servidor interno de PHP lo entregue directamente con su MIME type nativo.
// ==========================================================
if (php_sapi_name() === 'cli-server') {
    $urlPath = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
    $filePath = __DIR__ . $urlPath;
    if ($urlPath !== '/' && $urlPath !== '' && file_exists($filePath) && !is_dir($filePath)) {
        return false;
    }
}

// ==========================================================
// 2. PUNTO DE ENTRADA FRONTAL (FRONT CONTROLLER)
// ==========================================================

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/Database.php';
require_once __DIR__ . '/core/Model.php';
require_once __DIR__ . '/core/Controller.php';
require_once __DIR__ . '/core/App.php';

// INICIAR APLICACIÓN
$app = new App();
