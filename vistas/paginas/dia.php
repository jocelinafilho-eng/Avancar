<div class="dashboard-cabecalho">
    <h1><i class="fas fa-calendar-day"></i> Página do Dia</h1>
    <p>As suas tarefas para hoje, <?php echo date('d/m/Y'); ?>.</p>
</div>

<div class="dia-container" style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">

    <div class="coluna-tarefas">
        <!-- Tarefas com Hora Marcada -->
        <div class="card" style="margin-bottom: 24px;">
            <div class="card-header"><h3><i class="fas fa-clock"></i> Hora Marcada</h3></div>
            <div class="card-body" id="lista-tarefas-hora_marcada">
                <?php if (empty($data['tarefas']['hora_marcada'])): ?>
                    <p class="sem-tarefas">Nenhuma tarefa com hora marcada.</p>
                <?php else: ?>
                    <?php foreach($data['tarefas']['hora_marcada'] as $tarefa): ?>
                        <div class="tarefa-item" data-id-tarefa="<?php echo $tarefa['id']; ?>">
                            <input type="checkbox" id="tarefa-<?php echo $tarefa['id']; ?>" data-id="<?php echo $tarefa['id']; ?>" <?php echo $tarefa['concluida'] ? 'checked' : ''; ?>>
                            <label for="tarefa-<?php echo $tarefa['id']; ?>" class="<?php echo $tarefa['concluida'] ? 'concluida' : ''; ?>"><?php echo htmlspecialchars(substr($tarefa['hora_inicio'], 0, 5)); ?> - <?php echo htmlspecialchars($tarefa['nome']); ?></label>
                            <button class="btn-remover-tarefa" data-id="<?php echo $tarefa['id']; ?>">&times;</button>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Tarefas Arbitrárias -->
        <div class="card">
            <div class="card-header"><h3><i class="fas fa-tasks"></i> Arbitrárias</h3></div>
            <div class="card-body" id="lista-tarefas-arbitraria">
                 <?php if (empty($data['tarefas']['arbitraria'])): ?>
                    <p class="sem-tarefas">Nenhuma tarefa arbitrária.</p>
                <?php else: ?>
                    <?php foreach($data['tarefas']['arbitraria'] as $tarefa): ?>
                        <div class="tarefa-item" data-id-tarefa="<?php echo $tarefa['id']; ?>">
                            <input type="checkbox" id="tarefa-<?php echo $tarefa['id']; ?>" data-id="<?php echo $tarefa['id']; ?>" <?php echo $tarefa['concluida'] ? 'checked' : ''; ?>>
                            <label for="tarefa-<?php echo $tarefa['id']; ?>" class="<?php echo $tarefa['concluida'] ? 'concluida' : ''; ?>"><?php echo htmlspecialchars($tarefa['nome']); ?></label>
                            <button class="btn-remover-tarefa" data-id="<?php echo $tarefa['id']; ?>">&times;</button>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="coluna-acoes">
        <!-- Formulário de Nova Tarefa -->
        <div class="card" style="margin-bottom: 24px;">
            <div class="card-header"><h3><i class="fas fa-plus-circle"></i> Adicionar Nova Tarefa</h3></div>
            <div class="card-body">
                <form id="form-nova-tarefa" class="form-com-feedback">
                    <div class="campo-grupo">
                        <label for="nome-tarefa">Nome da Tarefa</label>
                        <input type="text" name="nome" id="nome-tarefa" required class="campo-input">
                    </div>
                    <div class="campo-grupo">
                        <label for="tipo-temporal">Tipo</label>
                        <select name="tipo_temporal" id="tipo-temporal" class="campo-input">
                            <option value="periodo">Período</option>
                            <option value="hora_marcada">Hora Marcada</option>
                            <option value="arbitraria">Arbitrária</option>
                        </select>
                    </div>
                    <div id="campos-periodo" class="campos-condicionais">
                        <div class="campo-grupo">
                            <label for="periodo">Período</label>
                            <select name="periodo" id="periodo" class="campo-input">
                                <option value="manha">Manhã</option>
                                <option value="tarde">Tarde</option>
                                <option value="noite">Noite</option>
                            </select>
                        </div>
                    </div>
                    <div id="campos-hora-marcada" class="campos-condicionais" style="display: none;">
                        <div class="campo-grupo">
                            <label for="hora-inicio">Hora de Início</label>
                            <input type="time" name="hora_inicio" id="hora-inicio" class="campo-input">
                        </div>
                         <div class="campo-grupo">
                            <label for="duracao-estimada">Duração (minutos)</label>
                            <input type="number" name="duracao_estimada" id="duracao-estimada" class="campo-input" value="30">
                        </div>
                    </div>
                    <input type="hidden" name="data_execucao" value="<?php echo date('Y-m-d'); ?>">
                    <button type="submit" class="btn btn-primario btn-com-feedback" style="width:100%;">
                        <span class="btn-texto">Adicionar Tarefa</span>
                        <span class="btn-spinner" style="display: none;"><i class="fas fa-spinner fa-spin"></i></span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Tarefas por Período -->
        <div class="card">
            <div class="card-header"><h3><i class="fas fa-sun"></i> Períodos</h3></div>
            <div class="card-body">
                <h4>Manhã</h4>
                <div id="lista-tarefas-manha">
                    <?php if (empty($data['tarefas']['manha'])): ?>
                        <p class="sem-tarefas">Nenhuma tarefa para a manhã.</p>
                    <?php else: ?>
                        <?php foreach($data['tarefas']['manha'] as $tarefa): ?>
                            <div class="tarefa-item" data-id-tarefa="<?php echo $tarefa['id']; ?>">
                                <input type="checkbox" id="tarefa-<?php echo $tarefa['id']; ?>" data-id="<?php echo $tarefa['id']; ?>" <?php echo $tarefa['concluida'] ? 'checked' : ''; ?>>
                                <label for="tarefa-<?php echo $tarefa['id']; ?>" class="<?php echo $tarefa['concluida'] ? 'concluida' : ''; ?>"><?php echo htmlspecialchars($tarefa['nome']); ?></label>
                                <button class="btn-remover-tarefa" data-id="<?php echo $tarefa['id']; ?>">&times;</button>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <hr style="border-color: var(--bordas-separadores); margin: 1rem 0;">
                <h4>Tarde</h4>
                 <div id="lista-tarefas-tarde">
                    <?php if (empty($data['tarefas']['tarde'])): ?>
                        <p class="sem-tarefas">Nenhuma tarefa para a tarde.</p>
                    <?php else: ?>
                        <?php foreach($data['tarefas']['tarde'] as $tarefa): ?>
                            <div class="tarefa-item" data-id-tarefa="<?php echo $tarefa['id']; ?>">
                                <input type="checkbox" id="tarefa-<?php echo $tarefa['id']; ?>" data-id="<?php echo $tarefa['id']; ?>" <?php echo $tarefa['concluida'] ? 'checked' : ''; ?>>
                                <label for="tarefa-<?php echo $tarefa['id']; ?>" class="<?php echo $tarefa['concluida'] ? 'concluida' : ''; ?>"><?php echo htmlspecialchars($tarefa['nome']); ?></label>
                                <button class="btn-remover-tarefa" data-id="<?php echo $tarefa['id']; ?>">&times;</button>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <hr style="border-color: var(--bordas-separadores); margin: 1rem 0;">
                <h4>Noite</h4>
                <div id="lista-tarefas-noite">
                    <?php if (empty($data['tarefas']['noite'])): ?>
                        <p class="sem-tarefas">Nenhuma tarefa para a noite.</p>
                    <?php else: ?>
                        <?php foreach($data['tarefas']['noite'] as $tarefa): ?>
                            <div class="tarefa-item" data-id-tarefa="<?php echo $tarefa['id']; ?>">
                                <input type="checkbox" id="tarefa-<?php echo $tarefa['id']; ?>" data-id="<?php echo $tarefa['id']; ?>" <?php echo $tarefa['concluida'] ? 'checked' : ''; ?>>
                                <label for="tarefa-<?php echo $tarefa['id']; ?>" class="<?php echo $tarefa['concluida'] ? 'concluida' : ''; ?>"><?php echo htmlspecialchars($tarefa['nome']); ?></label>
                                <button class="btn-remover-tarefa" data-id="<?php echo $tarefa['id']; ?>">&times;</button>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
