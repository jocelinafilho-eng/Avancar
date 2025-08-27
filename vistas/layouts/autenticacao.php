<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($titulo) ? $titulo . ' - Avançar' : 'Avançar'; ?></title>
    <link rel="stylesheet" href="/recursos/css/principal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body style="display: flex; justify-content: center; align-items: center; height: 100vh;">
    <div class="auth-container">
        <?php if (isset($view)) include_once ROOT_PATH . '/vistas/paginas/' . $view . '.php'; ?>
    </div>
    <?php if (isset($_SESSION['flash_message'])): ?>
        <script>
            Swal.fire({
                icon: '<?php echo $_SESSION['flash_message']['tipo']; ?>',
                title: '<?php echo $_SESSION['flash_message']['mensagem']; ?>',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                background: 'var(--fundo-secundario)',
                color: 'var(--texto-principal)'
            });
        </script>
        <?php unset($_SESSION['flash_message']); ?>
    <?php endif; ?>
</body>
</html>
