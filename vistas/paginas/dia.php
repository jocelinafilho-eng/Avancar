<div class="dashboard-cabecalho">
    <h1><i class="fas fa-calendar-day"></i> Página do Dia</h1>
    <p>As suas tarefas para hoje, <?php echo date('d/m/Y'); ?>.</p>
</div>

<div class="dia-container" style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">

    <div class="coluna-periodos">
        <!-- Tarefas com Hora Marcada -->
        <div class="card" style="margin-bottom: 24px;">
            <div class="card-header">
                <h3><i class="fas fa-clock"></i> Hora Marcada</h3>
            </div>
            <div class="card-body">
                <?php if (empty($tarefas['hora_marcada'])): ?>
                    <p>Nenhuma tarefa com hora marcada.</p>
                <?php else: ?>
                    <?php foreach($tarefas['hora_marcada'] as $tarefa): ?>
                        <div class="tarefa-item">
                            <input type="checkbox" id="tarefa-<?php echo $tarefa['id']; ?>" data-id="<?php echo $tarefa['id']; ?>" <?php echo $tarefa['concluida'] ? 'checked' : ''; ?>>
                            <label for="tarefa-<?php echo $tarefa['id']; ?>"><?php echo htmlspecialchars(substr($tarefa['hora_inicio'], 0, 5)); ?> - <?php echo htmlspecialchars($tarefa['nome']); ?></label>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Tarefas Arbitrárias -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-tasks"></i> Arbitrárias</h3>
            </div>
            <div class="card-body">
                 <?php if (empty($tarefas['arbitraria'])): ?>
                    <p>Nenhuma tarefa arbitrária.</p>
                <?php else: ?>
                    <?php foreach($tarefas['arbitraria'] as $tarefa): ?>
                        <div class="tarefa-item">
                            <input type="checkbox" id="tarefa-<?php echo $tarefa['id']; ?>" data-id="<?php echo $tarefa['id']; ?>" <?php echo $tarefa['concluida'] ? 'checked' : ''; ?>>
                            <label for="tarefa-<?php echo $tarefa['id']; ?>"><?php echo htmlspecialchars($tarefa['nome']); ?></label>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="coluna-arbitrarias">
        <!-- Tarefas por Período -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-sun"></i> Períodos</h3>
            </div>
            <div class="card-body">
                <h4>Manhã</h4>
                <?php if (empty($tarefas['manha'])): ?>
                    <p>Nenhuma tarefa para a manhã.</p>
                <?php else: ?>
                    <?php foreach($tarefas['manha'] as $tarefa): ?>
                        <div class="tarefa-item">
                            <input type="checkbox" id="tarefa-<?php echo $tarefa['id']; ?>" data-id="<?php echo $tarefa['id']; ?>" <?php echo $tarefa['concluida'] ? 'checked' : ''; ?>>
                            <label for="tarefa-<?php echo $tarefa['id']; ?>"><?php echo htmlspecialchars($tarefa['nome']); ?></label>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <hr style="border-color: var(--bordas-separadores); margin: 1rem 0;">
                <h4>Tarde</h4>
                 <?php if (empty($tarefas['tarde'])): ?>
                    <p>Nenhuma tarefa para a tarde.</p>
                <?php else: ?>
                    <?php foreach($tarefas['tarde'] as $tarefa): ?>
                        <div class="tarefa-item">
                            <input type="checkbox" id="tarefa-<?php echo $tarefa['id']; ?>" data-id="<?php echo $tarefa['id']; ?>" <?php echo $tarefa['concluida'] ? 'checked' : ''; ?>>
                            <label for="tarefa-<?php echo $tarefa['id']; ?>"><?php echo htmlspecialchars($tarefa['nome']); ?></label>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <hr style="border-color: var(--bordas-separadores); margin: 1rem 0;">
                <h4>Noite</h4>
                <?php if (empty($tarefas['noite'])): ?>
                    <p>Nenhuma tarefa para a noite.</p>
                <?php else: ?>
                    <?php foreach($tarefas['noite'] as $tarefa): ?>
                        <div class="tarefa-item">
                            <input type="checkbox" id="tarefa-<?php echo $tarefa['id']; ?>" data-id="<?php echo $tarefa['id']; ?>" <?php echo $tarefa['concluida'] ? 'checked' : ''; ?>>
                            <label for="tarefa-<?php echo $tarefa['id']; ?>"><?php echo htmlspecialchars($tarefa['nome']); ?></label>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.tarefa-item input[type="checkbox"]');
    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const id_tarefa = this.dataset.id;
            const concluida = this.checked ? 1 : 0;

            const formData = new FormData();
            formData.append('id_tarefa', id_tarefa);
            formData.append('concluida', concluida);

            fetch('/tarefa/actualizarEstado', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.sucesso) {
                    // Mudar o estilo da label
                    const label = this.nextElementSibling;
                    if (concluida) {
                        label.style.textDecoration = 'line-through';
                        label.style.color = 'var(--texto-desabilitado)';
                    } else {
                        label.style.textDecoration = 'none';
                        label.style.color = 'var(--texto-secundario)';
                    }
                } else {
                    // Reverter o checkbox em caso de erro
                    this.checked = !this.checked;
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Erro ao atualizar a tarefa.',
                        background: 'var(--fundo-secundario)',
                        color: 'var(--texto-principal)'
                    });
                }
            })
            .catch(error => {
                this.checked = !this.checked;
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Erro de conexão.',
                    background: 'var(--fundo-secundario)',
                    color: 'var(--texto-principal)'
                });
            });
        });
    });
});
</script>
