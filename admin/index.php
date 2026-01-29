<?php
/**
 * OPERON ADMIN DASHBOARD
 * Painel de controle administrativo
 */

// Iniciar sessão se ainda não iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Carregar helpers essenciais
require_once __DIR__ . '/../app/config/constants.php';
require_once __DIR__ . '/../app/helpers/sanitize.php';
require_once __DIR__ . '/../app/helpers/format.php';

file_put_contents(__DIR__ . '/../debug_login.log', date('[Y-m-d H:i:s] ') . "Admin Index reached. Session ID: " . session_id() . "\n", FILE_APPEND);
file_put_contents(__DIR__ . '/../debug_login.log', date('[Y-m-d H:i:s] ') . "Session Data: " . print_r($_SESSION, true) . "\n", FILE_APPEND);

// Verificar autenticação
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    file_put_contents(__DIR__ . '/../debug_login.log', date('[Y-m-d H:i:s] ') . "Not logged in. Including login.php\n", FILE_APPEND);
    include __DIR__ . '/actions/login.php';
    exit;
}

// Carregar configurações
require_once __DIR__ . '/../app/config/database.php';
$db = Database::getConnection();

// Detectar view
$view = $_GET['view'] ?? 'dashboard';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operon Cockpit | Dashboard</title>
    <link href="/assets/css/operon.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-petrol text-softwhite font-sans antialiased">

    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <?php include __DIR__ . '/components/sidebar.php'; ?>

        <!-- Main Content -->
        <main class="flex-1 p-8 overflow-y-auto">

            <?php
            // Roteamento interno do admin
            switch($view) {
                case 'leads':
                    include __DIR__ . '/views/leads.php';
                    break;

                case 'lead':
                    include __DIR__ . '/views/lead-detail.php';
                    break;

                case 'configuracoes':
                    include __DIR__ . '/views/configuracoes.php';
                    break;

                case 'logs':
                    include __DIR__ . '/views/logs.php';
                    break;

                default:
                    include __DIR__ . '/views/dashboard.php';
            }
            ?>

        </main>

    </div>

</body>
</html>
