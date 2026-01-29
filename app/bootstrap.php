<?php
/**
 * OPERON BOOTSTRAP
 * Inicialização centralizada do sistema
 * Garante que ambiente, banco e helpers estejam carregados em qualquer ponto de entrada
 */

// 1. Iniciar Sessão (se ainda não iniciada)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Carregar Variáveis de Ambiente
require_once __DIR__ . '/helpers/env.php';
// Tenta carregar do diretório atual, ou sobe um nível se estiver em subpasta, ou sobe dois...
// A estratégia mais segura é assumir que o .env está na raiz do projeto (pai de 'app')
$rootDir = dirname(__DIR__); // .../siteoperonagents
loadEnv($rootDir . '/.env');

// 3. Carregar Constantes e Helpers
require_once __DIR__ . '/config/constants.php';
require_once __DIR__ . '/helpers/sanitize.php';
require_once __DIR__ . '/helpers/format.php';

// 4. Carregar Banco de Dados
require_once __DIR__ . '/config/database.php';
