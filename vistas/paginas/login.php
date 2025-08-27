<div class="auth-form card">
    <h2 style="text-align: center;">Login</h2>
    <?php if (isset($erro)): ?>
        <div class="alerta alerta-erro" style="display:none;"><?php echo htmlspecialchars($erro); ?></div>
    <?php endif; ?>
    <form action="/login" method="POST" class="form-com-feedback">
        <div class="campo-grupo com-icone">
            <label for="email" class="sr-only">Email</label>
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" id="email" class="campo-input" placeholder="Email" required>
        </div>
        <div class="campo-grupo com-icone">
            <label for="palavra_passe" class="sr-only">Palavra-passe</label>
            <i class="fas fa-lock"></i>
            <input type="password" name="palavra_passe" id="palavra_passe" class="campo-input" placeholder="Palavra-passe" required>
            <button type="button" class="btn-toggle-password" aria-label="Mostrar/Esconder palavra-passe">
                <i class="fas fa-eye"></i>
            </button>
        </div>
        <button type="submit" class="btn btn-primario btn-com-feedback" style="width: 100%;">
            <span class="btn-texto">Entrar</span>
            <span class="btn-spinner" style="display: none;"><i class="fas fa-spinner fa-spin"></i></span>
        </button>
    </form>
    <p style="text-align: center; margin-top: 1rem;">Não tem uma conta? <a href="/registo">Registe-se</a></p>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const togglePasswordBtn = document.querySelector('.btn-toggle-password');
    if (togglePasswordBtn) {
        togglePasswordBtn.addEventListener('click', function() {
            const passwordInput = document.getElementById('palavra_passe');
            const icon = this.querySelector('i');
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });
    }

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
