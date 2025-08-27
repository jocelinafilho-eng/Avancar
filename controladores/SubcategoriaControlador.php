<?php

class SubcategoriaControlador {
    private $db;
    private $subcategoria_modelo;

    public function __construct() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: /login');
            exit();
        }
        $database = BaseDados::obterInstancia();
        $this->db = $database->getConexao();
        $this->subcategoria_modelo = new Subcategoria($this->db);
    }

    public function criar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json');
            $this->subcategoria_modelo->categoria_id = $_POST['categoria_id'];
            $this->subcategoria_modelo->nome = $_POST['nome'];

            $nova_subcategoria_id = $this->subcategoria_modelo->criar();

            if ($nova_subcategoria_id) {
                echo json_encode([
                    'sucesso' => true,
                    'subcategoria' => [
                        'id' => $nova_subcategoria_id,
                        'nome' => $this->subcategoria_modelo->nome
                    ]
                ]);
            } else {
                echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao criar subcategoria.']);
            }
            exit();
        }
    }
}
