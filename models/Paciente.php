<?php
class Paciente extends Model {
    /**
     * Lista pacientes activos con paginación y búsqueda
     */
    public function listar(int $limite = 20, int $offset = 0, string $busqueda = ''): array {
        $sql = "SELECT id, dni, apellidos_nombres, fecha_nacimiento, edad, genero, 
                       tipo_paciente, telefono, celular_emergencia, contacto_emergencia, 
                       direccion, programa_estudios, semestre, tipo_sangre, seguro, 
                       alergias, enfermedades, medicamentos_actuales, observaciones_salud, 
                       fecha_creacion 
                FROM pacientes 
                WHERE estado = 'activo'";
        
        $params = [];
        if (!empty($busqueda)) {
            $sql .= " AND (dni LIKE ? OR apellidos_nombres LIKE ? OR programa_estudios LIKE ?)";
            $termino = "%{$busqueda}%";
            $params = [$termino, $termino, $termino];
        }

        $sql .= " ORDER BY apellidos_nombres ASC LIMIT ? OFFSET ?";
        $params[] = $limite;
        $params[] = $offset;

        return $this->selectAll($sql, $params);
    }

    /**
     * Cuenta total de pacientes activos para paginación
     */
    public function contar(string $busqueda = ''): int {
        $sql = "SELECT COUNT(*) as total FROM pacientes WHERE estado = 'activo'";
        $params = [];

        if (!empty($busqueda)) {
            $sql .= " AND (dni LIKE ? OR apellidos_nombres LIKE ? OR programa_estudios LIKE ?)";
            $termino = "%{$busqueda}%";
            $params = [$termino, $termino, $termino];
        }

        $res = $this->selectOne($sql, $params);
        return (int)($res['total'] ?? 0);
    }

    /**
     * Obtiene paciente por ID
     */
    public function obtenerPorId(int $id): ?array {
        return $this->selectOne("SELECT * FROM pacientes WHERE id = ? AND estado = 'activo' LIMIT 1", [$id]);
    }

    /**
     * Obtiene paciente por DNI
     */
    public function obtenerPorDni(string $dni): ?array {
        return $this->selectOne("SELECT * FROM pacientes WHERE dni = ? AND estado = 'activo' LIMIT 1", [$dni]);
    }

    /**
     * Registra un nuevo paciente
     */
    public function registrar(array $d): int {
        $sql = "INSERT INTO pacientes (
            dni, apellidos_nombres, fecha_nacimiento, edad, genero, tipo_paciente,
            telefono, celular_emergencia, contacto_emergencia, parentesco_emergencia,
            direccion, lugar_nacimiento, programa_estudios, semestre, tipo_sangre,
            seguro, alergias, enfermedades, medicamentos_actuales, observaciones_salud,
            creado_por, estado
        ) VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'activo'
        )";

        $this->query($sql, [
            $d['dni'],
            $d['apellidos_nombres'],
            $d['fecha_nacimiento'] ?? null,
            (int)($d['edad'] ?? 0),
            $d['genero'] ?? '',
            $d['tipo_paciente'] ?? 'Estudiante',
            $d['telefono'] ?? '',
            $d['celular_emergencia'] ?? '',
            $d['contacto_emergencia'] ?? '',
            $d['parentesco_emergencia'] ?? '',
            $d['direccion'] ?? '',
            $d['lugar_nacimiento'] ?? '',
            $d['programa_estudios'] ?? '',
            $d['semestre'] ?? '',
            $d['tipo_sangre'] ?? '',
            $d['seguro'] ?? '',
            $d['alergias'] ?? '',
            $d['enfermedades'] ?? '',
            $d['medicamentos_actuales'] ?? '',
            $d['observaciones_salud'] ?? '',
            $d['creado_por'] ?? 'Sistema'
        ]);

        return $this->lastInsertId();
    }

    /**
     * Actualiza la información de un paciente
     */
    public function actualizar(int $id, array $d): bool {
        $sql = "UPDATE pacientes SET 
            dni = ?, apellidos_nombres = ?, fecha_nacimiento = ?, edad = ?, genero = ?, tipo_paciente = ?,
            telefono = ?, celular_emergencia = ?, contacto_emergencia = ?, parentesco_emergencia = ?,
            direccion = ?, lugar_nacimiento = ?, programa_estudios = ?, semestre = ?, tipo_sangre = ?,
            seguro = ?, alergias = ?, enfermedades = ?, medicamentos_actuales = ?, observaciones_salud = ?,
            modificado_por = ?, fecha_modificacion = CURRENT_TIMESTAMP
        WHERE id = ? AND estado = 'activo'";

        $stmt = $this->query($sql, [
            $d['dni'],
            $d['apellidos_nombres'],
            $d['fecha_nacimiento'] ?? null,
            (int)($d['edad'] ?? 0),
            $d['genero'] ?? '',
            $d['tipo_paciente'] ?? 'Estudiante',
            $d['telefono'] ?? '',
            $d['celular_emergencia'] ?? '',
            $d['contacto_emergencia'] ?? '',
            $d['parentesco_emergencia'] ?? '',
            $d['direccion'] ?? '',
            $d['lugar_nacimiento'] ?? '',
            $d['programa_estudios'] ?? '',
            $d['semestre'] ?? '',
            $d['tipo_sangre'] ?? '',
            $d['seguro'] ?? '',
            $d['alergias'] ?? '',
            $d['enfermedades'] ?? '',
            $d['medicamentos_actuales'] ?? '',
            $d['observaciones_salud'] ?? '',
            $d['modificado_por'] ?? 'Sistema',
            $id
        ]);

        return $stmt->rowCount() > 0;
    }

    /**
     * Eliminación lógica de paciente
     */
    public function eliminar(int $id, string $usuario = 'Sistema'): bool {
        $sql = "UPDATE pacientes SET 
            estado = 'eliminado', 
            eliminado_por = ?, 
            fecha_eliminacion = CURRENT_TIMESTAMP 
        WHERE id = ?";

        $stmt = $this->query($sql, [$usuario, $id]);
        return $stmt->rowCount() > 0;
    }
}
