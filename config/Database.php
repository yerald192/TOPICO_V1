<?php
require_once __DIR__ . '/config.php';

class Database {
    private static ?PDO $instance = null;

    private function __construct() {}
    private function __clone() {}

    public static function getInstance(): PDO {
        if (self::$instance === null) {
            $dbExiste = file_exists(DB_PATH);

            try {
                // Crear conexión SQLite
                self::$instance = new PDO('sqlite:' . DB_PATH);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

                // Habilitar claves foráneas y modo WAL para máximo rendimiento concurrente
                self::$instance->exec("PRAGMA foreign_keys = ON;");
                self::$instance->exec("PRAGMA journal_mode = WAL;");

                // Si el archivo no existía o está vacío, auto-ejecutar schema.sql
                if (!$dbExiste || filesize(DB_PATH) === 0) {
                    if (file_exists(SCHEMA_PATH)) {
                        $sql = file_get_contents(SCHEMA_PATH);
                        self::$instance->exec($sql);
                    }
                }
            } catch (PDOException $e) {
                die("Error crítico al inicializar la base de datos integrada: " . $e->getMessage());
            }
        }

        return self::$instance;
    }
}
