<div class="form-wrapper">
    <div class="page-header">
        <div>
            <h1 class="page-title"><i class="fa-solid fa-file-medical"></i> Atención Médica #<?= $atencion['id'] ?></h1>
            <p class="page-subtitle">Detalle completo de la consulta médica realizada</p>
        </div>
        <div class="page-actions">
            <a href="<?= BASE_URL ?>/historial?dni=<?= urlencode($atencion['dni']) ?>" class="btn btn-secondary">
                <i class="fa-solid fa-clock-rotate-left"></i> Ver Historial del Paciente
            </a>
            <a href="<?= BASE_URL ?>/atencion" class="btn btn-outline">
                <i class="fa-solid fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    <div class="content-card" style="padding: 24px; margin-bottom: 24px;">
        <div style="display: flex; justify-content: space-between; border-bottom: 1px solid #e2e8f0; padding-bottom: 16px; margin-bottom: 20px;">
            <div>
                <h2 style="font-size: 1.3rem; color: #1e293b;"><?= htmlspecialchars($atencion['apellidos_nombres']) ?></h2>
                <p class="text-muted">DNI: <strong><?= htmlspecialchars($atencion['dni']) ?></strong> • Carrera: <?= htmlspecialchars($atencion['programa_estudios'] ?: 'General') ?> • Semestre: <?= htmlspecialchars($atencion['semestre'] ?: '-') ?></p>
            </div>
            <div style="text-align: right;">
                <span class="badge badge-success" style="font-size: 0.9rem; padding: 6px 12px;">Atención Activa</span>
                <p class="text-muted" style="margin-top: 6px;">Fecha: <?= date('d/m/Y', strtotime($atencion['fecha'])) ?> (<?= htmlspecialchars($atencion['hora_ingreso']) ?>)</p>
            </div>
        </div>

        <div class="form-grid" style="margin-bottom: 24px;">
            <div>
                <strong>Edad / Género:</strong>
                <p><?= htmlspecialchars($atencion['edad']) ?> años / <?= htmlspecialchars($atencion['genero']) ?></p>
            </div>
            <div>
                <strong>Teléfono:</strong>
                <p><?= htmlspecialchars($atencion['telefono'] ?: '-') ?></p>
            </div>
            <div>
                <strong>Contacto de Emergencia:</strong>
                <p><?= htmlspecialchars($atencion['celular_emergencia'] ?: '-') ?></p>
            </div>
        </div>

        <h3 style="font-size: 1.1rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 8px; margin-bottom: 14px;">
            <i class="fa-solid fa-heart-pulse"></i> Signos Vitales y Triaje
        </h3>
        <div class="metrics-grid" style="margin-bottom: 24px;">
            <div class="metric-card card-blue" style="padding: 14px;">
                <div class="metric-info">
                    <h3><?= $atencion['temperatura'] ? $atencion['temperatura'] . '°C' : '-' ?></h3>
                    <p>Temperatura</p>
                </div>
            </div>
            <div class="metric-card card-emerald" style="padding: 14px;">
                <div class="metric-info">
                    <h3><?= htmlspecialchars($atencion['presion_arterial'] ?: '-') ?></h3>
                    <p>Presión Arterial</p>
                </div>
            </div>
            <div class="metric-card card-amber" style="padding: 14px;">
                <div class="metric-info">
                    <h3><?= $atencion['frecuencia_cardiaca'] ? $atencion['frecuencia_cardiaca'] . ' lpm' : '-' ?></h3>
                    <p>Frecuencia Cardíaca</p>
                </div>
            </div>
            <div class="metric-card card-purple" style="padding: 14px;">
                <div class="metric-info">
                    <h3><?= $atencion['imc'] ?: '-' ?></h3>
                    <p>IMC (Peso: <?= $atencion['peso'] ?: '-' ?> kg)</p>
                </div>
            </div>
        </div>

        <h3 style="font-size: 1.1rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 8px; margin-bottom: 14px;">
            <i class="fa-solid fa-clipboard-check"></i> Diagnóstico y Tratamiento
        </h3>
        <div style="margin-bottom: 16px;">
            <strong>Motivo de Consulta:</strong>
            <p style="font-size: 1.05rem; margin-top: 4px;"><?= htmlspecialchars($atencion['motivo_consulta']) ?></p>
        </div>

        <?php if (!empty($atencion['signos_sintomas'])): ?>
            <div style="margin-bottom: 16px;">
                <strong>Signos y Síntomas:</strong>
                <p><?= nl2br(htmlspecialchars($atencion['signos_sintomas'])) ?></p>
            </div>
        <?php endif; ?>

        <div style="margin-bottom: 16px;">
            <strong>Tratamiento Administrado:</strong>
            <p><?= nl2br(htmlspecialchars($atencion['tratamiento'] ?: 'Ninguno registrado')) ?></p>
        </div>

        <div class="form-grid">
            <div>
                <strong>Tipo de Descanso:</strong>
                <p><span class="badge badge-light"><?= htmlspecialchars($atencion['tipo_descanso']) ?></span></p>
            </div>
            <div>
                <strong>Derivación a Centro:</strong>
                <p><?= htmlspecialchars($atencion['hospital_derivacion'] ?: 'No aplica') ?></p>
            </div>
            <div>
                <strong>Responsable de Atención:</strong>
                <p><?= htmlspecialchars($atencion['responsable_atencion']) ?></p>
            </div>
        </div>
    </div>
</div>
