<div class="form-wrapper">
    <div class="page-header">
        <div>
            <h1 class="page-title"><i class="fa-solid fa-pen-to-square"></i> Editar Equipo: <?= htmlspecialchars($equipo['nombre']) ?></h1>
            <p class="page-subtitle">Modifique el estado o detalles técnicos del equipo</p>
        </div>
        <div class="page-actions">
            <a href="<?= BASE_URL ?>/equipo" class="btn btn-outline">
                <i class="fa-solid fa-arrow-left"></i> Volver a Equipos
            </a>
        </div>
    </div>

    <form method="POST" action="<?= BASE_URL ?>/equipo/actualizar/<?= $equipo['id'] ?>" class="medical-form">
        <div class="form-section">
            <div class="section-title">
                <i class="fa-solid fa-microscope"></i> Ficha del Equipo
            </div>
            <div class="form-grid">
                <div class="form-group grid-col-2">
                    <label for="nombre">Nombre del Equipo <span class="required">*</span></label>
                    <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($equipo['nombre']) ?>" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="categoria">Categoría</label>
                    <input type="text" id="categoria" name="categoria" value="<?= htmlspecialchars($equipo['categoria']) ?>" class="form-control">
                </div>

                <div class="form-group">
                    <label for="serie">N° de Serie / Código</label>
                    <input type="text" id="serie" name="serie" value="<?= htmlspecialchars($equipo['serie'] ?? '') ?>" class="form-control">
                </div>

                <div class="form-group">
                    <label for="cantidad">Cantidad</label>
                    <input type="number" id="cantidad" name="cantidad" value="<?= $equipo['cantidad'] ?>" min="1" class="form-control">
                </div>

                <div class="form-group">
                    <label for="estado">Estado Operativo</label>
                    <select id="estado" name="estado" class="form-control">
                        <option value="Operativo" <?= $equipo['estado'] === 'Operativo' ? 'selected' : '' ?>>Operativo</option>
                        <option value="Mantenimiento" <?= $equipo['estado'] === 'Mantenimiento' ? 'selected' : '' ?>>En Mantenimiento</option>
                        <option value="Inoperativo" <?= $equipo['estado'] === 'Inoperativo' ? 'selected' : '' ?>>Inoperativo</option>
                    </select>
                </div>

                <div class="form-group grid-col-3">
                    <label for="observacion">Observaciones</label>
                    <textarea id="observacion" name="observacion" rows="3" class="form-control"><?= htmlspecialchars($equipo['observacion'] ?? '') ?></textarea>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <a href="<?= BASE_URL ?>/equipo" class="btn btn-outline">Cancelar</a>
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk"></i> Actualizar Equipo
            </button>
        </div>
    </form>
</div>
