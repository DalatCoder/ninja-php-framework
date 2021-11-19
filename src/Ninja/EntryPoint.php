<?php

namespace Ninja;

use Ninja\NJInterface\IRoutes;

class EntryPoint
{
    private string $route;
    private string $method;
    private IRoutes $route_handler;

    public function __construct($route, $method, IRoutes $route_handler)
    {
        $this->route = $route;
        $this->route_handler = $route_handler;
        $this->method = $method;
        $this->checkUrl();
    }

    private function checkUrl()
    {
        if ($this->route !== strtolower($this->route)) {
            http_response_code(301);
            header('location: ' . strtolower($this->route));
            exit();
        }
    }

    /**
     * @throws NinjaException
     */
    public function run()
    {
        include __DIR__ . '/../../ninja-config.php';

        $routes = $this->route_handler->getRoutes() ?? [];
        $authentication = $this->route_handler->getAuthentication() ?? null;

        if (isset($routes[$this->route]['REDIRECT'])) {
            http_response_code(301);
            header('location: ' . $routes[$this->route]['REDIRECT']);
            exit();
        }

        $controller = $routes[$this->route][$this->method]['controller'] ?? null;
        $action = $routes[$this->route][$this->method]['action'] ?? null;

        if (!$controller || !$action) {
            if (method_exists($controller, 'handle_on_page_not_found')) {
                $controller->handle_on_page_not_found([
                    'route' => $this->route,
                    'method' => $this->method
                ]);
                exit();
            } else
                throw new NinjaException('Đường dẫn không tồn tại');
        }

        if (!method_exists($controller, $action))
            throw new NinjaException("Action: $action không tồn tại trên Controller: $controller");

        if (method_exists($controller, 'get_entrypoint_args'))
            $controller->get_entrypoint_args([
                'route' => $this->route,
                'method' => $this->method
            ]);

        $login_required = $routes[$this->route]['login'] ?? false;
        if ($login_required) {
            if (!($authentication instanceof Authentication))
                throw new NinjaException('Bạn phải viết phương thức getAuthentication trả về đối tượng thuộc lớp \\Ninja\\Authentication');
            
            if (!$authentication->isLoggedIn()) {
                if (method_exists($controller, 'handle_on_invalid_authentication')) {
                    $controller->handle_on_invalid_authentication([
                        'route' => $this->route,
                        'method' => $this->method
                    ]);
                    exit();
                } else
                    throw new NinjaException('Bạn phải đăng nhập để tiếp tục', 401);
            }
        }

        $permission_required = $routes[$this->route]['permissions'] ?? false;
        if ($permission_required) {
            $permission = $routes[$this->route]['permissions'];

            if (!$this->route_handler->checkPermission($permission)) {

                if (method_exists($controller, 'handle_on_invalid_permission')) {
                    $controller->handle_on_invalid_permission([
                        'route' => $this->route,
                        'method' => $this->method
                    ]);
                    exit();
                } else
                    throw new NinjaException('Bạn không có quyền thực hiện tính năng này', 401);
            }
        }

        $controller->$action();
    }
}
