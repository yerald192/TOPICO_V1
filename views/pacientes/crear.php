<div class="form-wrapper">
    <div class="page-header">
        <div>
            <h1 class="page-title"><i class="fa-solid fa-user-plus"></i> Registrar Nuevo Paciente</h1>
            <p class="page-subtitle">Complete el formulario para incorporar al paciente en la base local</p>
        </div>
        <div class="page-actions">
            <a href="<?= BASE_URL ?>/paciente" class="btn btn-outline">
                <i class="fa-solid fa-arrow-left"></i> Volver al Listado
            </a>
        </div>
    </div>

    <form method="POST" action="<?= BASE_URL ?>/paciente/guardar" class="medical-form">
        <!-- SECCIÓN 1: DATOS PERSONALES -->
        <div class="form-section">
            <div class="section-title">
                <i class="fa-solid fa-id-card"></i> 1. Información Personal
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label for="dni">DNI / Documento <span class="required">*</span></label>
                    <input type="text" id="dni" name="dni" required maxlength="8" pattern="\d{8}" placeholder="8 dígitos" class="form-control">
                </div>

                <div class="form-group grid-col-2">
                    <label for="apellidos_nombres">Nombres y Apellidos Completos <span class="required">*</span></label>
                    <input type="text" id="apellidos_nombres" name="apellidos_nombres" required placeholder="Ej. Juan Pérez Quispe" class="form-control">
                </div>

                <div class="form-group">
                    <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control">
                </div>

                <div class="form-group">
                    <label for="edad">Edad</label>
                    <input type="number" id="edad" name="edad" min="0" max="120" placeholder="Años" class="form-control">
                </div>

                <div class="form-group">
                    <label for="genero">Género</label>
                    <select id="genero" name="genero" class="form-control">
                        <option value="Masculino">Masculino</option>
                        <option value="Femenino">Femenino</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="tipo_paciente">Tipo de Paciente</label>
                    <select id="tipo_paciente" name="tipo_paciente" class="form-control">
                        <option value="Estudiante">Estudiante</option>
                        <option value="Docente">Docente</option>
                        <option value="Administrativo">Personal Administrativo</option>
                        <option value="Externo">Externo / Visitante</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="telefono">Teléfono / Celular</label>
                    <input type="tel" id="telefono" name="telefono" placeholder="Ej. 987654321" class="form-control">
                </div>

                <div class="form-group grid-col-2">
                    <label for="direccion">Dirección Domiciliaria</label>
                    <input type="text" id="direccion" name="direccion" placeholder="Av. / Jr. / Calle y N°" class="form-control">
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
                    <input type="text" id="programa_estudios" name="programa_estudios" placeholder="Ej. Educación Inicial, Primaria, etc." class="form-control">
                </div>

                <div class="form-group">
                    <label for="semestre">Semestre / Ciclo</label>
                    <input type="text" id="semestre" name="semestre" placeholder="Ej. I, II, III..." class="form-control">
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
                    <input type="text" id="contacto_emergencia" name="contacto_emergencia" placeholder="Familiar o apoderado" class="form-control">
                </div>

                <div class="form-group">
                    <label for="parentesco_emergencia">Parentesco</label>
                    <input type="text" id="parentesco_emergencia" name="parentesco_emergencia" placeholder="Padre, Madre, Hermano..." class="form-control">
                </div>

                <div class="form-group">
                    <label for="celular_emergencia">Celular de Emergencia</label>
                    <input type="tel" id="celular_emergencia" name="celular_emergencia" placeholder="Número de emergencia" class="form-control">
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
                        <option value="O+">O Positivo (O+)</option>
                        <option value="O-">O Negativo (O-)</option>
                        <option value="A+">A Positivo (A+)</option>
                        <option value="A-">A Negativo (A-)</option>
                        <option value="B+">B Positivo (B+)</option>
                        <option value="B-">B Negativo (B-)</option>
                        <option value="AB+">AB Positivo (AB+)</option>
                        <option value="AB-">AB Negativo (AB-)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="seguro">Tipo de Seguro</label>
                    <input type="text" id="seguro" name="seguro" placeholder="SIS, EsSalud, Privado..." class="form-control">
                </div>

                <div class="form-group grid-col-2">
                    <label for="alergias">Alergias Conocidas</label>
                    <input type="text" id="alergias" name="alergias" placeholder="Penicilina, polen, etc." class="form-control">
                </div>

                <div class="form-group grid-col-2">
                    <label for="enfermedades">Enfermedades Crónicas / Diagnósticos</label>
                    <input type="text" id="enfermedades" name="enfermedades" placeholder="Asma, diabetes, hipertensión..." class="form-control">
                </div>

                <div class="form-group grid-col-2">
                    <label for="medicamentos_actuales">Medicamentos Actuales</label>
                    <input type="text" id="medicamentos_actuales" name="medicamentos_actuales" placeholder="Fármacos de consumo habitual" class="form-control">
                </div>

                <div class="form-group grid-col-3">
                    <label for="observaciones_salud">Observaciones Generales de Salud</label>
                    <textarea id="observaciones_salud" name="observaciones_salud" rows="3" placeholder="Comentarios adicionales sobre el estado del paciente..." class="form-control"></textarea>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="<?= BASE_URL ?>/paciente" class="btn btn-outline">Cancelar</a>
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk"></i> Guardar Paciente en Base Integrada
            </button>
        </div>
    </form>
</div>
