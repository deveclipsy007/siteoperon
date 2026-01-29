<?php
/**
 * OPERON FORMATTING HELPERS
 * Funções de formatação de dados
 */

/**
 * Formatar data para padrão brasileiro
 */
function format_date($date, $format = 'd/m/Y') {
    if (empty($date)) return '-';

    $timestamp = is_numeric($date) ? $date : strtotime($date);
    return date($format, $timestamp);
}

/**
 * Formatar data e hora
 */
function format_datetime($datetime) {
    return format_date($datetime, 'd/m/Y H:i');
}

/**
 * Formatar telefone brasileiro
 */
function format_phone($phone) {
    $phone = preg_replace('/[^0-9]/', '', $phone);

    $length = strlen($phone);

    if ($length == 11) {
        // (00) 90000-0000
        return sprintf('(%s) %s-%s',
            substr($phone, 0, 2),
            substr($phone, 2, 5),
            substr($phone, 7)
        );
    } elseif ($length == 10) {
        // (00) 0000-0000
        return sprintf('(%s) %s-%s',
            substr($phone, 0, 2),
            substr($phone, 2, 4),
            substr($phone, 6)
        );
    }

    return $phone;
}

/**
 * Formatar CPF
 */
function format_cpf($cpf) {
    $cpf = preg_replace('/[^0-9]/', '', $cpf);

    if (strlen($cpf) == 11) {
        return sprintf('%s.%s.%s-%s',
            substr($cpf, 0, 3),
            substr($cpf, 3, 3),
            substr($cpf, 6, 3),
            substr($cpf, 9, 2)
        );
    }

    return $cpf;
}

/**
 * Formatar CNPJ
 */
function format_cnpj($cnpj) {
    $cnpj = preg_replace('/[^0-9]/', '', $cnpj);

    if (strlen($cnpj) == 14) {
        return sprintf('%s.%s.%s/%s-%s',
            substr($cnpj, 0, 2),
            substr($cnpj, 2, 3),
            substr($cnpj, 5, 3),
            substr($cnpj, 8, 4),
            substr($cnpj, 12, 2)
        );
    }

    return $cnpj;
}

/**
 * Truncar texto com reticências
 */
function truncate($text, $length = 100, $suffix = '...') {
    if (strlen($text) <= $length) {
        return $text;
    }

    return substr($text, 0, $length) . $suffix;
}

/**
 * Formatar status para exibição
 */
function format_status($status) {
    $statuses = [
        'pendente' => 'Pendente',
        'em_andamento' => 'Em Andamento',
        'protocolo_enviado' => 'Protocolo Enviado',
        'em_reuniao' => 'Em Reunião',
        'fechado' => 'Fechado',
        'cancelado' => 'Cancelado'
    ];

    return $statuses[$status] ?? ucfirst($status);
}

/**
 * Gerar protocolo único
 */
function generate_protocol() {
    return 'OP-' . strtoupper(substr(uniqid(), -8));
}
