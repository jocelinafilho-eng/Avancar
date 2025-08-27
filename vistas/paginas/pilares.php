<div class="dashboard-cabecalho" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1><i class="fas fa-columns"></i> Gestão de Pilares</h1>
        <p>Crie e organize os seus pilares de vida, categorias e subcategorias.</p>
    </div>
    <button id="btn-add-pilar" class="btn btn-primario"><i class="fas fa-plus"></i> Adicionar Pilar</button>
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
                                    <button class="btn btn-pequeno btn-add-subcategoria" data-categoria-id="<?php echo $categoria['id']; ?>">+</button>
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
                                </div>
                            </div>
                        <?php endforeach; ?>
                         <?php if(empty($pilar['categorias'])): ?>
                            <p>Nenhuma categoria neste pilar.</p>
                        <?php endif; ?>
                    </div>
                    <button class="btn btn-primario btn-add-categoria" data-pilar-id="<?php echo $pilar['id']; ?>">Adicionar Categoria</button>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="card"><p>Ainda não tem pilares criados. Adicione um acima para começar!</p></div>
    <?php endif; ?>
</div>

<style> .sr-only { position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0, 0, 0, 0); border: 0; } </style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Modal para Adicionar Pilar
    document.getElementById('btn-add-pilar').addEventListener('click', function() {
        Swal.fire({
            title: 'Adicionar Novo Pilar',
            html: `
                <form id="form-add-pilar-modal" class="form-modal">
                    <div class="campo-grupo">
                        <label for="swal-nome-pilar">Nome do Pilar</label>
                        <input type="text" name="nome" id="swal-nome-pilar" class="swal2-input" placeholder="Nome do novo pilar" required>
                    </div>
                    <div class="campo-grupo">
                        <label for="swal-cor">Cor</label>
                        <input type="color" name="cor" id="swal-cor" class="swal2-input" value="#6b46c1">
                    </div>
                </form>
            `,
            confirmButtonText: 'Adicionar',
            showCancelButton: true,
            background: 'var(--fundo-secundario)',
            color: 'var(--texto-principal)',
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
                    .then(response => response.json())
                    .then(data => { if (!data.sucesso) throw new Error(data.mensagem); return data; })
                    .catch(error => { Swal.showValidationMessage(`Request failed: ${error}`); });
            }
        }).then((result) => {
            if (result.isConfirmed) {
                location.reload();
            }
        });
    });

    // Modal para Adicionar Categoria
    document.querySelectorAll('.btn-add-categoria').forEach(button => {
        button.addEventListener('click', function() {
            const pilarId = this.dataset.pilarId;
            Swal.fire({
                title: 'Adicionar Nova Categoria',
                html: `<input id="swal-nome-categoria" class="swal2-input" placeholder="Nome da Categoria">`,
                confirmButtonText: 'Adicionar',
                showCancelButton: true,
                background: 'var(--fundo-secundario)',
                color: 'var(--texto-principal)',
                preConfirm: () => {
                    const nome = document.getElementById('swal-nome-categoria').value;
                    if (!nome) {
                        Swal.showValidationMessage('O nome é obrigatório.');
                        return false;
                    }
                    Swal.showLoading();
                    const formData = new FormData();
                    formData.append('pilar_id', pilarId);
                    formData.append('nome', nome);
                    return fetch('/categoria/criar', { method: 'POST', body: formData })
                        .then(response => response.json())
                        .then(data => { if (!data.sucesso) throw new Error(data.mensagem); return data; })
                        .catch(error => { Swal.showValidationMessage(`Request failed: ${error}`); });
                }
            }).then(result => {
                if (result.isConfirmed) {
                    location.reload();
                }
            });
        });
    });

    // Modal para Adicionar Subcategoria
    document.querySelectorAll('.btn-add-subcategoria').forEach(button => {
        button.addEventListener('click', function() {
            const categoriaId = this.dataset.categoriaId;
            Swal.fire({
                title: 'Adicionar Nova Subcategoria',
                html: `<input id="swal-nome-subcategoria" class="swal2-input" placeholder="Nome da Subcategoria">`,
                confirmButtonText: 'Adicionar',
                showCancelButton: true,
                background: 'var(--fundo-secundario)',
                color: 'var(--texto-principal)',
                preConfirm: () => {
                    const nome = document.getElementById('swal-nome-subcategoria').value;
                    if (!nome) {
                        Swal.showValidationMessage('O nome é obrigatório.');
                        return false;
                    }
                    Swal.showLoading();
                    const formData = new FormData();
                    formData.append('categoria_id', categoriaId);
                    formData.append('nome', nome);
                    return fetch('/subcategoria/criar', { method: 'POST', body: formData })
                        .then(response => response.json())
                        .then(data => { if (!data.sucesso) throw new Error(data.mensagem); return data; })
                        .catch(error => { Swal.showValidationMessage(`Request failed: ${error}`); });
                }
            }).then(result => {
                if (result.isConfirmed) {
                    location.reload();
                }
            });
        });
    });
});
</script>
