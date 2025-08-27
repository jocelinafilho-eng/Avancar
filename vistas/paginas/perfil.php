<div class="dashboard-cabecalho">
    <h1><i class="fas fa-user"></i> Perfil do Utilizador</h1>
</div>

<div class="card">
    <div class="card-header">
        <h3>As suas informações</h3>
    </div>
    <div class="card-body">
        <p><strong>Nome:</strong> <?php echo htmlspecialchars($usuario['nome']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($usuario['email']); ?></p>
        <hr style="border-color: var(--bordas-separadores); margin: 1rem 0;">
        <h3>Gamificação</h3>
        <p><strong>Nível:</strong> <?php echo htmlspecialchars($usuario['nivel']); ?></p>
        <p><strong>Pontos:</strong> <?php echo htmlspecialchars($usuario['pontos']); ?></p>
    </div>
</div>
