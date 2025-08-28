<div class="dashboard-cabecalho">
    <h1>Bem-vindo, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>!</h1>
    <p>Aqui está um resumo do seu avanço.</p>
</div>

<div class="dashboard-grid">
    <div class="card card-tarefas-dia">
        <div class="card-header">
            <h3><i class="fas fa-calendar-day"></i> Tarefas de Hoje</h3>
        </div>
        <div class="card-body">
            <!-- Placeholder para tarefas do dia -->
            <p>Nenhuma tarefa para hoje. Planeie a sua semana!</p>
        </div>
    </div>

    <div class="card card-progresso-geral">
        <div class="card-header">
            <h3><i class="fas fa-chart-line"></i> Progresso Geral</h3>
        </div>
        <div class="card-body">
            <!-- Placeholder para progresso geral -->
            <p>O seu progresso aparecerá aqui.</p>
        </div>
    </div>

    <div class="card card-alertas">
        <div class="card-header">
            <h3><i class="fas fa-bell"></i> Alertas e Notificações</h3>
        </div>
        <div class="card-body">
            <!-- Placeholder para alertas -->
            <p>Nenhuma notificação nova.</p>
        </div>
    </div>

    <div class="card card-tarefas-urgentes">
        <div class="card-header">
            <h3><i class="fas fa-exclamation-triangle"></i> Tarefas Urgentes</h3>
        </div>
        <div class="card-body">
            <!-- Placeholder para tarefas urgentes -->
            <p>Nenhuma tarefa urgente.</p>
        </div>
    </div>
</div>

<div class="dashboard-pilares">
    <h3><i class="fas fa-columns"></i> Estatísticas por Pilar</h3>
    <div class="pilares-grid">
        <?php if (isset($stats_pilares) && count($stats_pilares) > 0): ?>
            <?php foreach ($stats_pilares as $pilar_stat): ?>
                <div class="card pilar-card" style="border-left: 4px solid <?php echo htmlspecialchars($pilar_stat['cor']); ?>">
                    <div class="card-body">
                        <h4><?php echo htmlspecialchars($pilar_stat['nome']); ?></h4>
                        <p>
                            <?php if ($pilar_stat['total_tarefas'] > 0): ?>
                                <strong><?php echo $pilar_stat['tarefas_concluidas']; ?></strong> de
                                <strong><?php echo $pilar_stat['total_tarefas']; ?></strong> tarefas concluídas.
                            <?php else: ?>
                                Nenhuma tarefa associada ainda.
                            <?php endif; ?>
                        </p>
                        <?php
                            $progresso = ($pilar_stat['total_tarefas'] > 0) ? ($pilar_stat['tarefas_concluidas'] / $pilar_stat['total_tarefas']) * 100 : 0;
                        ?>
                        <div class="barra-progresso">
                            <div class="barra-progresso-preenchimento" style="width: <?php echo $progresso; ?>%; background-color: <?php echo htmlspecialchars($pilar_stat['cor']); ?>;"></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="sem-dados">Nenhuma estatística de pilar para mostrar. Comece a adicionar metas e tarefas!</p>
        <?php endif; ?>
    </div>
</div>
