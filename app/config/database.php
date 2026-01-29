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
            // Detectar ambiente baseado no hostname
            $server_name = $_SERVER['SERVER_NAME'] ?? 'localhost';
            $is_local = (
                $server_name === 'localhost' ||
                $server_name === '127.0.0.1' ||
                strpos($server_name, '.local') !== false ||
                php_sapi_name() === 'cli' // CLI sempre usa SQLite
            );

            try {
                if ($is_local) {
                    // SQLITE para desenvolvimento
                    $db_path = __DIR__ . '/../../database/local.db';

                    // Criar diretório se não existir
                    $db_dir = dirname($db_path);
                    if (!file_exists($db_dir)) {
                        mkdir($db_dir, 0755, true);
                    }

                    self::$connection = new PDO("sqlite:$db_path");

                    // Habilitar chaves estrangeiras no SQLite
                    self::$connection->exec('PRAGMA foreign_keys = ON;');

                } else {
                    // MYSQL para produção (Hostinger)
                    $host = getenv('DB_HOST') ?: 'localhost';
                    $name = getenv('DB_NAME') ?: 'operon_db';
                    $user = getenv('DB_USER') ?: 'root';
                    $pass = getenv('DB_PASS') ?: '';

                    $dsn = "mysql:host=$host;dbname=$name;charset=utf8mb4";
                    self::$connection = new PDO($dsn, $user, $pass, [
                        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
                    ]);
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
