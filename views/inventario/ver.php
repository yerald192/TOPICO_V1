<div class="form-wrapper" style="max-width: 900px;">
    <div class="page-header">
        <div>
            <h1 class="page-title"><i class="fa-solid fa-receipt"></i> Auditoría <?= htmlspecialchars($inventario['nro_inventario']) ?></h1>
            <p class="page-subtitle">Reporte detallado de conteo físico y diferencias registradas</p>
        </div>
        <div class="page-actions">
            <a href="<?= BASE_URL ?>/inventario" class="btn btn-outline">
                <i class="fa-solid fa-arrow-left"></i> Volver a Auditorías
            </a>
        </div>
    </div>

    <div class="content-card" style="padding: 20px; margin-bottom: 24px;">
        <div class="form-grid">
            <div>
                <strong>Fecha del Conteo:</strong>
                <p><?= date('d/m/Y', strtotime($inventario['fecha'])) ?></p>
            </div>
            <div>
                <strong>Responsable:</strong>
                <p><?= htmlspecialchars($inventario['responsable']) ?></p>
            </div>
            <div>
                <strong>Fecha de Registro en BD:</strong>
                <p><?= date('d/m/Y H:i', strtotime($inventario['fecha_creacion'])) ?></p>
            </div>
            <div class="grid-col-3">
                <strong>Observaciones:</strong>
                <p><?= htmlspecialchars($inventario['observaciones'] ?: 'Ninguna') ?></p>
            </div>
        </div>
    </div>

    <div class="content-card">
        <div class="card-header">
            <h2><i class="fa-solid fa-table-list"></i> Conciliación de Medicamentos (<?= count($items) ?> items)</h2>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Medicamento</th>
                        <th class="text-center">Stock Anterior</th>
                        <th class="text-center">Conteo Físico</th>
                        <th class="text-center">Diferencia</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $it): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($it['nombre']) ?></strong></td>
                            <td class="text-center"><?= $it['stock_sistema'] ?></td>
                            <td class="text-center"><strong><?= $it['conteo_fisico'] ?></strong></td>
                            <td class="text-center">
                                <?php if ($it['diferencia'] == 0): ?>
                                    <span class="badge badge-light">0</span>
                                <?php elseif ($it['diferencia'] < 0): ?>
                                    <span class="badge" style="background: #fee2e2; color: #991b1b;"><?= $it['diferencia'] ?> (Faltante)</span>
                                <?php else: ?>
                                    <span class="badge badge-success">+<?= $it['diferencia'] ?> (Sobrante)</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
