<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Avançar</title>
    <link rel="stylesheet" href="/recursos/css/principal.css">
    <style>
        body { display: flex; justify-content: center; align-items: center; height: 100vh; }
        .auth-container { width: 100%; max-width: 400px; }
        .auth-form { background: var(--fundo-secundario); padding: 2rem; border-radius: 8px; }
        .campo-grupo { margin-bottom: 1rem; }
        label { display: block; margin-bottom: 0.5rem; }
        input { width: 100%; padding: 0.5rem; border-radius: 4px; border: 1px solid var(--bordas-separadores); background: var(--fundo-principal); color: var(--texto-principal); }
        .btn { width: 100%; padding: 0.75rem; border: none; border-radius: 4px; cursor: pointer; background: var(--primaria); color: white; }
        .alerta { padding: 1rem; margin-bottom: 1rem; border-radius: 4px; }
        .alerta-erro { background: var(--vermelho); color: white; }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-form">
            <h2>Login</h2>
            <?php if (isset($erro)): ?>
                <div class="alerta alerta-erro"><?php echo htmlspecialchars($erro); ?></div>
            <?php endif; ?>
            <form action="/login" method="POST">
                <div class="campo-grupo">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required>
                </div>
                <div class="campo-grupo">
                    <label for="palavra_passe">Palavra-passe</label>
                    <input type="password" name="palavra_passe" id="palavra_passe" required>
                </div>
                <button type="submit" class="btn">Entrar</button>
            </form>
            <p style="text-align: center; margin-top: 1rem;">Não tem uma conta? <a href="/registo" style="color: var(--primaria-hover);">Registe-se</a></p>
        </div>
    </div>
</body>
</html>
