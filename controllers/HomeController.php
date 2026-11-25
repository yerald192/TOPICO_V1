<?php
class HomeController extends Controller {
    public function index(): void {
        $db = Database::getInstance();

        // Métricas rápidas para el dashboard
        $totalPacientes = (int)$db->query("SELECT COUNT(*) FROM pacientes WHERE estado = 'activo'")->fetchColumn();
        $totalAtenciones = (int)$db->query("SELECT COUNT(*) FROM atenciones WHERE estado = 'activa'")->fetchColumn();
        $totalEquipos = (int)$db->query("SELECT COUNT(*) FROM equipos_registrados WHERE estado_registro = 'activo'")->fetchColumn();
        $totalProductos = (int)$db->query("SELECT COUNT(*) FROM stock_productos WHERE estado = 'activo'")->fetchColumn();

        // Últimos pacientes registrados
        $ultimosPacientes = $db->query("SELECT id, dni, apellidos_nombres, programa_estudios, fecha_creacion FROM pacientes WHERE estado = 'activo' ORDER BY id DESC LIMIT 5")->fetchAll();

        // Últimas atenciones
        $ultimasAtenciones = $db->query("SELECT id, fecha, apellidos_nombres, motivo_consulta, responsable_atencion FROM atenciones WHERE estado = 'activa' ORDER BY id DESC LIMIT 5")->fetchAll();

        $this->view('home/index', [
            'titulo' => 'Panel de Control Principal',
            'totalPacientes' => $totalPacientes,
            'totalAtenciones' => $totalAtenciones,
            'totalEquipos' => $totalEquipos,
            'totalProductos' => $totalProductos,
            'ultimosPacientes' => $ultimosPacientes,
            'ultimasAtenciones' => $ultimasAtenciones
        ]);
    }
}
