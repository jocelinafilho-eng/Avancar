<?php

class OnboardingControlador {
    private $db;
    private $pilar_modelo;

    public function __construct() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: /login');
            exit();
        }
        $database = BaseDados::obterInstancia();
        $this->db = $database->getConexao();
        $this->pilar_modelo = new Pilar($this->db);

        // TODO: Adicionar lógica para verificar se o onboarding já foi concluído
        // e redirecionar para o dashboard caso tenha sido.
    }

    public function index() {
        $this->render('onboarding');
    }

    public function salvar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario_id = $_SESSION['usuario_id'];

            $pilares_obrigatorios = ['Saúde', 'Educação', 'Finanças', 'Espiritualidade', 'Global/Básico'];
            $pilares_opcionais = $_POST['pilares_opcionais'] ?? [];

            foreach ($pilares_obrigatorios as $nome_pilar) {
                $this->pilar_modelo->usuario_id = $usuario_id;
                $this->pilar_modelo->nome = $nome_pilar;
                $this->pilar_modelo->tipo = 'obrigatorio';
                $this->pilar_modelo->cor = '#cccccc'; // Cor padrão
                $this->pilar_modelo->criar();
            }

            foreach ($pilares_opcionais as $nome_pilar) {
                $this->pilar_modelo->usuario_id = $usuario_id;
                $this->pilar_modelo->nome = $nome_pilar;
                $this->pilar_modelo->tipo = 'opcional';
                $this->pilar_modelo->cor = '#6b46c1'; // Cor padrão para opcionais
                $this->pilar_modelo->criar();
            }

            // TODO: Marcar onboarding como concluído no banco de dados

            header('Location: /dashboard');
            exit();
        }
    }

    private function render($view, $data = []) {
        $data['view'] = $view;
        // O layout principal é adequado por enquanto
        include_once ROOT_PATH . '/vistas/layouts/principal.php';
    }
}
