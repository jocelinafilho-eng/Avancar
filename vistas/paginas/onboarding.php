<div class="onboarding-container" style="max-width: 800px; margin: auto;">
    <div class="card">
        <div class="card-body">
            <h1 style="text-align: center;">Bem-vindo ao Avançar!</h1>
            <p style="text-align: center;">Vamos configurar a sua conta. Comece por selecionar os pilares que são importantes para si.</p>

            <form action="/onboarding/salvar" method="POST">
                <h3><i class="fas fa-lock"></i> Pilares Obrigatórios</h3>
                <p>Estes são os pilares fundamentais que vêm pré-selecionados.</p>
                <ul class="lista-pilares">
                    <li><i class="fas fa-heartbeat"></i> Saúde</li>
                    <li><i class="fas fa-book-open"></i> Educação</li>
                    <li><i class="fas fa-coins"></i> Finanças</li>
                    <li><i class="fas fa-pray"></i> Espiritualidade</li>
                    <li><i class="fas fa-globe"></i> Global/Básico</li>
                </ul>

                <hr style="border-color: var(--bordas-separadores); margin: 2rem 0;">

                <h3><i class="fas fa-check-square"></i> Pilares Opcionais</h3>
                <p>Selecione os pilares que também fazem parte da sua vida.</p>
                <div class="pilares-opcionais-grid">
                    <div><input type="checkbox" name="pilares_opcionais[]" value="Carreira" id="p-carreira"> <label for="p-carreira">Carreira</label></div>
                    <div><input type="checkbox" name="pilares_opcionais[]" value="Desenvolvimento Pessoal" id="p-dev"> <label for="p-dev">Desenvolvimento Pessoal</label></div>
                    <div><input type="checkbox" name="pilares_opcionais[]" value="Relacionamentos" id="p-rel"> <label for="p-rel">Relacionamentos</label></div>
                    <div><input type="checkbox" name="pilares_opcionais[]" value="Família" id="p-fam"> <label for="p-fam">Família</label></div>
                    <div><input type="checkbox" name="pilares_opcionais[]" value="Lazer/Entretenimento" id="p-lazer"> <label for="p-lazer">Lazer/Entretenimento</label></div>
                </div>

                <button type="submit" class="btn" style="width: 100%; margin-top: 2rem;">Concluir Onboarding e Ir para o Dashboard</button>
            </form>
        </div>
    </div>
</div>
