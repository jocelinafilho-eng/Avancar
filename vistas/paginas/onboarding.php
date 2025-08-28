<div class="onboarding-header">
    <h1>Bem-vindo(a) ao Avançar!</h1>
    <p>Vamos configurar os seus Pilares de Vida. Os pilares são as grandes áreas que estruturam o seu desenvolvimento.</p>
</div>

<form action="/onboarding/salvar" method="POST">
    <div class="onboarding-section">
        <h2>Pilares Obrigatórios</h2>
        <p>Estes são os pilares essenciais que formam a base do sistema. Eles já estão selecionados para si.</p>
        <div class="pilares-grid">
            <div class="pilar-card selecionado desativado">
                <div class="pilar-card-cor" style="background-color: #f44336;"></div>
                <div class="pilar-card-conteudo">
                    <h3><i class="fas fa-heartbeat"></i> Saúde</h3>
                    <p>Cuidados com o corpo e a mente.</p>
                </div>
            </div>
             <div class="pilar-card selecionado desativado">
                <div class="pilar-card-cor" style="background-color: #2196f3;"></div>
                <div class="pilar-card-conteudo">
                    <h3><i class="fas fa-book-open"></i> Educação</h3>
                    <p>Aprimoramento contínuo e aprendizagem.</p>
                </div>
            </div>
             <div class="pilar-card selecionado desativado">
                <div class="pilar-card-cor" style="background-color: #4caf50;"></div>
                <div class="pilar-card-conteudo">
                    <h3><i class="fas fa-dollar-sign"></i> Finanças</h3>
                    <p>Organização e prosperidade financeira.</p>
                </div>
            </div>
             <div class="pilar-card selecionado desativado">
                <div class="pilar-card-cor" style="background-color: #9c27b0;"></div>
                <div class="pilar-card-conteudo">
                    <h3><i class="fas fa-praying-hands"></i> Espiritualidade</h3>
                    <p>Conexão interior e propósito de vida.</p>
                </div>
            </div>
             <div class="pilar-card selecionado desativado">
                <div class="pilar-card-cor" style="background-color: #795548;"></div>
                <div class="pilar-card-conteudo">
                    <h3><i class="fas fa-globe"></i> Global/Básico</h3>
                    <p>Tarefas e hábitos gerais do dia a dia.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="onboarding-section">
        <h2>Pilares Opcionais</h2>
        <p>Selecione outras áreas que são importantes para si neste momento.</p>
        <div class="pilares-grid">

            <label class="pilar-card clicavel">
                <input type="checkbox" name="pilares_opcionais[]" value="Carreira">
                <div class="pilar-card-cor" style="background-color: #ff9800;"></div>
                <div class="pilar-card-conteudo">
                    <h3><i class="fas fa-briefcase"></i> Carreira</h3>
                    <p>Crescimento e desenvolvimento profissional.</p>
                </div>
            </label>
            <label class="pilar-card clicavel">
                <input type="checkbox" name="pilares_opcionais[]" value="Relacionamentos">
                 <div class="pilar-card-cor" style="background-color: #e91e63;"></div>
                <div class="pilar-card-conteudo">
                    <h3><i class="fas fa-users"></i> Relacionamentos</h3>
                    <p>Família, amigos e vida social.</p>
                </div>
            </label>
            <label class="pilar-card clicavel">
                <input type="checkbox" name="pilares_opcionais[]" value="Lazer e Hobbies">
                 <div class="pilar-card-cor" style="background-color: #00bcd4;"></div>
                <div class="pilar-card-conteudo">
                    <h3><i class="fas fa-gamepad"></i> Lazer e Hobbies</h3>
                    <p>Atividades que trazem alegria e descanso.</p>
                </div>
            </label>

        </div>
    </div>

    <div class="onboarding-footer">
        <button type="submit" class="btn btn-primario btn-grande">Concluir e ir para o Dashboard</button>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const pilarCards = document.querySelectorAll('.pilar-card.clicavel');

    pilarCards.forEach(card => {
        card.addEventListener('click', function(e) {
            // Não previne o default para o checkbox funcionar, mas impede bubbling
            e.stopPropagation();

            const checkbox = this.querySelector('input[type="checkbox"]');

            // Sincroniza o estado visual com o checkbox, caso o clique não tenha sido no checkbox
            if (e.target.type !== 'checkbox') {
                 checkbox.checked = !checkbox.checked;
            }

            this.classList.toggle('selecionado', checkbox.checked);
        });
    });
});
</script>
