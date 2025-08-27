<div class="auth-form card">
    <h2 style="text-align: center;">Login</h2>
    <?php if (isset($erro)): ?>
        <div class="alerta alerta-erro"><?php echo htmlspecialchars($erro); ?></div>
    <?php endif; ?>
    <form action="/login" method="POST">
        <div class="campo-grupo com-icone">
            <label for="email" class="sr-only">Email</label>
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" id="email" class="campo-input" placeholder="Email" required>
        </div>
        <div class="campo-grupo com-icone">
            <label for="palavra_passe" class="sr-only">Palavra-passe</label>
            <i class="fas fa-lock"></i>
            <input type="password" name="palavra_passe" id="palavra_passe" class="campo-input" placeholder="Palavra-passe" required>
        </div>
        <button type="submit" class="btn btn-primario" style="width: 100%;">Entrar</button>
    </form>
    <p style="text-align: center; margin-top: 1rem;">Não tem uma conta? <a href="/registo">Registe-se</a></p>
</div>
