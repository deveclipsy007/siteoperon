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
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }
        
        @keyframes shimmer {
            0% {
                background-position: -1000px 0;
            }
            100% {
                background-position: 1000px 0;
            }
        }
        
        .fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }
        
        .logo-container {
            animation: fadeInUp 0.6s ease-out 0.1s both;
        }
        
        .form-container {
            animation: fadeInUp 0.6s ease-out 0.2s both;
        }
        
        .back-link {
            animation: fadeInUp 0.6s ease-out 0.3s both;
        }
        
        .logo-icon {
            transition: all 0.3s ease;
        }
        
        .logo-container:hover .logo-icon {
            transform: rotate(360deg) scale(1.1);
            background: linear-gradient(135deg, rgba(147, 197, 114, 0.3), rgba(147, 197, 114, 0.1));
        }
        
        .input-group {
            position: relative;
        }
        
        .input-field {
            transition: all 0.3s ease;
        }
        
        .input-field:focus {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(147, 197, 114, 0.2);
        }
        
        .submit-btn {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .submit-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        
        .submit-btn:hover::before {
            left: 100%;
        }
        
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(147, 197, 114, 0.3);
        }
        
        .submit-btn:active {
            transform: translateY(0);
        }
        
        .error-message {
            animation: shake 0.5s ease-in-out;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }
        
        .bg-animated {
            background: linear-gradient(-45deg, #0a2e2e, #0d3838, #0a2e2e, #0f3f3f);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
        }
        
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .floating-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }
        
        .shape {
            position: absolute;
            background: rgba(147, 197, 114, 0.05);
            border-radius: 50%;
            animation: float 20s infinite ease-in-out;
        }
        
        .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            left: 10%;
            animation-delay: 0s;
        }
        
        .shape:nth-child(2) {
            width: 120px;
            height: 120px;
            right: 20%;
            animation-delay: 2s;
        }
        
        .shape:nth-child(3) {
            width: 60px;
            height: 60px;
            left: 70%;
            animation-delay: 4s;
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            33% {
                transform: translateY(-100px) rotate(120deg);
            }
            66% {
                transform: translateY(-50px) rotate(240deg);
            }
        }
    </style>
</head>
<body class="bg-petrol text-softwhite flex items-center justify-center min-h-screen font-sans antialiased bg-animated">
    
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <div class="w-full max-w-md px-6 fade-in-up">

        <!-- Logo/Header -->
        <div class="text-center mb-10 logo-container">
            <div class="w-20 h-20 bg-olive/20 border border-olive/50 mx-auto flex items-center justify-center mb-4 rounded-2xl logo-icon backdrop-blur-sm">
                <span class="text-olive font-mono text-2xl font-bold">OP</span>
            </div>
            <h1 class="text-4xl font-serif mb-2 bg-gradient-to-r from-softwhite to-olive bg-clip-text text-transparent">Operon Cockpit</h1>
            <p class="text-softwhite/70 text-sm">Painel Administrativo Seguro</p>
            <div class="mt-4 flex items-center justify-center space-x-2">
                <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                <span class="text-xs text-softwhite/50">Sistema Online</span>
            </div>
        </div>

        <!-- Formulário de Login -->
        <form method="POST" class="bg-white/5 border border-white/10 p-8 space-y-6 backdrop-blur-sm rounded-2xl shadow-2xl form-container">

            <?php if (isset($error)): ?>
            <div class="bg-red-500/20 border border-red-500/50 p-4 text-sm text-red-200 rounded-lg flex items-center space-x-3 error-message">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                <span><?= escape($error) ?></span>
            </div>
            <?php endif; ?>

            <div>
                <label for="username" class="block text-sm mb-2 font-medium text-softwhite/80">Usuário</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    required
                    autofocus
                    class="w-full bg-white/10 border border-white/20 px-4 py-3 text-softwhite placeholder-softwhite/40 focus:outline-none focus:border-olive transition-all duration-300 rounded-lg input-field"
                    placeholder="Digite seu usuário"
                >
            </div>

            <div>
                <label for="password" class="block text-sm mb-2 font-medium text-softwhite/80">Senha</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    class="w-full bg-white/10 border border-white/20 px-4 py-3 text-softwhite placeholder-softwhite/40 focus:outline-none focus:border-olive transition-all duration-300 rounded-lg input-field"
                    placeholder="Digite sua senha"
                >
            </div>

            <button
                type="submit"
                class="w-full bg-olive text-petrol py-3 font-medium hover:bg-olive/90 transition-all duration-300 submit-btn rounded-lg font-semibold tracking-wide"
            >
                <span class="relative z-10 flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                    </svg>
                    <span>Acessar Cockpit</span>
                </span>
            </button>

            
        </form>

        <!-- Links Úteis -->
        <div class="mt-6 space-y-3 back-link">
            <div class="text-center">
                <a href="#" class="text-xs text-softwhite/50 hover:text-olive transition-colors">Esqueceu sua senha?</a>
            </div>
            <div class="text-center">
                <a href="/" class="text-sm text-softwhite/60 hover:text-olive transition-colors inline-flex items-center space-x-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span>Voltar ao site</span>
                </a>
            </div>
        </div>

    </div>

</body>
</html>
