<div class="patients-wrapper">
    <div class="page-header">
        <div>
            <h1 class="page-title"><i class="fa-solid fa-pills"></i> Farmacia y Stock de Medicamentos</h1>
            <p class="page-subtitle">Control de existencias de fármacos y suministros del tópico</p>
        </div>
        <div class="page-actions">
            <a href="<?= BASE_URL ?>/producto/crear" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i> Registrar Medicamento
            </a>
            <a href="<?= BASE_URL ?>/inventario/crear" class="btn btn-secondary">
                <i class="fa-solid fa-clipboard-check"></i> Realizar Toma de Inventario
            </a>
        </div>
    </div>

    <!-- ALERTA DE STOCK BAJO -->
    <?php if ($totalBajoStock > 0): ?>
        <div class="alert alert-danger">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <span>¡Atención! Hay <strong><?= $totalBajoStock ?></strong> medicamento(s) con stock por debajo del límite mínimo de seguridad.</span>
            <a href="<?= BASE_URL ?>/producto?alerta=1" style="margin-left: 10px; color: inherit; font-weight: bold; text-decoration: underline;">Ver críticos</a>
        </div>
    <?php endif; ?>

    <!-- FILTRO -->
    <div class="filter-card">
        <form method="GET" action="<?= BASE_URL ?>/producto" class="search-form">
            <div class="search-input-group">
                <i class="fa-solid fa-magnifying-glass search-icon"></i>
                <input type="text" name="q" value="<?= htmlspecialchars($busqueda) ?>" placeholder="Buscar medicamento o insumo por nombre..." class="form-control">
                <button type="submit" class="btn btn-secondary">Buscar</button>
                <?php if (!empty($busqueda) || $soloBajoStock): ?>
                    <a href="<?= BASE_URL ?>/producto" class="btn btn-outline"><i class="fa-solid fa-xmark"></i></a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <div class="content-card">
        <div class="card-header">
            <h2><i class="fa-solid fa-prescription-bottle-medical"></i> Productos en Stock (<?= count($productos) ?>)</h2>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nombre del Producto</th>
                        <th>Categoría</th>
                        <th>Unidad</th>
                        <th>Cantidad Disponible</th>
                        <th>Stock Mínimo</th>
                        <th>Estado de Stock</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($productos)): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted" style="padding: 40px 0;">
                                No hay productos registrados en el stock.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($productos as $pr): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($pr['nombre']) ?></strong></td>
                                <td><span class="badge badge-light"><?= htmlspecialchars($pr['categoria']) ?></span></td>
                                <td><?= htmlspecialchars($pr['unidad']) ?></td>
                                <td><strong style="font-size: 1.05rem;"><?= $pr['cantidad'] ?></strong></td>
                                <td><?= $pr['stock_minimo'] ?></td>
                                <td>
                                    <?php if ($pr['cantidad'] <= 0): ?>
                                        <span class="badge" style="background: #fee2e2; color: #991b1b;">Agotado</span>
                                    <?php elseif ($pr['cantidad'] <= $pr['stock_minimo']): ?>
                                        <span class="badge" style="background: #fef3c7; color: #92400e;">Bajo Stock</span>
                                    <?php else: ?>
                                        <span class="badge badge-success">Suficiente</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center action-buttons">
                                    <a href="<?= BASE_URL ?>/producto/editar/<?= $pr['id'] ?>" class="btn-action btn-edit" title="Editar">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a href="<?= BASE_URL ?>/producto/eliminar/<?= $pr['id'] ?>" class="btn-action btn-delete" title="Eliminar" onclick="return confirm('¿Eliminar producto?');">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
