<?php

class ProgressoControlador {
    private $db;
    // Futuramente, um modelo de Progresso dedicado
    private $pilar_modelo;

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
        $stmt = $this->pilar_modelo->obterEstatisticasPorPilar($_SESSION['usuario_id']);
        $stats = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $dados_grafico = [
            'labels' => [],
            'dados_concluidas' => [],
            'dados_totais' => [],
            'cores' => []
        ];

        foreach($stats as $stat) {
            $dados_grafico['labels'][] = $stat['nome'];
            $dados_grafico['dados_concluidas'][] = $stat['tarefas_concluidas'];
            $dados_grafico['dados_totais'][] = $stat['total_tarefas'];
            $dados_grafico['cores'][] = $stat['cor'];
        }

        $this->render('progresso', [
            'dados_grafico' => $dados_grafico
        ]);
    }

    private function render($view, $data = []) {
        $data['view'] = $view;
        extract($data);
        include_once ROOT_PATH . '/vistas/layouts/principal.php';
    }
}
