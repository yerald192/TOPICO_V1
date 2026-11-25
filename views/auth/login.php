<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso al Sistema - <?= APP_NAME ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/style.css">
    <style>
        .login-body {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .login-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.25);
            width: 100%;
            max-width: 440px;
            overflow: hidden;
        }
        .login-header {
            background: #1e3a8a;
            color: #ffffff;
            padding: 32px 28px;
            text-align: center;
        }
        .login-header i { font-size: 2.8rem; margin-bottom: 12px; color: #60a5fa; }
        .login-header h1 { font-size: 1.35rem; font-weight: 700; }
        .login-header p { font-size: 0.85rem; color: #bfdbfe; margin-top: 4px; }
        .login-content { padding: 32px 28px; }
        .login-hint {
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            padding: 12px;
            border-radius: 8px;
            font-size: 0.82rem;
            color: #475569;
            margin-top: 20px;
            line-height: 1.4;
        }
    </style>
</head>
<body class="login-body">
    <div class="login-card">
        <div class="login-header">
            <?php if (file_exists(ROOT_PATH . '/public/img/logo.png')): ?>
                <img src="<?= BASE_URL ?>/public/img/logo.png" alt="Logo" style="height: 64px; width: auto; margin-bottom: 12px; filter: drop-shadow(0 4px 6px rgba(0,0,0,0.2));">
            <?php else: ?>
                <i class="fa-solid fa-notes-medical"></i>
            <?php endif; ?>
            <h1>TÓPICO INSTITUCIONAL</h1>
            <p>IESP Huanta • Sistema Local con SQLite</p>
        </div>

        <div class="login-content">
            <?php if (!empty($_SESSION['error'])): ?>
                <div class="alert alert-danger" style="margin-bottom: 18px;">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span><?= htmlspecialchars($_SESSION['error']) ?></span>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <form method="POST" action="<?= BASE_URL ?>/auth/procesarLogin">
                <div class="form-group" style="margin-bottom: 18px;">
                    <label for="dni"><i class="fa-solid fa-id-card"></i> DNI de Usuario</label>
                    <input type="text" id="dni" name="dni" required maxlength="8" pattern="\d{8}" placeholder="Ingrese su DNI (8 dígitos)" class="form-control" autofocus>
                </div>

                <div class="form-group" style="margin-bottom: 24px;">
                    <label for="password"><i class="fa-solid fa-lock"></i> Contraseña</label>
                    <input type="password" id="password" name="password" required placeholder="Contraseña de acceso" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 12px;">
                    <i class="fa-solid fa-arrow-right-to-bracket"></i> Ingresar al Sistema
                </button>
            </form>

            <div class="login-hint">
                <strong><i class="fa-solid fa-shield-halved"></i> Credenciales por Defecto:</strong><br>
                • <strong>DNI:</strong> 12345678<br>
                • <strong>Contraseña:</strong> Admin123*
            </div>
        </div>
    </div>
</body>
</html>
