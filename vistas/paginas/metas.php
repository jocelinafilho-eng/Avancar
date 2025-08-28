<div class="dashboard-cabecalho" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <!-- O título agora é dinâmico e vem do controlador -->
    </div>
    <button id="btn-add-meta" class="btn btn-primario"><i class="fas fa-plus"></i> Adicionar Meta</button>
</div>

<div class="metas-container" style="margin-top: 24px;">
    <?php if (isset($metas) && count($metas) > 0): ?>
        <?php foreach ($metas as $meta): ?>
            <div class="card meta-card" style="margin-bottom: 16px;" data-meta-id="<?php echo $meta['id']; ?>">
                <div class="card-header">
                    <h3><?php echo htmlspecialchars($meta['nome']); ?></h3>
                    <small>Prazo: <?php echo htmlspecialchars(date('d/m/Y', strtotime($meta['data_fim']))); ?></small>
                </div>
                <div class="card-body">
                    <h4>Micro-metas</h4>
                    <ul class="subcategoria-lista">
                        <?php if(!empty($meta['micrometas'])): ?>
                            <?php foreach ($meta['micrometas'] as $micrometa): ?>
                                <li><?php echo htmlspecialchars($micrometa['nome']); ?> (até <?php echo htmlspecialchars(date('d/m/Y', strtotime($micrometa['data_fim']))); ?>)</li>
                            <?php endforeach; ?>
                        <?php else: ?>
                             <li class="sem-dados">Nenhuma micro-meta.</li>
                        <?php endif; ?>
                    </ul>
                    <hr style="border-color: var(--bordas-separadores); margin: 1rem 0;">
                    <button class="btn btn-pequeno btn-add-micrometa" data-meta-id="<?php echo $meta['id']; ?>">+ Adicionar Micro-meta</button>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="card sem-dados"><p>Ainda não tem metas criadas.</p></div>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const pilaresData = <?php echo json_encode($pilares ?? []); ?>;

    // Constrói as opções do select de categorias
    let categoriaOptions = '';
    pilaresData.forEach(pilar => {
        if(pilar.categorias) {
            categoriaOptions += `<optgroup label="${pilar.nome}">`;
            pilar.categorias.forEach(cat => {
                categoriaOptions += `<option value="${cat.id}">${cat.nome}</option>`;
            });
            categoriaOptions += `</optgroup>`;
        }
    });

    document.getElementById('btn-add-meta').addEventListener('click', function() {
        Swal.fire({
            title: 'Adicionar Nova Meta',
            html: `
                <form id="form-add-meta-modal" class="form-modal" style="text-align: left;">
                    <div class="campo-grupo">
                        <label for="swal-nome-meta">Nome da Meta</label>
                        <input type="text" name="nome" id="swal-nome-meta" class="swal2-input" required>
                    </div>
                    <div class="campo-grupo">
                        <label for="swal-categoria-meta">Categoria</label>
                        <select name="categoria_id" id="swal-categoria-meta" class="swal2-input" required>
                            <option value="">Selecione...</option>
                            ${categoriaOptions}
                        </select>
                    </div>
                    <div class="campo-grupo">
                        <label for="swal-data-inicio">Data de Início</label>
                        <input type="date" name="data_inicio" id="swal-data-inicio" class="swal2-input" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    <div class="campo-grupo">
                        <label for="swal-data-fim">Data Final</label>
                        <input type="date" name="data_fim" id="swal-data-fim" class="swal2-input" required>
                    </div>
                </form>
            `,
            confirmButtonText: 'Adicionar',
            showCancelButton: true,
            background: 'var(--fundo-secundario)',
            color: 'var(--texto-principal)',
            preConfirm: () => {
                const form = document.getElementById('form-add-meta-modal');
                const nome = form.querySelector('#swal-nome-meta').value;
                const categoria = form.querySelector('#swal-categoria-meta').value;
                if (!nome || !categoria) {
                    Swal.showValidationMessage('Nome e Categoria são obrigatórios.');
                    return false;
                }
                Swal.showLoading();
                const formData = new FormData(form);
                return fetch('/meta/criar', { method: 'POST', body: formData })
                    .then(response => response.json())
                    .then(data => { if (!data.sucesso) throw new Error(data.mensagem); return data; })
                    .catch(error => { Swal.showValidationMessage(`Falha: ${error}`); });
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Idealmente, adicionaríamos dinamicamente. Por agora, reload é um patch funcional.
                location.reload();
            }
        });
    });

    // A lógica para adicionar micro-meta também precisa ser implementada
    // TODO: Implementar modal para adicionar micro-meta
});
</script>
