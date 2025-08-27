<div class="dashboard-cabecalho">
    <h1><i class="fas fa-calendar-week"></i> Planeamento Semanal</h1>
    <p>Arraste as suas micro-metas para os dias da semana para criar tarefas.</p>
</div>

<div class="planeamento-container">
    <div class="lista-micrometas card">
        <div class="card-header">
            <h3><i class="fas fa-bullseye"></i> As suas Micro-Metas</h3>
        </div>
        <div class="card-body">
            <?php if (empty($metas)): ?>
                <p>Crie metas e micro-metas primeiro.</p>
            <?php else: ?>
                <?php foreach($metas as $meta): ?>
                    <h5><?php echo htmlspecialchars($meta['nome']); ?></h5>
                    <ul>
                        <?php
                        // A lógica para buscar micrometas está no MetaControlador,
                        // mas não foi passada para esta view. Isto é um TODO.
                        ?>
                        <li>Exemplo de micro-meta 1</li>
                        <li>Exemplo de micro-meta 2</li>
                    </ul>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="calendario-semanal-container card">
        <div class="card-header">
            <h3><i class="fas fa-grip-horizontal"></i> Arraste para os dias</h3>
        </div>
        <div class="card-body calendario-semanal">
            <div class="dia"><h4>Segunda</h4><button class="btn btn-pequeno btn-add-tarefa" data-dia="monday">+</button></div>
            <div class="dia"><h4>Terça</h4><button class="btn btn-pequeno btn-add-tarefa" data-dia="tuesday">+</button></div>
            <div class="dia"><h4>Quarta</h4><button class="btn btn-pequeno btn-add-tarefa" data-dia="wednesday">+</button></div>
            <div class="dia"><h4>Quinta</h4><button class="btn btn-pequeno btn-add-tarefa" data-dia="thursday">+</button></div>
            <div class="dia"><h4>Sexta</h4><button class="btn btn-pequeno btn-add-tarefa" data-dia="friday">+</button></div>
            <div class="dia"><h4>Sábado</h4><button class="btn btn-pequeno btn-add-tarefa" data-dia="saturday">+</button></div>
            <div class="dia"><h4>Domingo</h4><button class="btn btn-pequeno btn-add-tarefa" data-dia="sunday">+</button></div>
        </div>
    </div>
</div>

<style>
.planeamento-container { display: grid; grid-template-columns: 1fr 3fr; gap: 24px; }
.calendario-semanal { display: grid; grid-template-columns: repeat(7, 1fr); gap: 8px; }
.dia { background: var(--fundo-principal); padding: 16px; border-radius: 8px; min-height: 300px; border: 1px dashed var(--bordas-separadores); }
.lista-micrometas ul { list-style: none; padding: 0; }
.lista-micrometas li { background: var(--fundo-secundario); padding: 8px; margin-bottom: 8px; border-radius: 4px; cursor: grab; }
</style>

<script>
document.querySelectorAll('.btn-add-tarefa').forEach(button => {
    button.addEventListener('click', function() {
        const dia = this.dataset.dia;
        // Lógica para abrir o modal de criação de tarefa
        // com o dia pré-selecionado.
        alert('Adicionar tarefa para ' + dia);
    });
});
</script>
