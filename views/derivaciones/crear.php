<div class="form-wrapper">
    <div class="page-header">
        <div>
            <h1 class="page-title"><i class="fa-solid fa-truck-medical"></i> Emitir Derivación Médica</h1>
            <p class="page-subtitle">Referencia formal a centro hospitalario o de emergencias</p>
        </div>
        <div class="page-actions">
            <a href="<?= BASE_URL ?>/derivacion" class="btn btn-outline">
                <i class="fa-solid fa-arrow-left"></i> Volver a Derivaciones
            </a>
        </div>
    </div>

    <form method="POST" action="<?= BASE_URL ?>/derivacion/guardar" class="medical-form">
        <!-- CABECERA -->
        <div class="form-section">
            <div class="section-title">
                <i class="fa-solid fa-file-contract"></i> 1. Información General de la Referencia
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label>N° de Derivación Asignado</label>
                    <input type="text" readonly value="<?= htmlspecialchars($siguienteNro) ?>" class="form-control" style="background: #f1f5f9; font-weight: 700;">
                </div>

                <div class="form-group">
                    <label for="fecha_emision">Fecha de Emisión <span class="required">*</span></label>
                    <input type="date" id="fecha_emision" name="fecha_emision" value="<?= date('Y-m-d') ?>" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="hospital_destino">Centro / Hospital de Destino <span class="required">*</span></label>
                    <input type="text" id="hospital_destino" name="hospital_destino" required value="Hospital de Apoyo Huanta" class="form-control">
                </div>

                <div class="form-group">
                    <label for="tipo_atencion">Tipo de Atención</label>
                    <select id="tipo_atencion" name="tipo_atencion" class="form-control">
                        <option value="Emergencia">Emergencia / Código Rojo</option>
                        <option value="Urgencia" selected>Urgencia Médica</option>
                        <option value="Consulta Especializada">Consulta Especializada</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- PACIENTE -->
        <div class="form-section">
            <div class="section-title">
                <i class="fa-solid fa-user"></i> 2. Datos del Paciente Derivado
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label for="paciente_dni">DNI del Paciente <span class="required">*</span></label>
                    <input type="text" id="paciente_dni" name="paciente_dni" value="<?= htmlspecialchars($dni ?: ($paciente['dni'] ?? '')) ?>" required maxlength="8" class="form-control">
                </div>

                <div class="form-group grid-col-2">
                    <label for="paciente_nombre">Nombres y Apellidos Completos <span class="required">*</span></label>
                    <input type="text" id="paciente_nombre" name="paciente_nombre" value="<?= htmlspecialchars($paciente['apellidos_nombres'] ?? '') ?>" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="paciente_edad">Edad</label>
                    <input type="number" id="paciente_edad" name="paciente_edad" value="<?= htmlspecialchars($paciente['edad'] ?? '') ?>" class="form-control">
                </div>

                <div class="form-group">
                    <label for="paciente_sexo">Sexo</label>
                    <input type="text" id="paciente_sexo" name="paciente_sexo" value="<?= htmlspecialchars($paciente['genero'] ?? '') ?>" class="form-control">
                </div>

                <div class="form-group">
                    <label for="paciente_carrera">Programa de Estudios</label>
                    <input type="text" id="paciente_carrera" name="paciente_carrera" value="<?= htmlspecialchars($paciente['programa_estudios'] ?? '') ?>" class="form-control">
                </div>

                <div class="form-group">
                    <label for="ciclo">Ciclo / Semestre</label>
                    <input type="text" id="ciclo" name="ciclo" value="<?= htmlspecialchars($paciente['semestre'] ?? '') ?>" class="form-control">
                </div>

                <div class="form-group">
                    <label for="paciente_telefono">Teléfono Paciente</label>
                    <input type="tel" id="paciente_telefono" name="paciente_telefono" value="<?= htmlspecialchars($paciente['telefono'] ?? '') ?>" class="form-control">
                </div>
            </div>
        </div>

        <!-- MOTIVO Y CONSTANTES -->
        <div class="form-section">
            <div class="section-title">
                <i class="fa-solid fa-notes-medical"></i> 3. Diagnóstico Presuntivo y Motivo
            </div>
            <div class="form-grid">
                <div class="form-group grid-col-3">
                    <label for="motivo">Motivo Principal de Derivación <span class="required">*</span></label>
                    <textarea id="motivo" name="motivo" rows="2" required placeholder="Diagnóstico presuntivo y justificación de traslado..." class="form-control"></textarea>
                </div>

                <div class="form-group grid-col-3">
                    <label for="signos_sintomas">Signos, Síntomas y Tratamiento Inicial de Tópico</label>
                    <textarea id="signos_sintomas" name="signos_sintomas" rows="2" placeholder="Primeros auxilios o estabilización suministrada..." class="form-control"></textarea>
                </div>

                <div class="form-group">
                    <label for="presion_arterial">P. Arterial</label>
                    <input type="text" id="presion_arterial" name="presion_arterial" placeholder="120/80" class="form-control">
                </div>

                <div class="form-group">
                    <label for="temperatura">Temperatura (°C)</label>
                    <input type="number" step="0.1" id="temperatura" name="temperatura" placeholder="36.5" class="form-control">
                </div>

                <div class="form-group">
                    <label for="frecuencia_cardiaca">FC (lpm)</label>
                    <input type="number" id="frecuencia_cardiaca" name="frecuencia_cardiaca" placeholder="72" class="form-control">
                </div>
            </div>
        </div>

        <!-- APODERADO / FAMILIAR -->
        <div class="form-section">
            <div class="section-title">
                <i class="fa-solid fa-users"></i> 4. Datos del Apoderado o Acompañante
            </div>
            <div class="form-grid">
                <div class="form-group grid-col-2">
                    <label for="apoderado_nombre">Nombre del Apoderado / Contacto</label>
                    <input type="text" id="apoderado_nombre" name="apoderado_nombre" value="<?= htmlspecialchars($paciente['contacto_emergencia'] ?? '') ?>" class="form-control">
                </div>

                <div class="form-group">
                    <label for="apoderado_parentesco">Parentesco</label>
                    <input type="text" id="apoderado_parentesco" name="apoderado_parentesco" value="<?= htmlspecialchars($paciente['parentesco_emergencia'] ?? '') ?>" class="form-control">
                </div>

                <div class="form-group">
                    <label for="apoderado_celular">Celular del Apoderado</label>
                    <input type="tel" id="apoderado_celular" name="apoderado_celular" value="<?= htmlspecialchars($paciente['celular_emergencia'] ?? '') ?>" class="form-control">
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="<?= BASE_URL ?>/derivacion" class="btn btn-outline">Cancelar</a>
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-print"></i> Guardar y Generar Hoja de Derivación
            </button>
        </div>
    </form>
</div>
