<?php

class MetaControlador {
    private $db;
    private $meta_modelo;
    private $micrometa_modelo;
    private $pilar_modelo; // Para buscar categorias

    public function __construct() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: /login');
            exit();
        }
        $database = BaseDados::obterInstancia();
        $this->db = $database->getConexao();
        $this->meta_modelo = new Meta($this->db);
        $this->micrometa_modelo = new MicroMeta($this->db);
        $this->pilar_modelo = new Pilar($this->db); // Reutilizando para buscar categorias
    }

    public function index() {
        $metas = $this->meta_modelo->lerPorUsuario($_SESSION['usuario_id'])->fetchAll(PDO::FETCH_ASSOC);

        foreach ($metas as $key => $meta) {
            $metas[$key]['micrometas'] = $this->micrometa_modelo->lerPorMeta($meta['id'])->fetchAll(PDO::FETCH_ASSOC);
        }

        // Para o formulário de criação de metas, precisamos de todas as categorias do usuário
        $pilares = $this->pilar_modelo->lerPorUsuario($_SESSION['usuario_id'])->fetchAll(PDO::FETCH_ASSOC);
        // ... (lógica para buscar categorias e subcategorias e passar para a view)

        $dados = [
            'metas' => $metas,
            'pilares' => $pilares,
            'titulo_pagina' => 'Metas',
            'icone_pagina' => 'fas fa-bullseye'
        ];
        $this->render('metas', $dados);
    }

    public function criar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json');
            $this->meta_modelo->usuario_id = $_SESSION['usuario_id'];
            $this->meta_modelo->categoria_id = $_POST['categoria_id'];
            $this->meta_modelo->subcategoria_id = !empty($_POST['subcategoria_id']) ? $_POST['subcategoria_id'] : null;
            $this->meta_modelo->nome = $_POST['nome'];
            $this->meta_modelo->data_inicio = $_POST['data_inicio'];
            $this->meta_modelo->data_fim = $_POST['data_fim'];

            $nova_meta_id = $this->meta_modelo->criar();

            if ($nova_meta_id) {
                echo json_encode(['sucesso' => true, 'meta' => ['id' => $nova_meta_id, 'nome' => $this->meta_modelo->nome]]);
            } else {
                echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao criar meta.']);
            }
            exit();
        }
    }

    public function criarMicro() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json');
            $this->micrometa_modelo->meta_id = $_POST['meta_id'];
            $this->micrometa_modelo->nome = $_POST['nome'];
            $this->micrometa_modelo->data_inicio = $_POST['data_inicio'];
            $this->micrometa_modelo->data_fim = $_POST['data_fim'];

            $nova_micrometa_id = $this->micrometa_modelo->criar();

            if ($nova_micrometa_id) {
                echo json_encode(['sucesso' => true, 'micrometa' => ['id' => $nova_micrometa_id, 'nome' => $this->micrometa_modelo->nome]]);
            } else {
                echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao criar micro-meta.']);
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
