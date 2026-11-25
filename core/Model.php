<?php
require_once ROOT_PATH . '/config/Database.php';

abstract class Model {
    protected PDO $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function query(string $sql, array $params = []): PDOStatement {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function selectAll(string $sql, array $params = []): array {
        return $this->query($sql, $params)->fetchAll();
    }

    public function selectOne(string $sql, array $params = []): ?array {
        $res = $this->query($sql, $params)->fetch();
        return $res ?: null;
    }

    public function lastInsertId(): int {
        return (int)$this->db->lastInsertId();
    }
}
