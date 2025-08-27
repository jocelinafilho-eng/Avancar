<?php

class DiaControlador {
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
        $hoje = date('Y-m-d');
        $tarefas = $this->tarefa_modelo->lerPorDia($_SESSION['usuario_id'], $hoje);

        $tarefas_organizadas = [
            'hora_marcada' => [],
            'manha' => [],
            'tarde' => [],
            'noite' => [],
            'arbitraria' => []
        ];

        while ($tarefa = $tarefas->fetch(PDO::FETCH_ASSOC)) {
            if ($tarefa['tipo_temporal'] == 'hora_marcada') {
                $tarefas_organizadas['hora_marcada'][] = $tarefa;
            } elseif ($tarefa['tipo_temporal'] == 'periodo') {
                $tarefas_organizadas[$tarefa['periodo']][] = $tarefa;
            } else {
                $tarefas_organizadas['arbitraria'][] = $tarefa;
            }
        }

        // Ordenar tarefas com hora marcada
        usort($tarefas_organizadas['hora_marcada'], function($a, $b) {
            return strcmp($a['hora_inicio'], $b['hora_inicio']);
        });

        $this->render('dia', ['tarefas' => $tarefas_organizadas]);
    }

    private function render($view, $data = []) {
        $data['view'] = $view;
        extract($data);
        include_once ROOT_PATH . '/vistas/layouts/principal.php';
    }
}
