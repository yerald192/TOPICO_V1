<?php
// ==========================================================
// MODELO: Producto (Farmacia, Medicamentos e Insumos)
// ==========================================================

class Producto extends Model {
    public function listar(string $busqueda = '', bool $soloStockBajo = false): array {
        $sql = "SELECT * FROM stock_productos WHERE estado = 'activo'";
        $params = [];

        if (!empty($busqueda)) {
            $sql .= " AND (nombre LIKE ? OR categoria LIKE ?)";
            $t = "%{$busqueda}%";
            $params[] = $t;
            $params[] = $t;
        }

        if ($soloStockBajo) {
            $sql .= " AND cantidad <= stock_minimo";
        }

        $sql .= " ORDER BY nombre ASC";
        return $this->selectAll($sql, $params);
    }

    public function obtenerPorId(int $id): ?array {
        return $this->selectOne("SELECT * FROM stock_productos WHERE id = ? AND estado = 'activo' LIMIT 1", [$id]);
    }

    public function registrar(array $d): int {
        $sql = "INSERT INTO stock_productos (
            nombre, categoria, unidad, cantidad, stock_minimo, creado_por, estado
        ) VALUES (?, ?, ?, ?, ?, ?, 'activo')";

        $this->query($sql, [
            $d['nombre'],
            $d['categoria'] ?? 'Medicamento',
            $d['unidad'] ?? 'Tableta / Unidad',
            (int)($d['cantidad'] ?? 0),
            (int)($d['stock_minimo'] ?? 5),
            $d['creado_por'] ?? 'Sistema'
        ]);

        return $this->lastInsertId();
    }

    public function actualizar(int $id, array $d): bool {
        $sql = "UPDATE stock_productos SET 
            nombre = ?, categoria = ?, unidad = ?, cantidad = ?, stock_minimo = ?
            WHERE id = ? AND estado = 'activo'";

        $stmt = $this->query($sql, [
            $d['nombre'],
            $d['categoria'] ?? 'Medicamento',
            $d['unidad'] ?? 'Tableta / Unidad',
            (int)($d['cantidad'] ?? 0),
            (int)($d['stock_minimo'] ?? 5),
            $id
        ]);

        return $stmt->rowCount() > 0;
    }

    public function actualizarStock(int $id, int $nuevoStock): bool {
        $stmt = $this->query("UPDATE stock_productos SET cantidad = ? WHERE id = ? AND estado = 'activo'", [$nuevoStock, $id]);
        return $stmt->rowCount() > 0;
    }

    public function eliminar(int $id, string $usuario = 'Sistema'): bool {
        $stmt = $this->query(
            "UPDATE stock_productos SET estado = 'eliminado', fecha_eliminacion = CURRENT_TIMESTAMP, eliminado_por = ? WHERE id = ?",
            [$usuario, $id]
        );
        return $stmt->rowCount() > 0;
    }

    public function contarBajoStock(): int {
        $res = $this->selectOne("SELECT COUNT(*) as total FROM stock_productos WHERE estado = 'activo' AND cantidad <= stock_minimo");
        return (int)($res['total'] ?? 0);
    }
}
