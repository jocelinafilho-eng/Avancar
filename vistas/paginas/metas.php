<div class="dashboard-cabecalho" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1><i class="fas fa-target"></i> Gestão de Metas</h1>
        <p>Defina e acompanhe as suas metas e micro-metas.</p>
    </div>
    <button id="btn-add-meta" class="btn btn-primario"><i class="fas fa-plus"></i> Adicionar Meta</button>
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
                    <button class="btn btn-pequeno btn-add-micrometa" data-meta-id="<?php echo $meta['id']; ?>">+ Adicionar Micro-meta</button>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="card"><p>Ainda não tem metas criadas.</p></div>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Modal para Adicionar Meta
    document.getElementById('btn-add-meta').addEventListener('click', function() {
        // Lógica do Swal.fire para meta
    });

    // Modal para Adicionar Micro-meta
    document.querySelectorAll('.btn-add-micrometa').forEach(button => {
        button.addEventListener('click', function() {
            const metaId = this.dataset.metaId;
            // Lógica do Swal.fire para micro-meta
        });
    });
});
</script>
