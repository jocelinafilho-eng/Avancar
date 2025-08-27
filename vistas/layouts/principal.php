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
    <button class="menu-toggle"><i class="fas fa-bars"></i></button>
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
        document.querySelector('.menu-toggle').addEventListener('click', function() {
            document.querySelector('.menu-lateral').classList.toggle('aberto');
        });
    </script>
</body>
</html>
