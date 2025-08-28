<?php

class DashboardControlador {
    public function __construct() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: /login');
            exit();
        }
        $database = BaseDados::obterInstancia();
        $this->db = $database->getConexao();
        $this->pilar_modelo = new Pilar($this->db);
    }

    public function index() {
        $stats_pilares = $this->pilar_modelo->obterEstatisticasPorPilar($_SESSION['usuario_id'])->fetchAll(PDO::FETCH_ASSOC);

        $dados = [
            'titulo_pagina' => 'Dashboard',
            'icone_pagina' => 'fas fa-tachometer-alt',
            'stats_pilares' => $stats_pilares
        ];
        $this->render('dashboard', $dados);
    }

    private function render($view, $data = []) {
        $data['view'] = $view;
        extract($data);
        include_once ROOT_PATH . '/vistas/layouts/principal.php';
    }
}
