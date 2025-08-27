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

        $this->render('perfil', ['usuario' => $usuario_info]);
    }

    private function render($view, $data = []) {
        $data['view'] = $view;
        extract($data);
        include_once ROOT_PATH . '/vistas/layouts/principal.php';
    }
}
