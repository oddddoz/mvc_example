<?php

require_once '../controller/pokemon.php';

$controller = new Controller();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    switch ($_POST['action']) {
        case 'add':
            $controller->add($_POST['name']);
            break;
        case 'delete':
            $controller->delete($_POST['id']);
            break;
        default:
            $controller->notFound();
            break;
    }
}


$route = $_GET['route'] ?? 'index';

switch ($route) {
    case '':
    case 'index':
        $controller->index();
        break;
    case 'pokemon':
        $name = $_GET['name'] ?? '';
        $controller->get($name);
        break;
    default:
        $controller->notFound();
        break;
}
