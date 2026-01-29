<?php
/**
 * OPERON DIAGNOSTIC SERVICE
 * Processamento do formulário "Arquiteto Neural"
 * Gera diagnóstico inicial e salva lead no banco de dados
 */

// Carregar dependências
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/sanitize.php';
require_once __DIR__ . '/../helpers/format.php';

// Verificar método
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /?page=agendamento');
    exit;
}

// Sanitizar inputs
$nome = sanitize($_POST['nome'] ?? '');
$email = sanitize_email($_POST['email'] ?? '');
$telefone = sanitize_phone($_POST['telefone'] ?? '');
$empresa = sanitize($_POST['empresa'] ?? '');
$segmento = sanitize($_POST['segmento'] ?? '');
$descricao = sanitize($_POST['descricao_necessidade'] ?? '');

// Validações
$errors = [];

if (empty($nome)) {
    $errors[] = 'Nome é obrigatório';
}

if (!$email) {
    $errors[] = 'E-mail inválido';
}

if (empty($telefone)) {
    $errors[] = 'Telefone é obrigatório';
}

if (empty($empresa)) {
    $errors[] = 'Nome da empresa é obrigatório';
}

if (empty($segmento)) {
    $errors[] = 'Segmento é obrigatório';
}

if (empty($descricao) || strlen($descricao) < 20) {
    $errors[] = 'Descrição muito curta. Seja mais específico sobre sua dor operacional.';
}

// Se houver erros, redirecionar de volta
if (!empty($errors)) {
    $_SESSION['form_errors'] = $errors;
    $_SESSION['form_data'] = $_POST;
    header('Location: /?page=agendamento');
    exit;
}

// Gerar protocolo único
$protocolo = generate_protocol();

// Processar diagnóstico via IA (lógica simplificada)
$diagnostico_ia = gerarDiagnostico($descricao, $segmento);

// Salvar no banco de dados
try {
    $db = Database::getConnection();

    $stmt = $db->prepare("
        INSERT INTO leads (
            nome, email, telefone, empresa, segmento,
            descricao_necessidade, diagnostico_ia, protocolo, status
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pendente')
    ");

    $stmt->execute([
        $nome,
        $email,
        $telefone,
        $empresa,
        $segmento,
        $descricao,
        $diagnostico_ia,
        $protocolo
    ]);

    // Limpar dados da sessão
    unset($_SESSION['form_errors']);
    unset($_SESSION['form_data']);

    // Redirecionar para página de sucesso
    header("Location: /?page=obrigado&protocolo=" . urlencode($protocolo));
    exit;

} catch (PDOException $e) {
    error_log("Erro ao salvar lead: " . $e->getMessage());

    $_SESSION['form_errors'] = ['Erro ao processar diagnóstico. Tente novamente.'];
    header('Location: /?page=agendamento');
    exit;
}

/**
 * Geração de diagnóstico baseado em keywords
 * (Placeholder para integração futura com Claude API)
 */
function gerarDiagnostico($descricao, $segmento) {
    // Keywords que indicam alto potencial de automação
    $keywords_alto = [
        'manual', 'manualmente', 'planilha', 'excel',
        'tempo', 'demora', 'lento', 'retrabalho',
        'erro', 'erros', 'falha', 'problema',
        'dependente', 'dependo', 'pessoa',
        'caos', 'desorganizado', 'perdido'
    ];

    $keywords_moderado = [
        'ferramenta', 'sistema', 'integração',
        'processo', 'follow-up', 'controle',
        'gestão', 'acompanhamento'
    ];

    // Análise de score
    $score_alto = 0;
    $score_moderado = 0;

    $descricao_lower = strtolower($descricao);

    foreach ($keywords_alto as $keyword) {
        if (stripos($descricao_lower, $keyword) !== false) {
            $score_alto++;
        }
    }

    foreach ($keywords_moderado as $keyword) {
        if (stripos($descricao_lower, $keyword) !== false) {
            $score_moderado++;
        }
    }

    // Gerar diagnóstico baseado no score
    if ($score_alto >= 3) {
        return "**ALTO POTENCIAL DE OTIMIZAÇÃO**\n\n" .
               "Sua operação apresenta sinais claros de processos manuais críticos e alta dependência de intervenção humana. " .
               "Recomendamos implementação completa do Motor Operon com:\n\n" .
               "• Centralização de dados e processos\n" .
               "• Automação de fluxos críticos\n" .
               "• Agentes de IA para tarefas operacionais\n" .
               "• Dashboard de controle e métricas\n\n" .
               "ROI esperado: 40-60% de redução em tempo operacional no primeiro trimestre.";

    } elseif ($score_alto >= 1 || $score_moderado >= 2) {
        return "**POTENCIAL MODERADO - CONSULTORIA RECOMENDADA**\n\n" .
               "Identificamos oportunidades de otimização na sua operação. " .
               "Uma sessão de Arquitetura Operacional pode mapear:\n\n" .
               "• Gargalos críticos específicos do seu segmento\n" .
               "• Pontos de integração estratégica\n" .
               "• Módulos prioritários para implementação\n\n" .
               "Recomendamos iniciar com um diagnóstico aprofundado antes da implementação.";

    } else {
        return "**DIAGNÓSTICO INICIAL - APROFUNDAMENTO NECESSÁRIO**\n\n" .
               "Para fornecer uma análise precisa, precisamos entender melhor:\n\n" .
               "• Volume de operações e tamanho da equipe\n" .
               "• Stack tecnológica atual\n" .
               "• Pontos de dor específicos por área\n\n" .
               "Agende uma sessão de 30 minutos com nosso Arquiteto de Operações para um mapeamento técnico completo.";
    }
}
