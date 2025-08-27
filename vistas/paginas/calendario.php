<div class="dashboard-cabecalho">
    <h1><i class="fas fa-calendar-alt"></i> Calendário</h1>
</div>

<div class="card">
    <div class="card-body">
        <?php
            $timestamp = mktime(0, 0, 0, $mes, 1, $ano);
            $num_dias = date('t', $timestamp);
            $primeiro_dia_semana = date('w', $timestamp);

            $mes_anterior = $mes == 1 ? 12 : $mes - 1;
            $ano_anterior = $mes == 1 ? $ano - 1 : $ano;
            $mes_seguinte = $mes == 12 ? 1 : $mes + 1;
            $ano_seguinte = $mes == 12 ? $ano + 1 : $ano;
        ?>
        <div class="calendario-header">
            <a href="/calendario?mes=<?php echo $mes_anterior; ?>&ano=<?php echo $ano_anterior; ?>">&lt;</a>
            <h2><?php echo date('F', $timestamp) . ' ' . $ano; ?></h2>
            <a href="/calendario?mes=<?php echo $mes_seguinte; ?>&ano=<?php echo $ano_seguinte; ?>">&gt;</a>
        </div>
        <table class="calendario-tabela">
            <thead>
                <tr>
                    <th>Dom</th><th>Seg</th><th>Ter</th><th>Qua</th><th>Qui</th><th>Sex</th><th>Sáb</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <?php
                    for ($i = 0; $i < $primeiro_dia_semana; $i++) {
                        echo '<td></td>';
                    }
                    for ($dia = 1; $dia <= $num_dias; $dia++) {
                        if (($dia + $primeiro_dia_semana - 1) % 7 == 0 && $dia > 1) {
                            echo '</tr><tr>';
                        }
                        $classe_tarefa = isset($tarefas[$dia]) ? 'tem-tarefas' : '';
                        echo "<td class='{$classe_tarefa}'>{$dia}</td>";
                    }
                    while (($dia + $primeiro_dia_semana - 1) % 7 != 0) {
                        echo '<td></td>';
                        $dia++;
                    }
                ?>
                </tr>
            </tbody>
        </table>
    </div>
</div>
