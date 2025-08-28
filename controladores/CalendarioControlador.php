<?php

class CalendarioControlador {
    private $db;
    private $tarefa_modelo;

    public function __construct() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: /login');
            exit();
        }
        $database = BaseDados::obterInstancia();
        $this->db = $database->getConexao();
        $this->tarefa_modelo = new Tarefa($this->db);
        $this->meta_modelo = new Meta($this->db);
    }

    public function index() {
        $mes = isset($_GET['mes']) ? (int)$_GET['mes'] : date('m');
        $ano = isset($_GET['ano']) ? (int)$_GET['ano'] : date('Y');
        $meta_id = isset($_GET['meta_id']) && !empty($_GET['meta_id']) ? (int)$_GET['meta_id'] : null;

        // Buscar tarefas para o calendário
        $stmt = $this->tarefa_modelo->lerPorMes($_SESSION['usuario_id'], $mes, $ano, $meta_id);
        $tarefas_raw = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $tarefas = [];
        foreach ($tarefas_raw as $t) {
            $dia = (new DateTime($t['data_execucao']))->format('j');
            $tarefas[$dia] = $t['num_tarefas'];
        }

        // Buscar todas as metas para o filtro
        $metas_filtro = $this->meta_modelo->lerPorUsuario($_SESSION['usuario_id'])->fetchAll(PDO::FETCH_ASSOC);

        $dados = [
            'mes' => $mes,
            'ano' => $ano,
            'tarefas' => $tarefas,
            'metas_filtro' => $metas_filtro,
            'meta_id_selecionada' => $meta_id,
            'titulo_pagina' => 'Calendário',
            'icone_pagina' => 'fas fa-calendar-alt'
        ];
        $this->render('calendario', $dados);
    }

    private function render($view, $data = []) {
        $data['view'] = $view;
        extract($data);
        include_once ROOT_PATH . '/vistas/layouts/principal.php';
    }
}
