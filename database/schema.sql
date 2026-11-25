-- ==========================================================
-- ESQUEMA SQLITE INTEGRADO: SISTEMA TÓPICO MÉDICO
-- Base de datos embebida autónoma (No requiere MySQL/XAMPP)
-- ==========================================================

PRAGMA foreign_keys = ON;

-- 1. TABLA: PERSONAL / USUARIOS DEL SISTEMA
CREATE TABLE IF NOT EXISTS personal (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    dni TEXT UNIQUE NOT NULL,
    apellido_nombre TEXT NOT NULL,
    especialidad TEXT,
    password_hash TEXT NOT NULL,
    rol TEXT DEFAULT 'personal', -- 'admin', 'personal'
    estado TEXT DEFAULT 'activo', -- 'activo', 'inactivo'
    creado_por TEXT,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    fecha_inactivacion DATETIME,
    inactivado_por TEXT
);

-- 2. TABLA: PACIENTES
CREATE TABLE IF NOT EXISTS pacientes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    dni TEXT UNIQUE NOT NULL,
    apellidos_nombres TEXT NOT NULL,
    fecha_nacimiento DATE,
    edad INTEGER,
    genero TEXT,
    tipo_paciente TEXT DEFAULT 'Estudiante',
    telefono TEXT,
    celular_emergencia TEXT,
    contacto_emergencia TEXT,
    parentesco_emergencia TEXT,
    direccion TEXT,
    lugar_nacimiento TEXT,
    programa_estudios TEXT,
    semestre TEXT,
    tipo_sangre TEXT,
    seguro TEXT,
    alergias TEXT,
    enfermedades TEXT,
    medicamentos_actuales TEXT,
    observaciones_salud TEXT,
    estado TEXT DEFAULT 'activo', -- 'activo', 'eliminado'
    creado_por TEXT,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    modificado_por TEXT,
    fecha_modificacion DATETIME,
    eliminado_por TEXT,
    fecha_eliminacion DATETIME
);

-- 3. TABLA: ATENCIONES MÉDICAS
CREATE TABLE IF NOT EXISTS atenciones (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    fecha DATE NOT NULL,
    programa_estudios TEXT,
    semestre TEXT,
    apellidos_nombres TEXT NOT NULL,
    dni TEXT NOT NULL,
    telefono TEXT,
    celular_emergencia TEXT,
    edad INTEGER,
    genero TEXT,
    hora_ingreso TEXT,
    hora_salida TEXT,
    motivo_consulta TEXT,
    tratamiento TEXT,
    tipo_descanso TEXT,
    hospital_derivacion TEXT,
    observacion TEXT,
    peso REAL,
    talla REAL,
    imc REAL,
    temperatura REAL,
    presion_arterial TEXT,
    frecuencia_cardiaca INTEGER,
    signos_sintomas TEXT,
    responsable_atencion TEXT,
    dni_responsable TEXT,
    estado TEXT DEFAULT 'activa',
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 4. TABLA: DERIVACIONES
CREATE TABLE IF NOT EXISTS derivaciones (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nro_derivacion TEXT UNIQUE NOT NULL,
    fecha_emision DATE NOT NULL,
    profesional_nombre TEXT,
    profesional_dni TEXT,
    paciente_dni TEXT,
    paciente_nombre TEXT,
    paciente_carrera TEXT,
    paciente_edad INTEGER,
    paciente_sexo TEXT,
    paciente_telefono TEXT,
    ciclo TEXT,
    tipo_atencion TEXT,
    motivo TEXT,
    hospital_destino TEXT,
    peso REAL,
    talla REAL,
    imc REAL,
    temperatura REAL,
    presion_arterial TEXT,
    frecuencia_cardiaca INTEGER,
    signos_sintomas TEXT,
    apoderado_tipo TEXT,
    apoderado_nombre TEXT,
    apoderado_celular TEXT,
    apoderado_parentesco TEXT,
    apoderado_estado_civil TEXT,
    estado TEXT DEFAULT 'activa',
    creado_por TEXT,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 5. TABLA: EQUIPOS MÉDICOS REGISTRADOS
CREATE TABLE IF NOT EXISTS equipos_registrados (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre TEXT NOT NULL,
    equipo TEXT,
    categoria TEXT,
    serie TEXT,
    estado TEXT DEFAULT 'Operativo',
    cantidad INTEGER DEFAULT 1,
    observacion TEXT,
    creado_por TEXT,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    estado_registro TEXT DEFAULT 'activo',
    fecha_eliminacion DATETIME,
    eliminado_por TEXT
);

-- 6. TABLA: STOCK DE PRODUCTOS Y MEDICAMENTOS
CREATE TABLE IF NOT EXISTS stock_productos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre TEXT NOT NULL,
    categoria TEXT,
    unidad TEXT DEFAULT 'Unidad',
    cantidad INTEGER DEFAULT 0,
    stock_minimo INTEGER DEFAULT 5,
    creado_por TEXT,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    estado TEXT DEFAULT 'activo',
    fecha_eliminacion DATETIME,
    eliminado_por TEXT
);

-- 7. TABLA: INVENTARIOS GENERALES
CREATE TABLE IF NOT EXISTS inventariados (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nro_inventario TEXT UNIQUE NOT NULL,
    fecha DATE NOT NULL,
    responsable TEXT,
    observaciones TEXT,
    creado_por TEXT,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    estado TEXT DEFAULT 'activo'
);

-- 8. TABLA: DETALLES DE INVENTARIO (ITEMS)
CREATE TABLE IF NOT EXISTS inventariado_items (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    inventario_id INTEGER NOT NULL,
    producto_id INTEGER NOT NULL,
    nombre TEXT NOT NULL,
    stock_sistema INTEGER,
    conteo_fisico INTEGER,
    diferencia INTEGER,
    FOREIGN KEY (inventario_id) REFERENCES inventariados(id) ON DELETE CASCADE
);

-- 9. TABLA: REGISTRO DE ASISTENCIA / INGRESO PERSONAL
CREATE TABLE IF NOT EXISTS registros_ingreso (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    dni TEXT NOT NULL,
    nombre TEXT NOT NULL,
    fecha DATE NOT NULL,
    hora_inicio TEXT NOT NULL,
    hora_salida TEXT,
    total_minutos INTEGER,
    estado TEXT DEFAULT 'activo'
);

-- 10. TABLA: LOGS DE SEGURIDAD
CREATE TABLE IF NOT EXISTS logs_seguridad (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    dni_usuario TEXT,
    accion TEXT NOT NULL,
    detalle TEXT,
    ip_address TEXT,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 11. TABLA: INTENTOS FALLIDOS (RATE LIMITING)
CREATE TABLE IF NOT EXISTS logs_intentos_fallidos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    ip_address TEXT NOT NULL,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- USUARIO ADMINISTRADOR POR DEFECTO:
-- DNI: 12345678 | Contraseña: Admin123*
INSERT OR IGNORE INTO personal (dni, apellido_nombre, especialidad, password_hash, rol, estado)
VALUES ('12345678', 'Administrador General', 'Medicina General', '$2y$10$QXVhTmrLbwTEwByx18yM6.aQHYre62uxbmI4XuxWK22HiTRhCTtmm', 'admin', 'activo');
