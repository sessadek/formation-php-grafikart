<?php
// Report all PHP errors
ini_set('display_errors', 1);

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR .'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use App\Router;
use Whoops\Run;
use Whoops\Handler\PrettyPageHandler;

$whoops = new Run;
$whoops->pushHandler(new PrettyPageHandler);
$whoops->register();

// if(isset($_GET['page']) && $_GET['page'] === '1') {
//     $get = $_GET;
//     unset($get['page']);
//     $path = $_SERVER['PATH_INFO'] ?? '/';
//     $uri = '/';
//     if(!empty($get)) {
//         $uri = http_build_query($get);
//         $uri = $path . '?' . $uri;
//     }
//     header('Location: ' . $uri, true, 301);
//     exit;
// }

// if($currentPage === "1") {
//     header('Location: ' . $router->url('home'), true, 301);
//     exit;
// }

define('VIEW_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views');

$router = new Router(VIEW_PATH);

$router->get('/', 'post/index', 'home');
$router->get('/post/[*:slug]-[i:id]', 'post/show', 'post');
$router->get('/category/[*:slug]-[i:id]', 'category/show', 'category');

$router->get('/admin/post', 'admin/post/index', 'adminPostList');
$router->match('/admin/post/add', 'admin/post/add', 'adminPostAdd');
$router->match('/admin/post/edit/[i:id]', 'admin/post/edit', 'adminPostEdit');
$router->post('/admin/post/delete/[i:id]', 'admin/post/delete', 'adminPostDelete');

$router->run();
