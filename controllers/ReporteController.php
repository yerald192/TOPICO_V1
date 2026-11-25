<?php
// ==========================================================
// CONTROLADOR: ReporteController (Estadísticas y Reportes)
// ==========================================================

class ReporteController extends Controller {
    public function index(): void {
        $db = Database::getInstance();

        // Filtro de fechas opcional
        $desde = $this->get('desde', date('Y-m-01'));
        $hasta = $this->get('hasta', date('Y-m-d'));

        // Atenciones por programa de estudios
        $stmtProg = $db->prepare(
            "SELECT programa_estudios, COUNT(*) as total 
             FROM atenciones 
             WHERE estado = 'activa' AND fecha BETWEEN ? AND ? 
             GROUP BY programa_estudios 
             ORDER BY total DESC"
        );
        $stmtProg->execute([$desde, $hasta]);
        $porPrograma = $stmtProg->fetchAll();

        // Atenciones por tipo de descanso
        $stmtDesc = $db->prepare(
            "SELECT tipo_descanso, COUNT(*) as total 
             FROM atenciones 
             WHERE estado = 'activa' AND fecha BETWEEN ? AND ? 
             GROUP BY tipo_descanso"
        );
        $stmtDesc->execute([$desde, $hasta]);
        $porDescanso = $stmtDesc->fetchAll();

        // Motivos de consulta más comunes
        $stmtMot = $db->prepare(
            "SELECT motivo_consulta, COUNT(*) as total 
             FROM atenciones 
             WHERE estado = 'activa' AND fecha BETWEEN ? AND ? 
             GROUP BY motivo_consulta 
             ORDER BY total DESC 
             LIMIT 8"
        );
        $stmtMot->execute([$desde, $hasta]);
        $motivosFrecuentes = $stmtMot->fetchAll();

        // Listado de atenciones para exportar o imprimir
        $stmtList = $db->prepare(
            "SELECT fecha, hora_ingreso, dni, apellidos_nombres, programa_estudios, edad, motivo_consulta, tratamiento, responsable_atencion 
             FROM atenciones 
             WHERE estado = 'activa' AND fecha BETWEEN ? AND ? 
             ORDER BY fecha DESC, id DESC"
        );
        $stmtList->execute([$desde, $hasta]);
        $listado = $stmtList->fetchAll();

        $this->view('reportes/index', [
            'titulo' => 'Estadísticas y Reportes Generales',
            'desde' => $desde,
            'hasta' => $hasta,
            'porPrograma' => $porPrograma,
            'porDescanso' => $porDescanso,
            'motivosFrecuentes' => $motivosFrecuentes,
            'listado' => $listado
        ]);
    }
}
