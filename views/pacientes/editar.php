<div class="form-wrapper">
    <div class="page-header">
        <div>
            <h1 class="page-title"><i class="fa-solid fa-user-pen"></i> Editar Paciente: <?= htmlspecialchars($paciente['apellidos_nombres']) ?></h1>
            <p class="page-subtitle">Actualice los datos del paciente en el registro local</p>
        </div>
        <div class="page-actions">
            <a href="<?= BASE_URL ?>/paciente" class="btn btn-outline">
                <i class="fa-solid fa-arrow-left"></i> Volver al Listado
            </a>
        </div>
    </div>

    <form method="POST" action="<?= BASE_URL ?>/paciente/actualizar/<?= $paciente['id'] ?>" class="medical-form">
        <!-- SECCIÓN 1: DATOS PERSONALES -->
        <div class="form-section">
            <div class="section-title">
                <i class="fa-solid fa-id-card"></i> 1. Información Personal
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label for="dni">DNI / Documento <span class="required">*</span></label>
                    <input type="text" id="dni" name="dni" value="<?= htmlspecialchars($paciente['dni']) ?>" required maxlength="8" pattern="\d{8}" class="form-control">
                </div>

                <div class="form-group grid-col-2">
                    <label for="apellidos_nombres">Nombres y Apellidos Completos <span class="required">*</span></label>
                    <input type="text" id="apellidos_nombres" name="apellidos_nombres" value="<?= htmlspecialchars($paciente['apellidos_nombres']) ?>" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?= htmlspecialchars($paciente['fecha_nacimiento'] ?? '') ?>" class="form-control">
                </div>

                <div class="form-group">
                    <label for="edad">Edad</label>
                    <input type="number" id="edad" name="edad" min="0" max="120" value="<?= htmlspecialchars($paciente['edad'] ?? '') ?>" class="form-control">
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
                    <label for="tipo_paciente">Tipo de Paciente</label>
                    <select id="tipo_paciente" name="tipo_paciente" class="form-control">
                        <option value="Estudiante" <?= ($paciente['tipo_paciente'] ?? '') === 'Estudiante' ? 'selected' : '' ?>>Estudiante</option>
                        <option value="Docente" <?= ($paciente['tipo_paciente'] ?? '') === 'Docente' ? 'selected' : '' ?>>Docente</option>
                        <option value="Administrativo" <?= ($paciente['tipo_paciente'] ?? '') === 'Administrativo' ? 'selected' : '' ?>>Personal Administrativo</option>
                        <option value="Externo" <?= ($paciente['tipo_paciente'] ?? '') === 'Externo' ? 'selected' : '' ?>>Externo / Visitante</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="telefono">Teléfono / Celular</label>
                    <input type="tel" id="telefono" name="telefono" value="<?= htmlspecialchars($paciente['telefono'] ?? '') ?>" class="form-control">
                </div>

                <div class="form-group grid-col-2">
                    <label for="direccion">Dirección Domiciliaria</label>
                    <input type="text" id="direccion" name="direccion" value="<?= htmlspecialchars($paciente['direccion'] ?? '') ?>" class="form-control">
                </div>
            </div>
        </div>

        <!-- SECCIÓN 2: INFORMACIÓN ACADÉMICA -->
        <div class="form-section">
            <div class="section-title">
                <i class="fa-solid fa-graduation-cap"></i> 2. Programa de Estudios
            </div>
            <div class="form-grid">
                <div class="form-group grid-col-2">
                    <label for="programa_estudios">Programa de Estudios / Carrera</label>
                    <input type="text" id="programa_estudios" name="programa_estudios" value="<?= htmlspecialchars($paciente['programa_estudios'] ?? '') ?>" class="form-control">
                </div>

                <div class="form-group">
                    <label for="semestre">Semestre / Ciclo</label>
                    <input type="text" id="semestre" name="semestre" value="<?= htmlspecialchars($paciente['semestre'] ?? '') ?>" class="form-control">
                </div>
            </div>
        </div>

        <!-- SECCIÓN 3: CONTACTO DE EMERGENCIA -->
        <div class="form-section">
            <div class="section-title">
                <i class="fa-solid fa-phone-volume"></i> 3. Contacto de Emergencia
            </div>
            <div class="form-grid">
                <div class="form-group grid-col-2">
                    <label for="contacto_emergencia">Nombre de Contacto</label>
                    <input type="text" id="contacto_emergencia" name="contacto_emergencia" value="<?= htmlspecialchars($paciente['contacto_emergencia'] ?? '') ?>" class="form-control">
                </div>

                <div class="form-group">
                    <label for="parentesco_emergencia">Parentesco</label>
                    <input type="text" id="parentesco_emergencia" name="parentesco_emergencia" value="<?= htmlspecialchars($paciente['parentesco_emergencia'] ?? '') ?>" class="form-control">
                </div>

                <div class="form-group">
                    <label for="celular_emergencia">Celular de Emergencia</label>
                    <input type="tel" id="celular_emergencia" name="celular_emergencia" value="<?= htmlspecialchars($paciente['celular_emergencia'] ?? '') ?>" class="form-control">
                </div>
            </div>
        </div>

        <!-- SECCIÓN 4: ANTECEDENTES Y SALUD -->
        <div class="form-section">
            <div class="section-title">
                <i class="fa-solid fa-heart-pulse"></i> 4. Antecedentes Médicos
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label for="tipo_sangre">Tipo de Sangre</label>
                    <select id="tipo_sangre" name="tipo_sangre" class="form-control">
                        <option value="">Seleccione...</option>
                        <?php 
                        $tipos = ['O+', 'O-', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-'];
                        foreach ($tipos as $t): 
                        ?>
                            <option value="<?= $t ?>" <?= ($paciente['tipo_sangre'] ?? '') === $t ? 'selected' : '' ?>><?= $t ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="seguro">Tipo de Seguro</label>
                    <input type="text" id="seguro" name="seguro" value="<?= htmlspecialchars($paciente['seguro'] ?? '') ?>" class="form-control">
                </div>

                <div class="form-group grid-col-2">
                    <label for="alergias">Alergias Conocidas</label>
                    <input type="text" id="alergias" name="alergias" value="<?= htmlspecialchars($paciente['alergias'] ?? '') ?>" class="form-control">
                </div>

                <div class="form-group grid-col-2">
                    <label for="enfermedades">Enfermedades Crónicas / Diagnósticos</label>
                    <input type="text" id="enfermedades" name="enfermedades" value="<?= htmlspecialchars($paciente['enfermedades'] ?? '') ?>" class="form-control">
                </div>

                <div class="form-group grid-col-2">
                    <label for="medicamentos_actuales">Medicamentos Actuales</label>
                    <input type="text" id="medicamentos_actuales" name="medicamentos_actuales" value="<?= htmlspecialchars($paciente['medicamentos_actuales'] ?? '') ?>" class="form-control">
                </div>

                <div class="form-group grid-col-3">
                    <label for="observaciones_salud">Observaciones Generales de Salud</label>
                    <textarea id="observaciones_salud" name="observaciones_salud" rows="3" class="form-control"><?= htmlspecialchars($paciente['observaciones_salud'] ?? '') ?></textarea>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="<?= BASE_URL ?>/paciente" class="btn btn-outline">Cancelar</a>
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk"></i> Actualizar Paciente
            </button>
        </div>
    </form>
</div>
