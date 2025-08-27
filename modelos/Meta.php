<?php

class Meta {
    private $conexao;
    private $tabela = 'meta';

    public $id;
    public $usuario_id;
    public $categoria_id;
    public $subcategoria_id;
    public $nome;
    public $data_inicio;
    public $data_fim;
    public $progresso;
    public $data_criacao;

    public function __construct($bd) {
        $this->conexao = $bd;
    }

    public function lerPorUsuario($usuario_id) {
        $query = "SELECT * FROM " . $this->tabela . " WHERE usuario_id = :usuario_id ORDER BY data_fim ASC";

        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->execute();

        return $stmt;
    }

    public function criar() {
        $query = "INSERT INTO " . $this->tabela . " SET usuario_id = :usuario_id, categoria_id = :categoria_id, subcategoria_id = :subcategoria_id, nome = :nome, data_inicio = :data_inicio, data_fim = :data_fim";

        $stmt = $this->conexao->prepare($query);

        // Sanitização
        $this->nome = htmlspecialchars(strip_tags($this->nome));

        // Bind dos parâmetros
        $stmt->bindParam(':usuario_id', $this->usuario_id);
        $stmt->bindParam(':categoria_id', $this->categoria_id);
        $stmt->bindParam(':subcategoria_id', $this->subcategoria_id);
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':data_inicio', $this->data_inicio);
        $stmt->bindParam(':data_fim', $this->data_fim);

        if ($stmt->execute()) {
            return true;
        }

        printf("Erro: %s.\n", $stmt->error);

        return false;
    }
}
