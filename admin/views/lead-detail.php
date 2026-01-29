<?php
// Buscar lead específico
$lead_id = $_GET['id'] ?? 0;

$stmt = $db->prepare("SELECT * FROM leads WHERE id = ?");
$stmt->execute([$lead_id]);
$lead = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$lead) {
    echo '<div class="p-12 text-center text-softwhite/50">Lead não encontrado.</div>';
    exit;
}

// Processar atualização de status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $new_status = $_POST['status'] ?? '';
    $observacoes = $_POST['observacoes'] ?? '';

    $stmt = $db->prepare("UPDATE leads SET status = ?, observacoes = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
    $stmt->execute([$new_status, $observacoes, $lead_id]);

    // Registrar no histórico
    $stmt = $db->prepare("INSERT INTO lead_history (lead_id, status_anterior, status_novo, observacao, usuario_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$lead_id, $lead['status'], $new_status, $observacoes, $_SESSION['admin_id']]);

    header("Location: /admin?view=lead&id=$lead_id");
    exit;
}
?>

<!-- Header -->
<header class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-3xl font-serif">Lead #<?= escape($lead['protocolo']) ?></h1>
        <p class="text-softwhite/70 mt-2">Cadastrado em <?= format_datetime($lead['created_at']) ?></p>
    </div>
    <a href="/admin?view=leads" class="text-sm text-olive hover:text-softwhite transition-colors">
        ← Voltar para lista
    </a>
</header>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Coluna Principal -->
    <div class="lg:col-span-2 space-y-6">

        <!-- Informações Básicas -->
        <div class="bg-white/5 border border-white/10 p-6">
            <h2 class="text-xl font-semibold mb-6">Informações do Lead</h2>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="text-xs uppercase tracking-wider text-olive mb-1 block">Nome Completo</label>
                    <p class="text-softwhite"><?= escape($lead['nome']) ?></p>
                </div>

                <div>
                    <label class="text-xs uppercase tracking-wider text-olive mb-1 block">Empresa</label>
                    <p class="text-softwhite"><?= escape($lead['empresa']) ?></p>
                </div>

                <div>
                    <label class="text-xs uppercase tracking-wider text-olive mb-1 block">E-mail</label>
                    <p class="text-softwhite">
                        <a href="mailto:<?= escape($lead['email']) ?>" class="hover:text-olive transition-colors">
                            <?= escape($lead['email']) ?>
                        </a>
                    </p>
                </div>

                <div>
                    <label class="text-xs uppercase tracking-wider text-olive mb-1 block">Telefone</label>
                    <p class="text-softwhite">
                        <a href="tel:<?= escape($lead['telefone']) ?>" class="hover:text-olive transition-colors">
                            <?= format_phone($lead['telefone']) ?>
                        </a>
                    </p>
                </div>

                <div>
                    <label class="text-xs uppercase tracking-wider text-olive mb-1 block">Segmento</label>
                    <p class="text-softwhite"><?= ucfirst(escape($lead['segmento'])) ?></p>
                </div>

                <div>
                    <label class="text-xs uppercase tracking-wider text-olive mb-1 block">Status</label>
                    <span class="px-3 py-1 text-xs bg-olive/20 text-olive rounded-full">
                        <?= format_status($lead['status']) ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Descrição da Necessidade -->
        <div class="bg-white/5 border border-white/10 p-6">
            <h2 class="text-xl font-semibold mb-4">Descrição da Dor Operacional</h2>
            <p class="text-softwhite/80 leading-relaxed whitespace-pre-wrap"><?= escape($lead['descricao_necessidade']) ?></p>
        </div>

        <!-- Diagnóstico IA -->
        <div class="bg-white/5 border border-white/10 p-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center">
                <span class="mr-2">🤖</span> Diagnóstico Arquitetural (IA)
            </h2>
            <div class="prose prose-invert max-w-none">
                <p class="text-softwhite/80 leading-relaxed whitespace-pre-wrap"><?= escape($lead['diagnostico_ia']) ?></p>
            </div>
        </div>

    </div>

    <!-- Sidebar -->
    <div class="space-y-6">

        <!-- Atualizar Status -->
        <div class="bg-white/5 border border-white/10 p-6">
            <h3 class="text-lg font-semibold mb-4">Atualizar Status</h3>

            <form method="POST" class="space-y-4">
                <div>
                    <label class="block text-sm mb-2">Novo Status</label>
                    <select
                        name="status"
                        required
                        class="w-full bg-white/10 border border-white/20 px-4 py-2 text-softwhite focus:outline-none focus:border-olive"
                    >
                        <option value="pendente" <?= ($lead['status'] === 'pendente') ? 'selected' : '' ?>>Pendente</option>
                        <option value="em_andamento" <?= ($lead['status'] === 'em_andamento') ? 'selected' : '' ?>>Em Andamento</option>
                        <option value="protocolo_enviado" <?= ($lead['status'] === 'protocolo_enviado') ? 'selected' : '' ?>>Protocolo Enviado</option>
                        <option value="em_reuniao" <?= ($lead['status'] === 'em_reuniao') ? 'selected' : '' ?>>Em Reunião</option>
                        <option value="fechado" <?= ($lead['status'] === 'fechado') ? 'selected' : '' ?>>Fechado</option>
                        <option value="cancelado" <?= ($lead['status'] === 'cancelado') ? 'selected' : '' ?>>Cancelado</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm mb-2">Observações</label>
                    <textarea
                        name="observacoes"
                        rows="4"
                        class="w-full bg-white/10 border border-white/20 px-4 py-2 text-softwhite placeholder-softwhite/40 focus:outline-none focus:border-olive"
                        placeholder="Adicione notas sobre esta atualização..."
                    ><?= escape($lead['observacoes'] ?? '') ?></textarea>
                </div>

                <button type="submit" name="update_status" class="w-full bg-olive text-petrol py-2 font-medium hover:bg-olive/90 transition-all">
                    Atualizar
                </button>
            </form>
        </div>

        <!-- Ações Rápidas -->
        <div class="bg-white/5 border border-white/10 p-6">
            <h3 class="text-lg font-semibold mb-4">Ações Rápidas</h3>

            <div class="space-y-2">
                <a href="mailto:<?= escape($lead['email']) ?>?subject=Operon - Protocolo <?= escape($lead['protocolo']) ?>"
                   class="block w-full text-center border border-white/20 px-4 py-2 text-sm hover:bg-white/5 transition-colors">
                    Enviar E-mail
                </a>

                <a href="tel:<?= escape($lead['telefone']) ?>"
                   class="block w-full text-center border border-white/20 px-4 py-2 text-sm hover:bg-white/5 transition-colors">
                    Ligar
                </a>
            </div>
        </div>

        <!-- Metadados -->
        <div class="bg-white/5 border border-white/10 p-6">
            <h3 class="text-lg font-semibold mb-4">Metadados</h3>

            <div class="space-y-3 text-sm">
                <div>
                    <span class="text-softwhite/60">Protocolo:</span>
                    <p class="font-mono text-olive"><?= escape($lead['protocolo']) ?></p>
                </div>

                <div>
                    <span class="text-softwhite/60">Criado em:</span>
                    <p><?= format_datetime($lead['created_at']) ?></p>
                </div>

                <div>
                    <span class="text-softwhite/60">Última atualização:</span>
                    <p><?= format_datetime($lead['updated_at']) ?></p>
                </div>
            </div>
        </div>

    </div>

</div>
