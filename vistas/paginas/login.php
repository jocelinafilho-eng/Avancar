<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Avançar</title>
    <link rel="stylesheet" href="/recursos/css/principal.css">
</head>
<body style="display: flex; justify-content: center; align-items: center; height: 100vh;">
    <div class="auth-container">
        <div class="auth-form card">
            <h2 style="text-align: center;">Login</h2>
            <?php if (isset($erro)): ?>
                <div class="alerta alerta-erro"><?php echo htmlspecialchars($erro); ?></div>
            <?php endif; ?>
            <form action="/login" method="POST">
                <div class="campo-grupo">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="campo-input" required>
                </div>
                <div class="campo-grupo">
                    <label for="palavra_passe">Palavra-passe</label>
                    <input type="password" name="palavra_passe" id="palavra_passe" class="campo-input" required>
                </div>
                <button type="submit" class="btn btn-primario" style="width: 100%;">Entrar</button>
            </form>
            <p style="text-align: center; margin-top: 1rem;">Não tem uma conta? <a href="/registo">Registe-se</a></p>
        </div>
    </div>
</body>
</html>
