<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($titulo) ? htmlspecialchars($titulo) . ' - ' : '' ?><?= APP_NAME ?></title>
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Estilos de la aplicación -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/style.css">
    <style>
        .nav-dropdown {
            position: relative;
            display: inline-block;
        }
        .nav-dropdown-content {
            display: none;
            position: absolute;
            background-color: #ffffff;
            min-width: 200px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            z-index: 1000;
            top: 100%;
            left: 0;
            padding: 6px 0;
        }
        .nav-dropdown:hover .nav-dropdown-content {
            display: block;
        }
        .nav-dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 16px;
            color: #334155;
            text-decoration: none;
            font-size: 0.88rem;
            font-weight: 500;
            transition: background 0.15s;
        }
        .nav-dropdown-item:hover {
            background-color: #f1f5f9;
            color: #2563eb;
        }
    </style>
</head>
<body>
    <!-- HEADER INSTITUCIONAL -->
    <header class="main-header">
        <div class="header-container" style="max-width: 1400px;">
            <div class="brand">
                <a href="<?= BASE_URL ?>/" style="display: flex; align-items: center; gap: 12px; text-decoration: none;">
                    <?php if (file_exists(ROOT_PATH . '/public/img/logo.png')): ?>
                        <img src="<?= BASE_URL ?>/public/img/logo.png" alt="Logo IESP Huanta" style="height: 40px; width: auto; object-fit: contain;">
                    <?php else: ?>
                        <i class="fa-solid fa-notes-medical brand-icon"></i>
                    <?php endif; ?>
                    <div class="brand-text">
                        <span class="brand-title">TÓPICO INSTITUCIONAL</span>
                        <span class="brand-subtitle">IESP Huanta • Base de Datos Integrada</span>
                    </div>
                </a>
            </div>

            <nav class="main-nav">
                <a href="<?= BASE_URL ?>/" class="nav-link <?= empty($_GET['url']) || $_GET['url'] === 'home' ? 'active' : '' ?>">
                    <i class="fa-solid fa-chart-pie"></i> Inicio
                </a>

                <div class="nav-dropdown">
                    <a href="javascript:void(0)" class="nav-link <?= in_array(explode('/', $_GET['url'] ?? '')[0], ['paciente', 'atencion', 'historial', 'derivacion']) ? 'active' : '' ?>">
                        <i class="fa-solid fa-stethoscope"></i> Área Médica <i class="fa-solid fa-angle-down" style="font-size: 0.75rem;"></i>
                    </a>
                    <div class="nav-dropdown-content">
                        <a href="<?= BASE_URL ?>/paciente" class="nav-dropdown-item">
                            <i class="fa-solid fa-users" style="color: #2563eb;"></i> Pacientes
                        </a>
                        <a href="<?= BASE_URL ?>/atencion" class="nav-dropdown-item">
                            <i class="fa-solid fa-stethoscope" style="color: #059669;"></i> Atenciones Médicas
                        </a>
                        <a href="<?= BASE_URL ?>/historial" class="nav-dropdown-item">
                            <i class="fa-solid fa-clock-rotate-left" style="color: #d97706;"></i> Historial Clínico
                        </a>
                        <a href="<?= BASE_URL ?>/derivacion" class="nav-dropdown-item">
                            <i class="fa-solid fa-truck-medical" style="color: #dc2626;"></i> Derivaciones
                        </a>
                    </div>
                </div>

                <div class="nav-dropdown">
                    <a href="javascript:void(0)" class="nav-link <?= in_array(explode('/', $_GET['url'] ?? '')[0], ['producto', 'inventario', 'equipo']) ? 'active' : '' ?>">
                        <i class="fa-solid fa-boxes-stacked"></i> Recursos & Farmacia <i class="fa-solid fa-angle-down" style="font-size: 0.75rem;"></i>
                    </a>
                    <div class="nav-dropdown-content">
                        <a href="<?= BASE_URL ?>/producto" class="nav-dropdown-item">
                            <i class="fa-solid fa-pills" style="color: #7c3aed;"></i> Stock de Medicamentos
                        </a>
                        <a href="<?= BASE_URL ?>/inventario" class="nav-dropdown-item">
                            <i class="fa-solid fa-clipboard-check" style="color: #0284c7;"></i> Toma de Inventario
                        </a>
                        <a href="<?= BASE_URL ?>/equipo" class="nav-dropdown-item">
                            <i class="fa-solid fa-heart-pulse" style="color: #e11d48;"></i> Equipos Médicos
                        </a>
                    </div>
                </div>

                <a href="<?= BASE_URL ?>/reporte" class="nav-link <?= strpos($_GET['url'] ?? '', 'reporte') === 0 ? 'active' : '' ?>">
                    <i class="fa-solid fa-chart-line"></i> Reportes
                </a>

                <div class="nav-dropdown">
                    <a href="javascript:void(0)" class="nav-link <?= strpos($_GET['url'] ?? '', 'personal') === 0 ? 'active' : '' ?>">
                        <i class="fa-solid fa-user-shield"></i> Gestión <i class="fa-solid fa-angle-down" style="font-size: 0.75rem;"></i>
                    </a>
                    <div class="nav-dropdown-content">
                        <a href="<?= BASE_URL ?>/personal" class="nav-dropdown-item">
                            <i class="fa-solid fa-users-gear" style="color: #0f172a;"></i> Usuarios / Personal
                        </a>
                        <a href="<?= BASE_URL ?>/personal/asistencia" class="nav-dropdown-item">
                            <i class="fa-solid fa-calendar-check" style="color: #059669;"></i> Control de Asistencia
                        </a>
                    </div>
                </div>
            </nav>

            <div class="header-status" style="display: flex; align-items: center; gap: 12px;">
                <span class="badge-sqlite" title="Base de datos SQLite embebida">
                    <i class="fa-solid fa-database"></i> SQLite
                </span>

                <?php if (!empty($_SESSION['usuario_nombre'])): ?>
                    <span style="font-size: 0.85rem; font-weight: 600; color: #1e293b;">
                        <i class="fa-solid fa-user-circle"></i> <?= htmlspecialchars($_SESSION['usuario_nombre']) ?>
                    </span>
                    <a href="<?= BASE_URL ?>/auth/logout" class="btn btn-outline" style="padding: 5px 10px; font-size: 0.8rem;" title="Cerrar sesión">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    </a>
                <?php else: ?>
                    <a href="<?= BASE_URL ?>/auth/login" class="btn btn-outline" style="padding: 6px 12px; font-size: 0.85rem;">
                        <i class="fa-solid fa-lock"></i> Acceso
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- CONTENEDOR PRINCIPAL -->
    <main class="main-content" style="max-width: 1400px;">
        <!-- MENSAJES FLASH / NOTIFICACIONES -->
        <?php if (!empty($_SESSION['mensaje'])): ?>
            <div class="alert alert-success">
                <i class="fa-solid fa-circle-check"></i>
                <span><?= htmlspecialchars($_SESSION['mensaje']) ?></span>
                <button type="button" class="alert-close" onclick="this.parentElement.remove();">&times;</button>
            </div>
            <?php unset($_SESSION['mensaje']); ?>
        <?php endif; ?>

        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <span><?= htmlspecialchars($_SESSION['error']) ?></span>
                <button type="button" class="alert-close" onclick="this.parentElement.remove();">&times;</button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
