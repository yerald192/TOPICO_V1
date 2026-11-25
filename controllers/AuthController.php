<?php
// ==========================================================
// CONTROLADOR: AuthController (Autenticación y Sesión)
// ==========================================================

class AuthController extends Controller {
    private Personal $personalModel;

    public function __construct() {
        $this->personalModel = $this->model('Personal');
    }

    public function login(): void {
        if (!empty($_SESSION['usuario_id'])) {
            $this->redirect('home');
        }

        $this->view('auth/login', [
            'titulo' => 'Iniciar Sesión'
        ], false);
    }

    public function procesarLogin(): void {
        if (!$this->isPost()) {
            $this->redirect('auth/login');
        }

        $dni = $this->post('dni');
        $password = $this->post('password');

        if (empty($dni) || empty($password)) {
            $_SESSION['error'] = 'Debe ingresar su DNI y Contraseña.';
            $this->redirect('auth/login');
        }

        $usuario = $this->personalModel->autenticar($dni, $password);

        if ($usuario) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_dni'] = $usuario['dni'];
            $_SESSION['usuario_nombre'] = $usuario['apellido_nombre'];
            $_SESSION['usuario_rol'] = $usuario['rol'];
            $_SESSION['ultimo_acceso'] = time();

            // Registrar asistencia automáticamente al ingresar
            $this->personalModel->registrarIngreso($usuario['dni'], $usuario['apellido_nombre']);
            $this->personalModel->log($usuario['dni'], 'login', 'Inicio de sesión exitoso en el sistema local');

            $_SESSION['mensaje'] = "Bienvenido al sistema, {$usuario['apellido_nombre']}.";
            $this->redirect('home');
        } else {
            $_SESSION['error'] = 'DNI o contraseña incorrectos.';
            $this->redirect('auth/login');
        }
    }

    public function logout(): void {
        if (!empty($_SESSION['usuario_dni'])) {
            $this->personalModel->registrarSalida($_SESSION['usuario_dni']);
            $this->personalModel->log($_SESSION['usuario_dni'], 'logout', 'Cierre de sesión');
        }

        session_unset();
        session_destroy();
        $this->redirect('auth/login');
    }
}
