<?php

class TarefaControlador {
    private $db;
    private $tarefa_modelo;

    public function __construct() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: /login');
            exit();
        }
        $database = BaseDados::obterInstancia();
        $this->db = $database->getConexao();
        $this->tarefa_modelo = new Tarefa($this->db);
    }

    public function criar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->tarefa_modelo->micrometa_id = $_POST['micrometa_id'];
            $this->tarefa_modelo->nome = $_POST['nome'];
            $this->tarefa_modelo->tipo_temporal = $_POST['tipo_temporal'];
            $this->tarefa_modelo->periodo = !empty($_POST['periodo']) ? $_POST['periodo'] : null;
            $this->tarefa_modelo->hora_inicio = !empty($_POST['hora_inicio']) ? $_POST['hora_inicio'] : null;
            $this->tarefa_modelo->duracao_estimada = $_POST['duracao_estimada'];
            $this->tarefa_modelo->data_execucao = $_POST['data_execucao'];

            // Validação Temporal
            if ($this->tarefa_modelo->tipo_temporal == 'hora_marcada') {
                $tarefas_do_dia = $this->tarefa_modelo->lerPorDia($_SESSION['usuario_id'], $this->tarefa_modelo->data_execucao)->fetchAll(PDO::FETCH_ASSOC);

                $nova_inicio = new DateTime($this->tarefa_modelo->hora_inicio);
                $nova_fim = (new DateTime($this->tarefa_modelo->hora_inicio))->add(new DateInterval('PT' . $this->tarefa_modelo->duracao_estimada . 'M'));

                foreach ($tarefas_do_dia as $tarefa_existente) {
                    if ($tarefa_existente['tipo_temporal'] == 'hora_marcada') {
                        $existente_inicio = new DateTime($tarefa_existente['hora_inicio']);
                        $existente_fim = (new DateTime($tarefa_existente['hora_inicio']))->add(new DateInterval('PT' . $tarefa_existente['duracao_estimada'] . 'M'));

                        if ($nova_inicio < $existente_fim && $nova_fim > $existente_inicio) {
                            // Conflito encontrado
                            header('Location: /planeamento?erro=conflito_horario');
                            exit();
                        }
                    }
                }
            }

            if ($this->tarefa_modelo->criar()) {
                header('Location: /planeamento'); // Redireciona para a página de planeamento
                exit();
            } else {
                // TODO: Melhorar tratamento de erro
                header('Location: /planeamento?erro=criar_tarefa');
                exit();
            }
        }
    }

    public function actualizarEstado() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_tarefa = $_POST['id_tarefa'];
            $concluida = $_POST['concluida'];

            // Adicionar método no modelo para atualizar
            if ($this->tarefa_modelo->actualizarEstado($id_tarefa, $concluida)) {
                // Idealmente, responder com JSON para AJAX
                echo json_encode(['sucesso' => true]);
            } else {
                echo json_encode(['sucesso' => false]);
            }
            exit();
        }
    }
}
