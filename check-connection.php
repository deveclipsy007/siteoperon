<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Operon Conexão Diagnostic</h1>";

// 1. Check .env file
$envPath = __DIR__ . '/.env';
echo "<h2>1. Verificando arquivo .env</h2>";
if (file_exists($envPath)) {
    echo "<p style='color:green'>Found: $envPath</p>";
    if (is_readable($envPath)) {
        echo "<p style='color:green'>Readable: YES</p>";
        $content = file_get_contents($envPath);
        echo "<pre>Content Preview (first 50 chars): " . htmlspecialchars(substr($content, 0, 50)) . "...</pre>";
    } else {
        echo "<p style='color:red'>Readable: NO (Check Permissions)</p>";
    }
} else {
    echo "<p style='color:red'>NOT FOUND: $envPath</p>";
    echo "<p>Did you rename <strong>example.env</strong> to <strong>.env</strong>?</p>";
}

// 2. Test Helper Loading
echo "<h2>2. Testando app/helpers/env.php</h2>";
$helperPath = __DIR__ . '/app/helpers/env.php';

if (file_exists($helperPath)) {
    require_once $helperPath;
    echo "<p style='color:green'>Helper Loaded</p>";
    
    // Attempt load
    loadEnv($envPath);
    echo "<p>loadEnv() executed.</p>";
} else {
    echo "<p style='color:red'>Helper Not Found: $helperPath</p>";
}

// 3. Check Variables
echo "<h2>3. Verificando Variáveis Carregadas</h2>";
$vars = ['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS'];

echo "<table border='1' cellpadding='5'>";
echo "<tr><th>Var</th><th>getenv()</th><th>\$_ENV</th><th>Status</th></tr>";

foreach ($vars as $var) {
    $valEnv = $_ENV[$var] ?? 'NULL';
    $valGet = getenv($var);
    
    // Mask password
    if ($var === 'DB_PASS') {
        $valEnv = $valEnv === 'NULL' ? 'NULL' : '******** (' . strlen($valEnv) . ' chars)';
        $valGet = $valGet ? '******** (' . strlen($valGet) . ' chars)' : 'FALSE';
    }
    
    $status = ($valEnv !== 'NULL' || $valGet) ? "<span style='color:green'>OK</span>" : "<span style='color:red'>MISSING</span>";
    
    echo "<tr>";
    echo "<td>$var</td>";
    echo "<td>" . ($valGet ?: 'FALSE') . "</td>";
    echo "<td>$valEnv</td>";
    echo "<td>$status</td>";
    echo "</tr>";
}
echo "</table>";

// 4. Test PDO
echo "<h2>4. Teste de Conexão PDO</h2>";
$host = $_ENV['DB_HOST'] ?? getenv('DB_HOST') ?: 'localhost';
$name = $_ENV['DB_NAME'] ?? getenv('DB_NAME') ?: 'operon_db';
$user = $_ENV['DB_USER'] ?? getenv('DB_USER') ?: 'root';
$pass = $_ENV['DB_PASS'] ?? getenv('DB_PASS') ?: '';

try {
    $dsn = "mysql:host=$host;dbname=$name;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass);
    echo "<p style='color:green; font-weight:bold; font-size:1.2em'>SUCESSO: Conectado ao MySQL!</p>";
} catch (PDOException $e) {
    echo "<p style='color:red; font-weight:bold'>FALHA: " . $e->getMessage() . "</p>";
}
