<div class="patients-wrapper">
    <div class="page-header">
        <div>
            <h1 class="page-title"><i class="fa-solid fa-stethoscope"></i> Atenciones Médicas</h1>
            <p class="page-subtitle">Registro cronológico de consultas y atención de pacientes</p>
        </div>
        <div class="page-actions">
            <a href="<?= BASE_URL ?>/atencion/crear" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i> Nueva Consulta Médica
            </a>
        </div>
    </div>

    <!-- FILTROS -->
    <div class="filter-card">
        <form method="GET" action="<?= BASE_URL ?>/atencion" class="search-form">
            <div style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
                <div class="search-input-group" style="flex: 2; min-width: 260px;">
                    <i class="fa-solid fa-magnifying-glass search-icon"></i>
                    <input type="text" name="q" value="<?= htmlspecialchars($busqueda) ?>" placeholder="Buscar por DNI, Nombres o Motivo..." class="form-control">
                </div>
                <div style="flex: 1; min-width: 160px;">
                    <input type="date" name="fecha" value="<?= htmlspecialchars($fecha) ?>" class="form-control" title="Filtrar por fecha específica">
                </div>
                <button type="submit" class="btn btn-secondary">Filtrar</button>
                <?php if (!empty($busqueda) || !empty($fecha)): ?>
                    <a href="<?= BASE_URL ?>/atencion" class="btn btn-outline" title="Limpiar"><i class="fa-solid fa-xmark"></i></a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- TABLA DE ATENCIONES -->
    <div class="content-card">
        <div class="card-header">
            <h2><i class="fa-solid fa-notes-medical"></i> Consultas Registradas (<?= $total ?>)</h2>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Fecha / Hora</th>
                        <th>DNI</th>
                        <th>Paciente</th>
                        <th>Programa / Carrera</th>
                        <th>Motivo Consulta</th>
                        <th>Tratamiento</th>
                        <th>Constantes</th>
                        <th>Responsable</th>
                        <th class="text-center">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($atenciones)): ?>
                        <tr>
                            <td colspan="9" class="text-center text-muted" style="padding: 40px 0;">
                                <i class="fa-solid fa-clipboard-check" style="font-size: 2.5rem; display: block; margin-bottom: 10px; color: #94a3b8;"></i>
                                No se encontraron atenciones registradas.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($atenciones as $at): ?>
                            <tr>
                                <td>
                                    <strong><?= date('d/m/Y', strtotime($at['fecha'])) ?></strong>
                                    <div class="text-muted" style="font-size: 0.8rem;"><?= htmlspecialchars($at['hora_ingreso']) ?></div>
                                </td>
                                <td><span class="badge badge-dni"><?= htmlspecialchars($at['dni']) ?></span></td>
                                <td><strong><?= htmlspecialchars($at['apellidos_nombres']) ?></strong></td>
                                <td><span class="badge badge-light"><?= htmlspecialchars($at['programa_estudios'] ?: 'General') ?></span></td>
                                <td><?= htmlspecialchars($at['motivo_consulta']) ?></td>
                                <td><?= htmlspecialchars($at['tratamiento'] ?: 'Sintomático') ?></td>
                                <td>
                                    <small class="text-muted">
                                        <?= $at['temperatura'] ? "T: {$at['temperatura']}°C " : "" ?>
                                        <?= $at['presion_arterial'] ? "P.A: {$at['presion_arterial']} " : "" ?>
                                        <?= $at['imc'] ? "IMC: {$at['imc']}" : "" ?>
                                    </small>
                                </td>
                                <td><span class="badge badge-success"><?= htmlspecialchars($at['responsable_atencion']) ?></span></td>
                                <td class="text-center">
                                    <a href="<?= BASE_URL ?>/atencion/ver/<?= $at['id'] ?>" class="btn-action btn-edit" title="Ver Detalle">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if ($totalPaginas > 1): ?>
            <div class="pagination-wrapper">
                <div class="pagination">
                    <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                        <a href="<?= BASE_URL ?>/atencion?p=<?= $i ?>&q=<?= urlencode($busqueda) ?>&fecha=<?= urlencode($fecha) ?>" class="page-link <?= $i === $pagina ? 'active' : '' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
