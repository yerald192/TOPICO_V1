<div class="form-wrapper" style="max-width: 1000px;">
    <div class="page-header">
        <div>
            <h1 class="page-title"><i class="fa-solid fa-clipboard-list"></i> Nueva Toma Física de Inventario</h1>
            <p class="page-subtitle">Verifique el stock físico de cada fármaco contra el stock registrado en el sistema</p>
        </div>
        <div class="page-actions">
            <a href="<?= BASE_URL ?>/inventario" class="btn btn-outline">
                <i class="fa-solid fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    <form method="POST" action="<?= BASE_URL ?>/inventario/guardar" class="medical-form">
        <!-- DATOS DE CABECERA -->
        <div class="form-section">
            <div class="section-title">
                <i class="fa-solid fa-info-circle"></i> Datos de la Auditoría
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label>N° de Inventario</label>
                    <input type="text" readonly value="<?= htmlspecialchars($siguienteNro) ?>" class="form-control" style="background: #f1f5f9; font-weight: 700;">
                </div>

                <div class="form-group">
                    <label for="fecha">Fecha de Conteo <span class="required">*</span></label>
                    <input type="date" id="fecha" name="fecha" value="<?= date('Y-m-d') ?>" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="responsable">Responsable del Conteo</label>
                    <input type="text" id="responsable" name="responsable" value="<?= htmlspecialchars($_SESSION['usuario_nombre'] ?? 'Personal de Tópico') ?>" required class="form-control">
                </div>

                <div class="form-group grid-col-3">
                    <label for="observaciones">Observaciones Generales</label>
                    <input type="text" id="observaciones" name="observaciones" placeholder="Ej. Inventario mensual, cierre de semestre..." class="form-control">
                </div>
            </div>
        </div>

        <!-- LISTADO DE CONTEO FÍSICO -->
        <div class="content-card" style="margin-bottom: 24px;">
            <div class="card-header">
                <h2><i class="fa-solid fa-pills"></i> Conteo Físico por Medicamento</h2>
            </div>
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Categoría / Presentación</th>
                            <th class="text-center">Stock en Sistema</th>
                            <th class="text-center" style="width: 140px;">Conteo Físico</th>
                            <th class="text-center">Diferencia</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($productos)): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted" style="padding: 30px;">
                                    No hay medicamentos registrados en el sistema para inventariar.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($productos as $idx => $p): ?>
                                <tr>
                                    <td>
                                        <strong><?= htmlspecialchars($p['nombre']) ?></strong>
                                        <input type="hidden" name="items[<?= $idx ?>][producto_id]" value="<?= $p['id'] ?>">
                                        <input type="hidden" name="items[<?= $idx ?>][nombre]" value="<?= htmlspecialchars($p['nombre']) ?>">
                                    </td>
                                    <td><?= htmlspecialchars($p['categoria']) ?> (<?= htmlspecialchars($p['unidad']) ?>)</td>
                                    <td class="text-center">
                                        <span class="stock-sistema-val" data-idx="<?= $idx ?>"><?= $p['cantidad'] ?></span>
                                        <input type="hidden" name="items[<?= $idx ?>][stock_sistema]" value="<?= $p['cantidad'] ?>">
                                    </td>
                                    <td class="text-center">
                                        <input type="number" min="0" name="items[<?= $idx ?>][conteo_fisico]" value="<?= $p['cantidad'] ?>" class="form-control input-conteo text-center" data-idx="<?= $idx ?>" style="font-weight: 700;">
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-dif-<?= $idx ?> badge-light">0</span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="form-actions">
            <a href="<?= BASE_URL ?>/inventario" class="btn btn-outline">Cancelar</a>
            <button type="submit" class="btn btn-primary" onclick="return confirm('¿Está seguro de procesar el inventario? El stock de los productos se actualizará automáticamente con el conteo físico.');">
                <i class="fa-solid fa-check-double"></i> Finalizar y Conciliar Inventario
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Cálculo reactivo de diferencias en el conteo físico
    const inputs = document.querySelectorAll('.input-conteo');
    inputs.forEach(input => {
        input.addEventListener('input', () => {
            const idx = input.getAttribute('data-idx');
            const stockSis = parseInt(document.querySelector(`.stock-sistema-val[data-idx="${idx}"]`).textContent) || 0;
            const conteo = parseInt(input.value) || 0;
            const dif = conteo - stockSis;

            const badge = document.querySelector(`.badge-dif-${idx}`);
            badge.textContent = (dif > 0 ? '+' : '') + dif;
            if (dif === 0) {
                badge.style.background = '#e2e8f0';
                badge.style.color = '#475569';
            } else if (dif < 0) {
                badge.style.background = '#fee2e2';
                badge.style.color = '#991b1b';
            } else {
                badge.style.background = '#d1fae5';
                badge.style.color = '#065f46';
            }
        });
    });
});
</script>
