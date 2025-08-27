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

        $this->render('pilares', ['pilares' => $pilares]);
    }

    public function criar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->pilar_modelo->usuario_id = $_SESSION['usuario_id'];
            $this->pilar_modelo->nome = $_POST['nome'];
            $this->pilar_modelo->tipo = 'opcional'; // Por enquanto, apenas opcional
            $this->pilar_modelo->cor = $_POST['cor'];

            if ($this->pilar_modelo->criar()) {
                header('Location: /pilares');
                exit();
            } else {
                $this->render('pilares', ['erro' => 'Erro ao criar pilar.']);
            }
        }
    }

    private function render($view, $data = []) {
        $data['view'] = $view;
        extract($data);
        include_once ROOT_PATH . '/vistas/layouts/principal.php';
    }
}
