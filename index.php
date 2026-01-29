<?php
/**
 * OPERON SYSTEM - FRONT CONTROLLER
 * A PONTE entre os dois polos (Público e Administrativo)
 *
 * Este arquivo atua como maestro do sistema, roteando as requisições
 * para o polo correto baseado na URL acessada.
 *
 * Estrutura:
 * - /admin -> Polo Administrativo (Dashboard CMS)
 * - /* -> Polo Público (Landing Page)
 *
 * @version 1.0.0
 * @author Operon Agents
 */

// Iniciar sessão
session_start();

// Carregar Configurações de Ambiente (.env)
require_once __DIR__ . '/app/helpers/env.php';
loadEnv(__DIR__ . '/.env');

// Carregar configurações e helpers
require_once __DIR__ . '/app/config/database.php';
require_once __DIR__ . '/app/config/constants.php';
require_once __DIR__ . '/app/helpers/sanitize.php';
require_once __DIR__ . '/app/helpers/format.php';

// Detectar polo baseado na URL
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remover trailing slash (exceto para raiz)
if ($request_uri !== '/' && substr($request_uri, -1) === '/') {
    $request_uri = rtrim($request_uri, '/');
}

// Roteamento principal
if (strpos($request_uri, '/admin') === 0) {
    /**
     * POLO ADMINISTRATIVO
     * Dashboard, gestão de leads, controle do sistema
     */
    require_once __DIR__ . '/admin/index.php';

} else {
    /**
     * POLO PÚBLICO
     * Landing page, funil de diagnóstico, páginas institucionais
     */
    require_once __DIR__ . '/views/layout.php';
}
