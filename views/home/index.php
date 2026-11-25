<div class="dashboard-wrapper">
    <div class="page-header">
        <div>
            <h1 class="page-title"><i class="fa-solid fa-house-chimney-medical"></i> Panel Principal de Control</h1>
            <p class="page-subtitle">Sistema Autónomo de Gestión de Tópico Médico • IESP Huanta</p>
        </div>
        <div class="page-actions" style="display: flex; gap: 8px;">
            <a href="<?= BASE_URL ?>/atencion/crear" class="btn btn-primary">
                <i class="fa-solid fa-stethoscope"></i> Nueva Atención Médica
            </a>
            <a href="<?= BASE_URL ?>/paciente/crear" class="btn btn-secondary">
                <i class="fa-solid fa-user-plus"></i> Registrar Paciente
            </a>
        </div>
    </div>

    <!-- TARJETAS DE MÉTRICAS -->
    <div class="metrics-grid">
        <a href="<?= BASE_URL ?>/paciente" style="text-decoration: none; color: inherit;">
            <div class="metric-card card-blue">
                <div class="metric-icon"><i class="fa-solid fa-users"></i></div>
                <div class="metric-info">
                    <h3><?= number_format($totalPacientes) ?></h3>
                    <p>Pacientes Registrados</p>
                </div>
            </div>
        </a>

        <a href="<?= BASE_URL ?>/atencion" style="text-decoration: none; color: inherit;">
            <div class="metric-card card-emerald">
                <div class="metric-icon"><i class="fa-solid fa-stethoscope"></i></div>
                <div class="metric-info">
                    <h3><?= number_format($totalAtenciones) ?></h3>
                    <p>Atenciones Médicas</p>
                </div>
            </div>
        </a>

        <a href="<?= BASE_URL ?>/equipo" style="text-decoration: none; color: inherit;">
            <div class="metric-card card-amber">
                <div class="metric-icon"><i class="fa-solid fa-heart-pulse"></i></div>
                <div class="metric-info">
                    <h3><?= number_format($totalEquipos) ?></h3>
                    <p>Equipos e Instrumental</p>
                </div>
            </div>
        </a>

        <a href="<?= BASE_URL ?>/producto" style="text-decoration: none; color: inherit;">
            <div class="metric-card card-purple">
                <div class="metric-icon"><i class="fa-solid fa-pills"></i></div>
                <div class="metric-info">
                    <h3><?= number_format($totalProductos) ?></h3>
                    <p>Medicamentos en Stock</p>
                </div>
            </div>
        </a>
    </div>

    <!-- ACCESOS RÁPIDOS A MÓDULOS -->
    <div class="content-card" style="padding: 20px; margin-bottom: 28px;">
        <h2 style="font-size: 1.1rem; margin-bottom: 14px; color: #1e293b;">
            <i class="fa-solid fa-bolt"></i> Accesos Rápidos
        </h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px;">
            <a href="<?= BASE_URL ?>/historial" class="btn btn-outline" style="justify-content: flex-start; padding: 12px;">
                <i class="fa-solid fa-clock-rotate-left" style="color: #2563eb;"></i> Historial Clínico
            </a>
            <a href="<?= BASE_URL ?>/derivacion/crear" class="btn btn-outline" style="justify-content: flex-start; padding: 12px;">
                <i class="fa-solid fa-truck-medical" style="color: #dc2626;"></i> Ficha de Derivación
            </a>
            <a href="<?= BASE_URL ?>/inventario/crear" class="btn btn-outline" style="justify-content: flex-start; padding: 12px;">
                <i class="fa-solid fa-clipboard-check" style="color: #059669;"></i> Toma de Inventario
            </a>
            <a href="<?= BASE_URL ?>/reporte" class="btn btn-outline" style="justify-content: flex-start; padding: 12px;">
                <i class="fa-solid fa-chart-line" style="color: #7c3aed;"></i> Reportes y Estadísticas
            </a>
            <a href="<?= BASE_URL ?>/personal/asistencia" class="btn btn-outline" style="justify-content: flex-start; padding: 12px;">
                <i class="fa-solid fa-calendar-check" style="color: #0284c7;"></i> Control de Asistencia
            </a>
        </div>
    </div>

    <!-- SECCIONES DE ACTIVIDAD RECIENTE -->
    <div class="dashboard-columns">
        <div class="content-card">
            <div class="card-header">
                <h2><i class="fa-solid fa-notes-medical"></i> Últimas Atenciones Médicas</h2>
                <a href="<?= BASE_URL ?>/atencion" class="btn-link">Ver todas</a>
            </div>
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Paciente</th>
                            <th>Motivo Consulta</th>
                            <th>Responsable</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($ultimasAtenciones)): ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted" style="padding: 24px;">No hay atenciones registradas hoy.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($ultimasAtenciones as $at): ?>
                                <tr>
                                    <td><?= date('d/m/Y', strtotime($at['fecha'])) ?></td>
                                    <td><strong><?= htmlspecialchars($at['apellidos_nombres']) ?></strong></td>
                                    <td><?= htmlspecialchars($at['motivo_consulta']) ?></td>
                                    <td><span class="badge badge-success"><?= htmlspecialchars($at['responsable_atencion']) ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="content-card">
            <div class="card-header">
                <h2><i class="fa-solid fa-user-clock"></i> Últimos Pacientes Incorporados</h2>
                <a href="<?= BASE_URL ?>/paciente" class="btn-link">Ver todos</a>
            </div>
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>DNI</th>
                            <th>Nombres y Apellidos</th>
                            <th>Programa</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($ultimosPacientes)): ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted" style="padding: 24px;">No hay pacientes registrados aún.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($ultimosPacientes as $p): ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($p['dni']) ?></strong></td>
                                    <td><?= htmlspecialchars($p['apellidos_nombres']) ?></td>
                                    <td><span class="badge badge-light"><?= htmlspecialchars($p['programa_estudios'] ?: 'General') ?></span></td>
                                    <td class="text-muted"><?= date('d/m/Y', strtotime($p['fecha_creacion'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
