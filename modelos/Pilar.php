<?php

class Pilar {
    private $conexao;
    private $tabela = 'pilar';

    public $id;
    public $usuario_id;
    public $nome;
    public $descricao;
    public $tipo;
    public $cor;
    public $data_criacao;

    public function __construct($bd) {
        $this->conexao = $bd;
    }

    public function lerPorUsuario($usuario_id) {
        $query = "SELECT id, nome, descricao, tipo, cor FROM " . $this->tabela . " WHERE usuario_id = :usuario_id ORDER BY nome ASC";

        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->execute();

        return $stmt;
    }

    public function criar() {
        $query = "INSERT INTO " . $this->tabela . " SET usuario_id = :usuario_id, nome = :nome, descricao = :descricao, tipo = :tipo, cor = :cor";

        $stmt = $this->conexao->prepare($query);

        // Sanitização
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->descricao = htmlspecialchars(strip_tags($this->descricao));
        $this->tipo = htmlspecialchars(strip_tags($this->tipo));
        $this->cor = htmlspecialchars(strip_tags($this->cor));

        // Bind dos parâmetros
        $stmt->bindParam(':usuario_id', $this->usuario_id);
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':descricao', $this->descricao);
        $stmt->bindParam(':tipo', $this->tipo);
        $stmt->bindParam(':cor', $this->cor);

        if ($stmt->execute()) {
            return $this->conexao->lastInsertId();
        }

        printf("Erro: %s.\n", $stmt->error);

        return false;
    }

    public function obterEstatisticasPorPilar($usuario_id) {
        $query = "
            SELECT
                p.nome,
                p.cor,
                COUNT(t.id) as total_tarefas,
                SUM(CASE WHEN t.concluida = 1 THEN 1 ELSE 0 END) as tarefas_concluidas
            FROM pilar p
            LEFT JOIN categoria c ON p.id = c.pilar_id
            LEFT JOIN meta m ON c.id = m.categoria_id
            LEFT JOIN micrometa mm ON m.id = mm.meta_id
            LEFT JOIN tarefa t ON mm.id = t.micrometa_id
            WHERE p.usuario_id = :usuario_id
            GROUP BY p.id
            ORDER BY p.nome
        ";

        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->execute();

        return $stmt;
    }

    // TODO: Implementar métodos para ler um, atualizar e deletar
}
