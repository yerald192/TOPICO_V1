<?php
class PacienteController extends Controller {
    private Paciente $pacienteModel;

    public function __construct() {
        $this->pacienteModel = $this->model('Paciente');
    }

    /**
     * Listado principal de pacientes con búsqueda y paginación
     */
    public function index(): void {
        $busqueda = $this->get('q', '');
        $pagina = max(1, (int)$this->get('p', 1));
        $porPagina = 15;
        $offset = ($pagina - 1) * $porPagina;

        $total = $this->pacienteModel->contar($busqueda);
        $pacientes = $this->pacienteModel->listar($porPagina, $offset, $busqueda);
        $totalPaginas = ceil($total / $porPagina);

        $this->view('pacientes/index', [
            'titulo' => 'Listado de Pacientes',
            'pacientes' => $pacientes,
            'busqueda' => $busqueda,
            'pagina' => $pagina,
            'totalPaginas' => $totalPaginas,
            'total' => $total
        ]);
    }

    /**
     * Muestra formulario para registrar paciente
     */
    public function crear(): void {
        $this->view('pacientes/crear', [
            'titulo' => 'Registrar Nuevo Paciente'
        ]);
    }

    /**
     * Procesa y guarda un nuevo paciente
     */
    public function guardar(): void {
        if (!$this->isPost()) {
            $this->redirect('paciente');
        }

        $dni = $this->post('dni');
        $apellidosNombres = $this->post('apellidos_nombres');

        if (empty($dni) || empty($apellidosNombres)) {
            $_SESSION['error'] = 'El DNI y los Nombres completos son obligatorios.';
            $this->redirect('paciente/crear');
        }

        // Verificar DNI duplicado
        if ($this->pacienteModel->obtenerPorDni($dni)) {
            $_SESSION['error'] = "El paciente con DNI {$dni} ya se encuentra registrado.";
            $this->redirect('paciente/crear');
        }

        $datos = [
            'dni' => $dni,
            'apellidos_nombres' => $apellidosNombres,
            'fecha_nacimiento' => $this->post('fecha_nacimiento') ?: null,
            'edad' => (int)$this->post('edad', 0),
            'genero' => $this->post('genero', 'Otro'),
            'tipo_paciente' => $this->post('tipo_paciente', 'Estudiante'),
            'telefono' => $this->post('telefono', ''),
            'celular_emergencia' => $this->post('celular_emergencia', ''),
            'contacto_emergencia' => $this->post('contacto_emergencia', ''),
            'parentesco_emergencia' => $this->post('parentesco_emergencia', ''),
            'direccion' => $this->post('direccion', ''),
            'lugar_nacimiento' => $this->post('lugar_nacimiento', ''),
            'programa_estudios' => $this->post('programa_estudios', ''),
            'semestre' => $this->post('semestre', ''),
            'tipo_sangre' => $this->post('tipo_sangre', ''),
            'seguro' => $this->post('seguro', ''),
            'alergias' => $this->post('alergias', ''),
            'enfermedades' => $this->post('enfermedades', ''),
            'medicamentos_actuales' => $this->post('medicamentos_actuales', ''),
            'observaciones_salud' => $this->post('observaciones_salud', ''),
            'creado_por' => $_SESSION['usuario_nombre'] ?? 'Administrador'
        ];

        $id = $this->pacienteModel->registrar($datos);
        if ($id) {
            $_SESSION['mensaje'] = 'Paciente registrado exitosamente en la base de datos local.';
            $this->redirect('paciente');
        } else {
            $_SESSION['error'] = 'Ocurrió un error al guardar el paciente.';
            $this->redirect('paciente/crear');
        }
    }

    /**
     * Muestra formulario para editar paciente
     */
    public function editar(int $id = 0): void {
        if ($id <= 0) {
            $this->redirect('paciente');
        }

        $paciente = $this->pacienteModel->obtenerPorId($id);
        if (!$paciente) {
            $_SESSION['error'] = 'Paciente no encontrado.';
            $this->redirect('paciente');
        }

        $this->view('pacientes/editar', [
            'titulo' => 'Editar Paciente',
            'paciente' => $paciente
        ]);
    }

    /**
     * Procesa la actualización de un paciente
     */
    public function actualizar(int $id = 0): void {
        if (!$this->isPost() || $id <= 0) {
            $this->redirect('paciente');
        }

        $dni = $this->post('dni');
        $apellidosNombres = $this->post('apellidos_nombres');

        if (empty($dni) || empty($apellidosNombres)) {
            $_SESSION['error'] = 'El DNI y los Nombres completos son obligatorios.';
            $this->redirect('paciente/editar/' . $id);
        }

        $datos = [
            'dni' => $dni,
            'apellidos_nombres' => $apellidosNombres,
            'fecha_nacimiento' => $this->post('fecha_nacimiento') ?: null,
            'edad' => (int)$this->post('edad', 0),
            'genero' => $this->post('genero', 'Otro'),
            'tipo_paciente' => $this->post('tipo_paciente', 'Estudiante'),
            'telefono' => $this->post('telefono', ''),
            'celular_emergencia' => $this->post('celular_emergencia', ''),
            'contacto_emergencia' => $this->post('contacto_emergencia', ''),
            'parentesco_emergencia' => $this->post('parentesco_emergencia', ''),
            'direccion' => $this->post('direccion', ''),
            'lugar_nacimiento' => $this->post('lugar_nacimiento', ''),
            'programa_estudios' => $this->post('programa_estudios', ''),
            'semestre' => $this->post('semestre', ''),
            'tipo_sangre' => $this->post('tipo_sangre', ''),
            'seguro' => $this->post('seguro', ''),
            'alergias' => $this->post('alergias', ''),
            'enfermedades' => $this->post('enfermedades', ''),
            'medicamentos_actuales' => $this->post('medicamentos_actuales', ''),
            'observaciones_salud' => $this->post('observaciones_salud', ''),
            'modificado_por' => $_SESSION['usuario_nombre'] ?? 'Administrador'
        ];

        $this->pacienteModel->actualizar($id, $datos);
        $_SESSION['mensaje'] = 'Datos del paciente actualizados con éxito.';
        $this->redirect('paciente');
    }

    /**
     * Eliminación de paciente
     */
    public function eliminar(int $id = 0): void {
        if ($id > 0) {
            $this->pacienteModel->eliminar($id, $_SESSION['usuario_nombre'] ?? 'Administrador');
            $_SESSION['mensaje'] = 'Paciente eliminado del registro activo.';
        }
        $this->redirect('paciente');
    }

    /**
     * API JSON: Búsqueda rápida por DNI (útil para auto-completado en atenciones)
     */
    public function buscar(): void {
        $dni = $this->get('dni', '');
        $paciente = $this->pacienteModel->obtenerPorDni($dni);
        if ($paciente) {
            $this->json(['status' => 'success', 'data' => $paciente]);
        } else {
            $this->json(['status' => 'not_found', 'message' => 'Paciente no encontrado'], 404);
        }
    }
}
