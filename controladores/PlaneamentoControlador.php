<?php

class PlaneamentoControlador {
    private $db;
    private $meta_modelo;

    public function __construct() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: /login');
            exit();
        }
        $database = BaseDados::obterInstancia();
        $this->db = $database->getConexao();
        $this->meta_modelo = new Meta($this->db);
    }

    public function index() {
        // Para o planeamento, precisamos de todas as metas e micrometas do usuário
        $metas = $this->meta_modelo->lerPorUsuario($_SESSION['usuario_id'])->fetchAll(PDO::FETCH_ASSOC);
        // A lógica para buscar micrometas associadas já está no MetaControlador,
        // mas idealmente seria refatorada para um serviço ou para os próprios modelos.
        // Por agora, manteremos simples.

        $this->render('planeamento', ['metas' => $metas]);
    }

    public function salvar() {
        // A lógica para salvar um plano semanal inteiro seria complexa.
        // Envolveria receber um array de tarefas e criar cada uma.
        // Deixaremos como TODO para uma implementação mais detalhada.
        header('Location: /dia');
        exit();
    }

    private function render($view, $data = []) {
        $data['view'] = $view;
        extract($data);
        include_once ROOT_PATH . '/vistas/layouts/principal.php';
    }
}
