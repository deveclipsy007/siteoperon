<?php
/**
 * OPERON DATABASE INITIALIZATION
 * Script para inicializar o banco de dados automaticamente
 * Execute: php database/init.php
 */

require_once __DIR__ . '/../app/config/database.php';

echo "🔧 Inicializando banco de dados Operon...\n\n";

try {
    // Conectar ao banco
    $db = Database::getConnection();
    echo "✓ Conexão estabelecida\n";

    // Ler schema SQL
    $schema = file_get_contents(__DIR__ . '/schema.sql');

    // Executar comandos SQL
    $statements = explode(';', $schema);

    foreach ($statements as $statement) {
        $statement = trim($statement);
        if (!empty($statement)) {
            $db->exec($statement);
        }
    }

    echo "✓ Tabelas criadas com sucesso\n";

    // Verificar tabelas
    if (Database::isLocal()) {
        $result = $db->query("SELECT name FROM sqlite_master WHERE type='table'");
    } else {
        $result = $db->query("SHOW TABLES");
    }

    echo "\n📊 Tabelas disponíveis:\n";
    while ($row = $result->fetch(PDO::FETCH_NUM)) {
        echo "  - {$row[0]}\n";
    }

    // Verificar usuário admin
    $stmt = $db->query("SELECT username FROM admin_users WHERE username = 'admin'");
    $admin = $stmt->fetch();

    if ($admin) {
        echo "\n✓ Usuário admin já existe\n";
    } else {
        echo "\n⚠️  Usuário admin não encontrado. Execute o schema.sql novamente.\n";
    }

    echo "\n✅ Banco de dados inicializado com sucesso!\n";
    echo "\n📝 Credenciais de acesso:\n";
    echo "   Usuário: admin\n";
    echo "   Senha: operon2024\n";
    echo "\n🚀 Acesse: http://localhost:8000/admin\n";

} catch (PDOException $e) {
    echo "\n❌ Erro ao inicializar banco: " . $e->getMessage() . "\n";
    exit(1);
}
