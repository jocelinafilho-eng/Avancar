<?php

class TemplateTarefa {
    private $conexao;
    private $tabela = 'template_tarefa';

    public $id;
    public $usuario_id;
    public $nome_template;
    public $nome_tarefa;
    public $tipo_temporal;
    public $periodo;
    public $hora_inicio;
    public $duracao_estimada;

    public function __construct($bd) {
        $this->conexao = $bd;
    }

    public function criar() {
        $query = "INSERT INTO " . $this->tabela . " SET usuario_id = :usuario_id, nome_template = :nome_template, nome_tarefa = :nome_tarefa, tipo_temporal = :tipo_temporal, periodo = :periodo, hora_inicio = :hora_inicio, duracao_estimada = :duracao_estimada";

        $stmt = $this->conexao->prepare($query);

        // Sanitização
        $this->usuario_id = htmlspecialchars(strip_tags($this->usuario_id));
        $this->nome_template = htmlspecialchars(strip_tags($this->nome_template));
        $this->nome_tarefa = htmlspecialchars(strip_tags($this->nome_tarefa));
        $this->tipo_temporal = htmlspecialchars(strip_tags($this->tipo_temporal));
        $this->periodo = htmlspecialchars(strip_tags($this->periodo));
        $this->hora_inicio = htmlspecialchars(strip_tags($this->hora_inicio));
        $this->duracao_estimada = htmlspecialchars(strip_tags($this->duracao_estimada));

        // Bind dos parâmetros
        $stmt->bindParam(':usuario_id', $this->usuario_id);
        $stmt->bindParam(':nome_template', $this->nome_template);
        $stmt->bindParam(':nome_tarefa', $this->nome_tarefa);
        $stmt->bindParam(':tipo_temporal', $this->tipo_temporal);
        $stmt->bindParam(':periodo', $this->periodo);
        $stmt->bindParam(':hora_inicio', $this->hora_inicio);
        $stmt->bindParam(':duracao_estimada', $this->duracao_estimada);

        if ($stmt->execute()) {
            return true;
        }

        printf("Erro: %s.\n", $stmt->error);

        return false;
    }
}
