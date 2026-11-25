<div class="form-wrapper">
    <div class="page-header">
        <div>
            <h1 class="page-title"><i class="fa-solid fa-stethoscope"></i> Registrar Atención Médica</h1>
            <p class="page-subtitle">Formulario de consulta ambulatoria y registro de signos vitales</p>
        </div>
        <div class="page-actions">
            <a href="<?= BASE_URL ?>/atencion" class="btn btn-outline">
                <i class="fa-solid fa-arrow-left"></i> Volver a Atenciones
            </a>
        </div>
    </div>

    <form method="POST" action="<?= BASE_URL ?>/atencion/guardar" class="medical-form">
        <!-- SECCIÓN 1: DATOS DEL PACIENTE -->
        <div class="form-section">
            <div class="section-title">
                <i class="fa-solid fa-user-injured"></i> 1. Paciente a Atender
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label for="dni">DNI del Paciente <span class="required">*</span></label>
                    <div style="display: flex; gap: 8px;">
                        <input type="text" id="dni" name="dni" value="<?= htmlspecialchars($dni ?: ($paciente['dni'] ?? '')) ?>" required maxlength="8" pattern="\d{8}" placeholder="8 dígitos" class="form-control">
                        <button type="button" id="btnBuscarDni" class="btn btn-secondary" title="Buscar en base de datos">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group grid-col-2">
                    <label for="apellidos_nombres">Nombres y Apellidos Completos <span class="required">*</span></label>
                    <input type="text" id="apellidos_nombres" name="apellidos_nombres" value="<?= htmlspecialchars($paciente['apellidos_nombres'] ?? '') ?>" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="edad">Edad</label>
                    <input type="number" id="edad" name="edad" value="<?= htmlspecialchars($paciente['edad'] ?? '') ?>" class="form-control">
                </div>

                <div class="form-group">
                    <label for="genero">Género</label>
                    <select id="genero" name="genero" class="form-control">
                        <option value="Masculino" <?= ($paciente['genero'] ?? '') === 'Masculino' ? 'selected' : '' ?>>Masculino</option>
                        <option value="Femenino" <?= ($paciente['genero'] ?? '') === 'Femenino' ? 'selected' : '' ?>>Femenino</option>
                        <option value="Otro" <?= ($paciente['genero'] ?? '') === 'Otro' ? 'selected' : '' ?>>Otro</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="programa_estudios">Programa de Estudios</label>
                    <input type="text" id="programa_estudios" name="programa_estudios" value="<?= htmlspecialchars($paciente['programa_estudios'] ?? '') ?>" class="form-control">
                </div>

                <div class="form-group">
                    <label for="semestre">Semestre</label>
                    <input type="text" id="semestre" name="semestre" value="<?= htmlspecialchars($paciente['semestre'] ?? '') ?>" class="form-control">
                </div>

                <div class="form-group">
                    <label for="telefono">Teléfono / Celular</label>
                    <input type="tel" id="telefono" name="telefono" value="<?= htmlspecialchars($paciente['telefono'] ?? '') ?>" class="form-control">
                </div>

                <div class="form-group">
                    <label for="celular_emergencia">Celular de Emergencia</label>
                    <input type="tel" id="celular_emergencia" name="celular_emergencia" value="<?= htmlspecialchars($paciente['celular_emergencia'] ?? '') ?>" class="form-control">
                </div>
            </div>
        </div>

        <!-- SECCIÓN 2: HORARIO Y CONSTANTES VITALES (TRIAGE) -->
        <div class="form-section">
            <div class="section-title">
                <i class="fa-solid fa-heart-pulse"></i> 2. Signos y Constantes Vitales (Triaje)
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label for="fecha">Fecha de Atención</label>
                    <input type="date" id="fecha" name="fecha" value="<?= date('Y-m-d') ?>" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="hora_ingreso">Hora de Ingreso</label>
                    <input type="time" id="hora_ingreso" name="hora_ingreso" value="<?= date('H:i') ?>" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="hora_salida">Hora de Salida</label>
                    <input type="time" id="hora_salida" name="hora_salida" class="form-control">
                </div>

                <div class="form-group">
                    <label for="temperatura">Temperatura (°C)</label>
                    <input type="number" step="0.1" id="temperatura" name="temperatura" placeholder="Ej. 36.5" class="form-control">
                </div>

                <div class="form-group">
                    <label for="presion_arterial">Presión Arterial (mmHg)</label>
                    <input type="text" id="presion_arterial" name="presion_arterial" placeholder="Ej. 120/80" class="form-control">
                </div>

                <div class="form-group">
                    <label for="frecuencia_cardiaca">Frecuencia Cardíaca (lpm)</label>
                    <input type="number" id="frecuencia_cardiaca" name="frecuencia_cardiaca" placeholder="Ej. 72" class="form-control">
                </div>

                <div class="form-group">
                    <label for="peso">Peso (kg)</label>
                    <input type="number" step="0.1" id="peso" name="peso" placeholder="Ej. 65.5" class="form-control">
                </div>

                <div class="form-group">
                    <label for="talla">Talla (m o cm)</label>
                    <input type="number" step="0.01" id="talla" name="talla" placeholder="Ej. 1.68" class="form-control">
                </div>

                <div class="form-group">
                    <label for="imc">IMC Estimado</label>
                    <input type="text" id="imc" name="imc" readonly placeholder="Auto-calculado" class="form-control" style="background: #f1f5f9;">
                </div>
            </div>
        </div>

        <!-- SECCIÓN 3: DIAGNÓSTICO Y TRATAMIENTO -->
        <div class="form-section">
            <div class="section-title">
                <i class="fa-solid fa-clipboard-user"></i> 3. Consulta, Diagnóstico y Tratamiento
            </div>
            <div class="form-grid">
                <div class="form-group grid-col-3">
                    <label for="motivo_consulta">Motivo de Consulta / Diagnóstico Principal <span class="required">*</span></label>
                    <input type="text" id="motivo_consulta" name="motivo_consulta" required placeholder="Ej. Cefalea intensa, dolor abdominal, herida cortante..." class="form-control">
                </div>

                <div class="form-group grid-col-3">
                    <label for="signos_sintomas">Signos y Síntomas Presentados</label>
                    <textarea id="signos_sintomas" name="signos_sintomas" rows="2" placeholder="Detalle de sintomatología..." class="form-control"></textarea>
                </div>

                <div class="form-group grid-col-3">
                    <label for="tratamiento">Tratamiento Administrado / Indicaciones Médicas</label>
                    <textarea id="tratamiento" name="tratamiento" rows="2" placeholder="Medicamentos suministrados, dosis, curación realizada..." class="form-control"></textarea>
                </div>

                <div class="form-group">
                    <label for="tipo_descanso">Tipo de Descanso / Reposo</label>
                    <select id="tipo_descanso" name="tipo_descanso" class="form-control">
                        <option value="Sin reposo">Sin reposo</option>
                        <option value="Reposo en tópico">Reposo en tópico (horas)</option>
                        <option value="Descanso médico 24 hrs">Descanso médico 24 hrs</option>
                        <option value="Descanso médico 48 hrs">Descanso médico 48 hrs</option>
                    </select>
                </div>

                <div class="form-group grid-col-2">
                    <label for="hospital_derivacion">Centro de Derivación (si aplica)</label>
                    <input type="text" id="hospital_derivacion" name="hospital_derivacion" placeholder="Hospital de Apoyo Huanta, ESSALUD, etc." class="form-control">
                </div>

                <div class="form-group grid-col-3">
                    <label for="observacion">Observaciones Adicionales</label>
                    <input type="text" id="observacion" name="observacion" placeholder="Notas de evolución u observaciones..." class="form-control">
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="<?= BASE_URL ?>/atencion" class="btn btn-outline">Cancelar</a>
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk"></i> Guardar Atención Médica
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Cálculo reactivo de IMC en el formulario
    const pesoInput = document.getElementById('peso');
    const tallaInput = document.getElementById('talla');
    const imcInput = document.getElementById('imc');

    function calcularImc() {
        const peso = parseFloat(pesoInput.value);
        let talla = parseFloat(tallaInput.value);
        if (peso > 0 && talla > 0) {
            if (talla > 3) talla = talla / 100; // cm a m
            const imc = (peso / (talla * talla)).toFixed(2);
            imcInput.value = imc;
        }
    }

    pesoInput.addEventListener('input', calcularImc);
    tallaInput.addEventListener('input', calcularImc);

    // Búsqueda AJAX de paciente por DNI
    const btnBuscar = document.getElementById('btnBuscarDni');
    const dniInput = document.getElementById('dni');

    btnBuscar.addEventListener('click', async () => {
        const dni = dniInput.value.trim();
        if (dni.length !== 8) {
            alert('Por favor ingrese un DNI válido de 8 dígitos');
            return;
        }

        try {
            const res = await fetch(`<?= BASE_URL ?>/paciente/buscar?dni=${dni}`);
            const json = await res.json();
            if (json.status === 'success' && json.data) {
                const p = json.data;
                document.getElementById('apellidos_nombres').value = p.apellidos_nombres || '';
                document.getElementById('edad').value = p.edad || '';
                document.getElementById('genero').value = p.genero || 'Otro';
                document.getElementById('programa_estudios').value = p.programa_estudios || '';
                document.getElementById('semestre').value = p.semestre || '';
                document.getElementById('telefono').value = p.telefono || '';
                document.getElementById('celular_emergencia').value = p.celular_emergencia || '';
            } else {
                alert('Paciente no encontrado en la base de datos. Complete los campos para registrarlo.');
            }
        } catch (e) {
            console.error('Error buscando paciente:', e);
        }
    });
});
</script>
