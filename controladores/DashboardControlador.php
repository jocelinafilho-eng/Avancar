<?php

class DashboardControlador {
    public function __construct() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: /login');
            exit();
        }
    }

    public function index() {
        $this->render('dashboard');
    }

    private function render($view, $dados = []) {
        $data = $dados;
        include_once ROOT_PATH . '/vistas/layouts/principal.php';
    }
}
