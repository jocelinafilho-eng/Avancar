<?php

class Subcategoria {
    private $conexao;
    private $tabela = 'subcategoria';

    public $id;
    public $categoria_id;
    public $nome;
    public $data_criacao;

    public function __construct($bd) {
        $this->conexao = $bd;
    }

    public function lerPorCategoria($categoria_id) {
        $query = "SELECT id, nome FROM " . $this->tabela . " WHERE categoria_id = :categoria_id ORDER BY nome ASC";

        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':categoria_id', $categoria_id);
        $stmt->execute();

        return $stmt;
    }

    public function criar() {
        $query = "INSERT INTO " . $this->tabela . " SET categoria_id = :categoria_id, nome = :nome";

        $stmt = $this->conexao->prepare($query);

        // Sanitização
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->categoria_id = htmlspecialchars(strip_tags($this->categoria_id));

        // Bind dos parâmetros
        $stmt->bindParam(':categoria_id', $this->categoria_id);
        $stmt->bindParam(':nome', $this->nome);

        if ($stmt->execute()) {
            return true;
        }

        printf("Erro: %s.\n", $stmt->error);

        return false;
    }
}
