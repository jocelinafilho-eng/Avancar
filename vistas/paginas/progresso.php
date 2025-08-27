<div class="dashboard-cabecalho">
    <h1><i class="fas fa-chart-line"></i> Progresso e Análises</h1>
    <p>Visualize o seu progresso ao longo do tempo.</p>
</div>

<div class="card">
    <div class="card-header">
        <h3>Progresso por Pilar (Dados Mockados)</h3>
    </div>
    <div class="card-body">
        <canvas id="graficoProgressoPilares"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('graficoProgressoPilares').getContext('2d');
    const dados = <?php echo json_encode($dados_grafico['dados']); ?>;
    const labels = <?php echo json_encode($dados_grafico['labels']); ?>;

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Progresso (%)',
                data: dados,
                backgroundColor: 'rgba(107, 70, 193, 0.5)',
                borderColor: 'rgba(107, 70, 193, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100
                }
            }
        }
    });
});
</script>
