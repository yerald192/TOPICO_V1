<?php
class App {
    protected string $controllerName = 'HomeController';
    protected object $controllerInstance;
    protected string $method = 'index';
    protected array $params = [];

    public function __construct() {
        $url = $this->parseUrl();

        // 1. RESOLVER CONTROLADOR
        if (!empty($url[0])) {
            $candidate = ucfirst($url[0]) . 'Controller';
            if (file_exists(ROOT_PATH . '/controllers/' . $candidate . '.php')) {
                $this->controllerName = $candidate;
                unset($url[0]);
            } else {
                // Controlador no encontrado -> 404
                $this->render404("El controlador {$candidate} no existe.");
                return;
            }
        }

        require_once ROOT_PATH . '/controllers/' . $this->controllerName . '.php';
        $this->controllerInstance = new $this->controllerName();

        // 2. RESOLVER MÉTODO
        if (!empty($url[1])) {
            $methodCandidate = str_replace('-', '_', $url[1]);
            if (method_exists($this->controllerInstance, $methodCandidate)) {
                $this->method = $methodCandidate;
                unset($url[1]);
            } else {
                $this->render404("La acción {$methodCandidate} no existe.");
                return;
            }
        }

        // 3. PARÁMETROS RESTANTES
        $this->params = $url ? array_values($url) : [];

        // 4. EJECUTAR ACCIÓN
        call_user_func_array([$this->controllerInstance, $this->method], $this->params);
    }

    protected function parseUrl(): array {
        // 1. Si viene en $_GET['url'] (típico de Apache con .htaccess)
        if (!empty($_GET['url'])) {
            $url = filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL);
            return explode('/', $url);
        }

        // 2. Si corre bajo servidor interno de PHP (php -S) o Electron sin mod_rewrite
        if (!empty($_SERVER['REQUEST_URI'])) {
            $uriPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $scriptDir = trim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/.');
            if ($scriptDir && strpos($uriPath, '/' . $scriptDir) === 0) {
                $uriPath = substr($uriPath, strlen('/' . $scriptDir));
            }
            $uriPath = trim($uriPath, '/');
            if (!empty($uriPath)) {
                return explode('/', filter_var($uriPath, FILTER_SANITIZE_URL));
            }
        }

        return [];
    }

    protected function render404(string $mensaje = "Página no encontrada"): void {
        http_response_code(404);
        $errorFile = ROOT_PATH . '/views/errors/404.php';
        if (file_exists($errorFile)) {
            require_once ROOT_PATH . '/views/layouts/header.php';
            require_once $errorFile;
            require_once ROOT_PATH . '/views/layouts/footer.php';
        } else {
            echo "<h1>404 - No Encontrado</h1><p>{$mensaje}</p>";
        }
    }
}
