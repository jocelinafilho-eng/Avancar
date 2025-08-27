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
        <!-- Placeholder para estatísticas dos pilares -->
        <div class="card pilar-card">
            <div class="card-body">
                <h4>Saúde</h4>
                <p>Nenhum progresso ainda.</p>
            </div>
        </div>
        <div class="card pilar-card">
            <div class="card-body">
                <h4>Educação</h4>
                <p>Nenhum progresso ainda.</p>
            </div>
        </div>
        <div class="card pilar-card">
            <div class="card-body">
                <h4>Finanças</h4>
                <p>Nenhum progresso ainda.</p>
            </div>
        </div>
        <!-- Outros pilares aqui -->
    </div>
</div>
