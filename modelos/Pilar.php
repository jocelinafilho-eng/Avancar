<?php

class Pilar {
    private $conexao;
    private $tabela = 'pilar';

    public $id;
    public $usuario_id;
    public $nome;
    public $tipo;
    public $cor;
    public $data_criacao;

    public function __construct($bd) {
        $this->conexao = $bd;
    }

    public function lerPorUsuario($usuario_id) {
        $query = "SELECT id, nome, tipo, cor FROM " . $this->tabela . " WHERE usuario_id = :usuario_id ORDER BY nome ASC";

        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->execute();

        return $stmt;
    }

    public function criar() {
        $query = "INSERT INTO " . $this->tabela . " SET usuario_id = :usuario_id, nome = :nome, tipo = :tipo, cor = :cor";

        $stmt = $this->conexao->prepare($query);

        // Sanitização
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->tipo = htmlspecialchars(strip_tags($this->tipo));
        $this->cor = htmlspecialchars(strip_tags($this->cor));
        $this->usuario_id = htmlspecialchars(strip_tags($this->usuario_id));

        // Bind dos parâmetros
        $stmt->bindParam(':usuario_id', $this->usuario_id);
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':tipo', $this->tipo);
        $stmt->bindParam(':cor', $this->cor);

        if ($stmt->execute()) {
            return true;
        }

        printf("Erro: %s.\n", $stmt->error);

        return false;
    }

    // TODO: Implementar métodos para ler um, atualizar e deletar
}
