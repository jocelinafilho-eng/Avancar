<?php

class CategoriaControlador {
    private $db;
    private $categoria_modelo;

    public function __construct() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: /login');
            exit();
        }
        $database = BaseDados::obterInstancia();
        $this->db = $database->getConexao();
        $this->categoria_modelo = new Categoria($this->db);
    }

    public function criar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json');
            $this->categoria_modelo->pilar_id = $_POST['pilar_id'];
            $this->categoria_modelo->nome = $_POST['nome'];

            $nova_categoria_id = $this->categoria_modelo->criar();

            if ($nova_categoria_id) {
                echo json_encode([
                    'sucesso' => true,
                    'categoria' => [
                        'id' => $nova_categoria_id,
                        'nome' => $this->categoria_modelo->nome,
                        'subcategorias' => []
                    ]
                ]);
            } else {
                echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao criar categoria.']);
            }
            exit();
        }
    }
}
