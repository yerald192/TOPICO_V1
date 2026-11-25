<div class="patients-wrapper">
    <div class="page-header">
        <div>
            <h1 class="page-title"><i class="fa-solid fa-clock-rotate-left"></i> Historial Clínico de Pacientes</h1>
            <p class="page-subtitle">Consulte todas las atenciones médicas y evolución de un paciente</p>
        </div>
    </div>

    <!-- BUSCADOR POR DNI -->
    <div class="filter-card">
        <form method="GET" action="<?= BASE_URL ?>/historial" class="search-form">
            <div class="search-input-group">
                <i class="fa-solid fa-id-card search-icon"></i>
                <input type="text" name="dni" value="<?= htmlspecialchars($dni) ?>" maxlength="8" pattern="\d{8}" required placeholder="Ingrese el DNI del paciente a consultar..." class="form-control" autofocus>
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-magnifying-glass"></i> Consultar Historial
                </button>
            </div>
        </form>
    </div>

    <?php if ($paciente): ?>
        <!-- FICHA RESUMEN DEL PACIENTE -->
        <div class="content-card" style="padding: 20px; margin-bottom: 24px; border-left: 5px solid #2563eb;">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
                <div>
                    <h2 style="font-size: 1.35rem; color: #1e293b;"><?= htmlspecialchars($paciente['apellidos_nombres']) ?></h2>
                    <p class="text-muted">
                        DNI: <strong><?= htmlspecialchars($paciente['dni']) ?></strong> • 
                        Edad: <?= htmlspecialchars($paciente['edad'] ? $paciente['edad'] . ' años' : '-') ?> • 
                        Género: <?= htmlspecialchars($paciente['genero'] ?: '-') ?> • 
                        Tipo Sangre: <span class="badge badge-blood"><?= htmlspecialchars($paciente['tipo_sangre'] ?: 'Desc.') ?></span>
                    </p>
                    <p style="font-size: 0.88rem; margin-top: 4px;">
                        Carrera: <strong><?= htmlspecialchars($paciente['programa_estudios'] ?: 'No especificado') ?></strong> (Ciclo <?= htmlspecialchars($paciente['semestre'] ?: '-') ?>) • 
                        Alergias: <em><?= htmlspecialchars($paciente['alergias'] ?: 'Ninguna') ?></em>
                    </p>
                </div>
                <div>
                    <a href="<?= BASE_URL ?>/atencion/crear?dni=<?= urlencode($paciente['dni']) ?>" class="btn btn-primary">
                        <i class="fa-solid fa-plus"></i> Registrar Nueva Atención
                    </a>
                </div>
            </div>
        </div>

        <!-- LISTADO CRONOLÓGICO DE ATENCIONES -->
        <div class="content-card">
            <div class="card-header">
                <h2><i class="fa-solid fa-timeline"></i> Línea de Tiempo de Consultas (<?= count($historial) ?>)</h2>
            </div>
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Motivo de Consulta</th>
                            <th>Signos y Síntomas</th>
                            <th>Tratamiento Realizado</th>
                            <th>Constantes Vitales</th>
                            <th>Responsable</th>
                            <th class="text-center">Detalle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($historial)): ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted" style="padding: 30px 0;">
                                    El paciente no registra atenciones médicas previas.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($historial as $h): ?>
                                <tr>
                                    <td>
                                        <strong><?= date('d/m/Y', strtotime($h['fecha'])) ?></strong>
                                        <div class="text-muted" style="font-size: 0.8rem;"><?= htmlspecialchars($h['hora_ingreso']) ?></div>
                                    </td>
                                    <td><strong><?= htmlspecialchars($h['motivo_consulta']) ?></strong></td>
                                    <td><?= htmlspecialchars($h['signos_sintomas'] ?: '-') ?></td>
                                    <td><?= htmlspecialchars($h['tratamiento'] ?: 'Sintomático') ?></td>
                                    <td>
                                        <small class="text-muted">
                                            <?= $h['temperatura'] ? "T: {$h['temperatura']}°C " : "" ?>
                                            <?= $h['presion_arterial'] ? "P.A: {$h['presion_arterial']} " : "" ?>
                                            <?= $h['frecuencia_cardiaca'] ? "FC: {$h['frecuencia_cardiaca']} " : "" ?>
                                            <?= $h['imc'] ? "IMC: {$h['imc']}" : "" ?>
                                        </small>
                                    </td>
                                    <td><span class="badge badge-light"><?= htmlspecialchars($h['responsable_atencion']) ?></span></td>
                                    <td class="text-center">
                                        <a href="<?= BASE_URL ?>/atencion/ver/<?= $h['id'] ?>" class="btn-action btn-edit" title="Ver Detalle Completo">
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
    <?php elseif (!empty($dni)): ?>
        <div class="content-card" style="padding: 40px; text-align: center;">
            <i class="fa-solid fa-user-xmark" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 12px;"></i>
            <h3>Paciente no encontrado</h3>
            <p class="text-muted" style="margin-bottom: 18px;">No existe ningún paciente registrado con el DNI <strong><?= htmlspecialchars($dni) ?></strong>.</p>
            <a href="<?= BASE_URL ?>/paciente/crear" class="btn btn-primary">
                <i class="fa-solid fa-user-plus"></i> Registrar este Paciente Ahora
            </a>
        </div>
    <?php endif; ?>
</div>
