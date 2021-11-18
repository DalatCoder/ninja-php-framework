<?php

use Lab05\Lab05Routes;
use Ninja\EntryPoint;

try {
    define('ROOT_DIR', dirname(__DIR__ . '/../../'));
    
    include __DIR__ . '/../includes/autoload.php';

    $route = strtok($_SERVER['REQUEST_URI'], '?');
    $routes_handler = new Lab05Routes();

    $method = $_SERVER['REQUEST_METHOD'];

    $entryPoint = new EntryPoint($route, $method, $routes_handler);
    $entryPoint->run();
} 
catch (\Ninja\NinjaException $e) {
    echo $e->getTraceAsString();
}
catch (\PDOException $e) {
    $title = 'Đã có lỗi nghiêm trọng xảy ra';
    $content = 'Lỗi trong quá trình kết nối CSDL: ' . $e->getMessage() . ' in ' . $e->getFile() . ': ' . $e->getLine();
    $custom_styles = [];
    $custom_scripts = [];

    include __DIR__ . '/../views/master.html.php';
} catch (\Exception $e) {
    $title = 'Đã có lỗi nghiêm tọng xảy ra';
    $content = 'Đã có lỗi nghiêm trọng xảy ra: "' . $e->getMessage() . '" tại tập tin: ' . $e->getFile() . ': ' . $e->getLine();
    $custom_styles = [];
    $custom_scripts = [];

    include __DIR__ . '/../views/master.html.php';
}
