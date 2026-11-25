<?php
// ==========================================================
// CONTROLADOR: AtencionController (Atenciones Médicas)
// ==========================================================

class AtencionController extends Controller {
    private Atencion $atencionModel;
    private Paciente $pacienteModel;

    public function __construct() {
        $this->atencionModel = $this->model('Atencion');
        $this->pacienteModel = $this->model('Paciente');
    }

    public function index(): void {
        $busqueda = $this->get('q', '');
        $fecha = $this->get('fecha', '');
        $pagina = max(1, (int)$this->get('p', 1));
        $porPagina = 20;
        $offset = ($pagina - 1) * $porPagina;

        $total = $this->atencionModel->contar($busqueda, $fecha);
        $atenciones = $this->atencionModel->listar($porPagina, $offset, $busqueda, $fecha);
        $totalPaginas = ceil($total / $porPagina);

        $this->view('atenciones/index', [
            'titulo' => 'Registro de Atenciones Médicas',
            'atenciones' => $atenciones,
            'busqueda' => $busqueda,
            'fecha' => $fecha,
            'pagina' => $pagina,
            'totalPaginas' => $totalPaginas,
            'total' => $total
        ]);
    }

    public function crear(): void {
        $dni = $this->get('dni', '');
        $paciente = null;
        if (!empty($dni)) {
            $paciente = $this->pacienteModel->obtenerPorDni($dni);
        }

        $this->view('atenciones/crear', [
            'titulo' => 'Nueva Atención Médica',
            'paciente' => $paciente,
            'dni' => $dni
        ]);
    }

    public function guardar(): void {
        if (!$this->isPost()) {
            $this->redirect('atencion');
        }

        $dni = $this->post('dni');
        $nombres = $this->post('apellidos_nombres');

        if (empty($dni) || empty($nombres)) {
            $_SESSION['error'] = 'El DNI y los nombres del paciente son obligatorios.';
            $this->redirect('atencion/crear');
        }

        // Si el paciente no existía en el registro general de pacientes, registrarlo automáticamente
        $pacienteExistente = $this->pacienteModel->obtenerPorDni($dni);
        if (!$pacienteExistente) {
            $this->pacienteModel->registrar([
                'dni' => $dni,
                'apellidos_nombres' => $nombres,
                'edad' => (int)$this->post('edad', 0),
                'genero' => $this->post('genero', ''),
                'tipo_paciente' => $this->post('tipo_paciente', 'Estudiante'),
                'programa_estudios' => $this->post('programa_estudios', ''),
                'semestre' => $this->post('semestre', ''),
                'telefono' => $this->post('telefono', ''),
                'celular_emergencia' => $this->post('celular_emergencia', '')
            ]);
        }

        $datos = [
            'fecha' => $this->post('fecha') ?: date('Y-m-d'),
            'hora_ingreso' => $this->post('hora_ingreso') ?: date('H:i'),
            'hora_salida' => $this->post('hora_salida') ?: null,
            'dni' => $dni,
            'apellidos_nombres' => $nombres,
            'programa_estudios' => $this->post('programa_estudios', ''),
            'semestre' => $this->post('semestre', ''),
            'edad' => (int)$this->post('edad', 0),
            'genero' => $this->post('genero', ''),
            'telefono' => $this->post('telefono', ''),
            'celular_emergencia' => $this->post('celular_emergencia', ''),
            'motivo_consulta' => $this->post('motivo_consulta', ''),
            'signos_sintomas' => $this->post('signos_sintomas', ''),
            'peso' => $this->post('peso'),
            'talla' => $this->post('talla'),
            'temperatura' => $this->post('temperatura'),
            'presion_arterial' => $this->post('presion_arterial', ''),
            'frecuencia_cardiaca' => $this->post('frecuencia_cardiaca'),
            'tratamiento' => $this->post('tratamiento', ''),
            'tipo_descanso' => $this->post('tipo_descanso', 'Sin reposo'),
            'hospital_derivacion' => $this->post('hospital_derivacion', ''),
            'observacion' => $this->post('observacion', ''),
            'responsable_atencion' => $_SESSION['usuario_nombre'] ?? 'Personal de Tópico',
            'dni_responsable' => $_SESSION['usuario_dni'] ?? ''
        ];

        $id = $this->atencionModel->registrar($datos);
        if ($id) {
            $_SESSION['mensaje'] = 'Atención médica guardada exitosamente.';
            $this->redirect('atencion');
        } else {
            $_SESSION['error'] = 'Error al registrar la atención médica.';
            $this->redirect('atencion/crear');
        }
    }

    public function ver(int $id = 0): void {
        if ($id <= 0) $this->redirect('atencion');

        $atencion = $this->atencionModel->obtenerPorId($id);
        if (!$atencion) {
            $_SESSION['error'] = 'Atención médica no encontrada.';
            $this->redirect('atencion');
        }

        $this->view('atenciones/ver', [
            'titulo' => 'Detalle de Atención Médica #' . $id,
            'atencion' => $atencion
        ]);
    }
}
