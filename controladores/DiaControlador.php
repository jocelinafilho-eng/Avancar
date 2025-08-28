<?php

class DiaControlador {
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
        $this->pilar_modelo = new Pilar($this->db);
        $this->categoria_modelo = new Categoria($this->db);
        $this->meta_modelo = new Meta($this->db);
        $this->micrometa_modelo = new MicroMeta($this->db);
    }

    public function index() {
        // Buscar tarefas do dia
        $hoje = date('Y-m-d');
        $tarefas = $this->tarefa_modelo->lerPorDia($_SESSION['usuario_id'], $hoje);

        $tarefas_organizadas = [
            'hora_marcada' => [],
            'manha' => [],
            'tarde' => [],
            'noite' => [],
            'arbitraria' => []
        ];

        while ($tarefa = $tarefas->fetch(PDO::FETCH_ASSOC)) {
            if ($tarefa['tipo_temporal'] == 'hora_marcada') {
                $tarefas_organizadas['hora_marcada'][] = $tarefa;
            } elseif ($tarefa['tipo_temporal'] == 'periodo') {
                $tarefas_organizadas[$tarefa['periodo']][] = $tarefa;
            } else {
                $tarefas_organizadas['arbitraria'][] = $tarefa;
            }
        }

        // Ordenar tarefas com hora marcada
        usort($tarefas_organizadas['hora_marcada'], function($a, $b) {
            return strcmp($a['hora_inicio'], $b['hora_inicio']);
        });

        // Buscar hierarquia completa para o formulário
        $pilares = $this->pilar_modelo->lerPorUsuario($_SESSION['usuario_id'])->fetchAll(PDO::FETCH_ASSOC);
        foreach ($pilares as $p_key => $pilar) {
            $categorias = $this->categoria_modelo->lerPorPilar($pilar['id'])->fetchAll(PDO::FETCH_ASSOC);
            foreach ($categorias as $c_key => $categoria) {
                $metas = $this->meta_modelo->lerPorCategoria($categoria['id'])->fetchAll(PDO::FETCH_ASSOC);
                foreach ($metas as $m_key => $meta) {
                    $micrometas = $this->micrometa_modelo->lerPorMeta($meta['id'])->fetchAll(PDO::FETCH_ASSOC);
                    $metas[$m_key]['micrometas'] = $micrometas;
                }
                $categorias[$c_key]['metas'] = $metas;
            }
            $pilares[$p_key]['categorias'] = $categorias;
        }

        $dados = [
            'tarefas' => $tarefas_organizadas,
            'pilares' => $pilares, // Passa a hierarquia completa para a view
            'titulo_pagina' => 'Página do Dia',
            'icone_pagina' => 'fas fa-calendar-day'
        ];

        $this->render('dia', $dados);
    }

    private function render($view, $data = []) {
        $data['view'] = $view;
        extract($data);
        include_once ROOT_PATH . '/vistas/layouts/principal.php';
    }
}
