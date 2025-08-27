<div class="dashboard-cabecalho">
    <h1><i class="fas fa-columns"></i> Gestão de Pilares</h1>
    <p>Crie e organize os seus pilares de vida, categorias e subcategorias.</p>
</div>

<div class="card">
    <div class="card-header">
        <h3>Adicionar Novo Pilar</h3>
    </div>
    <div class="card-body">
        <?php if (isset($erro)): ?>
            <div class="alerta alerta-erro"><?php echo htmlspecialchars($erro); ?></div>
        <?php endif; ?>
        <form action="/pilar/criar" method="POST" class="form-inline">
            <div class="campo-grupo" style="flex-grow: 1;">
                <label for="nome" class="sr-only">Nome do Pilar</label>
                <input type="text" name="nome" id="nome" class="campo-input" placeholder="Nome do novo pilar" required>
            </div>
            <div class="campo-grupo">
                <label for="cor" class="sr-only">Cor</label>
                <input type="color" name="cor" id="cor" class="campo-input" value="#6b46c1" title="Escolha uma cor para o pilar">
            </div>
            <button type="submit" class="btn btn-primario">Adicionar Pilar</button>
        </form>
    </div>
</div>

<div class="pilares-container">
    <?php if (isset($pilares) && count($pilares) > 0): ?>
        <?php foreach ($pilares as $pilar): ?>
            <div class="pilar-card-container card">
                <div class="card-header" style="border-left: 5px solid <?php echo htmlspecialchars($pilar['cor']); ?>;">
                    <h3><?php echo htmlspecialchars($pilar['nome']); ?></h3>
                    <small><?php echo htmlspecialchars(ucfirst($pilar['tipo'])); ?></small>
                </div>
                <div class="card-body">
                    <div class="categorias-container">
                        <?php foreach ($pilar['categorias'] as $categoria): ?>
                            <div class="categoria-card card">
                                <div class="card-header">
                                    <h4><?php echo htmlspecialchars($categoria['nome']); ?></h4>
                                </div>
                                <div class="card-body">
                                    <ul class="subcategoria-lista">
                                        <?php foreach ($categoria['subcategorias'] as $subcategoria): ?>
                                            <li><?php echo htmlspecialchars($subcategoria['nome']); ?></li>
                                        <?php endforeach; ?>
                                        <?php if(empty($categoria['subcategorias'])): ?>
                                            <p>Nenhuma subcategoria.</p>
                                        <?php endif; ?>
                                    </ul>
                                    <form action="/subcategoria/criar" method="POST" class="form-inline" style="margin-top: 1rem;">
                                        <input type="hidden" name="categoria_id" value="<?php echo $categoria['id']; ?>">
                                        <input type="text" name="nome" class="campo-input" placeholder="Nova Subcategoria" required>
                                        <button type="submit" class="btn btn-pequeno">+</button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                         <?php if(empty($pilar['categorias'])): ?>
                            <p>Nenhuma categoria neste pilar.</p>
                        <?php endif; ?>
                    </div>
                    <form action="/categoria/criar" method="POST" class="form-inline" style="margin-top: 1rem;">
                        <input type="hidden" name="pilar_id" value="<?php echo $pilar['id']; ?>">
                        <input type="text" name="nome" class="campo-input" placeholder="Nova Categoria" required>
                        <button type="submit" class="btn btn-primario">Adicionar Categoria</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="card"><p>Ainda não tem pilares criados. Adicione um acima para começar!</p></div>
    <?php endif; ?>
</div>

<style> .sr-only { position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0, 0, 0, 0); border: 0; } </style>
