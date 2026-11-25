<?php
// ==========================================================
// MODELO: Atencion (Consultas y Atenciones Médicas)
// ==========================================================

class Atencion extends Model {
    /**
     * Lista atenciones con filtros, búsqueda y paginación
     */
    public function listar(int $limite = 20, int $offset = 0, string $busqueda = '', string $fecha = ''): array {
        $sql = "SELECT * FROM atenciones WHERE estado = 'activa'";
        $params = [];

        if (!empty($busqueda)) {
            $sql .= " AND (dni LIKE ? OR apellidos_nombres LIKE ? OR motivo_consulta LIKE ?)";
            $t = "%{$busqueda}%";
            $params[] = $t;
            $params[] = $t;
            $params[] = $t;
        }

        if (!empty($fecha)) {
            $sql .= " AND fecha = ?";
            $params[] = $fecha;
        }

        $sql .= " ORDER BY fecha DESC, id DESC LIMIT ? OFFSET ?";
        $params[] = $limite;
        $params[] = $offset;

        return $this->selectAll($sql, $params);
    }

    public function contar(string $busqueda = '', string $fecha = ''): int {
        $sql = "SELECT COUNT(*) as total FROM atenciones WHERE estado = 'activa'";
        $params = [];

        if (!empty($busqueda)) {
            $sql .= " AND (dni LIKE ? OR apellidos_nombres LIKE ? OR motivo_consulta LIKE ?)";
            $t = "%{$busqueda}%";
            $params[] = $t;
            $params[] = $t;
            $params[] = $t;
        }

        if (!empty($fecha)) {
            $sql .= " AND fecha = ?";
            $params[] = $fecha;
        }

        $res = $this->selectOne($sql, $params);
        return (int)($res['total'] ?? 0);
    }

    public function obtenerPorId(int $id): ?array {
        return $this->selectOne("SELECT * FROM atenciones WHERE id = ? AND estado = 'activa' LIMIT 1", [$id]);
    }

    public function registrar(array $d): int {
        // Calcular IMC si se dispone de peso y talla
        $peso = !empty($d['peso']) ? (float)$d['peso'] : null;
        $talla = !empty($d['talla']) ? (float)$d['talla'] : null;
        $imc = null;

        if ($peso && $talla && $talla > 0) {
            $tallaMetros = $talla > 3 ? ($talla / 100) : $talla; // si se ingresó en cm
            $imc = round($peso / ($tallaMetros * $tallaMetros), 2);
        }

        $sql = "INSERT INTO atenciones (
            fecha, programa_estudios, semestre, apellidos_nombres, dni, telefono, celular_emergencia,
            edad, genero, hora_ingreso, hora_salida, motivo_consulta, tratamiento, tipo_descanso,
            hospital_derivacion, observacion, peso, talla, imc, temperatura, presion_arterial,
            frecuencia_cardiaca, signos_sintomas, responsable_atencion, dni_responsable, estado
        ) VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'activa'
        )";

        $this->query($sql, [
            $d['fecha'] ?? date('Y-m-d'),
            $d['programa_estudios'] ?? '',
            $d['semestre'] ?? '',
            $d['apellidos_nombres'],
            $d['dni'],
            $d['telefono'] ?? '',
            $d['celular_emergencia'] ?? '',
            (int)($d['edad'] ?? 0),
            $d['genero'] ?? '',
            $d['hora_ingreso'] ?? date('H:i'),
            $d['hora_salida'] ?? null,
            $d['motivo_consulta'] ?? '',
            $d['tratamiento'] ?? '',
            $d['tipo_descanso'] ?? 'Sin reposo',
            $d['hospital_derivacion'] ?? '',
            $d['observacion'] ?? '',
            $peso,
            $talla,
            $imc,
            !empty($d['temperatura']) ? (float)$d['temperatura'] : null,
            $d['presion_arterial'] ?? '',
            !empty($d['frecuencia_cardiaca']) ? (int)$d['frecuencia_cardiaca'] : null,
            $d['signos_sintomas'] ?? '',
            $d['responsable_atencion'] ?? 'Personal de Tópico',
            $d['dni_responsable'] ?? ''
        ]);

        return $this->lastInsertId();
    }

    public function obtenerHistorialPorDni(string $dni): array {
        return $this->selectAll(
            "SELECT * FROM atenciones WHERE dni = ? AND estado = 'activa' ORDER BY fecha DESC, id DESC",
            [$dni]
        );
    }

    public function obtenerUltimaAtencion(string $dni): ?array {
        return $this->selectOne(
            "SELECT * FROM atenciones WHERE dni = ? AND estado = 'activa' ORDER BY fecha DESC, id DESC LIMIT 1",
            [$dni]
        );
    }
}
