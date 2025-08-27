<?php

class ConfiguracaoControlador {

    public function __construct() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: /login');
            exit();
        }
    }

    public function index() {
        $this->render('configuracoes');
    }

    private function render($view, $data = []) {
        $data['view'] = $view;
        extract($data);
        include_once ROOT_PATH . '/vistas/layouts/principal.php';
    }
}
