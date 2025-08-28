<?php

class ConfiguracaoControlador {

    public function __construct() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: /login');
            exit();
        }
    }

    public function index() {
        $dados = [
            'titulo_pagina' => 'Configurações',
            'icone_pagina' => 'fas fa-cog'
        ];
        $this->render('configuracoes', $dados);
    }

    private function render($view, $data = []) {
        $data['view'] = $view;
        extract($data);
        include_once ROOT_PATH . '/vistas/layouts/principal.php';
    }
}
