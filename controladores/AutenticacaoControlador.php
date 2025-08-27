<?php

class AutenticacaoControlador {
    private $db;
    private $usuario_modelo;

    public function __construct() {
        $database = BaseDados::obterInstancia();
        $this->db = $database->getConexao();
        $this->usuario_modelo = new Usuario($this->db);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Processar formulário de login
            $this->processarLogin();
        } else {
            // Mostrar página de login
            $this->mostrarPagina('login');
        }
    }

    public function registo() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Processar formulário de registo
            $this->processarRegisto();
        } else {
            // Mostrar página de registo
            $this->mostrarPagina('registo');
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        header('Location: /login');
        exit();
    }

    private function processarLogin() {
        $email = $_POST['email'] ?? '';
        $palavra_passe = $_POST['palavra_passe'] ?? '';

        $usuario = $this->usuario_modelo->encontrarPorEmail($email);

        if ($usuario && password_verify($palavra_passe, $usuario['palavra_passe'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            header('Location: /dashboard');
            exit();
        } else {
            // Erro de login
            $this->mostrarPagina('login', ['erro' => 'Email ou palavra-passe inválidos.']);
        }
    }

    private function processarRegisto() {
        $this->usuario_modelo->nome = $_POST['nome'] ?? '';
        $this->usuario_modelo->email = $_POST['email'] ?? '';
        $this->usuario_modelo->palavra_passe = $_POST['palavra_passe'] ?? '';
        $confirmar_palavra_passe = $_POST['confirmar_palavra_passe'] ?? '';

        // Validação simples
        if (empty($this->usuario_modelo->nome) || empty($this->usuario_modelo->email) || empty($this->usuario_modelo->palavra_passe) || empty($confirmar_palavra_passe)) {
            $this->mostrarPagina('registo', ['erro' => 'Todos os campos são obrigatórios.']);
            return;
        }

        if (strlen($this->usuario_modelo->palavra_passe) < 8) {
            $this->mostrarPagina('registo', ['erro' => 'A palavra-passe deve ter pelo menos 8 caracteres.']);
            return;
        }

        if ($this->usuario_modelo->palavra_passe !== $confirmar_palavra_passe) {
            $this->mostrarPagina('registo', ['erro' => 'As palavras-passe não correspondem.']);
            return;
        }

        if (!filter_var($this->usuario_modelo->email, FILTER_VALIDATE_EMAIL)) {
            $this->mostrarPagina('registo', ['erro' => 'Formato de email inválido.']);
            return;
        }

        if ($this->usuario_modelo->encontrarPorEmail($this->usuario_modelo->email)) {
            $this->mostrarPagina('registo', ['erro' => 'Este email já está em uso.']);
            return;
        }

        // Hash da palavra-passe
        $this->usuario_modelo->palavra_passe = password_hash($this->usuario_modelo->palavra_passe, PASSWORD_DEFAULT);

        if ($this->usuario_modelo->criar()) {
            header('Location: /login');
            exit();
        } else {
            $this->mostrarPagina('registo', ['erro' => 'Ocorreu um erro ao criar a conta.']);
        }
    }

    private function mostrarPagina($view, $dados = []) {
        $data = $dados;
        $data['view'] = $view;
        if ($view == 'login') {
            $data['titulo'] = 'Login';
        } else {
            $data['titulo'] = 'Registo';
        }
        extract($data);
        include_once ROOT_PATH . '/vistas/layouts/autenticacao.php';
    }
}
