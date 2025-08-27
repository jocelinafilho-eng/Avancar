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
        // Lógica para buscar dados de progresso
        // Esta lógica será complexa e precisará de queries dedicadas no futuro.
        // Por agora, vamos passar dados mockados para o Chart.js

        $pilares = $this->pilar_modelo->lerPorUsuario($_SESSION['usuario_id'])->fetchAll(PDO::FETCH_ASSOC);
        $dados_grafico = [
            'labels' => [],
            'dados' => []
        ];

        foreach($pilares as $pilar) {
            $dados_grafico['labels'][] = $pilar['nome'];
            // Valor mockado de progresso
            $dados_grafico['dados'][] = rand(10, 100);
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
