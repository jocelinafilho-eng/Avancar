function iniciarGestorDeTarefasDoDia() {
    // Listener para actualizar estado da tarefa (completar/descompletar)
    document.body.addEventListener('change', function(event) {
        if (event.target.matches('.tarefa-item input[type="checkbox"]')) {
            const checkbox = event.target;
            const id_tarefa = checkbox.dataset.id;
            const concluida = checkbox.checked ? 1 : 0;
            const label = checkbox.nextElementSibling;

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
                    label.classList.toggle('concluida', concluida);
                    // Opcional: mostrar um alerta de sucesso rápido
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                          toast.onmouseenter = Swal.stopTimer;
                          toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                    Toast.fire({
                        icon: 'success',
                        title: concluida ? 'Tarefa concluída!' : 'Tarefa reaberta!'
                    });
                } else {
                    checkbox.checked = !checkbox.checked; // Reverte
                    mostrarAlertaErro('Erro ao atualizar a tarefa.');
                }
            })
            .catch(error => {
                checkbox.checked = !checkbox.checked; // Reverte
                mostrarAlertaErro('Erro de conexão ao servidor.');
            });
        }
    });

    // Listener para os botões de remover tarefa
    document.body.addEventListener('click', function(event) {
        if (event.target.matches('.btn-remover-tarefa')) {
            const btn = event.target;
            const id_tarefa = btn.dataset.id;

            Swal.fire({
                title: 'Tem a certeza?',
                text: "Não poderá reverter esta ação!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'var(--primaria)',
                cancelButtonColor: 'var(--hover-focus)',
                confirmButtonText: 'Sim, remover!',
                cancelButtonText: 'Cancelar',
                background: 'var(--fundo-secundario)',
                color: 'var(--texto-principal)'
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData();
                    formData.append('id_tarefa', id_tarefa);

                    fetch('/tarefa/remover', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.sucesso) {
                            document.querySelector(`.tarefa-item[data-id-tarefa="${id_tarefa}"]`).remove();
                            mostrarAlertaSucesso('Tarefa removida.');
                        } else {
                            mostrarAlertaErro(data.erro || 'Não foi possível remover a tarefa.');
                        }
                    })
                    .catch(() => mostrarAlertaErro('Erro de comunicação com o servidor.'));
                }
            })
        }
    });

    // Listener para campos condicionais do formulário
    const tipoTemporalSelect = document.getElementById('tipo-temporal');
    if(tipoTemporalSelect) {
        tipoTemporalSelect.addEventListener('change', function() {
            const camposPeriodo = document.getElementById('campos-periodo');
            const camposHoraMarcada = document.getElementById('campos-hora-marcada');

            camposPeriodo.style.display = 'none';
            camposHoraMarcada.style.display = 'none';

            if (this.value === 'periodo') {
                camposPeriodo.style.display = 'block';
            } else if (this.value === 'hora_marcada') {
                camposHoraMarcada.style.display = 'block';
            }
        });
        tipoTemporalSelect.dispatchEvent(new Event('change'));
    }

}

function adicionarTarefaNaLista(tarefa) {
    const elementoTarefa = criarElementoTarefa(tarefa);
    let container;

    if (tarefa.tipo_temporal === 'hora_marcada') {
        container = document.getElementById('lista-tarefas-hora_marcada');
    } else if (tarefa.tipo_temporal === 'arbitraria') {
        container = document.getElementById('lista-tarefas-arbitraria');
    } else if (tarefa.tipo_temporal === 'periodo') {
        container = document.getElementById(`lista-tarefas-${tarefa.periodo}`);
    }

    if (container) {
        const placeholder = container.querySelector('.sem-tarefas');
        if (placeholder) {
            placeholder.remove();
        }
        container.insertAdjacentHTML('beforeend', elementoTarefa);
    }
}

function criarElementoTarefa(tarefa) {
    const nomeEscapado = tarefa.nome.replace(/</g, "&lt;").replace(/>/g, "&gt;");
    let prefixo = '';
    if (tarefa.tipo_temporal === 'hora_marcada' && tarefa.hora_inicio) {
        prefixo = `${tarefa.hora_inicio.substring(0, 5)} - `;
    }

    return `
        <div class="tarefa-item" data-id-tarefa="${tarefa.id}">
            <input type="checkbox" id="tarefa-${tarefa.id}" data-id="${tarefa.id}">
            <label for="tarefa-${tarefa.id}" class="">${prefixo}${nomeEscapado}</label>
            <button class="btn-remover-tarefa" data-id="${tarefa.id}">&times;</button>
        </div>
    `;
}

function mostrarAlertaSucesso(mensagem) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        background: 'var(--fundo-secundario)',
        color: 'var(--texto-principal)',
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });
    Toast.fire({
        icon: 'success',
        title: mensagem
    });
}

function mostrarAlertaErro(mensagem) {
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: mensagem,
        background: 'var(--fundo-secundario)',
        color: 'var(--texto-principal)'
    });
}

// Inicia os scripts da página do dia se o container existir
if (document.querySelector('.dia-container')) {
    iniciarGestorDeTarefasDoDia();
}
