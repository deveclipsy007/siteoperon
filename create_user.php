<?php
/**
 * Script para redefinir usuário administrador
 * ATENÇÃO: Executar apenas uma vez e deletar em seguida.
 */

// Carregar bootstrap (conecta no banco automaticamente)
require_once __DIR__ . '/app/bootstrap.php';

echo "<h1>Configuração de Usuário Admin</h1>";

$novo_usuario = 'Yohann';
$nova_senha = 'biagostosona';

try {
    $db = Database::getConnection();

    // 1. Limpar todos os usuários existentes (Garante que só ele terá acesso)
    $db->exec("DELETE FROM admin_users");
    echo "<p>🗑️ Usuários antigos removidos.</p>";

    // 2. Criar hash da senha
    $hash = password_hash($nova_senha, PASSWORD_DEFAULT);

    // 3. Inserir novo usuário
    $stmt = $db->prepare("INSERT INTO admin_users (username, password_hash, nome_completo, ativo) VALUES (?, ?, ?, 1)");
    $stmt->execute([$novo_usuario, $hash, 'Yohann Admin']);

    echo "<p style='color:green; font-weight:bold'>✅ Usuário '$novo_usuario' criado com sucesso!</p>";
    echo "<p>Agora você pode fazer login em <a href='/admin'>/admin</a>.</p>";

} catch (PDOException $e) {
    echo "<p style='color:red'>Erro ao configurar usuário: " . $e->getMessage() . "</p>";
}
