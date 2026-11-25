<div class="patients-wrapper">
    <div class="page-header">
        <div>
            <h1 class="page-title"><i class="fa-solid fa-calendar-check"></i> Registro de Asistencia del Personal</h1>
            <p class="page-subtitle">Marcaciones automáticas de ingreso y salida en el tópico</p>
        </div>
        <div class="page-actions">
            <a href="<?= BASE_URL ?>/personal" class="btn btn-outline">
                <i class="fa-solid fa-arrow-left"></i> Volver a Personal
            </a>
        </div>
    </div>

    <div class="content-card">
        <div class="card-header">
            <h2><i class="fa-solid fa-clock"></i> Últimas Marcaciones</h2>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>DNI</th>
                        <th>Personal</th>
                        <th>Hora de Ingreso</th>
                        <th>Hora de Salida</th>
                        <th>Minutos Laborados</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($asistencias)): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted" style="padding: 30px;">
                                No hay registros de asistencia en la base de datos local.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($asistencias as $as): ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($as['fecha'])) ?></td>
                                <td><span class="badge badge-dni"><?= htmlspecialchars($as['dni']) ?></span></td>
                                <td><strong><?= htmlspecialchars($as['nombre']) ?></strong></td>
                                <td><i class="fa-regular fa-clock" style="color: #059669;"></i> <?= htmlspecialchars($as['hora_inicio']) ?></td>
                                <td>
                                    <?php if ($as['hora_salida']): ?>
                                        <i class="fa-regular fa-clock" style="color: #dc2626;"></i> <?= htmlspecialchars($as['hora_salida']) ?>
                                    <?php else: ?>
                                        <span class="text-muted">En turno...</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= $as['total_minutos'] ? $as['total_minutos'] . ' min' : '-' ?></td>
                                <td>
                                    <?php if ($as['estado'] === 'activo'): ?>
                                        <span class="badge badge-success">Activo en Turno</span>
                                    <?php else: ?>
                                        <span class="badge badge-light">Turno Finalizado</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
