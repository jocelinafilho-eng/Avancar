<?php

class OnboardingControlador {
    private $db;

    public function __construct() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: /login');
            exit();
        }
        $database = BaseDados::obterInstancia();
        $this->db = $database->getConexao();
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
                $pilar = new Pilar($this->db);
                $pilar->usuario_id = $usuario_id;
                $pilar->nome = $nome_pilar;
                $pilar->tipo = 'obrigatorio';
                $pilar->cor = '#cccccc'; // Cor padrão
                $pilar->criar();
            }

            foreach ($pilares_opcionais as $nome_pilar) {
                $pilar = new Pilar($this->db);
                $pilar->usuario_id = $usuario_id;
                $pilar->nome = $nome_pilar;
                $pilar->tipo = 'opcional';
                $pilar->cor = '#6b46c1'; // Cor padrão para opcionais
                $pilar->criar();
            }

            // Criar hierarquia padrão para tarefas avulsas
            $pilar_geral = new Pilar($this->db);
            $pilar_geral->usuario_id = $usuario_id;
            $pilar_geral->nome = 'Geral';
            $pilar_geral->tipo = 'obrigatorio';
            $pilar_geral->cor = '#808080';
            $pilar_geral_id = $pilar_geral->criar();

            if ($pilar_geral_id) {
                $categoria_geral = new Categoria($this->db);
                $categoria_geral->pilar_id = $pilar_geral_id;
                $categoria_geral->nome = 'Tarefas Diárias';
                $categoria_geral_id = $categoria_geral->criar();

                if ($categoria_geral_id) {
                    $meta_geral = new Meta($this->db);
                    $meta_geral->usuario_id = $usuario_id;
                    $meta_geral->categoria_id = $categoria_geral_id;
                    $meta_geral->nome = 'Metas Gerais';
                    $meta_geral->data_inicio = date('Y-m-d');
                    $meta_geral->data_fim = date('Y-m-d', strtotime('+5 years'));
                    $meta_geral_id = $meta_geral->criar();

                    if ($meta_geral_id) {
                        $micrometa_geral = new MicroMeta($this->db);
                        $micrometa_geral->meta_id = $meta_geral_id;
                        $micrometa_geral->nome = 'Tarefas Avulsas';
                        $micrometa_geral->data_inicio = date('Y-m-d');
                        $micrometa_geral->data_fim = date('Y-m-d', strtotime('+5 years'));
                        $micrometa_geral->criar();
                    }
                }
            }

            // Marcar onboarding como concluído
            $usuario_modelo = new Usuario($this->db);
            $usuario_modelo->marcarOnboardingConcluido($usuario_id);

            header('Location: /dashboard');
            exit();
        }
    }

    private function render($view, $data = []) {
        $data['view'] = $view;
        include_once ROOT_PATH . '/vistas/layouts/onboarding.php';
    }
}
