<?php
/**
 * OPERON SYSTEM CHECK
 * Verifica se todos os componentes estão prontos
 * Execute: php check-system.php
 */

$checks = [];
$errors = [];

echo "╔══════════════════════════════════════════╗\n";
echo "║   OPERON SYSTEM - VERIFICAÇÃO v1.0.0    ║\n";
echo "╚══════════════════════════════════════════╝\n\n";

// Check 1: PHP Version
echo "🔍 Verificando PHP...\n";
$php_version = phpversion();
if (version_compare($php_version, '8.0.0', '>=')) {
    echo "   ✓ PHP $php_version (OK)\n";
    $checks[] = true;
} else {
    echo "   ✗ PHP $php_version (Mínimo: 8.0)\n";
    $errors[] = "PHP version insuficiente";
    $checks[] = false;
}

// Check 2: Estrutura de Pastas
echo "\n🔍 Verificando estrutura de pastas...\n";
$required_dirs = [
    'admin', 'admin/actions', 'admin/components', 'admin/views',
    'app', 'app/config', 'app/helpers', 'app/services',
    'assets', 'assets/css', 'assets/js', 'assets/img',
    'database',
    'views', 'views/components', 'views/pages'
];

$missing_dirs = [];
foreach ($required_dirs as $dir) {
    if (!is_dir($dir)) {
        $missing_dirs[] = $dir;
    }
}

if (empty($missing_dirs)) {
    echo "   ✓ Todas as pastas existem (" . count($required_dirs) . ")\n";
    $checks[] = true;
} else {
    echo "   ✗ Pastas faltando: " . implode(', ', $missing_dirs) . "\n";
    $errors[] = "Estrutura de pastas incompleta";
    $checks[] = false;
}

// Check 3: Arquivos Críticos
echo "\n🔍 Verificando arquivos críticos...\n";
$required_files = [
    'index.php',
    'app/config/database.php',
    'app/config/constants.php',
    'database/schema.sql',
    'views/layout.php',
    'admin/index.php',
    'admin/actions/login.php',
    'tailwind.config.js',
    'DOCUMENTATION.md',
    'README.md'
];

$missing_files = [];
foreach ($required_files as $file) {
    if (!file_exists($file)) {
        $missing_files[] = $file;
    }
}

if (empty($missing_files)) {
    echo "   ✓ Todos os arquivos críticos existem (" . count($required_files) . ")\n";
    $checks[] = true;
} else {
    echo "   ✗ Arquivos faltando: " . implode(', ', $missing_files) . "\n";
    $errors[] = "Arquivos críticos faltando";
    $checks[] = false;
}

// Check 4: Extensões PHP
echo "\n🔍 Verificando extensões PHP...\n";
$required_extensions = ['pdo', 'pdo_sqlite', 'pdo_mysql', 'mbstring', 'json'];
$missing_extensions = [];

foreach ($required_extensions as $ext) {
    if (!extension_loaded($ext)) {
        $missing_extensions[] = $ext;
    }
}

if (empty($missing_extensions)) {
    echo "   ✓ Todas as extensões necessárias estão instaladas\n";
    $checks[] = true;
} else {
    echo "   ✗ Extensões faltando: " . implode(', ', $missing_extensions) . "\n";
    $errors[] = "Extensões PHP faltando";
    $checks[] = false;
}

// Check 5: Permissões de Escrita
echo "\n🔍 Verificando permissões...\n";
$writable_dirs = ['database'];
$permission_errors = [];

foreach ($writable_dirs as $dir) {
    if (!is_writable($dir)) {
        $permission_errors[] = $dir;
    }
}

if (empty($permission_errors)) {
    echo "   ✓ Permissões de escrita OK\n";
    $checks[] = true;
} else {
    echo "   ✗ Sem permissão de escrita: " . implode(', ', $permission_errors) . "\n";
    $errors[] = "Permissões insuficientes";
    $checks[] = false;
}

// Check 6: Arquivo .env
echo "\n🔍 Verificando configuração...\n";
if (file_exists('.env')) {
    echo "   ✓ Arquivo .env existe\n";
    $checks[] = true;
} else {
    echo "   ⚠️  Arquivo .env não encontrado (copie example.env)\n";
    $checks[] = true; // Não bloqueante
}

// Check 7: CSS
echo "\n🔍 Verificando assets...\n";
if (file_exists('assets/css/operon.css')) {
    $css_size = filesize('assets/css/operon.css');
    echo "   ✓ CSS compilado existe (" . round($css_size / 1024, 2) . " KB)\n";
    $checks[] = true;
} else {
    echo "   ⚠️  CSS não compilado (execute: npm run build)\n";
    $checks[] = true; // Não bloqueante
}

// Check 8: Teste de Conexão com Banco
echo "\n🔍 Testando conexão com banco de dados...\n";
try {
    require_once 'app/config/database.php';
    $db = Database::getConnection();
    echo "   ✓ Conexão com banco estabelecida\n";

    // Verificar tabelas
    if (Database::isLocal()) {
        $stmt = $db->query("SELECT name FROM sqlite_master WHERE type='table' AND name='leads'");
    } else {
        $stmt = $db->query("SHOW TABLES LIKE 'leads'");
    }

    if ($stmt->fetch()) {
        echo "   ✓ Tabelas existem\n";
        $checks[] = true;
    } else {
        echo "   ⚠️  Tabelas não encontradas (execute: php database/init.php)\n";
        $checks[] = true; // Não bloqueante
    }
} catch (Exception $e) {
    echo "   ✗ Erro de conexão: " . $e->getMessage() . "\n";
    $errors[] = "Falha na conexão com banco de dados";
    $checks[] = false;
}

// Resumo Final
echo "\n" . str_repeat("=", 50) . "\n";

$total_checks = count($checks);
$passed_checks = count(array_filter($checks));
$percentage = round(($passed_checks / $total_checks) * 100);

if (empty($errors)) {
    echo "✅ SISTEMA PRONTO! ($passed_checks/$total_checks verificações - $percentage%)\n\n";
    echo "📝 Próximos passos:\n";
    echo "   1. Inicialize o banco: php database/init.php\n";
    echo "   2. Compile o CSS: npm run build\n";
    echo "   3. Inicie o servidor: php -S localhost:8000\n";
    echo "   4. Acesse: http://localhost:8000\n";
    echo "   5. Admin: http://localhost:8000/admin\n";
    echo "      Usuário: admin | Senha: operon2024\n\n";
    exit(0);
} else {
    echo "⚠️  ATENÇÃO: $passed_checks/$total_checks verificações passaram ($percentage%)\n\n";
    echo "❌ Erros encontrados:\n";
    foreach ($errors as $error) {
        echo "   • $error\n";
    }
    echo "\n";
    exit(1);
}
