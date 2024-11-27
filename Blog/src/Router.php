<?php 

namespace App;

use AltoRouter;
use Exception;

class Router {

    /**
     * Undocumented variable
     *
     * @var string
     */
    private $viewPath;

    /**
     * Undocumented variable
     *
     * @var AltoRouter
     */
    private $router;

    /**
     * Undocumented function
     *
     * @param string $viewPath
     */
    public function __construct(string $viewPath)
    {
        $this->viewPath = $viewPath;
        $this->router = new AltoRouter();

    }

    /**
     * Undocumented function
     *
     * @param string $path
     * @param string $view
     * @param string|null $routeName
     * @return self
     */
    public function get(string $path, string $view, ?string $routeName = null): self {
        $this->router->map('GET', $path, $view, $routeName);
        return $this;
    }

    /**
     * Undocumented function
     *
     * @param string $path
     * @param string $view
     * @param string|null $routeName
     * @return self
     */
    public function post(string $path, string $view, ?string $routeName = null): self {
        $this->router->map('POST', $path, $view, $routeName);
        return $this;
    }

    public function match(string $path, string $view, ?string $routeName = null): self {
        $this->router->map('GET|POST', $path, $view, $routeName);
        return $this;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function run () {
        $match = $this->router->match();
        if($match === false) {
            throw new Exception('This route "' . $_SERVER['REQUEST_URI'] . '" not match any template');
        }
        $router = $this;
        $view = $match['target'];
        ob_start();
        require_once $this->viewPath . DIRECTORY_SEPARATOR . $view . '.php';
        $content = ob_get_clean();
        require_once $this->viewPath . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR . 'default.php';
    }

    /**
     * Undocumented function
     *
     * @param string $routeName
     * @param array $params
     * @return void
     */
    public function url(string $routeName, array $params = []) {
        return $this->router->generate($routeName, $params);
    }
}