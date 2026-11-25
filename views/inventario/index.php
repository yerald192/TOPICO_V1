<div class="patients-wrapper">
    <div class="page-header">
        <div>
            <h1 class="page-title"><i class="fa-solid fa-clipboard-check"></i> Auditorías Físicas de Inventario</h1>
            <p class="page-subtitle">Historial de tomas físicas y conciliación de stock de farmacia</p>
        </div>
        <div class="page-actions">
            <a href="<?= BASE_URL ?>/inventario/crear" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i> Nueva Toma de Inventario
            </a>
        </div>
    </div>

    <div class="content-card">
        <div class="card-header">
            <h2><i class="fa-solid fa-folder-open"></i> Inventarios Registrados (<?= count($inventarios) ?>)</h2>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>N° Inventario</th>
                        <th>Fecha de Conteo</th>
                        <th>Responsable</th>
                        <th>Observaciones</th>
                        <th>Fecha de Registro</th>
                        <th class="text-center">Ver Conciliación</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($inventarios)): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted" style="padding: 40px 0;">
                                No se han realizado auditorías de inventario aún.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($inventarios as $inv): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($inv['nro_inventario']) ?></strong></td>
                                <td><?= date('d/m/Y', strtotime($inv['fecha'])) ?></td>
                                <td><span class="badge badge-light"><?= htmlspecialchars($inv['responsable']) ?></span></td>
                                <td><?= htmlspecialchars($inv['observaciones'] ?: 'Conteo regular') ?></td>
                                <td class="text-muted"><?= date('d/m/Y H:i', strtotime($inv['fecha_creacion'])) ?></td>
                                <td class="text-center">
                                    <a href="<?= BASE_URL ?>/inventario/ver/<?= $inv['id'] ?>" class="btn-action btn-edit" title="Ver Detalle de Conteo">
                                        <i class="fa-solid fa-eye"></i>
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
