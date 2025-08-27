<?php
session_start();

require_once 'configuracao/constantes.php';
require_once 'configuracao/basedados.php';

// Autoload para controladores e modelos
spl_autoload_register(function ($className) {
    $paths = [
        'controladores/',
        'modelos/'
    ];
    foreach ($paths as $path) {
        $file = ROOT_PATH . '/' . $path . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Roteamento simples
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'dashboard';
$urlParts = explode('/', $url);

$controllerName = $urlParts[0] ?? 'dashboard';
$methodName = $urlParts[1] ?? 'index';
$parametros = array_slice($urlParts, 2);

// Casos especiais para autenticação
if ($controllerName == 'login' || $controllerName == 'registo' || $controllerName == 'logout') {
    $controladorNome = 'AutenticacaoControlador';
    $metodoNome = $controllerName;
} else {
    $controladorNome = ucfirst(strtolower($controllerName)) . 'Controlador';
    $metodoNome = $methodName;
}

// Verifica se o controlador existe
if (class_exists($controladorNome)) {
    $controlador = new $controladorNome();

    // Verifica se o método existe
    if (method_exists($controlador, $metodoNome)) {
        call_user_func_array([$controlador, $metodoNome], $parametros);
    } else {
        // Erro 404 - Método não encontrado
        echo "404 - Método não encontrado";
    }
} else {
    // Erro 404 - Controlador não encontrado
    echo "404 - Controlador não encontrado: $controladorNome";
}
