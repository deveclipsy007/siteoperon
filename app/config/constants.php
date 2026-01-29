<?php
/**
 * OPERON SYSTEM CONSTANTS
 * Constantes globais do sistema
 */

// Versão do sistema
define('OPERON_VERSION', '1.0.0');

// Caminhos base
define('BASE_PATH', __DIR__ . '/../..');
define('APP_PATH', __DIR__ . '/..');
define('VIEWS_PATH', BASE_PATH . '/views');
define('ADMIN_PATH', BASE_PATH . '/admin');
define('ASSETS_PATH', BASE_PATH . '/assets');

// URLs base
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
define('BASE_URL', $protocol . $_SERVER['HTTP_HOST']);

// Status de leads
define('STATUS_PENDENTE', 'pendente');
define('STATUS_EM_ANDAMENTO', 'em_andamento');
define('STATUS_PROTOCOLO_ENVIADO', 'protocolo_enviado');
define('STATUS_EM_REUNIAO', 'em_reuniao');
define('STATUS_FECHADO', 'fechado');
define('STATUS_CANCELADO', 'cancelado');

// Configurações de sessão
define('SESSION_TIMEOUT', getenv('SESSION_LIFETIME') ?: 7200);

// Debug mode
define('DEBUG_MODE', getenv('APP_DEBUG') === 'true');
