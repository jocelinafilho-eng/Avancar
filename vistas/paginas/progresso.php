<div class="dashboard-cabecalho">
    <h1><i class="fas fa-chart-line"></i> Progresso e Análises</h1>
    <p>Visualize o seu progresso ao longo do tempo.</p>
</div>

<div class="card">
    <div class="card-header">
        <h3>Tarefas por Pilar</h3>
    </div>
    <div class="card-body">
        <canvas id="graficoProgressoPilares"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('graficoProgressoPilares').getContext('2d');
    const labels = <?php echo json_encode($dados_grafico['labels']); ?>;
    const dadosConcluidas = <?php echo json_encode($dados_grafico['dados_concluidas']); ?>;
    const dadosTotais = <?php echo json_encode($dados_grafico['dados_totais']); ?>;
    const cores = <?php echo json_encode($dados_grafico['cores']); ?>;

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Tarefas Concluídas',
                    data: dadosConcluidas,
                    backgroundColor: cores.map(cor => cor + 'BF'), // Adiciona transparência
                    borderColor: cores,
                    borderWidth: 1
                },
                {
                    label: 'Tarefas Totais',
                    data: dadosTotais,
                    backgroundColor: 'rgba(200, 200, 200, 0.2)',
                    borderColor: 'rgba(200, 200, 200, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>
