<?php
// Helper para determinar o link ativo
$caminhoAtual = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if (empty($caminhoAtual) || $caminhoAtual === '/') {
    $caminhoAtual = '/dashboard'; // Página padrão
}

function is_link_ativo($caminhoLink, $caminhoAtual) {
    // Lógica para lidar com sub-rotas, ex: /pilares/editar/1 deve ativar /pilares
    if ($caminhoLink !== '/dashboard' && strpos($caminhoAtual, $caminhoLink) === 0) {
        return 'ativo';
    }
    // Caso exato para o dashboard ou outras rotas
    return $caminhoLink === $caminhoAtual ? 'ativo' : '';
}
?>
<aside class="menu-lateral">
    <div class="menu-cabecalho">
        <a href="/dashboard" class="logo">
            <i class="fas fa-rocket logo-icone"></i>
            <span class="logo-texto">Avançar</span>
        </a>
        <button class="menu-toggle-btn" aria-label="Alternar menu">
            <i class="fas fa-chevron-left"></i>
        </button>
    </div>

    <nav class="menu-principal">
        <h3 class="menu-titulo">Principal</h3>
        <ul class="menu-lista">
            <li class="menu-item">
                <a href="/dashboard" class="menu-link <?php echo is_link_ativo('/dashboard', $caminhoAtual); ?>">
                    <i class="fas fa-home fa-fw"></i>
                    <span class="menu-texto">Dashboard</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="/dia" class="menu-link <?php echo is_link_ativo('/dia', $caminhoAtual); ?>">
                    <i class="fas fa-calendar-day fa-fw"></i>
                    <span class="menu-texto">Página do Dia</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="/calendario" class="menu-link <?php echo is_link_ativo('/calendario', $caminhoAtual); ?>">
                    <i class="fas fa-calendar-alt fa-fw"></i>
                    <span class="menu-texto">Calendário</span>
                </a>
            </li>
        </ul>

        <h3 class="menu-titulo">Organização</h3>
        <ul class="menu-lista">
            <li class="menu-item">
                <a href="/pilares" class="menu-link <?php echo is_link_ativo('/pilares', $caminhoAtual); ?>">
                    <i class="fas fa-stream fa-fw"></i>
                    <span class="menu-texto">Pilares</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="/metas" class="menu-link <?php echo is_link_ativo('/metas', $caminhoAtual); ?>">
                    <i class="fas fa-bullseye fa-fw"></i>
                    <span class="menu-texto">Metas</span>
                </a>
            </li>
             <li class="menu-item">
                <a href="/planeamento" class="menu-link <?php echo is_link_ativo('/planeamento', $caminhoAtual); ?>">
                    <i class="fas fa-calendar-week fa-fw"></i>
                    <span class="menu-texto">Planeamento</span>
                </a>
            </li>
        </ul>

        <h3 class="menu-titulo">Análise</h3>
        <ul class="menu-lista">
            <li class="menu-item">
                <a href="/progresso" class="menu-link <?php echo is_link_ativo('/progresso', $caminhoAtual); ?>">
                    <i class="fas fa-chart-line fa-fw"></i>
                    <span class="menu-texto">Progresso</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="/gamificacao" class="menu-link <?php echo is_link_ativo('/gamificacao', $caminhoAtual); ?>">
                    <i class="fas fa-trophy fa-fw"></i>
                    <span class="menu-texto">Gamificação</span>
                </a>
            </li>
        </ul>
    </nav>

    <div class="menu-rodape">
        <ul class="menu-lista">
             <li class="menu-item">
                <a href="/perfil" class="menu-link <?php echo is_link_ativo('/perfil', $caminhoAtual); ?>">
                    <i class="fas fa-user-circle fa-fw"></i>
                    <span class="menu-texto"><?php echo htmlspecialchars($_SESSION['usuario_nome'] ?? 'Usuário'); ?></span>
                </a>
            </li>
             <li class="menu-item">
                <a href="/configuracoes" class="menu-link <?php echo is_link_ativo('/configuracoes', $caminhoAtual); ?>">
                    <i class="fas fa-cog fa-fw"></i>
                    <span class="menu-texto">Configurações</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="/logout" class="menu-link">
                    <i class="fas fa-sign-out-alt fa-fw"></i>
                    <span class="menu-texto">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
