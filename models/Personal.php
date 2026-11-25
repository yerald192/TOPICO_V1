<?php
// ==========================================================
// MODELO: Personal (Usuarios, Asistencia y Seguridad)
// ==========================================================

class Personal extends Model {
    /**
     * Autentica a un usuario por DNI y Contraseña
     */
    public function autenticar(string $dni, string $password): ?array {
        $usuario = $this->selectOne(
            "SELECT * FROM personal WHERE dni = ? AND estado = 'activo' LIMIT 1",
            [$dni]
        );

        if ($usuario && password_verify($password, $usuario['password_hash'])) {
            return $usuario;
        }

        return null;
    }

    /**
     * Lista todo el personal activo
     */
    public function listar(): array {
        return $this->selectAll(
            "SELECT id, dni, apellido_nombre, especialidad, rol, estado, fecha_creacion 
             FROM personal 
             WHERE estado = 'activo' 
             ORDER BY apellido_nombre ASC"
        );
    }

    public function obtenerPorId(int $id): ?array {
        return $this->selectOne("SELECT * FROM personal WHERE id = ? LIMIT 1", [$id]);
    }

    public function obtenerPorDni(string $dni): ?array {
        return $this->selectOne("SELECT * FROM personal WHERE dni = ? LIMIT 1", [$dni]);
    }

    public function crear(array $d): int {
        $hash = password_hash($d['password'], PASSWORD_BCRYPT);
        $this->query(
            "INSERT INTO personal (dni, apellido_nombre, especialidad, password_hash, rol, estado, creado_por) 
             VALUES (?, ?, ?, ?, ?, 'activo', ?)",
            [
                $d['dni'],
                $d['apellido_nombre'],
                $d['especialidad'] ?? 'Enfermería / Tópico',
                $hash,
                $d['rol'] ?? 'personal',
                $d['creado_por'] ?? 'Sistema'
            ]
        );
        return $this->lastInsertId();
    }

    public function actualizarRol(string $dni, string $nuevoRol): bool {
        $stmt = $this->query("UPDATE personal SET rol = ? WHERE dni = ?", [$nuevoRol, $dni]);
        return $stmt->rowCount() > 0;
    }

    public function cambiarPassword(string $dni, string $nuevoPassword): bool {
        $hash = password_hash($nuevoPassword, PASSWORD_BCRYPT);
        $stmt = $this->query("UPDATE personal SET password_hash = ? WHERE dni = ?", [$hash, $dni]);
        return $stmt->rowCount() > 0;
    }

    public function inactivar(string $dni, string $usuario): bool {
        $stmt = $this->query(
            "UPDATE personal SET estado = 'inactivo', fecha_inactivacion = CURRENT_TIMESTAMP, inactivado_por = ? 
             WHERE dni = ?",
            [$usuario, $dni]
        );
        return $stmt->rowCount() > 0;
    }

    // ================= REGISTRO DE ASISTENCIA / ENTRADA Y SALIDA =================
    public function registrarIngreso(string $dni, string $nombre): int {
        $hoy = date('Y-m-d');
        $hora = date('H:i:s');

        // Verificar si ya registró entrada hoy
        $existente = $this->selectOne(
            "SELECT id FROM registros_ingreso WHERE dni = ? AND fecha = ? AND estado = 'activo' LIMIT 1",
            [$dni, $hoy]
        );

        if ($existente) {
            return (int)$existente['id'];
        }

        $this->query(
            "INSERT INTO registros_ingreso (dni, nombre, fecha, hora_inicio, estado) VALUES (?, ?, ?, ?, 'activo')",
            [$dni, $nombre, $hoy, $hora]
        );
        return $this->lastInsertId();
    }

    public function registrarSalida(string $dni): bool {
        $hoy = date('Y-m-d');
        $hora = date('H:i:s');

        $registro = $this->selectOne(
            "SELECT id, hora_inicio FROM registros_ingreso WHERE dni = ? AND fecha = ? AND estado = 'activo' LIMIT 1",
            [$dni, $hoy]
        );

        if (!$registro) return false;

        $inicio = strtotime($registro['hora_inicio']);
        $salida = strtotime($hora);
        $minutos = round(abs($salida - $inicio) / 60);

        $stmt = $this->query(
            "UPDATE registros_ingreso SET hora_salida = ?, total_minutos = ?, estado = 'finalizado' WHERE id = ?",
            [$hora, $minutos, $registro['id']]
        );

        return $stmt->rowCount() > 0;
    }

    public function obtenerAsistenciasRecientes(int $limite = 30): array {
        return $this->selectAll(
            "SELECT * FROM registros_ingreso ORDER BY fecha DESC, hora_inicio DESC LIMIT ?",
            [$limite]
        );
    }

    // LOGS DE AUDITORÍA
    public function log(string $dni, string $accion, string $detalle): void {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        $this->query(
            "INSERT INTO logs_seguridad (dni_usuario, accion, detalle, ip_address) VALUES (?, ?, ?, ?)",
            [$dni, $accion, $detalle, $ip]
        );
    }
}
