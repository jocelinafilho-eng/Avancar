<?php

class Tarefa {
    private $conexao;
    private $tabela = 'tarefa';

    public $id;
    public $micrometa_id;
    public $nome;
    public $tipo_temporal;
    public $periodo;
    public $hora_inicio;
    public $duracao_estimada;
    public $data_execucao;
    public $concluida;
    public $data_criacao;

    public function __construct($bd) {
        $this->conexao = $bd;
    }

    public function criar() {
        $query = "INSERT INTO " . $this->tabela . " SET micrometa_id = :micrometa_id, nome = :nome, tipo_temporal = :tipo_temporal, periodo = :periodo, hora_inicio = :hora_inicio, duracao_estimada = :duracao_estimada, data_execucao = :data_execucao";

        $stmt = $this->conexao->prepare($query);

        // Sanitização
        $this->micrometa_id = htmlspecialchars(strip_tags($this->micrometa_id));
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->tipo_temporal = htmlspecialchars(strip_tags($this->tipo_temporal));
        $this->periodo = htmlspecialchars(strip_tags($this->periodo));
        $this->hora_inicio = htmlspecialchars(strip_tags($this->hora_inicio));
        $this->duracao_estimada = htmlspecialchars(strip_tags($this->duracao_estimada));
        $this->data_execucao = htmlspecialchars(strip_tags($this->data_execucao));

        // Bind dos parâmetros
        $stmt->bindParam(':micrometa_id', $this->micrometa_id);
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':tipo_temporal', $this->tipo_temporal);
        $stmt->bindParam(':periodo', $this->periodo);
        $stmt->bindParam(':hora_inicio', $this->hora_inicio);
        $stmt->bindParam(':duracao_estimada', $this->duracao_estimada);
        $stmt->bindParam(':data_execucao', $this->data_execucao);

        if ($stmt->execute()) {
            return true;
        }

        printf("Erro: %s.\n", $stmt->error);

        return false;
    }

    public function lerPorDia($usuario_id, $dia) {
        // Esta query precisa ser mais complexa para buscar tarefas do usuário.
        // Por enquanto, vamos assumir uma junção (join) com micrometa e meta.
        $query = "
            SELECT t.* FROM " . $this->tabela . " t
            JOIN micrometa mm ON t.micrometa_id = mm.id
            JOIN meta m ON mm.meta_id = m.id
            WHERE m.usuario_id = :usuario_id AND t.data_execucao = :dia
        ";

        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->bindParam(':dia', $dia);
        $stmt->execute();

        return $stmt;
    }

    public function actualizarEstado($id, $concluida) {
        $query = "UPDATE " . $this->tabela . " SET concluida = :concluida WHERE id = :id";

        $stmt = $this->conexao->prepare($query);

        $id = htmlspecialchars(strip_tags($id));
        $concluida = htmlspecialchars(strip_tags($concluida));

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':concluida', $concluida);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // TODO: Implementar outros métodos CRUD e de busca
}
