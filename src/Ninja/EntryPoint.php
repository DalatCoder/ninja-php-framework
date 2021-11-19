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

        $controller = null;
        if (isset($routes[$this->route][$this->method]['controller']))
            $controller = $routes[$this->route][$this->method]['controller'];

        $action = null;
        if (isset($routes[$this->route][$this->method]['action']))
            $action = $routes[$this->route][$this->method]['action'];

        if (!$controller)
            throw new NinjaException('Controller không hợp lệ');

        if (!$action)
            throw new NinjaException('Action không hợp lệ');
        
        if (!method_exists($controller, $action))
            throw new NinjaException("Action: $action không tồn tại trên Controller: $controller");

        if (method_exists($controller, 'get_entrypoint_args'))
            $controller->get_entrypoint_args([
                'route' => $this->route,
                'method' => $this->method
            ]);

        $login_required = $routes[$this->route]['login'] ?? false;
        if ($login_required) {
            if (method_exists($controller, 'handle_on_invalid_authentication')) {
                $controller->handle_on_invalid_authentication([
                    'route' => $this->route,
                    'method' => $this->method
                ]);
                exit();
            }
            else 
                throw new NinjaException('Bạn phải đăng nhập để tiếp tục', 401);
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
                }
                else 
                    throw new NinjaException('Bạn không có quyền thực hiện tính năng này', 401);
            }
        }

        $controller->$action();
    }
}
