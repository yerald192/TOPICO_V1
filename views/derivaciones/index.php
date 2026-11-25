<div class="patients-wrapper">
    <div class="page-header">
        <div>
            <h1 class="page-title"><i class="fa-solid fa-truck-medical"></i> Derivaciones Médicas</h1>
            <p class="page-subtitle">Referencias emitidas a hospitales y centros de salud externos</p>
        </div>
        <div class="page-actions">
            <a href="<?= BASE_URL ?>/derivacion/crear" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i> Emitir Nueva Derivación
            </a>
        </div>
    </div>

    <!-- BUSCADOR -->
    <div class="filter-card">
        <form method="GET" action="<?= BASE_URL ?>/derivacion" class="search-form">
            <div class="search-input-group">
                <i class="fa-solid fa-magnifying-glass search-icon"></i>
                <input type="text" name="q" value="<?= htmlspecialchars($busqueda) ?>" placeholder="Buscar por N° Derivación, DNI, Paciente u Hospital..." class="form-control">
                <button type="submit" class="btn btn-secondary">Buscar</button>
            </div>
        </form>
    </div>

    <div class="content-card">
        <div class="card-header">
            <h2><i class="fa-solid fa-file-invoice"></i> Fichas Emitidas (<?= $total ?>)</h2>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>N° Derivación</th>
                        <th>Fecha</th>
                        <th>DNI</th>
                        <th>Paciente</th>
                        <th>Carrera / Ciclo</th>
                        <th>Hospital Destino</th>
                        <th>Motivo</th>
                        <th>Estado</th>
                        <th class="text-center">Imprimir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($derivaciones)): ?>
                        <tr>
                            <td colspan="9" class="text-center text-muted" style="padding: 40px 0;">
                                No hay derivaciones hospitalarias registradas.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($derivaciones as $d): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($d['nro_derivacion']) ?></strong></td>
                                <td><?= date('d/m/Y', strtotime($d['fecha_emision'])) ?></td>
                                <td><span class="badge badge-dni"><?= htmlspecialchars($d['paciente_dni']) ?></span></td>
                                <td><strong><?= htmlspecialchars($d['paciente_nombre']) ?></strong></td>
                                <td><?= htmlspecialchars($d['paciente_carrera'] ?: '-') ?></td>
                                <td><span class="badge badge-light"><?= htmlspecialchars($d['hospital_destino']) ?></span></td>
                                <td><?= htmlspecialchars($d['motivo']) ?></td>
                                <td><span class="badge badge-success"><?= htmlspecialchars($d['estado']) ?></span></td>
                                <td class="text-center">
                                    <a href="<?= BASE_URL ?>/derivacion/imprimir/<?= $d['id'] ?>" target="_blank" class="btn-action btn-edit" title="Ver / Imprimir Ficha">
                                        <i class="fa-solid fa-print"></i>
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
