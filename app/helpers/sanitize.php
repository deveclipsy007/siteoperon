<?php
/**
 * OPERON SANITIZATION HELPERS
 * Funções de sanitização e validação de inputs
 */

/**
 * Sanitizar string genérica
 */
function sanitize($input) {
    if (is_array($input)) {
        return array_map('sanitize', $input);
    }

    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');

    return $input;
}

/**
 * Sanitizar e-mail
 */
function sanitize_email($email) {
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    return filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : false;
}

/**
 * Sanitizar telefone
 */
function sanitize_phone($phone) {
    // Remove tudo exceto números
    return preg_replace('/[^0-9]/', '', $phone);
}

/**
 * Sanitizar URL
 */
function sanitize_url($url) {
    $url = filter_var($url, FILTER_SANITIZE_URL);
    return filter_var($url, FILTER_VALIDATE_URL) ? $url : false;
}

/**
 * Validar CPF (útil para futuras expansões)
 */
function validate_cpf($cpf) {
    $cpf = preg_replace('/[^0-9]/', '', $cpf);

    if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    // Validação do dígito verificador
    for ($t = 9; $t < 11; $t++) {
        $d = 0;
        for ($c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }

    return true;
}

/**
 * Escapar output para prevenir XSS
 */
function escape($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
