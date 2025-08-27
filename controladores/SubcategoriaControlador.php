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
            $this->subcategoria_modelo->categoria_id = $_POST['categoria_id'];
            $this->subcategoria_modelo->nome = $_POST['nome'];

            if ($this->subcategoria_modelo->criar()) {
                header('Location: /pilares'); // Redireciona de volta para a página de pilares
                exit();
            } else {
                // TODO: Melhorar tratamento de erro
                header('Location: /pilares?erro=criar_subcategoria');
                exit();
            }
        }
    }
}
