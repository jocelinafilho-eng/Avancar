<?php

class BaseDados {
    private static $instancia = null;
    private $conexao;

    private $host = 'localhost';
    private $db_name = 'avancar';
    private $username = 'root';
    private $password = '';

    private function __construct() {
        try {
            $this->conexao = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Erro de conexão: " . $e->getMessage();
        }
    }

    public static function obterInstancia() {
        if (self::$instancia === null) {
            self::$instancia = new self();
        }
        return self::$instancia;
    }

    public function getConexao() {
        return $this->conexao;
    }
}
