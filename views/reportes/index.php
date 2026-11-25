<div class="patients-wrapper">
    <div class="page-header">
        <div>
            <h1 class="page-title"><i class="fa-solid fa-chart-pie"></i> Estadísticas y Reportes Generales</h1>
            <p class="page-subtitle">Informes consolidados de atención médica y diagnósticos</p>
        </div>
        <div class="page-actions">
            <button onclick="window.print();" class="btn btn-secondary">
                <i class="fa-solid fa-print"></i> Imprimir Reporte
            </button>
        </div>
    </div>

    <!-- FILTRO DE RANGO DE FECHAS -->
    <div class="filter-card no-print">
        <form method="GET" action="<?= BASE_URL ?>/reporte" class="search-form">
            <div style="display: flex; gap: 14px; flex-wrap: wrap; align-items: flex-end;">
                <div class="form-group">
                    <label>Desde:</label>
                    <input type="date" name="desde" value="<?= htmlspecialchars($desde) ?>" class="form-control">
                </div>
                <div class="form-group">
                    <label>Hasta:</label>
                    <input type="date" name="hasta" value="<?= htmlspecialchars($hasta) ?>" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary" style="margin-bottom: 2px;">
                    <i class="fa-solid fa-filter"></i> Generar Estadísticas
                </button>
            </div>
        </form>
    </div>

    <!-- CUADROS ESTADÍSTICOS -->
    <div class="dashboard-columns" style="margin-bottom: 24px;">
        <div class="content-card">
            <div class="card-header">
                <h2><i class="fa-solid fa-graduation-cap"></i> Atenciones por Carrera / Programa</h2>
            </div>
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Programa de Estudios</th>
                            <th class="text-center">Total Atenciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($porPrograma)): ?>
                            <tr><td colspan="2" class="text-center text-muted">Sin datos en el período</td></tr>
                        <?php else: ?>
                            <?php foreach ($porPrograma as $prog): ?>
                                <tr>
                                    <td><?= htmlspecialchars($prog['programa_estudios'] ?: 'General / Docentes') ?></td>
                                    <td class="text-center"><strong><?= $prog['total'] ?></strong></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="content-card">
            <div class="card-header">
                <h2><i class="fa-solid fa-stethoscope"></i> Motivos de Consulta Más Frecuentes</h2>
            </div>
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Diagnóstico / Motivo</th>
                            <th class="text-center">Casos</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($motivosFrecuentes)): ?>
                            <tr><td colspan="2" class="text-center text-muted">Sin datos en el período</td></tr>
                        <?php else: ?>
                            <?php foreach ($motivosFrecuentes as $mot): ?>
                                <tr>
                                    <td><?= htmlspecialchars($mot['motivo_consulta']) ?></td>
                                    <td class="text-center"><span class="badge badge-success"><?= $mot['total'] ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- LISTADO GENERAL DETALLADO -->
    <div class="content-card">
        <div class="card-header">
            <h2><i class="fa-solid fa-list-ol"></i> Registro Detallado del Período (<?= count($listado) ?> consultas)</h2>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>DNI</th>
                        <th>Paciente</th>
                        <th>Programa</th>
                        <th>Motivo</th>
                        <th>Tratamiento</th>
                        <th>Responsable</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($listado)): ?>
                        <tr><td colspan="7" class="text-center text-muted" style="padding: 30px;">No se registran atenciones entre las fechas seleccionadas.</td></tr>
                    <?php else: ?>
                        <?php foreach ($listado as $item): ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($item['fecha'])) ?></td>
                                <td><?= htmlspecialchars($item['dni']) ?></td>
                                <td><strong><?= htmlspecialchars($item['apellidos_nombres']) ?></strong></td>
                                <td><?= htmlspecialchars($item['programa_estudios']) ?></td>
                                <td><?= htmlspecialchars($item['motivo_consulta']) ?></td>
                                <td><?= htmlspecialchars($item['tratamiento']) ?></td>
                                <td><span class="badge badge-light"><?= htmlspecialchars($item['responsable_atencion']) ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
