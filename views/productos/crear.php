<div class="form-wrapper">
    <div class="page-header">
        <div>
            <h1 class="page-title"><i class="fa-solid fa-plus-circle"></i> Registrar Medicamento / Insumo</h1>
            <p class="page-subtitle">Añada un nuevo producto farmacéutico al inventario</p>
        </div>
        <div class="page-actions">
            <a href="<?= BASE_URL ?>/producto" class="btn btn-outline">
                <i class="fa-solid fa-arrow-left"></i> Volver a Productos
            </a>
        </div>
    </div>

    <form method="POST" action="<?= BASE_URL ?>/producto/guardar" class="medical-form">
        <div class="form-section">
            <div class="section-title">
                <i class="fa-solid fa-prescription-bottle"></i> Información del Fármaco
            </div>
            <div class="form-grid">
                <div class="form-group grid-col-2">
                    <label for="nombre">Nombre Comercial / Genérico <span class="required">*</span></label>
                    <input type="text" id="nombre" name="nombre" required placeholder="Ej. Paracetamol 500mg, Amoxicilina..." class="form-control">
                </div>

                <div class="form-group">
                    <label for="categoria">Categoría</label>
                    <select id="categoria" name="categoria" class="form-control">
                        <option value="Medicamento" selected>Medicamento</option>
                        <option value="Analgésico / Antipirético">Analgésico / Antipirético</option>
                        <option value="Antibiótico">Antibiótico</option>
                        <option value="Antiinflamatorio">Antiinflamatorio</option>
                        <option value="Material Médico">Material Médico / Insumo</option>
                        <option value="Desinfectante">Desinfectante y Antiséptico</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="unidad">Presentación / Unidad</label>
                    <input type="text" id="unidad" name="unidad" value="Tableta" placeholder="Tableta, Frasco, Ampolla, Caja..." class="form-control">
                </div>

                <div class="form-group">
                    <label for="cantidad">Stock Inicial Disponible <span class="required">*</span></label>
                    <input type="number" id="cantidad" name="cantidad" value="0" min="0" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="stock_minimo">Stock Mínimo de Alerta</label>
                    <input type="number" id="stock_minimo" name="stock_minimo" value="10" min="1" class="form-control">
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="<?= BASE_URL ?>/producto" class="btn btn-outline">Cancelar</a>
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk"></i> Guardar Medicamento
            </button>
        </div>
    </form>
</div>
