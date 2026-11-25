<?php
// ==========================================================
// MODELO: Derivacion (Referencias Médicas a Hospitales)
// ==========================================================

class Derivacion extends Model {
    public function listar(int $limite = 20, int $offset = 0, string $busqueda = ''): array {
        $sql = "SELECT * FROM derivaciones WHERE estado = 'activa'";
        $params = [];

        if (!empty($busqueda)) {
            $sql .= " AND (nro_derivacion LIKE ? OR paciente_nombre LIKE ? OR paciente_dni LIKE ? OR hospital_destino LIKE ?)";
            $t = "%{$busqueda}%";
            $params = [$t, $t, $t, $t];
        }

        $sql .= " ORDER BY id DESC LIMIT ? OFFSET ?";
        $params[] = $limite;
        $params[] = $offset;

        return $this->selectAll($sql, $params);
    }

    public function contar(string $busqueda = ''): int {
        $sql = "SELECT COUNT(*) as total FROM derivaciones WHERE estado = 'activa'";
        $params = [];

        if (!empty($busqueda)) {
            $sql .= " AND (nro_derivacion LIKE ? OR paciente_nombre LIKE ? OR paciente_dni LIKE ? OR hospital_destino LIKE ?)";
            $t = "%{$busqueda}%";
            $params = [$t, $t, $t, $t];
        }

        $res = $this->selectOne($sql, $params);
        return (int)($res['total'] ?? 0);
    }

    public function obtenerPorId(int $id): ?array {
        return $this->selectOne("SELECT * FROM derivaciones WHERE id = ? LIMIT 1", [$id]);
    }

    public function generarSiguienteNumero(): string {
        $ano = date('Y');
        $ultimo = $this->selectOne(
            "SELECT nro_derivacion FROM derivaciones WHERE nro_derivacion LIKE ? ORDER BY id DESC LIMIT 1",
            ["DER-{$ano}-%"]
        );

        if ($ultimo) {
            $partes = explode('-', $ultimo['nro_derivacion']);
            $correlativo = isset($partes[2]) ? (int)$partes[2] + 1 : 1;
        } else {
            $correlativo = 1;
        }

        return sprintf("DER-%s-%04d", $ano, $correlativo);
    }

    public function registrar(array $d): int {
        $nro = $this->generarSiguienteNumero();

        $sql = "INSERT INTO derivaciones (
            nro_derivacion, fecha_emision, profesional_nombre, profesional_dni,
            paciente_dni, paciente_nombre, paciente_carrera, paciente_edad, paciente_sexo,
            paciente_telefono, ciclo, tipo_atencion, motivo, hospital_destino,
            peso, talla, imc, temperatura, presion_arterial, frecuencia_cardiaca, signos_sintomas,
            apoderado_tipo, apoderado_nombre, apoderado_celular, apoderado_parentesco, apoderado_estado_civil,
            creado_por, estado
        ) VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'activa'
        )";

        $this->query($sql, [
            $nro,
            $d['fecha_emision'] ?? date('Y-m-d'),
            $d['profesional_nombre'] ?? 'Personal de Tópico',
            $d['profesional_dni'] ?? '',
            $d['paciente_dni'],
            $d['paciente_nombre'],
            $d['paciente_carrera'] ?? '',
            (int)($d['paciente_edad'] ?? 0),
            $d['paciente_sexo'] ?? '',
            $d['paciente_telefono'] ?? '',
            $d['ciclo'] ?? '',
            $d['tipo_atencion'] ?? 'Urgencia',
            $d['motivo'] ?? '',
            $d['hospital_destino'] ?? 'Hospital de Apoyo Huanta',
            !empty($d['peso']) ? (float)$d['peso'] : null,
            !empty($d['talla']) ? (float)$d['talla'] : null,
            !empty($d['imc']) ? (float)$d['imc'] : null,
            !empty($d['temperatura']) ? (float)$d['temperatura'] : null,
            $d['presion_arterial'] ?? '',
            !empty($d['frecuencia_cardiaca']) ? (int)$d['frecuencia_cardiaca'] : null,
            $d['signos_sintomas'] ?? '',
            $d['apoderado_tipo'] ?? '',
            $d['apoderado_nombre'] ?? '',
            $d['apoderado_celular'] ?? '',
            $d['apoderado_parentesco'] ?? '',
            $d['apoderado_estado_civil'] ?? '',
            $d['creado_por'] ?? 'Sistema'
        ]);

        return $this->lastInsertId();
    }

    public function anular(int $id): bool {
        $stmt = $this->query("UPDATE derivaciones SET estado = 'anulada' WHERE id = ?", [$id]);
        return $stmt->rowCount() > 0;
    }
}
