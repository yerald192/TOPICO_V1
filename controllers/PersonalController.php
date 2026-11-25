<?php
// ==========================================================
// CONTROLADOR: PersonalController (Gestión de Personal y Asistencia)
// ==========================================================

class PersonalController extends Controller {
    private Personal $personalModel;

    public function __construct() {
        $this->personalModel = $this->model('Personal');
    }

    public function index(): void {
        $personal = $this->personalModel->listar();

        $this->view('personal/index', [
            'titulo' => 'Gestión del Personal y Usuarios',
            'personal' => $personal
        ]);
    }

    public function crear(): void {
        $this->view('personal/crear', [
            'titulo' => 'Registrar Nuevo Usuario / Personal'
        ]);
    }

    public function guardar(): void {
        if (!$this->isPost()) $this->redirect('personal');

        $dni = $this->post('dni');
        $nombre = $this->post('apellido_nombre');
        $password = $this->post('password');

        if (empty($dni) || empty($nombre) || empty($password)) {
            $_SESSION['error'] = 'DNI, Nombre y Contraseña son obligatorios.';
            $this->redirect('personal/crear');
        }

        if ($this->personalModel->obtenerPorDni($dni)) {
            $_SESSION['error'] = 'Ya existe un usuario registrado con el DNI ' . $dni;
            $this->redirect('personal/crear');
        }

        $this->personalModel->crear([
            'dni' => $dni,
            'apellido_nombre' => $nombre,
            'especialidad' => $this->post('especialidad', 'Enfermería / Tópico'),
            'password' => $password,
            'rol' => $this->post('rol', 'personal'),
            'creado_por' => $_SESSION['usuario_nombre'] ?? 'Administrador'
        ]);

        $_SESSION['mensaje'] = 'Usuario registrado exitosamente.';
        $this->redirect('personal');
    }

    public function cambiarRol(int $id = 0): void {
        $user = $this->personalModel->obtenerPorId($id);
        if ($user) {
            $nuevoRol = ($user['rol'] === 'admin') ? 'personal' : 'admin';
            $this->personalModel->actualizarRol($user['dni'], $nuevoRol);
            $_SESSION['mensaje'] = "Rol de {$user['apellido_nombre']} cambiado a {$nuevoRol}.";
        }
        $this->redirect('personal');
    }

    public function eliminar(int $id = 0): void {
        $user = $this->personalModel->obtenerPorId($id);
        if ($user) {
            $this->personalModel->inactivar($user['dni'], $_SESSION['usuario_nombre'] ?? 'Administrador');
            $_SESSION['mensaje'] = "Usuario {$user['apellido_nombre']} inactivado del sistema.";
        }
        $this->redirect('personal');
    }

    public function asistencia(): void {
        $asistencias = $this->personalModel->obtenerAsistenciasRecientes(50);

        $this->view('personal/asistencia', [
            'titulo' => 'Control de Asistencia del Personal',
            'asistencias' => $asistencias
        ]);
    }
}
