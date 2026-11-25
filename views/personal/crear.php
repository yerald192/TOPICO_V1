<div class="form-wrapper">
    <div class="page-header">
        <div>
            <h1 class="page-title"><i class="fa-solid fa-user-plus"></i> Registrar Personal</h1>
            <p class="page-subtitle">Cree una cuenta para el personal médico o administrativo</p>
        </div>
        <div class="page-actions">
            <a href="<?= BASE_URL ?>/personal" class="btn btn-outline">
                <i class="fa-solid fa-arrow-left"></i> Volver a Personal
            </a>
        </div>
    </div>

    <form method="POST" action="<?= BASE_URL ?>/personal/guardar" class="medical-form">
        <div class="form-section">
            <div class="section-title">
                <i class="fa-solid fa-id-badge"></i> Credenciales y Datos Personales
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label for="dni">DNI / Documento <span class="required">*</span></label>
                    <input type="text" id="dni" name="dni" required maxlength="8" pattern="\d{8}" placeholder="8 dígitos" class="form-control">
                </div>

                <div class="form-group grid-col-2">
                    <label for="apellido_nombre">Apellidos y Nombres Completos <span class="required">*</span></label>
                    <input type="text" id="apellido_nombre" name="apellido_nombre" required placeholder="Ej. Lic. María López" class="form-control">
                </div>

                <div class="form-group grid-col-2">
                    <label for="especialidad">Especialidad / Cargo</label>
                    <input type="text" id="especialidad" name="especialidad" value="Enfermería / Tópico" class="form-control">
                </div>

                <div class="form-group">
                    <label for="rol">Rol de Acceso</label>
                    <select id="rol" name="rol" class="form-control">
                        <option value="personal" selected>Personal de Tópico</option>
                        <option value="admin">Administrador General</option>
                    </select>
                </div>

                <div class="form-group grid-col-2">
                    <label for="password">Contraseña Inicial <span class="required">*</span></label>
                    <input type="password" id="password" name="password" required placeholder="Contraseña de acceso seguro" class="form-control">
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="<?= BASE_URL ?>/personal" class="btn btn-outline">Cancelar</a>
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk"></i> Registrar Usuario
            </button>
        </div>
    </form>
</div>
