<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo ao Avançar</title>
    <link rel="stylesheet" href="/recursos/css/principal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="onboarding-body">
    <div class="onboarding-container">
        <?php if (isset($view)) include_once ROOT_PATH . '/vistas/paginas/' . $view . '.php'; ?>
    </div>
</body>
</html>
