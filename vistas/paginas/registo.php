<div class="auth-form card">
    <h2 style="text-align: center;">Registo</h2>
    <?php if (isset($erro)): ?>
        <div class="alerta alerta-erro" style="display:none;"><?php echo htmlspecialchars($erro); ?></div>
    <?php endif; ?>
    <form action="/registo" method="POST" class="form-com-feedback">
        <div class="campo-grupo com-icone">
            <label for="nome" class="sr-only">Nome</label>
            <i class="fas fa-user"></i>
            <input type="text" name="nome" id="nome" class="campo-input" placeholder="Nome" required>
        </div>
        <div class="campo-grupo com-icone">
            <label for="email" class="sr-only">Email</label>
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" id="email" class="campo-input" placeholder="Email" required>
        </div>
        <div class="campo-grupo com-icone">
            <label for="palavra_passe" class="sr-only">Palavra-passe</label>
            <i class="fas fa-lock"></i>
            <input type="password" name="palavra_passe" id="palavra_passe" class="campo-input" placeholder="Palavra-passe" required>
            <button type="button" class="btn-toggle-password" data-target="palavra_passe" aria-label="Mostrar/Esconder palavra-passe">
                <i class="fas fa-eye"></i>
            </button>
        </div>
        <div class="campo-grupo com-icone">
            <label for="confirmar_palavra_passe" class="sr-only">Confirmar Palavra-passe</label>
            <i class="fas fa-lock"></i>
            <input type="password" name="confirmar_palavra_passe" id="confirmar_palavra_passe" class="campo-input" placeholder="Confirmar Palavra-passe" required>
            <button type="button" class="btn-toggle-password" data-target="confirmar_palavra_passe" aria-label="Mostrar/Esconder palavra-passe">
                <i class="fas fa-eye"></i>
            </button>
        </div>
        <button type="submit" class="btn btn-primario btn-com-feedback" style="width: 100%;">
            <span class="btn-texto">Registar</span>
            <span class="btn-spinner" style="display: none;"><i class="fas fa-spinner fa-spin"></i></span>
        </button>
    </form>
    <p style="text-align: center; margin-top: 1rem;">Já tem uma conta? <a href="/login">Login</a></p>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const togglePasswordBtns = document.querySelectorAll('.btn-toggle-password');
    togglePasswordBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const targetId = this.dataset.target;
            const passwordInput = document.getElementById(targetId);
            const icon = this.querySelector('i');
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });
    });

    // Usar SweetAlert para o erro, se existir
    const errorDiv = document.querySelector('.alerta-erro');
    if (errorDiv && errorDiv.textContent.trim() !== '') {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: errorDiv.textContent,
            background: 'var(--fundo-secundario)',
            color: 'var(--texto-principal)'
        });
    }
});
</script>
