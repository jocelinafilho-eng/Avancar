<div class="dashboard-cabecalho">
    <h1><i class="fas fa-trophy"></i> Gamificação</h1>
    <p>Veja o seu progresso e conquistas.</p>
</div>

<div class="gamificacao-stats">
    <div class="card">
        <h3>Nível</h3>
        <p class="stat-numero"><?php echo htmlspecialchars($nivel); ?></p>
    </div>
    <div class="card">
        <h3>Pontos</h3>
        <p class="stat-numero"><?php echo htmlspecialchars($pontos); ?></p>
    </div>
</div>

<div class="card" style="margin-top: 24px;">
    <div class="card-header">
        <h3>Badges Conquistados</h3>
    </div>
    <div class="card-body">
        <?php if (empty($badges)): ?>
            <p>Ainda não conquistou badges.</p>
        <?php else: ?>
            <div class="badges-container">
                <?php foreach ($badges as $badge): ?>
                    <div class="badge-item">
                        <img src="/recursos/imagens/badges/<?php echo htmlspecialchars($badge['icone']); ?>" alt="<?php echo htmlspecialchars($badge['nome']); ?>">
                        <h4><?php echo htmlspecialchars($badge['nome']); ?></h4>
                        <p><?php echo htmlspecialchars($badge['descricao']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
