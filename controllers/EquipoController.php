<?php
// ==========================================================
// CONTROLADOR: EquipoController (Equipos Médicos)
// ==========================================================

class EquipoController extends Controller {
    private Equipo $equipoModel;

    public function __construct() {
        $this->equipoModel = $this->model('Equipo');
    }

    public function index(): void {
        $busqueda = $this->get('q', '');
        $estado = $this->get('estado', '');
        $equipos = $this->equipoModel->listar($busqueda, $estado);

        $this->view('equipos/index', [
            'titulo' => 'Control de Equipos Médicos',
            'equipos' => $equipos,
            'busqueda' => $busqueda,
            'estado' => $estado
        ]);
    }

    public function crear(): void {
        $this->view('equipos/crear', [
            'titulo' => 'Registrar Equipo Médico'
        ]);
    }

    public function guardar(): void {
        if (!$this->isPost()) $this->redirect('equipo');

        $nombre = $this->post('nombre');
        if (empty($nombre)) {
            $_SESSION['error'] = 'El nombre del equipo es obligatorio.';
            $this->redirect('equipo/crear');
        }

        $this->equipoModel->registrar([
            'nombre' => $nombre,
            'equipo' => $this->post('equipo', $nombre),
            'categoria' => $this->post('categoria', 'Diagnóstico'),
            'serie' => $this->post('serie', ''),
            'estado' => $this->post('estado', 'Operativo'),
            'cantidad' => (int)$this->post('cantidad', 1),
            'observacion' => $this->post('observacion', ''),
            'creado_por' => $_SESSION['usuario_nombre'] ?? 'Administrador'
        ]);

        $_SESSION['mensaje'] = 'Equipo médico registrado correctamente.';
        $this->redirect('equipo');
    }

    public function editar(int $id = 0): void {
        if ($id <= 0) $this->redirect('equipo');

        $equipo = $this->equipoModel->obtenerPorId($id);
        if (!$equipo) {
            $_SESSION['error'] = 'Equipo no encontrado.';
            $this->redirect('equipo');
        }

        $this->view('equipos/editar', [
            'titulo' => 'Editar Equipo Médico',
            'equipo' => $equipo
        ]);
    }

    public function actualizar(int $id = 0): void {
        if (!$this->isPost() || $id <= 0) $this->redirect('equipo');

        $this->equipoModel->actualizar($id, [
            'nombre' => $this->post('nombre'),
            'equipo' => $this->post('equipo'),
            'categoria' => $this->post('categoria'),
            'serie' => $this->post('serie', ''),
            'estado' => $this->post('estado', 'Operativo'),
            'cantidad' => (int)$this->post('cantidad', 1),
            'observacion' => $this->post('observacion', '')
        ]);

        $_SESSION['mensaje'] = 'Información del equipo actualizada.';
        $this->redirect('equipo');
    }

    public function eliminar(int $id = 0): void {
        if ($id > 0) {
            $this->equipoModel->eliminar($id, $_SESSION['usuario_nombre'] ?? 'Administrador');
            $_SESSION['mensaje'] = 'Equipo dado de baja del registro activo.';
        }
        $this->redirect('equipo');
    }
}
