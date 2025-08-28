<div class="dashboard-cabecalho" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <!-- Título dinâmico, o h1 é gerado pelo cabecalho.php -->
    </div>
    <button id="btn-add-tarefa" class="btn btn-primario"><i class="fas fa-plus"></i> Adicionar Tarefa</button>
</div>

<div class="dia-container" style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">

    <div class="coluna-tarefas">
        <div class="card" style="margin-bottom: 24px;">
            <div class="card-header"><h3><i class="fas fa-clock" style="color: var(--azul);"></i> Hora Marcada</h3></div>
            <div class="card-body" id="lista-tarefas-hora_marcada">
                <?php if (empty($tarefas['hora_marcada'])): ?><p class="sem-tarefas">Nenhuma tarefa.</p><?php else: foreach($tarefas['hora_marcada'] as $t): ?><div class="tarefa-item" data-id-tarefa="<?php echo $t['id']; ?>"><input type="checkbox" id="tarefa-<?php echo $t['id']; ?>" data-id="<?php echo $t['id']; ?>" <?php echo $t['concluida'] ? 'checked' : ''; ?>><label for="tarefa-<?php echo $t['id']; ?>" class="<?php echo $t['concluida'] ? 'concluida' : ''; ?>"><?php echo htmlspecialchars(substr($t['hora_inicio'], 0, 5)); ?> - <?php echo htmlspecialchars($t['nome']); ?></label><button class="btn-remover-tarefa" data-id="<?php echo $t['id']; ?>">&times;</button></div><?php endforeach; endif; ?>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h3><i class="fas fa-tasks" style="color: var(--laranja);"></i> Arbitrárias</h3></div>
            <div class="card-body" id="lista-tarefas-arbitraria">
                 <?php if (empty($tarefas['arbitraria'])): ?><p class="sem-tarefas">Nenhuma tarefa.</p><?php else: foreach($tarefas['arbitraria'] as $t): ?><div class="tarefa-item" data-id-tarefa="<?php echo $t['id']; ?>"><input type="checkbox" id="tarefa-<?php echo $t['id']; ?>" data-id="<?php echo $t['id']; ?>" <?php echo $t['concluida'] ? 'checked' : ''; ?>><label for="tarefa-<?php echo $t['id']; ?>" class="<?php echo $t['concluida'] ? 'concluida' : ''; ?>"><?php echo htmlspecialchars($t['nome']); ?></label><button class="btn-remover-tarefa" data-id="<?php echo $t['id']; ?>">&times;</button></div><?php endforeach; endif; ?>
            </div>
        </div>
    </div>

    <div class="coluna-acoes">
        <div class="card">
            <div class="card-header"><h3><i class="fas fa-calendar-check" style="color: var(--primaria);"></i> Resumo por Períodos</h3></div>
            <div class="card-body">
                <h4><i class="fas fa-coffee"></i> Manhã</h4>
                <div id="lista-tarefas-manha"><?php if (empty($tarefas['manha'])): ?><p class="sem-tarefas">Nenhuma tarefa.</p><?php else: foreach($tarefas['manha'] as $t): ?><div class="tarefa-item" data-id-tarefa="<?php echo $t['id']; ?>"><input type="checkbox" id="tarefa-<?php echo $t['id']; ?>" data-id="<?php echo $t['id']; ?>" <?php echo $t['concluida'] ? 'checked' : ''; ?>><label for="tarefa-<?php echo $t['id']; ?>" class="<?php echo $t['concluida'] ? 'concluida' : ''; ?>"><?php echo htmlspecialchars($t['nome']); ?></label><button class="btn-remover-tarefa" data-id="<?php echo $t['id']; ?>">&times;</button></div><?php endforeach; endif; ?></div>
                <hr><h4 class="mt-3"><i class="fas fa-sun"></i> Tarde</h4>
                <div id="lista-tarefas-tarde"><?php if (empty($tarefas['tarde'])): ?><p class="sem-tarefas">Nenhuma tarefa.</p><?php else: foreach($tarefas['tarde'] as $t): ?><div class="tarefa-item" data-id-tarefa="<?php echo $t['id']; ?>"><input type="checkbox" id="tarefa-<?php echo $t['id']; ?>" data-id="<?php echo $t['id']; ?>" <?php echo $t['concluida'] ? 'checked' : ''; ?>><label for="tarefa-<?php echo $t['id']; ?>" class="<?php echo $t['concluida'] ? 'concluida' : ''; ?>"><?php echo htmlspecialchars($t['nome']); ?></label><button class="btn-remover-tarefa" data-id="<?php echo $t['id']; ?>">&times;</button></div><?php endforeach; endif; ?></div>
                <hr><h4 class="mt-3"><i class="fas fa-moon"></i> Noite</h4>
                <div id="lista-tarefas-noite"><?php if (empty($tarefas['noite'])): ?><p class="sem-tarefas">Nenhuma tarefa.</p><?php else: foreach($tarefas['noite'] as $t): ?><div class="tarefa-item" data-id-tarefa="<?php echo $t['id']; ?>"><input type="checkbox" id="tarefa-<?php echo $t['id']; ?>" data-id="<?php echo $t['id']; ?>" <?php echo $t['concluida'] ? 'checked' : ''; ?>><label for="tarefa-<?php echo $t['id']; ?>" class="<?php echo $t['concluida'] ? 'concluida' : ''; ?>"><?php echo htmlspecialchars($t['nome']); ?></label><button class="btn-remover-tarefa" data-id="<?php echo $t['id']; ?>">&times;</button></div><?php endforeach; endif; ?></div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const hierarquia_pilares = <?php echo json_encode($pilares ?? []); ?>;

    document.getElementById('btn-add-tarefa').addEventListener('click', function() {
        Swal.fire({
            title: 'Adicionar Nova Tarefa',
            width: '800px',
            html: `
                <form id="form-nova-tarefa-modal" class="form-modal" style="text-align: left;">
                    <div class="campo-grupo"><label for="swal-nome-tarefa">Nome da Tarefa</label><input type="text" name="nome" id="swal-nome-tarefa" class="swal2-input" required></div><hr>
                    <div class="campo-grupo"><label for="swal-pilar-select">Pilar</label><select id="swal-pilar-select" class="swal2-input"><option value="">Selecione...</option>${hierarquia_pilares.map(p => `<option value="${p.id}">${p.nome}</option>`).join('')}</select></div>
                    <div class="campo-grupo"><label for="swal-categoria-select">Categoria</label><select id="swal-categoria-select" class="swal2-input" disabled></select></div>
                    <div class="campo-grupo"><label for="swal-meta-select">Meta</label><select id="swal-meta-select" class="swal2-input" disabled></select></div>
                    <div class="campo-grupo"><label for="swal-micrometa-select">Micro-Meta</label><select name="micrometa_id" id="swal-micrometa-select" class="swal2-input" required disabled></select></div><hr>
                    <div class="campo-grupo"><label for="swal-tipo-temporal">Agendamento</label><select name="tipo_temporal" id="swal-tipo-temporal" class="swal2-input"><option value="periodo">Período</option><option value="hora_marcada">Hora Marcada</option><option value="arbitraria">Sem horário</option></select></div>
                    <div id="swal-campos-periodo" style="display:none;"><div class="campo-grupo"><label for="swal-periodo">Período</label><select name="periodo" id="swal-periodo" class="swal2-input"><option value="manha">Manhã</option><option value="tarde">Tarde</option><option value="noite">Noite</option></select></div></div>
                    <div id="swal-campos-hora-marcada" style="display: none;"><div class="campo-grupo"><label for="swal-hora-inicio">Hora</label><input type="time" name="hora_inicio" id="swal-hora-inicio" class="swal2-input"></div><div class="campo-grupo"><label for="swal-duracao">Duração (min)</label><input type="number" name="duracao_estimada" id="swal-duracao" class="swal2-input" value="30"></div></div>
                    <input type="hidden" name="data_execucao" value="<?php echo date('Y-m-d'); ?>">
                </form>
            `,
            confirmButtonText: '<i class="fas fa-plus"></i> Adicionar',
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            background: 'var(--fundo-secundario)',
            color: 'var(--texto-principal)',
            didOpen: () => {
                const pilarSelect = document.getElementById('swal-pilar-select');
                const categoriaSelect = document.getElementById('swal-categoria-select');
                const metaSelect = document.getElementById('swal-meta-select');
                const micrometaSelect = document.getElementById('swal-micrometa-select');
                const tipoTemporalSelect = document.getElementById('swal-tipo-temporal');

                const updateDropdown = (el, options, placeholder) => {
                    el.innerHTML = `<option value="">${placeholder}</option>`;
                    if (options) options.forEach(o => { el.innerHTML += `<option value="${o.id}">${o.nome}</option>`; });
                    el.disabled = !options || options.length === 0;
                };
                const resetDropdown = (el, placeholder = '...') => {
                    el.innerHTML = `<option value="">${placeholder}</option>`;
                    el.disabled = true;
                };

                pilarSelect.addEventListener('change', function() {
                    resetDropdown(categoriaSelect, '...'); resetDropdown(metaSelect, '...'); resetDropdown(micrometaSelect, '...');
                    if (this.value) {
                        const pilar = hierarquia_pilares.find(p => p.id == this.value);
                        updateDropdown(categoriaSelect, pilar.categorias, 'Selecione Categoria');
                    }
                });
                categoriaSelect.addEventListener('change', function() {
                    resetDropdown(metaSelect, '...'); resetDropdown(micrometaSelect, '...');
                    if (this.value) {
                        const pilar = hierarquia_pilares.find(p => p.id == pilarSelect.value);
                        const cat = pilar.categorias.find(c => c.id == this.value);
                        updateDropdown(metaSelect, cat.metas, 'Selecione Meta');
                    }
                });
                metaSelect.addEventListener('change', function() {
                    resetDropdown(micrometaSelect, '...');
                    if (this.value) {
                        const pilar = hierarquia_pilares.find(p => p.id == pilarSelect.value);
                        const cat = pilar.categorias.find(c => c.id == categoriaSelect.value);
                        const meta = cat.metas.find(m => m.id == this.value);
                        updateDropdown(micrometaSelect, meta.micrometas, 'Selecione Micro-Meta');
                    }
                });
                tipoTemporalSelect.addEventListener('change', function() {
                    document.getElementById('swal-campos-periodo').style.display = 'none';
                    document.getElementById('swal-campos-hora-marcada').style.display = 'none';
                    if (this.value === 'periodo') document.getElementById('swal-campos-periodo').style.display = 'block';
                    if (this.value === 'hora_marcada') document.getElementById('swal-campos-hora-marcada').style.display = 'block';
                });
                tipoTemporalSelect.dispatchEvent(new Event('change'));

                const pilarGeral = hierarquia_pilares.find(p => p.nome === 'Geral');
                if (pilarGeral) {
                    pilarSelect.value = pilarGeral.id;
                    pilarSelect.dispatchEvent(new Event('change'));
                    setTimeout(() => {
                        const catGeral = pilarGeral.categorias.find(c => c.nome === 'Tarefas Diárias');
                        if (catGeral) {
                            categoriaSelect.value = catGeral.id;
                            categoriaSelect.dispatchEvent(new Event('change'));
                            setTimeout(() => {
                                const metaGeral = catGeral.metas.find(m => m.nome === 'Metas Gerais');
                                if (metaGeral) {
                                    metaSelect.value = metaGeral.id;
                                    metaSelect.dispatchEvent(new Event('change'));
                                    setTimeout(() => {
                                        const microGeral = metaGeral.micrometas.find(m => m.nome === 'Tarefas Avulsas');
                                        if (microGeral) micrometaSelect.value = microGeral.id;
                                    }, 100);
                                }
                            }, 100);
                        }
                    }, 100);
                }
            },
            preConfirm: () => {
                const form = document.getElementById('form-nova-tarefa-modal');
                const nome = form.querySelector('#swal-nome-tarefa').value;
                const micrometa = form.querySelector('#swal-micrometa-select').value;
                if (!nome || !micrometa) {
                    Swal.showValidationMessage('Nome da tarefa e a hierarquia completa são obrigatórios.');
                    return false;
                }
                Swal.showLoading();
                const formData = new FormData(form);
                return fetch('/tarefa/criarParaHoje', { method: 'POST', body: formData })
                    .then(response => response.json())
                    .then(data => { if (!data.sucesso) throw new Error(data.erro); return data; })
                    .catch(error => { Swal.showValidationMessage(`Falha: ${error}`); });
            }
        }).then(result => {
            if (result.isConfirmed) {
                adicionarTarefaNaLista(result.value.tarefa);
                mostrarAlertaSucesso('Tarefa adicionada!');
            }
        });
    });
});
</script>
