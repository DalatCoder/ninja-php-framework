<?php

namespace Ninja;

use Ninja\IRoutes;

class EntryPoint
{
    private $route;
    private $method;
    private $route_handler;

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

    private function checkTemplateDir($templateFileName)
    {
        return file_exists(__DIR__ . '/../../templates/' . $templateFileName);
    }

    private function loadTemplate($templateFileName, $variables = [])
    {
        extract($variables);

        ob_start();
        include __DIR__ . '/../../templates/' . $templateFileName;

        return ob_get_clean();
    }

    public function run()
    {
        include __DIR__ . '/../../ninja-config.php';

        $routes = $this->route_handler->getRoutes();

        $authentication = $this->route_handler->getAuthentication();

        if ($ninja_global_configs['auth'] == true) {

            if (!$authentication)
                throw new \Exception('Bạn phải viết phương thức getAuthentication');

            $login_required = $routes[$this->route]['login'] ?? false;
            if ($authentication && $login_required) {
                if (!$authentication->isLoggedIn()) {
                    header('location: /login/error');
                    exit();
                }
            }
        }

        if ($ninja_global_configs['permission']) {
            $permission_required = $routes[$this->route]['permissions'] ?? false;
            if ($permission_required) {
                $permission = $routes[$this->route]['permissions'];

                if (!$this->route_handler->checkPermission($permission)) {
                    header('location: /login/error');
                    exit();
                }
            }
        }

        if (isset($routes[$this->route]['REDIRECT'])) {
            http_response_code(301);
            header('location: ' . $routes[$this->route]['REDIRECT']);
            exit();
        }

        $controller = $routes['404']['controller'];
        $action = $routes['404']['action'];

        if (isset($routes[$this->route][$this->method]['controller']))
            $controller = $routes[$this->route][$this->method]['controller'];

        if (isset($routes[$this->route][$this->method]['action']))
            $action = $routes[$this->route][$this->method]['action'];

        $page = $controller->$action();

        $master = $page['master'] ?? null;
        if (!$master)
            throw new \Exception('Vui lòng thêm thuộc tính master để xác định master layout');
        if (!$this->checkTemplateDir($master))
            throw new \Exception('Đường dẫn không hợp lệ! Trang master không tồn tại');

        $title = $page['title'] ?? null;
        if (!$title)
            throw new \Exception('Vụi lòng thêm thuộc tính title');

        $templateFileName = $page['template'] ?? null;
        if (!$templateFileName)
            throw new \Exception('Vui lòng thêm thuộc tính template để xác định template layout');
        if (!$this->checkTemplateDir($templateFileName))
            throw new \Exception('Đường dẫn không hợp lệ! Trang template không tồn tại');

        $variables = $page['variables'] ?? [];
        $custom_styles = $page['custom_styles'] ?? [];
        $custom_scripts = $page['custom_scripts'] ?? [];

        $output = $this->loadTemplate($templateFileName, $variables) ?? '';

        $template_args = [
            'content' => $output,
            'title' => $title,
            'custom_styles' => $custom_styles,
            'custom_scripts' => $custom_scripts,
            'route' => $this->route,
            'loggedIn' => null,
            'shop_name' => null,
            'loggedInUser' => null
        ];

        if ($ninja_global_configs['auth']) {
            $template_args['loggedIn'] = $authentication->isLoggedIn() ?? null;
            $template_args['loggedInUser'] = $authentication->getUser() ?? null;
        }

        if ($ninja_global_configs['shop_name']) {
            $template_args['shop_name'] = $ninja_global_configs['shop_name'];
        }

        echo $this->loadTemplate($master, $template_args);
    }
}
