<?php
/**
 * OPERON ADMIN - LOGOUT
 * Encerra sessão administrativa
 */

session_start();

// Destruir todas as variáveis de sessão
$_SESSION = [];

// Destruir a sessão
session_destroy();

// Destruir o cookie de sessão
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Redirecionar para login
header('Location: /admin');
exit;
