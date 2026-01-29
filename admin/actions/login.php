<?php
/**
 * OPERON ADMIN - LOGIN
 * Autenticação do painel administrativo
 */

// Processar login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    file_put_contents(__DIR__ . '/../../debug_login.log', date('[Y-m-d H:i:s] ') . "Login POST received.\n", FILE_APPEND);
    file_put_contents(__DIR__ . '/../../debug_login.log', date('[Y-m-d H:i:s] ') . "Login POST received.\n", FILE_APPEND);
    require_once __DIR__ . '/../../app/bootstrap.php';

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    try {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM admin_users WHERE username = ? AND ativo = 1");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
             file_put_contents(__DIR__ . '/../../debug_login.log', date('[Y-m-d H:i:s] ') . "User found: " . $user['username'] . "\n", FILE_APPEND);
        } else {
             file_put_contents(__DIR__ . '/../../debug_login.log', date('[Y-m-d H:i:s] ') . "User NOT found: $username\n", FILE_APPEND);
        }

        if ($user && password_verify($password, $user['password_hash'])) {
            // Login bem-sucedido
            file_put_contents(__DIR__ . '/../../debug_login.log', date('[Y-m-d H:i:s] ') . "Password verified. Setting session.\n", FILE_APPEND);
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_username'] = $user['username'];
            $_SESSION['admin_nome'] = $user['nome_completo'] ?? 'Admin';

            // Atualizar último acesso
            $stmt = $db->prepare("UPDATE admin_users SET ultimo_acesso = CURRENT_TIMESTAMP WHERE id = ?");
            $stmt->execute([$user['id']]);

            file_put_contents(__DIR__ . '/../../debug_login.log', date('[Y-m-d H:i:s] ') . "Redirecting to /admin\n", FILE_APPEND);
            header('Location: /admin');
            exit;
        } else {
            file_put_contents(__DIR__ . '/../../debug_login.log', date('[Y-m-d H:i:s] ') . "Password verify failed.\n", FILE_APPEND);
            $error = "Credenciais inválidas. Verifique usuário e senha.";
        }
    } catch (PDOException $e) {
        error_log("Erro no login: " . $e->getMessage());
        $error = "Erro ao processar login. Tente novamente.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Operon Cockpit</title>
    <link href="/assets/css/operon.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-petrol text-softwhite flex items-center justify-center min-h-screen font-sans antialiased">

    <div class="w-full max-w-md px-6">

        <!-- Logo/Header -->
        <div class="text-center mb-10">
            <div class="w-16 h-16 bg-olive/20 border border-olive/50 mx-auto flex items-center justify-center mb-4">
                <span class="text-olive font-mono text-xl font-bold">OP</span>
            </div>
            <h1 class="text-3xl font-serif">Operon Cockpit</h1>
            <p class="text-softwhite/70 mt-2 text-sm">Controle Administrativo</p>
        </div>

        <!-- Formulário de Login -->
        <form method="POST" class="bg-white/5 border border-white/10 p-8 space-y-6 backdrop-blur-sm">

            <?php if (isset($error)): ?>
            <div class="bg-red-500/20 border border-red-500/50 p-4 text-sm text-red-200">
                <?= escape($error) ?>
            </div>
            <?php endif; ?>

            <div>
                <label for="username" class="block text-sm mb-2 font-medium">Usuário</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    required
                    autofocus
                    class="w-full bg-white/10 border border-white/20 px-4 py-3 text-softwhite placeholder-softwhite/40 focus:outline-none focus:border-olive transition-colors"
                    placeholder="admin"
                >
            </div>

            <div>
                <label for="password" class="block text-sm mb-2 font-medium">Senha</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    class="w-full bg-white/10 border border-white/20 px-4 py-3 text-softwhite placeholder-softwhite/40 focus:outline-none focus:border-olive transition-colors"
                    placeholder="••••••••"
                >
            </div>

            <button
                type="submit"
                class="w-full bg-olive text-petrol py-3 font-medium hover:bg-olive/90 transition-all duration-300"
            >
                Entrar no Cockpit
            </button>

            <p class="text-center text-xs text-softwhite/50 mt-4">
                Usuário padrão: <code class="text-olive">admin</code> | Senha: <code class="text-olive">operon2024</code>
            </p>

        </form>

        <!-- Link de Volta -->
        <div class="text-center mt-8">
            <a href="/" class="text-sm text-softwhite/60 hover:text-olive transition-colors">
                ← Voltar ao site
            </a>
        </div>

    </div>

</body>
</html>
