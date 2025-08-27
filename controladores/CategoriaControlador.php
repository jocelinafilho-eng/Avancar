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
            $this->categoria_modelo->pilar_id = $_POST['pilar_id'];
            $this->categoria_modelo->nome = $_POST['nome'];

            if ($this->categoria_modelo->criar()) {
                header('Location: /pilares'); // Redireciona de volta para a página de pilares
                exit();
            } else {
                // TODO: Melhorar tratamento de erro
                header('Location: /pilares?erro=criar_categoria');
                exit();
            }
        }
    }
}
