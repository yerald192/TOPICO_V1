<?php
// ==========================================================
// MODELO: Inventario (Toma Física y Auditoría de Stock)
// ==========================================================

class Inventario extends Model {
    public function listar(): array {
        return $this->selectAll(
            "SELECT * FROM inventariados WHERE estado = 'activo' ORDER BY fecha DESC, id DESC"
        );
    }

    public function obtenerPorId(int $id): ?array {
        return $this->selectOne("SELECT * FROM inventariados WHERE id = ? AND estado = 'activo' LIMIT 1", [$id]);
    }

    public function obtenerItems(int $inventarioId): array {
        return $this->selectAll(
            "SELECT * FROM inventariado_items WHERE inventario_id = ? ORDER BY nombre ASC",
            [$inventarioId]
        );
    }

    public function generarSiguienteNumero(): string {
        $ano = date('Y');
        $ultimo = $this->selectOne(
            "SELECT nro_inventario FROM inventariados WHERE nro_inventario LIKE ? ORDER BY id DESC LIMIT 1",
            ["INV-{$ano}-%"]
        );

        if ($ultimo) {
            $partes = explode('-', $ultimo['nro_inventario']);
            $correlativo = isset($partes[2]) ? (int)$partes[2] + 1 : 1;
        } else {
            $correlativo = 1;
        }

        return sprintf("INV-%s-%04d", $ano, $correlativo);
    }

    public function registrar(array $cabecera, array $items): int {
        $nro = $this->generarSiguienteNumero();

        $this->db->beginTransaction();

        try {
            // 1. Guardar Cabecera de Inventario
            $sqlHead = "INSERT INTO inventariados (nro_inventario, fecha, responsable, observaciones, creado_por, estado)
                        VALUES (?, ?, ?, ?, ?, 'activo')";
            $this->query($sqlHead, [
                $nro,
                $cabecera['fecha'] ?? date('Y-m-d'),
                $cabecera['responsable'] ?? 'Responsable de Tópico',
                $cabecera['observaciones'] ?? '',
                $cabecera['creado_por'] ?? 'Sistema'
            ]);

            $invId = $this->lastInsertId();

            // 2. Guardar Items y actualizar stock en stock_productos
            $sqlItem = "INSERT INTO inventariado_items (inventario_id, producto_id, nombre, stock_sistema, conteo_fisico, diferencia)
                        VALUES (?, ?, ?, ?, ?, ?)";
            
            $sqlUpd = "UPDATE stock_productos SET cantidad = ? WHERE id = ?";

            foreach ($items as $item) {
                $pId = (int)$item['producto_id'];
                $nom = $item['nombre'];
                $stockSis = (int)$item['stock_sistema'];
                $conteoFis = (int)$item['conteo_fisico'];
                $dif = $conteoFis - $stockSis;

                $this->query($sqlItem, [$invId, $pId, $nom, $stockSis, $conteoFis, $dif]);

                // Actualizar el stock al conteo físico verificado
                $this->query($sqlUpd, [$conteoFis, $pId]);
            }

            $this->db->commit();
            return $invId;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
}
