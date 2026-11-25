<?php
// ==========================================================
// CONTROLADOR: InventarioController (Auditoría Física de Stock)
// ==========================================================

class InventarioController extends Controller {
    private Inventario $inventarioModel;
    private Producto $productoModel;

    public function __construct() {
        $this->inventarioModel = $this->model('Inventario');
        $this->productoModel = $this->model('Producto');
    }

    public function index(): void {
        $inventarios = $this->inventarioModel->listar();

        $this->view('inventario/index', [
            'titulo' => 'Historial de Auditorías de Inventario',
            'inventarios' => $inventarios
        ]);
    }

    public function crear(): void {
        $productos = $this->productoModel->listar();
        $siguienteNro = $this->inventarioModel->generarSiguienteNumero();

        $this->view('inventario/crear', [
            'titulo' => 'Toma Física de Inventario',
            'productos' => $productos,
            'siguienteNro' => $siguienteNro
        ]);
    }

    public function guardar(): void {
        if (!$this->isPost()) $this->redirect('inventario');

        $itemsPost = $_POST['items'] ?? [];
        if (empty($itemsPost) || !is_array($itemsPost)) {
            $_SESSION['error'] = 'No se enviaron productos para el inventariado.';
            $this->redirect('inventario/crear');
        }

        $cabecera = [
            'fecha' => $this->post('fecha') ?: date('Y-m-d'),
            'responsable' => $this->post('responsable') ?: ($_SESSION['usuario_nombre'] ?? 'Responsable'),
            'observaciones' => $this->post('observaciones', ''),
            'creado_por' => $_SESSION['usuario_nombre'] ?? 'Sistema'
        ];

        try {
            $id = $this->inventarioModel->registrar($cabecera, $itemsPost);
            $_SESSION['mensaje'] = 'Inventario y conteo físico guardados con éxito. Stock de medicamentos sincronizado.';
            $this->redirect('inventario/ver/' . $id);
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error al registrar el inventario: ' . $e->getMessage();
            $this->redirect('inventario/crear');
        }
    }

    public function ver(int $id = 0): void {
        if ($id <= 0) $this->redirect('inventario');

        $inventario = $this->inventarioModel->obtenerPorId($id);
        if (!$inventario) {
            $_SESSION['error'] = 'Auditoría no encontrada.';
            $this->redirect('inventario');
        }

        $items = $this->inventarioModel->obtenerItems($id);

        $this->view('inventario/ver', [
            'titulo' => 'Auditoría ' . $inventario['nro_inventario'],
            'inventario' => $inventario,
            'items' => $items
        ]);
    }
}
