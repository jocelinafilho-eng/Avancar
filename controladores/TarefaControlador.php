<?php

class TarefaControlador {
    private $db;
    private $tarefa_modelo;
    private $gamificacao_modelo;

    public function __construct() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: /login');
            exit();
        }
        $database = BaseDados::obterInstancia();
        $this->db = $database->getConexao();
        $this->tarefa_modelo = new Tarefa($this->db);
        $this->gamificacao_modelo = new Gamificacao($this->db);
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

            if ($this->tarefa_modelo->actualizarEstado($id_tarefa, $concluida)) {
                if ($concluida) {
                    // Adicionar 10 pontos por tarefa concluída
                    $this->gamificacao_modelo->adicionarPontos($_SESSION['usuario_id'], 10);
                }
                echo json_encode(['sucesso' => true]);
            } else {
                echo json_encode(['sucesso' => false]);
            }
            exit();
        }
    }

    public function criarParaHoje() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['sucesso' => false, 'erro' => 'Método não permitido.']);
            exit();
        }

        $this->tarefa_modelo->nome = $_POST['nome'];
        $this->tarefa_modelo->tipo_temporal = $_POST['tipo_temporal'];
        $this->tarefa_modelo->periodo = !empty($_POST['periodo']) ? $_POST['periodo'] : null;
        $this->tarefa_modelo->hora_inicio = !empty($_POST['hora_inicio']) ? $_POST['hora_inicio'] : null;
        $this->tarefa_modelo->duracao_estimada = !empty($_POST['duracao_estimada']) ? $_POST['duracao_estimada'] : 30;
        $this->tarefa_modelo->data_execucao = $_POST['data_execucao'];
        $this->tarefa_modelo->usuario_id = $_SESSION['usuario_id'];
        $this->tarefa_modelo->micrometa_id = null; // Tarefas do dia não estão ligadas a micrometas por agora

        // Validação básica
        if (empty($this->tarefa_modelo->nome) || empty($this->tarefa_modelo->tipo_temporal) || empty($this->tarefa_modelo->data_execucao)) {
            echo json_encode(['sucesso' => false, 'erro' => 'Dados incompletos.']);
            exit();
        }

        // Validação Temporal
        if ($this->tarefa_modelo->tipo_temporal == 'hora_marcada') {
             if (empty($this->tarefa_modelo->hora_inicio)) {
                echo json_encode(['sucesso' => false, 'erro' => 'Hora de início é obrigatória para tarefas com hora marcada.']);
                exit();
            }
            $tarefas_do_dia = $this->tarefa_modelo->lerPorDia($_SESSION['usuario_id'], $this->tarefa_modelo->data_execucao)->fetchAll(PDO::FETCH_ASSOC);
            $nova_inicio = new DateTime($this->tarefa_modelo->hora_inicio);
            $nova_fim = (new DateTime($this->tarefa_modelo->hora_inicio))->add(new DateInterval('PT' . $this->tarefa_modelo->duracao_estimada . 'M'));

            foreach ($tarefas_do_dia as $tarefa_existente) {
                if ($tarefa_existente['tipo_temporal'] == 'hora_marcada' && $tarefa_existente['hora_inicio']) {
                    $existente_inicio = new DateTime($tarefa_existente['hora_inicio']);
                    $existente_fim = (new DateTime($tarefa_existente['hora_inicio']))->add(new DateInterval('PT' . $tarefa_existente['duracao_estimada'] . 'M'));
                    if ($nova_inicio < $existente_fim && $nova_fim > $existente_inicio) {
                        echo json_encode(['sucesso' => false, 'erro' => 'Conflito de horário com outra tarefa.']);
                        exit();
                    }
                }
            }
        }

        if ($id = $this->tarefa_modelo->criar()) {
            $nova_tarefa = $this->tarefa_modelo->lerPorId($id);
            echo json_encode(['sucesso' => true, 'tarefa' => $nova_tarefa]);
        } else {
            echo json_encode(['sucesso' => false, 'erro' => 'Erro ao guardar a tarefa na base de dados.']);
        }
        exit();
    }

    public function remover() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { // Usando POST por simplicidade com FormData
            http_response_code(405);
            echo json_encode(['sucesso' => false, 'erro' => 'Método não permitido.']);
            exit();
        }

        $id_tarefa = $_POST['id_tarefa'];
        $tarefa = $this->tarefa_modelo->lerPorId($id_tarefa);

        if (!$tarefa || $tarefa['usuario_id'] != $_SESSION['usuario_id']) {
            http_response_code(403); // Forbidden
            echo json_encode(['sucesso' => false, 'erro' => 'Não autorizado.']);
            exit();
        }

        if ($this->tarefa_modelo->remover($id_tarefa)) {
            echo json_encode(['sucesso' => true]);
        } else {
            echo json_encode(['sucesso' => false, 'erro' => 'Erro ao remover a tarefa.']);
        }
        exit();
    }
}
