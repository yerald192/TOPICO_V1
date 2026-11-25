<div class="patients-wrapper">
    <div class="page-header">
        <div>
            <h1 class="page-title"><i class="fa-solid fa-heart-pulse"></i> Equipos Médicos e Instrumental</h1>
            <p class="page-subtitle">Inventario de equipos disponibles en el tópico institucional</p>
        </div>
        <div class="page-actions">
            <a href="<?= BASE_URL ?>/equipo/crear" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i> Registrar Equipo
            </a>
        </div>
    </div>

    <!-- FILTRO -->
    <div class="filter-card">
        <form method="GET" action="<?= BASE_URL ?>/equipo" class="search-form">
            <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                <div class="search-input-group" style="flex: 2; min-width: 250px;">
                    <i class="fa-solid fa-magnifying-glass search-icon"></i>
                    <input type="text" name="q" value="<?= htmlspecialchars($busqueda) ?>" placeholder="Buscar por nombre, serie o categoría..." class="form-control">
                </div>
                <div style="flex: 1; min-width: 150px;">
                    <select name="estado" class="form-control">
                        <option value="">Todos los Estados</option>
                        <option value="Operativo" <?= $estado === 'Operativo' ? 'selected' : '' ?>>Operativo</option>
                        <option value="Mantenimiento" <?= $estado === 'Mantenimiento' ? 'selected' : '' ?>>En Mantenimiento</option>
                        <option value="Inoperativo" <?= $estado === 'Inoperativo' ? 'selected' : '' ?>>Inoperativo</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-secondary">Filtrar</button>
            </div>
        </form>
    </div>

    <div class="content-card">
        <div class="card-header">
            <h2><i class="fa-solid fa-boxes-stacked"></i> Equipos Registrados (<?= count($equipos) ?>)</h2>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nombre del Equipo</th>
                        <th>Categoría</th>
                        <th>N° de Serie / Código</th>
                        <th>Cantidad</th>
                        <th>Estado Físico</th>
                        <th>Observación</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($equipos)): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted" style="padding: 40px 0;">
                                No hay equipos registrados en el inventario.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($equipos as $eq): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($eq['nombre']) ?></strong></td>
                                <td><span class="badge badge-light"><?= htmlspecialchars($eq['categoria']) ?></span></td>
                                <td><code><?= htmlspecialchars($eq['serie'] ?: 'S/N') ?></code></td>
                                <td><strong><?= $eq['cantidad'] ?></strong> unid.</td>
                                <td>
                                    <?php if ($eq['estado'] === 'Operativo'): ?>
                                        <span class="badge badge-success">Operativo</span>
                                    <?php elseif ($eq['estado'] === 'Mantenimiento'): ?>
                                        <span class="badge" style="background: #fef3c7; color: #92400e;">Mantenimiento</span>
                                    <?php else: ?>
                                        <span class="badge" style="background: #fee2e2; color: #991b1b;"><?= htmlspecialchars($eq['estado']) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($eq['observacion'] ?: '-') ?></td>
                                <td class="text-center action-buttons">
                                    <a href="<?= BASE_URL ?>/equipo/editar/<?= $eq['id'] ?>" class="btn-action btn-edit" title="Editar">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a href="<?= BASE_URL ?>/equipo/eliminar/<?= $eq['id'] ?>" class="btn-action btn-delete" title="Dar de Baja" onclick="return confirm('¿Seguro de dar de baja este equipo?');">
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
