<div class="form-wrapper">
    <div class="page-header">
        <div>
            <h1 class="page-title"><i class="fa-solid fa-plus-circle"></i> Registrar Equipo Médico</h1>
            <p class="page-subtitle">Añada un equipo o instrumental médico al inventario del tópico</p>
        </div>
        <div class="page-actions">
            <a href="<?= BASE_URL ?>/equipo" class="btn btn-outline">
                <i class="fa-solid fa-arrow-left"></i> Volver a Equipos
            </a>
        </div>
    </div>

    <form method="POST" action="<?= BASE_URL ?>/equipo/guardar" class="medical-form">
        <div class="form-section">
            <div class="section-title">
                <i class="fa-solid fa-microscope"></i> Ficha del Equipo
            </div>
            <div class="form-grid">
                <div class="form-group grid-col-2">
                    <label for="nombre">Nombre del Equipo / Instrumento <span class="required">*</span></label>
                    <input type="text" id="nombre" name="nombre" required placeholder="Ej. Tensiómetro Digital de Brazo" class="form-control">
                </div>

                <div class="form-group">
                    <label for="categoria">Categoría</label>
                    <select id="categoria" name="categoria" class="form-control">
                        <option value="Diagnóstico">Diagnóstico</option>
                        <option value="Monitoreo">Monitoreo</option>
                        <option value="Emergencia">Emergencia / Triaje</option>
                        <option value="Cirugía Menor">Curaciones y Cirugía Menor</option>
                        <option value="Mobiliario">Mobiliario Clínico</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="serie">N° de Serie / Código Patrimonial</label>
                    <input type="text" id="serie" name="serie" placeholder="Ej. PAT-2026-0042" class="form-control">
                </div>

                <div class="form-group">
                    <label for="cantidad">Cantidad</label>
                    <input type="number" id="cantidad" name="cantidad" value="1" min="1" class="form-control">
                </div>

                <div class="form-group">
                    <label for="estado">Estado Operativo</label>
                    <select id="estado" name="estado" class="form-control">
                        <option value="Operativo" selected>Operativo</option>
                        <option value="Mantenimiento">En Mantenimiento</option>
                        <option value="Inoperativo">Inoperativo</option>
                    </select>
                </div>

                <div class="form-group grid-col-3">
                    <label for="observacion">Observaciones / Especificaciones Técnicas</label>
                    <textarea id="observacion" name="observacion" rows="3" placeholder="Marca, modelo, última calibración, etc." class="form-control"></textarea>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="<?= BASE_URL ?>/equipo" class="btn btn-outline">Cancelar</a>
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk"></i> Guardar Equipo
            </button>
        </div>
    </form>
</div>
