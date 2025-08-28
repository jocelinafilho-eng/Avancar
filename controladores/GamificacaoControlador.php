<?php

class GamificacaoControlador {
    private $db;
    private $usuario_modelo;

    public function __construct() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: /login');
            exit();
        }
        $database = BaseDados::obterInstancia();
        $this->db = $database->getConexao();
        $this->usuario_modelo = new Usuario($this->db);
    }

    public function index() {
        // Adicionar um método para buscar por ID no modelo Usuario
        $usuario_info = $this->usuario_modelo->encontrarPorId($_SESSION['usuario_id']);

        // Adicionar um método para buscar badges do usuário
        // $badges = $this->gamificacao_modelo->lerBadgesPorUsuario($_SESSION['usuario_id']);

        $dados = [
            'pontos' => $usuario_info['pontos'] ?? 0,
            'nivel' => $usuario_info['nivel'] ?? 1,
            'badges' => [], // Mock por enquanto
            'titulo_pagina' => 'Gamificação',
            'icone_pagina' => 'fas fa-trophy'
        ];
        $this->render('gamificacao', $dados);
    }

    private function render($view, $data = []) {
        $data['view'] = $view;
        extract($data);
        include_once ROOT_PATH . '/vistas/layouts/principal.php';
    }
}
