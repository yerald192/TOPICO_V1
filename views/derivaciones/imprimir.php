<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ficha de Derivación - <?= htmlspecialchars($derivacion['nro_derivacion']) ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #111;
            margin: 0;
            padding: 30px;
            background: #fff;
            line-height: 1.4;
        }
        .sheet {
            max-width: 800px;
            margin: 0 auto;
            border: 2px solid #0f172a;
            padding: 24px;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2px solid #0f172a;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .header-title h1 { font-size: 16pt; margin: 0; text-transform: uppercase; }
        .header-title p { font-size: 10pt; margin: 2px 0 0 0; color: #475569; }
        .badge-nro {
            font-size: 14pt;
            font-weight: bold;
            padding: 6px 12px;
            border: 2px dashed #0f172a;
            border-radius: 4px;
        }
        .section-box {
            border: 1px solid #cbd5e1;
            margin-bottom: 16px;
        }
        .section-header {
            background-color: #f1f5f9;
            font-weight: bold;
            font-size: 10pt;
            padding: 6px 10px;
            border-bottom: 1px solid #cbd5e1;
            text-transform: uppercase;
        }
        .section-content {
            padding: 10px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            font-size: 9.5pt;
        }
        .grid-full { grid-column: 1 / -1; }
        .signatures {
            display: flex;
            justify-content: space-around;
            margin-top: 50px;
            text-align: center;
            font-size: 9.5pt;
        }
        .sig-line {
            width: 200px;
            border-top: 1px solid #000;
            padding-top: 6px;
        }
        @media print {
            body { padding: 0; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="max-width: 800px; margin: 0 auto 16px auto; text-align: right;">
        <button onclick="window.print();" style="padding: 10px 20px; background: #1e3a8a; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-size: 11pt; font-weight: bold;">
            🖨️ Imprimir Hoja de Derivación
        </button>
    </div>

    <div class="sheet">
        <div class="header">
            <div class="header-title">
                <h1>IESP HUANTA • TÓPICO INSTITUCIONAL</h1>
                <p>HOJA DE REFERENCIA Y DERIVACIÓN DE PACIENTE</p>
            </div>
            <div class="badge-nro">
                <?= htmlspecialchars($derivacion['nro_derivacion']) ?>
            </div>
        </div>

        <div class="section-box">
            <div class="section-header">1. Destino y Datos de la Referencia</div>
            <div class="section-content">
                <div><strong>Fecha:</strong> <?= date('d/m/Y', strtotime($derivacion['fecha_emision'])) ?></div>
                <div><strong>Centro de Destino:</strong> <?= htmlspecialchars($derivacion['hospital_destino']) ?></div>
                <div><strong>Tipo de Atención:</strong> <?= htmlspecialchars($derivacion['tipo_atencion']) ?></div>
            </div>
        </div>

        <div class="section-box">
            <div class="section-header">2. Identificación del Paciente</div>
            <div class="section-content">
                <div class="grid-full"><strong>Nombres y Apellidos:</strong> <?= htmlspecialchars($derivacion['paciente_nombre']) ?></div>
                <div><strong>DNI:</strong> <?= htmlspecialchars($derivacion['paciente_dni']) ?></div>
                <div><strong>Edad / Sexo:</strong> <?= htmlspecialchars($derivacion['paciente_edad']) ?> años / <?= htmlspecialchars($derivacion['paciente_sexo']) ?></div>
                <div><strong>Teléfono:</strong> <?= htmlspecialchars($derivacion['paciente_telefono'] ?: '-') ?></div>
                <div class="grid-full"><strong>Programa de Estudios:</strong> <?= htmlspecialchars($derivacion['paciente_carrera'] ?: 'No especificado') ?> (Ciclo <?= htmlspecialchars($derivacion['ciclo'] ?: '-') ?>)</div>
            </div>
        </div>

        <div class="section-box">
            <div class="section-header">3. Constantes Vitales en Tópico</div>
            <div class="section-content">
                <div><strong>Presión Arterial:</strong> <?= htmlspecialchars($derivacion['presion_arterial'] ?: '-') ?></div>
                <div><strong>Temperatura:</strong> <?= $derivacion['temperatura'] ? $derivacion['temperatura'] . ' °C' : '-' ?></div>
                <div><strong>Frecuencia Cardíaca:</strong> <?= $derivacion['frecuencia_cardiaca'] ? $derivacion['frecuencia_cardiaca'] . ' lpm' : '-' ?></div>
            </div>
        </div>

        <div class="section-box">
            <div class="section-header">4. Motivo de Derivación y Diagnóstico Presuntivo</div>
            <div class="section-content">
                <div class="grid-full">
                    <p style="margin: 0; font-size: 10pt;"><?= nl2br(htmlspecialchars($derivacion['motivo'])) ?></p>
                </div>
            </div>
        </div>

        <?php if (!empty($derivacion['signos_sintomas'])): ?>
            <div class="section-box">
                <div class="section-header">5. Acciones y Manejo Inicial en Tópico</div>
                <div class="section-content">
                    <div class="grid-full">
                        <p style="margin: 0; font-size: 9.5pt;"><?= nl2br(htmlspecialchars($derivacion['signos_sintomas'])) ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="section-box">
            <div class="section-header">6. Familiar o Apoderado Responsable</div>
            <div class="section-content">
                <div><strong>Nombre:</strong> <?= htmlspecialchars($derivacion['apoderado_nombre'] ?: '-') ?></div>
                <div><strong>Parentesco:</strong> <?= htmlspecialchars($derivacion['apoderado_parentesco'] ?: '-') ?></div>
                <div><strong>Teléfono:</strong> <?= htmlspecialchars($derivacion['apoderado_celular'] ?: '-') ?></div>
            </div>
        </div>

        <div class="signatures">
            <div class="sig-line">
                <strong><?= htmlspecialchars($derivacion['profesional_nombre']) ?></strong><br>
                Personal de Tópico Emisor
            </div>
            <div class="sig-line">
                Recepción Centro de Salud<br>
                Firma y Sello
            </div>
        </div>
    </div>
</body>
</html>
