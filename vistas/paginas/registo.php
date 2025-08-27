<div class="auth-form card">
    <h2 style="text-align: center;">Registo</h2>
    <?php if (isset($erro)): ?>
        <div class="alerta alerta-erro"><?php echo htmlspecialchars($erro); ?></div>
    <?php endif; ?>
    <form action="/registo" method="POST">
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
        </div>
        <button type="submit" class="btn btn-primario" style="width: 100%;">Registar</button>
    </form>
    <p style="text-align: center; margin-top: 1rem;">Já tem uma conta? <a href="/login">Login</a></p>
</div>
