<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <div class="calendario-header">
            <?php
                $mes = $data['mes'];
                $ano = $data['ano'];
                $mes_anterior = $mes == 1 ? 12 : $mes - 1;
                $ano_anterior = $mes == 1 ? $ano - 1 : $ano;
                $mes_seguinte = $mes == 12 ? 1 : $mes + 1;
                $ano_seguinte = $mes == 12 ? $ano + 1 : $ano;
                $meses_pt = [1=>'Janeiro', 2=>'Fevereiro', 3=>'Março', 4=>'Abril', 5=>'Maio', 6=>'Junho', 7=>'Julho', 8=>'Agosto', 9=>'Setembro', 10=>'Outubro', 11=>'Novembro', 12=>'Dezembro'];
                $nome_mes_pt = $meses_pt[(int)$mes];
            ?>
            <a href="/calendario?mes=<?php echo $mes_anterior; ?>&ano=<?php echo $ano_anterior; ?>&meta_id=<?php echo $data['meta_id_selecionada']; ?>" class="btn"><i class="fas fa-chevron-left"></i></a>
            <h2><?php echo $nome_mes_pt . ' ' . $ano; ?></h2>
            <a href="/calendario?mes=<?php echo $mes_seguinte; ?>&ano=<?php echo $ano_seguinte; ?>&meta_id=<?php echo $data['meta_id_selecionada']; ?>" class="btn"><i class="fas fa-chevron-right"></i></a>
        </div>
        <div class="calendario-filtro">
            <form action="/calendario" method="GET" id="form-filtro-calendario">
                <input type="hidden" name="mes" value="<?php echo $mes; ?>">
                <input type="hidden" name="ano" value="<?php echo $ano; ?>">
                <div class="campo-grupo" style="margin-bottom: 0;">
                    <label for="meta-filtro" class="sr-only">Filtrar por Meta</label>
                    <select name="meta_id" id="meta-filtro" class="campo-input" onchange="this.form.submit()">
                        <option value="">Todas as Metas</option>
                        <?php foreach($data['metas_filtro'] as $meta): ?>
                            <option value="<?php echo $meta['id']; ?>" <?php echo ($data['meta_id_selecionada'] == $meta['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($meta['nome']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </form>
        </div>
    </div>
    <div class="card-body">
        <?php
            $tarefas = $data['tarefas'];
            $timestamp = mktime(0, 0, 0, $mes, 1, $ano);
            $num_dias = date('t', $timestamp);
            $primeiro_dia_semana = date('w', $timestamp);
            $hoje_ano = date('Y');
            $hoje_mes = date('m');
            $hoje_dia = date('d');
        ?>
        <table class="calendario-tabela">
            <thead>
                <tr><th>Dom</th><th>Seg</th><th>Ter</th><th>Qua</th><th>Qui</th><th>Sex</th><th>Sáb</th></tr>
            </thead>
            <tbody>
                <tr>
                <?php
                    for ($i = 0; $i < $primeiro_dia_semana; $i++) { echo '<td></td>'; }
                    for ($dia = 1; $dia <= $num_dias; $dia++) {
                        if (($dia + $primeiro_dia_semana - 1) % 7 == 0 && $dia > 1) { echo '</tr><tr>'; }
                        $classes = [];
                        if (isset($tarefas[$dia])) { $classes[] = 'tem-tarefas'; }
                        if ($dia == $hoje_dia && $mes == $hoje_mes && $ano == $hoje_ano) { $classes[] = 'dia-atual'; }
                        $class_str = implode(' ', $classes);
                        echo "<td class='{$class_str}'><span>{$dia}</span></td>";
                    }
                    while (($dia + $primeiro_dia_semana - 1) % 7 != 0) { echo '<td></td>'; $dia++; }
                ?>
                </tr>
            </tbody>
        </table>
    </div>
</div>
