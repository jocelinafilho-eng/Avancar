<div class="dashboard-cabecalho" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <!-- O título agora é dinâmico e vem do controlador -->
    </div>
    <button id="btn-add-pilar" class="btn btn-primario"><i class="fas fa-plus"></i> Adicionar Pilar Opcional</button>
</div>

<div class="pilares-container">
    <?php if (isset($pilares) && count($pilares) > 0): ?>
        <?php foreach ($pilares as $pilar): ?>
            <div class="pilar-card-container card" data-pilar-id="<?php echo $pilar['id']; ?>">
                <div class="card-header" style="border-left: 5px solid <?php echo htmlspecialchars($pilar['cor']); ?>;">
                    <div class="pilar-card-titulo">
                        <h3><i class="fas fa-stream"></i> <?php echo htmlspecialchars($pilar['nome']); ?></h3>
                        <small class="pilar-tipo-<?php echo $pilar['tipo']; ?>"><?php echo htmlspecialchars(ucfirst($pilar['tipo'])); ?></small>
                    </div>
                    <?php if ($pilar['tipo'] == 'opcional'): ?>
                        <button class="btn btn-primario btn-add-categoria" data-pilar-id="<?php echo $pilar['id']; ?>"><i class="fas fa-plus"></i> Categoria</button>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <?php if (!empty($pilar['descricao'])): ?>
                        <p class="pilar-descricao"><?php echo htmlspecialchars($pilar['descricao']); ?></p>
                    <?php endif; ?>
                    <div class="categorias-container">
                        <?php if(!empty($pilar['categorias'])): ?>
                            <?php foreach ($pilar['categorias'] as $categoria): ?>
                                <div class="categoria-card card">
                                    <div class="card-header">
                                        <h4><?php echo htmlspecialchars($categoria['nome']); ?></h4>
                                        <button class="btn btn-pequeno btn-add-subcategoria" data-categoria-id="<?php echo $categoria['id']; ?>">+</button>
                                    </div>
                                    <div class="card-body">
                                        <ul class="subcategoria-lista">
                                            <?php if(!empty($categoria['subcategorias'])): ?>
                                                <?php foreach ($categoria['subcategorias'] as $subcategoria): ?>
                                                    <li><?php echo htmlspecialchars($subcategoria['nome']); ?></li>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <li class="sem-dados">Nenhuma subcategoria.</li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="sem-dados">Nenhuma categoria neste pilar.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="card sem-dados"><p>Ainda não tem pilares criados. Adicione um para começar!</p></div>
    <?php endif; ?>
</div>

<template id="pilar-card-template">
    <div class="pilar-card-container card" data-pilar-id="">
        <div class="card-header" style="border-left: 5px solid #cccccc;">
            <div class="pilar-card-titulo">
                <h3><i class="fas fa-stream"></i> <span></span></h3>
                <small class="pilar-tipo-opcional">Opcional</small>
            </div>
            <button class="btn btn-primario btn-add-categoria"><i class="fas fa-plus"></i> Categoria</button>
        </div>
        <div class="card-body">
            <p class="pilar-descricao"></p>
            <div class="categorias-container">
                <p class="sem-dados">Nenhuma categoria neste pilar.</p>
            </div>
        </div>
    </div>
</template>


<script>
document.addEventListener('DOMContentLoaded', function() {

    function adicionarPilarNaPagina(pilar) {
        const container = document.querySelector('.pilares-container');
        const template = document.getElementById('pilar-card-template');
        const clone = template.content.cloneNode(true);

        const card = clone.querySelector('.pilar-card-container');
        card.dataset.pilarId = pilar.id;
        card.querySelector('.card-header').style.borderLeftColor = pilar.cor;
        card.querySelector('.pilar-card-titulo h3 span').textContent = pilar.nome;

        const descricaoEl = card.querySelector('.pilar-descricao');
        if (pilar.descricao) {
            descricaoEl.textContent = pilar.descricao;
        } else {
            descricaoEl.remove();
        }

        // Adicionar listeners para os novos botões
        // TODO: Refatorar para usar event delegation no container principal
        clone.querySelector('.btn-add-categoria').dataset.pilarId = pilar.id;

        // Remover a mensagem de "sem pilares" se existir
        const placeholder = container.querySelector('.sem-dados');
        if (placeholder) placeholder.parentElement.remove();

        container.appendChild(clone);
        Swal.fire({ title: 'Sucesso!', text: 'Pilar adicionado.', icon: 'success', background: 'var(--fundo-secundario)', color: 'var(--texto-principal)' });
    }

    document.getElementById('btn-add-pilar').addEventListener('click', function() {
        Swal.fire({
            title: 'Adicionar Novo Pilar',
            html: `
                <form id="form-add-pilar-modal" class="form-modal" style="text-align: left;">
                    <div class="campo-grupo">
                        <label for="swal-nome-pilar">Nome do Pilar</label>
                        <input type="text" name="nome" id="swal-nome-pilar" class="swal2-input" placeholder="Ex: Carreira, Lazer..." required>
                    </div>
                    <div class="campo-grupo">
                        <label for="swal-descricao-pilar">Descrição</label>
                        <textarea name="descricao" id="swal-descricao-pilar" class="swal2-textarea" placeholder="Uma breve descrição sobre este pilar..."></textarea>
                    </div>
                    <div class="campo-grupo">
                        <label for="swal-cor">Cor de Destaque</label>
                        <input type="color" name="cor" id="swal-cor" class="swal2-input" value="#6b46c1" style="height: 40px;">
                    </div>
                </form>
            `,
            confirmButtonText: 'Adicionar',
            showCancelButton: true,
            background: 'var(--fundo-secundario)',
            color: 'var(--texto-principal)',
            didOpen: () => {
                Swal.getConfirmButton().focus();
            },
            preConfirm: () => {
                const form = document.getElementById('form-add-pilar-modal');
                const nome = form.querySelector('#swal-nome-pilar').value;
                if (!nome) {
                    Swal.showValidationMessage('O nome do pilar é obrigatório.');
                    return false;
                }
                Swal.showLoading();
                const formData = new FormData(form);
                return fetch('/pilar/criar', { method: 'POST', body: formData })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Erro na resposta do servidor.');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (!data.sucesso) {
                            throw new Error(data.mensagem || 'Erro desconhecido.');
                        }
                        return data;
                    })
                    .catch(error => {
                        Swal.showValidationMessage(`Falha na requisição: ${error.message}`);
                    });
            }
        }).then((result) => {
            if (result.isConfirmed) {
                adicionarPilarNaPagina(result.value.pilar);
            }
        });
    });

    // TODO: Refatorar os listeners de Categoria e Subcategoria para usar event delegation
    // e para também adicionar os elementos dinamicamente em vez de recarregar a página.
});
</script>
