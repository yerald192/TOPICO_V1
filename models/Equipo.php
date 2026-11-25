<?php
// ==========================================================
// MODELO: Equipo (Equipos Médicos e Instrumental)
// ==========================================================

class Equipo extends Model {
    public function listar(string $busqueda = '', string $estado = ''): array {
        $sql = "SELECT * FROM equipos_registrados WHERE estado_registro = 'activo'";
        $params = [];

        if (!empty($busqueda)) {
            $sql .= " AND (nombre LIKE ? OR serie LIKE ? OR categoria LIKE ?)";
            $t = "%{$busqueda}%";
            $params[] = $t;
            $params[] = $t;
            $params[] = $t;
        }

        if (!empty($estado)) {
            $sql .= " AND estado = ?";
            $params[] = $estado;
        }

        $sql .= " ORDER BY nombre ASC";
        return $this->selectAll($sql, $params);
    }

    public function obtenerPorId(int $id): ?array {
        return $this->selectOne("SELECT * FROM equipos_registrados WHERE id = ? AND estado_registro = 'activo' LIMIT 1", [$id]);
    }

    public function registrar(array $d): int {
        $sql = "INSERT INTO equipos_registrados (
            nombre, equipo, categoria, serie, estado, cantidad, observacion, creado_por, estado_registro
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'activo')";

        $this->query($sql, [
            $d['nombre'],
            $d['equipo'] ?? $d['nombre'],
            $d['categoria'] ?? 'General',
            $d['serie'] ?? '',
            $d['estado'] ?? 'Operativo',
            (int)($d['cantidad'] ?? 1),
            $d['observacion'] ?? '',
            $d['creado_por'] ?? 'Sistema'
        ]);

        return $this->lastInsertId();
    }

    public function actualizar(int $id, array $d): bool {
        $sql = "UPDATE equipos_registrados SET 
            nombre = ?, equipo = ?, categoria = ?, serie = ?, estado = ?, cantidad = ?, observacion = ?
            WHERE id = ? AND estado_registro = 'activo'";

        $stmt = $this->query($sql, [
            $d['nombre'],
            $d['equipo'] ?? $d['nombre'],
            $d['categoria'] ?? 'General',
            $d['serie'] ?? '',
            $d['estado'] ?? 'Operativo',
            (int)($d['cantidad'] ?? 1),
            $d['observacion'] ?? '',
            $id
        ]);

        return $stmt->rowCount() > 0;
    }

    public function eliminar(int $id, string $usuario = 'Sistema'): bool {
        $stmt = $this->query(
            "UPDATE equipos_registrados SET estado_registro = 'eliminado', fecha_eliminacion = CURRENT_TIMESTAMP, eliminado_por = ? WHERE id = ?",
            [$usuario, $id]
        );
        return $stmt->rowCount() > 0;
    }

    public function contar(): int {
        $res = $this->selectOne("SELECT COUNT(*) as total FROM equipos_registrados WHERE estado_registro = 'activo'");
        return (int)($res['total'] ?? 0);
    }
}
