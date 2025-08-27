<?php

class MicroMeta {
    private $conexao;
    private $tabela = 'micrometa';

    public $id;
    public $meta_id;
    public $nome;
    public $data_inicio;
    public $data_fim;
    public $concluida;
    public $data_criacao;

    public function __construct($bd) {
        $this->conexao = $bd;
    }

    public function lerPorMeta($meta_id) {
        $query = "SELECT * FROM " . $this->tabela . " WHERE meta_id = :meta_id ORDER BY data_fim ASC";

        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':meta_id', $meta_id);
        $stmt->execute();

        return $stmt;
    }

    public function criar() {
        $query = "INSERT INTO " . $this->tabela . " SET meta_id = :meta_id, nome = :nome, data_inicio = :data_inicio, data_fim = :data_fim";

        $stmt = $this->conexao->prepare($query);

        // Sanitização
        $this->nome = htmlspecialchars(strip_tags($this->nome));

        // Bind dos parâmetros
        $stmt->bindParam(':meta_id', $this->meta_id);
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
