<div class="patients-wrapper">
    <div class="page-header">
        <div>
            <h1 class="page-title"><i class="fa-solid fa-user-shield"></i> Gestión de Personal y Usuarios</h1>
            <p class="page-subtitle">Administración de credenciales, roles y acceso al sistema tópico</p>
        </div>
        <div class="page-actions">
            <a href="<?= BASE_URL ?>/personal/crear" class="btn btn-primary">
                <i class="fa-solid fa-user-plus"></i> Registrar Nuevo Usuario
            </a>
            <a href="<?= BASE_URL ?>/personal/asistencia" class="btn btn-secondary">
                <i class="fa-solid fa-calendar-check"></i> Ver Asistencia
            </a>
        </div>
    </div>

    <div class="content-card">
        <div class="card-header">
            <h2><i class="fa-solid fa-users-gear"></i> Personal Activo (<?= count($personal) ?>)</h2>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>DNI</th>
                        <th>Nombres y Apellidos</th>
                        <th>Especialidad / Cargo</th>
                        <th>Rol de Acceso</th>
                        <th>Fecha de Registro</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($personal as $u): ?>
                        <tr>
                            <td><span class="badge badge-dni"><?= htmlspecialchars($u['dni']) ?></span></td>
                            <td><strong><?= htmlspecialchars($u['apellido_nombre']) ?></strong></td>
                            <td><?= htmlspecialchars($u['especialidad'] ?: 'Enfermería / Tópico') ?></td>
                            <td>
                                <?php if ($u['rol'] === 'admin'): ?>
                                    <span class="badge badge-success"><i class="fa-solid fa-shield"></i> Administrador</span>
                                <?php else: ?>
                                    <span class="badge badge-light"><i class="fa-solid fa-user"></i> Personal</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-muted"><?= date('d/m/Y', strtotime($u['fecha_creacion'])) ?></td>
                            <td class="text-center action-buttons">
                                <a href="<?= BASE_URL ?>/personal/cambiarRol/<?= $u['id'] ?>" class="btn-action btn-edit" title="Cambiar Rol (Admin/Personal)" onclick="return confirm('¿Cambiar rol a este usuario?');">
                                    <i class="fa-solid fa-repeat"></i>
                                </a>
                                <?php if ($u['dni'] !== ($_SESSION['usuario_dni'] ?? '')): ?>
                                    <a href="<?= BASE_URL ?>/personal/eliminar/<?= $u['id'] ?>" class="btn-action btn-delete" title="Inactivar Usuario" onclick="return confirm('¿Inactivar cuenta de usuario?');">
                                        <i class="fa-solid fa-user-slash"></i>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
