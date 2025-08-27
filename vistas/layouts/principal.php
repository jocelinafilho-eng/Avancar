<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avançar</title>
    <link rel="stylesheet" href="/recursos/css/principal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/recursos/css/responsivo.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container">
        <?php include_once ROOT_PATH . '/vistas/componentes/menu-lateral.php'; ?>
        <main class="conteudo-principal">
            <?php include_once ROOT_PATH . '/vistas/componentes/cabecalho.php'; ?>
            <div class="pagina-conteudo">
                <!-- O conteúdo da página específica será carregado aqui -->
                <?php if (isset($view)) include_once ROOT_PATH . '/vistas/paginas/' . $view . '.php'; ?>
            </div>
            <?php include_once ROOT_PATH . '/vistas/componentes/rodape.php'; ?>
        </main>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.querySelector('.menu-toggle-btn');
            if(toggleBtn) {
                toggleBtn.addEventListener('click', () => {
                    document.body.classList.toggle('menu-recolhido');
                });
            }
        });
    </script>
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
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const forms = document.querySelectorAll('.form-com-feedback');
        forms.forEach(form => {
            form.addEventListener('submit', function() {
                const submitBtn = form.querySelector('button[type="submit"].btn-com-feedback');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.classList.add('a-processar');
                }
            });
        });
    });
    </script>
    <script src="/recursos/js/app.js"></script>
</body>
</html>
