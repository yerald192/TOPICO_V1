<?php
// ==========================================================
// CONTROLADOR: ProductoController (Farmacia y Stock)
// ==========================================================

class ProductoController extends Controller {
    private Producto $productoModel;

    public function __construct() {
        $this->productoModel = $this->model('Producto');
    }

    public function index(): void {
        $busqueda = $this->get('q', '');
        $soloBajoStock = $this->get('alerta', '') === '1';

        $productos = $this->productoModel->listar($busqueda, $soloBajoStock);
        $totalBajoStock = $this->productoModel->contarBajoStock();

        $this->view('productos/index', [
            'titulo' => 'Stock de Medicamentos e Insumos',
            'productos' => $productos,
            'busqueda' => $busqueda,
            'soloBajoStock' => $soloBajoStock,
            'totalBajoStock' => $totalBajoStock
        ]);
    }

    public function crear(): void {
        $this->view('productos/crear', [
            'titulo' => 'Registrar Medicamento / Insumo'
        ]);
    }

    public function guardar(): void {
        if (!$this->isPost()) $this->redirect('producto');

        $nombre = $this->post('nombre');
        if (empty($nombre)) {
            $_SESSION['error'] = 'El nombre del producto es obligatorio.';
            $this->redirect('producto/crear');
        }

        $this->productoModel->registrar([
            'nombre' => $nombre,
            'categoria' => $this->post('categoria', 'Medicamento'),
            'unidad' => $this->post('unidad', 'Tableta / Unidad'),
            'cantidad' => (int)$this->post('cantidad', 0),
            'stock_minimo' => (int)$this->post('stock_minimo', 5),
            'creado_por' => $_SESSION['usuario_nombre'] ?? 'Administrador'
        ]);

        $_SESSION['mensaje'] = 'Producto incorporado al inventario.';
        $this->redirect('producto');
    }

    public function editar(int $id = 0): void {
        if ($id <= 0) $this->redirect('producto');

        $producto = $this->productoModel->obtenerPorId($id);
        if (!$producto) {
            $_SESSION['error'] = 'Producto no encontrado.';
            $this->redirect('producto');
        }

        $this->view('productos/editar', [
            'titulo' => 'Editar Producto: ' . $producto['nombre'],
            'producto' => $producto
        ]);
    }

    public function actualizar(int $id = 0): void {
        if (!$this->isPost() || $id <= 0) $this->redirect('producto');

        $this->productoModel->actualizar($id, [
            'nombre' => $this->post('nombre'),
            'categoria' => $this->post('categoria'),
            'unidad' => $this->post('unidad'),
            'cantidad' => (int)$this->post('cantidad', 0),
            'stock_minimo' => (int)$this->post('stock_minimo', 5)
        ]);

        $_SESSION['mensaje'] = 'Stock y especificaciones actualizadas.';
        $this->redirect('producto');
    }

    public function eliminar(int $id = 0): void {
        if ($id > 0) {
            $this->productoModel->eliminar($id, $_SESSION['usuario_nombre'] ?? 'Administrador');
            $_SESSION['mensaje'] = 'Producto eliminado del stock activo.';
        }
        $this->redirect('producto');
    }
}
