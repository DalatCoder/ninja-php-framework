<?php

use Ninja\EntryPoint;
use Ninja\NinjaException;

include __DIR__ . '/../includes/autoload.php';
include __DIR__ . '/../includes/fatal_handler.php';
include __DIR__ . '/../includes/load_template.php';

try {
    define('ROOT_DIR', dirname(__DIR__ . '/../../'));

    $route = strtok($_SERVER['REQUEST_URI'], '?');
    $routes_handler = new \Lab07\Lab07RoutesHandler();

    $method = $_SERVER['REQUEST_METHOD'];

    $entryPoint = new EntryPoint($route, $method, $routes_handler);
    $entryPoint->run();
} catch (NinjaException $exception) {
    $template_args = [
        'title' => 'Lỗi từ lập trình viên khi sử dụng Ninja Framework',
        'error_message' => $exception->getMessage(),
        'error_stack_trace' => $exception->getTrace()
    ];

    $template_dir = ROOT_DIR . '/src/Ninja/NJViews/';
    $template_name = 'nj_error.html.php';

    echo load_template($template_name, $template_args);
} catch (\PDOException $exception) {
    $template_args = [
        'title' => 'Lỗi trong quá trình kết nối CSDL sử dụng PDO',
        'error_message' => $exception->getMessage(),
        'error_stack_trace' => $exception->getTrace()
    ];

    $template_dir = ROOT_DIR . '/src/Ninja/NJViews/';
    $template_name = 'nj_error.html.php';

    echo load_template($template_name, $template_args);
} catch (\Exception $exception) {
    $template_args = [
        'title' => 'Lỗi hệ thống',
        'error_message' => $exception->getMessage(),
        'error_stack_trace' => $exception->getTrace()
    ];

    $template_dir = ROOT_DIR . '/src/Ninja/NJViews/';
    $template_name = 'nj_error.html.php';

    echo load_template($template_name, $template_args);
} 
