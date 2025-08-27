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
    }

    public function index() {
        $mes = isset($_GET['mes']) ? (int)$_GET['mes'] : date('m');
        $ano = isset($_GET['ano']) ? (int)$_GET['ano'] : date('Y');

        $stmt = $this->tarefa_modelo->lerPorMes($_SESSION['usuario_id'], $mes, $ano);
        $tarefas_raw = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $tarefas = [];
        foreach ($tarefas_raw as $t) {
            $dia = (new DateTime($t['data_execucao']))->format('j');
            $tarefas[$dia] = $t['num_tarefas'];
        }

        $this->render('calendario', [
            'mes' => $mes,
            'ano' => $ano,
            'tarefas' => $tarefas
        ]);
    }

    private function render($view, $data = []) {
        $data['view'] = $view;
        extract($data);
        include_once ROOT_PATH . '/vistas/layouts/principal.php';
    }
}
