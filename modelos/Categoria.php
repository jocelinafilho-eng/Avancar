<?php

class Categoria {
    private $conexao;
    private $tabela = 'categoria';

    public $id;
    public $pilar_id;
    public $nome;
    public $data_criacao;

    public function __construct($bd) {
        $this->conexao = $bd;
    }

    public function lerPorPilar($pilar_id) {
        $query = "SELECT id, nome FROM " . $this->tabela . " WHERE pilar_id = :pilar_id ORDER BY nome ASC";

        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':pilar_id', $pilar_id);
        $stmt->execute();

        return $stmt;
    }

    public function criar() {
        $query = "INSERT INTO " . $this->tabela . " SET pilar_id = :pilar_id, nome = :nome";

        $stmt = $this->conexao->prepare($query);

        // Sanitização
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->pilar_id = htmlspecialchars(strip_tags($this->pilar_id));

        // Bind dos parâmetros
        $stmt->bindParam(':pilar_id', $this->pilar_id);
        $stmt->bindParam(':nome', $this->nome);

        if ($stmt->execute()) {
            return true;
        }

        printf("Erro: %s.\n", $stmt->error);

        return false;
    }
}
