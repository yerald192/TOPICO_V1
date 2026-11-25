<div class="patients-wrapper">
    <div class="page-header">
        <div>
            <h1 class="page-title"><i class="fa-solid fa-address-book"></i> Gestión de Pacientes</h1>
            <p class="page-subtitle">Listado general de pacientes registrados en la base de datos local</p>
        </div>
        <div class="page-actions">
            <a href="<?= BASE_URL ?>/paciente/crear" class="btn btn-primary">
                <i class="fa-solid fa-user-plus"></i> Nuevo Paciente
            </a>
        </div>
    </div>

    <!-- BARRA DE BÚSQUEDA Y FILTRO -->
    <div class="filter-card">
        <form method="GET" action="<?= BASE_URL ?>/paciente" class="search-form">
            <div class="search-input-group">
                <i class="fa-solid fa-magnifying-glass search-icon"></i>
                <input type="text" name="q" value="<?= htmlspecialchars($busqueda) ?>" placeholder="Buscar por DNI, Nombres o Programa de Estudios..." class="form-control">
                <?php if (!empty($busqueda)): ?>
                    <a href="<?= BASE_URL ?>/paciente" class="btn btn-outline" title="Limpiar búsqueda">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                <?php endif; ?>
                <button type="submit" class="btn btn-secondary">
                    Buscar
                </button>
            </div>
        </form>
    </div>

    <!-- TABLA DE PACIENTES -->
    <div class="content-card">
        <div class="card-header">
            <h2><i class="fa-solid fa-list-check"></i> Registros Encontrados (<?= $total ?>)</h2>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>DNI</th>
                        <th>Apellidos y Nombres</th>
                        <th>Programa / Carrera</th>
                        <th>Semestre</th>
                        <th>Edad</th>
                        <th>Teléfono</th>
                        <th>Tipo Sangre</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pacientes)): ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted" style="padding: 40px 0;">
                                <i class="fa-regular fa-folder-open" style="font-size: 2.5rem; display: block; margin-bottom: 10px; color: #94a3b8;"></i>
                                No se encontraron pacientes registrados con los criterios solicitados.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($pacientes as $p): ?>
                            <tr>
                                <td><span class="badge badge-dni"><?= htmlspecialchars($p['dni']) ?></span></td>
                                <td><strong><?= htmlspecialchars($p['apellidos_nombres']) ?></strong></td>
                                <td><?= htmlspecialchars($p['programa_estudios'] ?: 'No especificado') ?></td>
                                <td><?= htmlspecialchars($p['semestre'] ?: '-') ?></td>
                                <td><?= htmlspecialchars($p['edad'] ? $p['edad'] . ' años' : '-') ?></td>
                                <td><?= htmlspecialchars($p['telefono'] ?: '-') ?></td>
                                <td><span class="badge badge-blood"><?= htmlspecialchars($p['tipo_sangre'] ?: 'Desc.') ?></span></td>
                                <td class="text-center action-buttons">
                                    <a href="<?= BASE_URL ?>/paciente/editar/<?= $p['id'] ?>" class="btn-action btn-edit" title="Editar">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a href="<?= BASE_URL ?>/paciente/eliminar/<?= $p['id'] ?>" class="btn-action btn-delete" title="Eliminar" onclick="return confirm('¿Está seguro de eliminar al paciente <?= htmlspecialchars(addslashes($p['apellidos_nombres'])) ?>?');">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- PAGINACIÓN -->
        <?php if ($totalPaginas > 1): ?>
            <div class="pagination-wrapper">
                <div class="pagination">
                    <?php if ($pagina > 1): ?>
                        <a href="<?= BASE_URL ?>/paciente?p=<?= $pagina - 1 ?>&q=<?= urlencode($busqueda) ?>" class="page-link">&laquo; Anterior</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                        <a href="<?= BASE_URL ?>/paciente?p=<?= $i ?>&q=<?= urlencode($busqueda) ?>" class="page-link <?= $i === $pagina ? 'active' : '' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>

                    <?php if ($pagina < $totalPaginas): ?>
                        <a href="<?= BASE_URL ?>/paciente?p=<?= $pagina + 1 ?>&q=<?= urlencode($busqueda) ?>" class="page-link">Siguiente &raquo;</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
