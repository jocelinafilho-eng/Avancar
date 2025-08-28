<?php

class PilarControlador {
    private $db;
    private $pilar_modelo;
    private $categoria_modelo;
    private $subcategoria_modelo;

    public function __construct() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: /login');
            exit();
        }
        $database = BaseDados::obterInstancia();
        $this->db = $database->getConexao();
        $this->pilar_modelo = new Pilar($this->db);
        $this->categoria_modelo = new Categoria($this->db);
        $this->subcategoria_modelo = new Subcategoria($this->db);
    }

    public function index() {
        $this->pilar_modelo->usuario_id = $_SESSION['usuario_id'];
        $stmt_pilares = $this->pilar_modelo->lerPorUsuario($_SESSION['usuario_id']);
        $pilares = $stmt_pilares->fetchAll(PDO::FETCH_ASSOC);

        foreach ($pilares as $key => $pilar) {
            $stmt_categorias = $this->categoria_modelo->lerPorPilar($pilar['id']);
            $categorias = $stmt_categorias->fetchAll(PDO::FETCH_ASSOC);

            foreach ($categorias as $cat_key => $categoria) {
                $stmt_subcategorias = $this->subcategoria_modelo->lerPorCategoria($categoria['id']);
                $subcategorias = $stmt_subcategorias->fetchAll(PDO::FETCH_ASSOC);
                $categorias[$cat_key]['subcategorias'] = $subcategorias;
            }

            $pilares[$key]['categorias'] = $categorias;
        }

        $dados = [
            'pilares' => $pilares,
            'titulo_pagina' => 'Pilares e Categorias',
            'icone_pagina' => 'fas fa-stream'
        ];
        $this->render('pilares', $dados);
    }

    public function criar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json');
            $this->pilar_modelo->usuario_id = $_SESSION['usuario_id'];
            $this->pilar_modelo->nome = $_POST['nome'] ?? '';
            $this->pilar_modelo->descricao = $_POST['descricao'] ?? '';
            $this->pilar_modelo->tipo = 'opcional'; // Apenas pilares opcionais podem ser criados pela UI
            $this->pilar_modelo->cor = $_POST['cor'] ?? '#cccccc';

            if (empty($this->pilar_modelo->nome)) {
                 echo json_encode(['sucesso' => false, 'mensagem' => 'O nome do pilar é obrigatório.']);
                 exit();
            }

            $novo_pilar_id = $this->pilar_modelo->criar();

            if ($novo_pilar_id) {
                // Retornar o pilar completo para ser adicionado à UI
                $pilar_criado = [
                    'id' => $novo_pilar_id,
                    'nome' => $this->pilar_modelo->nome,
                    'descricao' => $this->pilar_modelo->descricao,
                    'tipo' => $this->pilar_modelo->tipo,
                    'cor' => $this->pilar_modelo->cor,
                    'categorias' => [] // Um novo pilar não tem categorias
                ];
                echo json_encode(['sucesso' => true, 'pilar' => $pilar_criado]);
            } else {
                echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao criar pilar.']);
            }
            exit();
        }
    }

    private function render($view, $data = []) {
        $data['view'] = $view;
        extract($data);
        include_once ROOT_PATH . '/vistas/layouts/principal.php';
    }
}
