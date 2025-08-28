<?php

class PerfilControlador {
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
        $usuario_info = $this->usuario_modelo->encontrarPorId($_SESSION['usuario_id']);

        if (!$usuario_info) {
            // Se não encontrar o usuário no banco de dados, algo está errado com a sessão.
            // Forçar logout para segurança.
            session_unset();
            session_destroy();
            header('Location: /login?erro=sessao_invalida');
            exit();
        }

        $dados = [
            'usuario' => $usuario_info,
            'titulo_pagina' => 'Perfil do Utilizador',
            'icone_pagina' => 'fas fa-user-circle'
        ];
        $this->render('perfil', $dados);
    }

    private function render($view, $data = []) {
        $data['view'] = $view;
        extract($data);
        include_once ROOT_PATH . '/vistas/layouts/principal.php';
    }
}
