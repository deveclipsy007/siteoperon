<?php
// Carregar bootstrap
require_once __DIR__ . '/app/bootstrap.php';

echo "<h1>Debug de Usuários e Sessão</h1>";

// 1. Verificar Sessão
echo "<h2>1. Status da Sessão</h2>";
if (session_status() === PHP_SESSION_ACTIVE) {
    echo "<p style='color:green'>Sessão Ativa. ID: " . session_id() . "</p>";
    echo "<pre>Conteúdo da Sessão: " . print_r($_SESSION, true) . "</pre>";
} else {
    echo "<p style='color:red'>Sessão NÃO iniciada.</p>";
}

// 2. Listar Usuários
echo "<h2>2. Usuários no Banco (admin_users)</h2>";

try {
    $db = Database::getConnection();
    $stmt = $db->query("SELECT id, username, ativo, created_at FROM admin_users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($users) > 0) {
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>ID</th><th>Username</th><th>Ativo</th><th>Criado em</th></tr>";
        foreach ($users as $user) {
            echo "<tr>";
            echo "<td>" . $user['id'] . "</td>";
            echo "<td><strong>" . $user['username'] . "</strong></td>";
            echo "<td>" . ($user['ativo'] ? 'SIM' : 'NÃO') . "</td>";
            echo "<td>" . $user['created_at'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='color:red; font-weight:bold'>NENHUM USUÁRIO ENCONTRADO!</p>";
        echo "<p>Por favor, execute o <code>create_user.php</code> novamente.</p>";
    }

} catch (PDOException $e) {
    echo "<p style='color:red'>Erro no Banco: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<p><a href='/admin/actions/logout.php'>Forçar Logout e Tentar Novamente</a></p>";
