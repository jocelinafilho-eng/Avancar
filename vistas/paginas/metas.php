<div class="dashboard-cabecalho">
    <h1><i class="fas fa-target"></i> Gestão de Metas</h1>
    <p>Defina e acompanhe as suas metas e micro-metas.</p>
</div>

<div class="card">
    <div class="card-header">
        <h3>Adicionar Nova Meta</h3>
    </div>
    <div class="card-body">
        <?php if (isset($erro)): ?>
            <div class="alerta alerta-erro"><?php echo htmlspecialchars($erro); ?></div>
        <?php endif; ?>
        <form action="/meta/criar" method="POST">
            <div class="campo-grupo">
                <label for="categoria_id">Categoria</label>
                <select name="categoria_id" id="categoria_id" class="campo-input" required>
                    <option value="">Selecione uma Categoria</option>
                    <?php
                    // Esta parte precisa de uma lógica mais robusta para pegar as categorias
                    // Por agora, é um placeholder.
                    // Idealmente, seria populado via JS ou uma query mais complexa no controlador.
                    ?>
                </select>
            </div>
            <div class="campo-grupo">
                <label for="nome">Nome da Meta</label>
                <input type="text" name="nome" id="nome" class="campo-input" required>
            </div>
            <div class="campo-grupo">
                <label for="data_inicio">Data de Início</label>
                <input type="date" name="data_inicio" id="data_inicio" class="campo-input" required>
            </div>
            <div class="campo-grupo">
                <label for="data_fim">Data de Fim</label>
                <input type="date" name="data_fim" id="data_fim" class="campo-input" required>
            </div>
            <button type="submit" class="btn btn-primario">Adicionar Meta</button>
        </form>
    </div>
</div>

<div class="metas-container" style="margin-top: 24px;">
    <h2>Minhas Metas</h2>
    <?php if (isset($metas) && count($metas) > 0): ?>
        <?php foreach ($metas as $meta): ?>
            <div class="card" style="margin-bottom: 16px;">
                <div class="card-header">
                    <h3><?php echo htmlspecialchars($meta['nome']); ?></h3>
                    <small><?php echo htmlspecialchars($meta['data_inicio']); ?> a <?php echo htmlspecialchars($meta['data_fim']); ?></small>
                </div>
                <div class="card-body">
                    <h4>Micro-metas</h4>
                    <ul class="subcategoria-lista">
                        <?php foreach ($meta['micrometas'] as $micrometa): ?>
                            <li><?php echo htmlspecialchars($micrometa['nome']); ?> (<?php echo htmlspecialchars($micrometa['data_fim']); ?>)</li>
                        <?php endforeach; ?>
                    </ul>
                    <hr style="border-color: var(--bordas-separadores); margin: 1rem 0;">
                    <form action="/meta/criarMicro" method="POST" class="form-inline">
                        <input type="hidden" name="meta_id" value="<?php echo $meta['id']; ?>">
                        <input type="text" name="nome" class="campo-input" placeholder="Nova Micro-meta" required>
                        <input type="date" name="data_inicio" class="campo-input" required>
                        <input type="date" name="data_fim" class="campo-input" required>
                        <button type="submit" class="btn btn-pequeno">+</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="card"><p>Ainda não tem metas criadas.</p></div>
    <?php endif; ?>
</div>
