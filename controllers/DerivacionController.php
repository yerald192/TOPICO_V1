<?php
// ==========================================================
// CONTROLADOR: DerivacionController (Referencias Hospitalarias)
// ==========================================================

class DerivacionController extends Controller {
    private Derivacion $derivacionModel;
    private Paciente $pacienteModel;

    public function __construct() {
        $this->derivacionModel = $this->model('Derivacion');
        $this->pacienteModel = $this->model('Paciente');
    }

    public function index(): void {
        $busqueda = $this->get('q', '');
        $pagina = max(1, (int)$this->get('p', 1));
        $porPagina = 15;
        $offset = ($pagina - 1) * $porPagina;

        $total = $this->derivacionModel->contar($busqueda);
        $derivaciones = $this->derivacionModel->listar($porPagina, $offset, $busqueda);
        $totalPaginas = ceil($total / $porPagina);

        $this->view('derivaciones/index', [
            'titulo' => 'Derivaciones Médicas',
            'derivaciones' => $derivaciones,
            'busqueda' => $busqueda,
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

        $siguienteNro = $this->derivacionModel->generarSiguienteNumero();

        $this->view('derivaciones/crear', [
            'titulo' => 'Emitir Ficha de Derivación Hospitalaria',
            'paciente' => $paciente,
            'dni' => $dni,
            'siguienteNro' => $siguienteNro
        ]);
    }

    public function guardar(): void {
        if (!$this->isPost()) {
            $this->redirect('derivacion');
        }

        $dni = $this->post('paciente_dni');
        $nombre = $this->post('paciente_nombre');

        if (empty($dni) || empty($nombre)) {
            $_SESSION['error'] = 'Los datos del paciente son obligatorios.';
            $this->redirect('derivacion/crear');
        }

        $datos = [
            'fecha_emision' => $this->post('fecha_emision') ?: date('Y-m-d'),
            'profesional_nombre' => $_SESSION['usuario_nombre'] ?? 'Personal de Tópico',
            'profesional_dni' => $_SESSION['usuario_dni'] ?? '',
            'paciente_dni' => $dni,
            'paciente_nombre' => $nombre,
            'paciente_carrera' => $this->post('paciente_carrera', ''),
            'paciente_edad' => (int)$this->post('paciente_edad', 0),
            'paciente_sexo' => $this->post('paciente_sexo', ''),
            'paciente_telefono' => $this->post('paciente_telefono', ''),
            'ciclo' => $this->post('ciclo', ''),
            'tipo_atencion' => $this->post('tipo_atencion', 'Urgencia'),
            'motivo' => $this->post('motivo', ''),
            'hospital_destino' => $this->post('hospital_destino', 'Hospital de Apoyo Huanta'),
            'peso' => $this->post('peso'),
            'talla' => $this->post('talla'),
            'imc' => $this->post('imc'),
            'temperatura' => $this->post('temperatura'),
            'presion_arterial' => $this->post('presion_arterial', ''),
            'frecuencia_cardiaca' => $this->post('frecuencia_cardiaca'),
            'signos_sintomas' => $this->post('signos_sintomas', ''),
            'apoderado_tipo' => $this->post('apoderado_tipo', ''),
            'apoderado_nombre' => $this->post('apoderado_nombre', ''),
            'apoderado_celular' => $this->post('apoderado_celular', ''),
            'apoderado_parentesco' => $this->post('apoderado_parentesco', ''),
            'apoderado_estado_civil' => $this->post('apoderado_estado_civil', ''),
            'creado_por' => $_SESSION['usuario_nombre'] ?? 'Sistema'
        ];

        $id = $this->derivacionModel->registrar($datos);
        if ($id) {
            $_SESSION['mensaje'] = 'Ficha de derivación generada con éxito.';
            $this->redirect('derivacion/imprimir/' . $id);
        } else {
            $_SESSION['error'] = 'No se pudo generar la derivación.';
            $this->redirect('derivacion/crear');
        }
    }

    public function imprimir(int $id = 0): void {
        if ($id <= 0) $this->redirect('derivacion');

        $derivacion = $this->derivacionModel->obtenerPorId($id);
        if (!$derivacion) {
            $_SESSION['error'] = 'Ficha de derivación no encontrada.';
            $this->redirect('derivacion');
        }

        $this->view('derivaciones/imprimir', [
            'titulo' => 'Ficha de Derivación: ' . $derivacion['nro_derivacion'],
            'derivacion' => $derivacion
        ], false); // Sin layout estándar, optimizado para impresión
    }
}
