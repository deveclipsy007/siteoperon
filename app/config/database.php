<?php
/**
 * OPERON DATABASE CONNECTION
 * Conexão inteligente que detecta ambiente automaticamente
 * SQLite para desenvolvimento local | MySQL para produção
 */

class Database {
    private static $connection = null;

    public static function getConnection() {
        if (self::$connection === null) {
            // Tentar obter configurações do ambiente
            $db_host = $_ENV['DB_HOST'] ?? getenv('DB_HOST');
            $server_name = $_SERVER['SERVER_NAME'] ?? 'localhost';
            
            // Lógica de Decisão:
            // 1. Se tem DB_HOST definido no .env, usa MySQL (Prioridade Máxima)
            // 2. Se não tem, e parece ser local/CLI, usa SQLite
            
            $use_mysql = !empty($db_host);

            try {
                if ($use_mysql) {
                    // MYSQL (Produção ou Dev com configuração explícita)
                    $host = $db_host;
                    $name = $_ENV['DB_NAME'] ?? getenv('DB_NAME') ?: 'operon_db';
                    $user = $_ENV['DB_USER'] ?? getenv('DB_USER') ?: 'root';
                    $pass = $_ENV['DB_PASS'] ?? getenv('DB_PASS') ?: '';

                    $dsn = "mysql:host=$host;dbname=$name;charset=utf8mb4";
                    self::$connection = new PDO($dsn, $user, $pass, [
                        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
                    ]);

                } else {
                    // SQLITE (Fallback para desenvolvimento local sem .env configurado)
                    $db_path = __DIR__ . '/../../database/local.db';
                    $db_dir = dirname($db_path);
                    if (!file_exists($db_dir)) {
                        mkdir($db_dir, 0755, true);
                    }

                    self::$connection = new PDO("sqlite:$db_path");
                    self::$connection->exec('PRAGMA foreign_keys = ON;');
                }

                // Configurações gerais do PDO
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                self::$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            } catch (PDOException $e) {
                die("Erro de conexão com o banco de dados: " . $e->getMessage());
            }
        }

        return self::$connection;
    }

    /**
     * Verificar se está em ambiente local
     */
    public static function isLocal() {
        $server_name = $_SERVER['SERVER_NAME'] ?? 'localhost';
        return (
            $server_name === 'localhost' ||
            $server_name === '127.0.0.1' ||
            strpos($server_name, '.local') !== false ||
            php_sapi_name() === 'cli'
        );
    }
}
