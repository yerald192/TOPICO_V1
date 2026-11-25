<?php
abstract class Controller {
    public function model(string $model) {
        $file = ROOT_PATH . '/models/' . $model . '.php';
        if (file_exists($file)) {
            require_once $file;
            return new $model();
        }
        throw new Exception("El modelo {$model} no fue encontrado.");
    }

    public function view(string $viewPath, array $data = [], bool $withLayout = true): void {
        extract($data);

        $viewFile = ROOT_PATH . '/views/' . $viewPath . '.php';
        if (!file_exists($viewFile)) {
            throw new Exception("La vista {$viewPath} no existe.");
        }

        if ($withLayout) {
            require_once ROOT_PATH . '/views/layouts/header.php';
            require_once $viewFile;
            require_once ROOT_PATH . '/views/layouts/footer.php';
        } else {
            require_once $viewFile;
        }
    }

    public function json(array $data, int $statusCode = 200): void {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit();
    }

    public function redirect(string $url): void {
        header("Location: " . BASE_URL . '/' . ltrim($url, '/'));
        exit();
    }

    public function isPost(): bool {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    public function post(?string $key = null, $default = null) {
        if ($key === null) {
            return $_POST;
        }
        return isset($_POST[$key]) ? trim((string)$_POST[$key]) : $default;
    }

    public function get(?string $key = null, $default = null) {
        if ($key === null) {
            return $_GET;
        }
        return isset($_GET[$key]) ? trim((string)$_GET[$key]) : $default;
    }
}
