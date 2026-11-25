<?php
// ==========================================================
// CONTROLADOR: HistorialController (Historial Clínico Integral)
// ==========================================================

class HistorialController extends Controller {
    private Atencion $atencionModel;
    private Paciente $pacienteModel;

    public function __construct() {
        $this->atencionModel = $this->model('Atencion');
        $this->pacienteModel = $this->model('Paciente');
    }

    public function index(): void {
        $dni = $this->get('dni', '');
        $paciente = null;
        $historial = [];

        if (!empty($dni)) {
            $paciente = $this->pacienteModel->obtenerPorDni($dni);
            if ($paciente) {
                $historial = $this->atencionModel->obtenerHistorialPorDni($dni);
            }
        }

        $this->view('historial/index', [
            'titulo' => 'Historial Clínico de Pacientes',
            'dni' => $dni,
            'paciente' => $paciente,
            'historial' => $historial
        ]);
    }
}
