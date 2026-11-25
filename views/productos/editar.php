<div class="form-wrapper">
    <div class="page-header">
        <div>
            <h1 class="page-title"><i class="fa-solid fa-pen-to-square"></i> Editar Producto: <?= htmlspecialchars($producto['nombre']) ?></h1>
            <p class="page-subtitle">Modifique el stock o datos del medicamento</p>
        </div>
        <div class="page-actions">
            <a href="<?= BASE_URL ?>/producto" class="btn btn-outline">
                <i class="fa-solid fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    <form method="POST" action="<?= BASE_URL ?>/producto/actualizar/<?= $producto['id'] ?>" class="medical-form">
        <div class="form-section">
            <div class="section-title">
                <i class="fa-solid fa-prescription-bottle"></i> Información del Fármaco
            </div>
            <div class="form-grid">
                <div class="form-group grid-col-2">
                    <label for="nombre">Nombre del Medicamento <span class="required">*</span></label>
                    <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="categoria">Categoría</label>
                    <input type="text" id="categoria" name="categoria" value="<?= htmlspecialchars($producto['categoria']) ?>" class="form-control">
                </div>

                <div class="form-group">
                    <label for="unidad">Presentación / Unidad</label>
                    <input type="text" id="unidad" name="unidad" value="<?= htmlspecialchars($producto['unidad']) ?>" class="form-control">
                </div>

                <div class="form-group">
                    <label for="cantidad">Cantidad Disponible en Stock <span class="required">*</span></label>
                    <input type="number" id="cantidad" name="cantidad" value="<?= $producto['cantidad'] ?>" min="0" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="stock_minimo">Stock Mínimo de Alerta</label>
                    <input type="number" id="stock_minimo" name="stock_minimo" value="<?= $producto['stock_minimo'] ?>" min="1" class="form-control">
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="<?= BASE_URL ?>/producto" class="btn btn-outline">Cancelar</a>
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk"></i> Actualizar Medicamento
            </button>
        </div>
    </form>
</div>
