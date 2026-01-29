<?php
// Roteamento interno do polo público
$page = $_GET['page'] ?? 'home';
$allowed_pages = ['home', 'sobre', 'servicos', 'parcerias', 'agendamento', 'sucesso', 'obrigado', 'sobre-nos', 'termos', 'seguranca', 'processar-agendamento'];

// Sanitizar nome da página
$page = preg_replace('/[^a-z_-]/', '', $page);

// Ações que não requerem layout (redirecionamentos, processamentos)
if ($page === 'processar-agendamento') {
    if (file_exists(__DIR__ . "/pages/{$page}.php")) {
        include __DIR__ . "/pages/{$page}.php";
    }
    exit; // Impede carregamento do restante do layout
}

// Definir página a ser exibida dentro do layout
if (!in_array($page, $allowed_pages) || !file_exists(__DIR__ . "/pages/{$page}.php")) {
    $page = 'home';
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Operon Agents - Arquitetura operacional de elite. Construímos o Motor Replicável que sua empresa precisa para escalar sem ruído.">
    <meta name="keywords" content="automação, agentes de IA, arquitetura de software, motor replicável, soberania técnica">

    <title>Operon Agents | Motor Replicável</title>

    <!-- Tailwind CSS -->
    <link href="/assets/css/operon.css" rel="stylesheet">

    <!-- Favicon (placeholder) -->
    <link rel="icon" type="image/svg+xml" href="/assets/img/favicon.svg">

    <!-- Preconnect for performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Google Fonts: Inter, Montserrat, Poppins, JetBrains Mono -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=JetBrains+Mono:wght@400;500&family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-softwhite text-petrol font-sans antialiased pb-24 md:pb-0">

    <?php include __DIR__ . '/components/header.php'; ?>

    <main>
        <?php include __DIR__ . "/pages/{$page}.php"; ?>
    </main>

    <?php include __DIR__ . '/components/footer.php'; ?>

    <!-- Mobile Floating CTA -->
    <div class="fixed bottom-0 left-0 w-full z-50 md:hidden p-2 bg-petrol-deep/90 backdrop-blur-md border-t border-white/10 shadow-[0_-4px_20px_rgba(0,0,0,0.3)]">
        <a href="?page=agendamento" class="block w-full bg-olive-light text-petrol-deep font-serif text-center font-medium py-5 rounded-lg shadow-glow active:scale-95 transition-transform uppercase tracking-wider text-base">
            Agendar Diagnóstico
        </a>
    </div>

    <!-- Scripts -->
    <script src="/assets/js/form-mask.js"></script>

</body>
</html>
