<?php
// Buscar estatísticas
$stats = [];

// Total de leads
$stmt = $db->query("SELECT COUNT(*) as total FROM leads");
$stats['total_leads'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

// Pendentes
$stmt = $db->query("SELECT COUNT(*) as total FROM leads WHERE status = 'pendente'");
$stats['pendentes'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

// Em andamento
$stmt = $db->query("SELECT COUNT(*) as total FROM leads WHERE status = 'em_andamento'");
$stats['em_andamento'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

// Fechados (últimos 30 dias)
$stmt = $db->query("SELECT COUNT(*) as total FROM leads WHERE status = 'fechado' AND created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)");
$stats['fechados_mes'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

// Leads recentes
$stmt = $db->query("SELECT * FROM leads ORDER BY created_at DESC LIMIT 10");
$leads_recentes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Header -->
<header class="mb-8">
    <h1 class="text-3xl font-serif">Dashboard Operon</h1>
    <p class="text-softwhite/70 mt-2">Controle total da operação</p>
</header>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

    <div class="bg-white/5 border border-white/10 p-6">
        <h3 class="text-olive text-sm uppercase tracking-wider mb-2">Total de Leads</h3>
        <p class="text-4xl font-serif"><?= $stats['total_leads'] ?></p>
    </div>

    <div class="bg-white/5 border border-white/10 p-6">
        <h3 class="text-olive text-sm uppercase tracking-wider mb-2">Pendentes</h3>
        <p class="text-4xl font-serif"><?= $stats['pendentes'] ?></p>
        <?php if ($stats['pendentes'] > 0): ?>
        <p class="text-xs text-softwhite/50 mt-2">⚠️ Necessitam atenção</p>
        <?php endif; ?>
    </div>

    <div class="bg-white/5 border border-white/10 p-6">
        <h3 class="text-olive text-sm uppercase tracking-wider mb-2">Em Andamento</h3>
        <p class="text-4xl font-serif"><?= $stats['em_andamento'] ?></p>
    </div>

    <div class="bg-white/5 border border-white/10 p-6">
        <h3 class="text-olive text-sm uppercase tracking-wider mb-2">Fechados (30d)</h3>
        <p class="text-4xl font-serif"><?= $stats['fechados_mes'] ?></p>
    </div>

</div>

<!-- Leads Recentes -->
<div class="bg-white/5 border border-white/10">
    <div class="p-6 border-b border-white/10 flex items-center justify-between">
        <h2 class="text-xl font-semibold">Leads Recentes</h2>
        <a href="/admin?view=leads" class="text-sm text-olive hover:text-softwhite transition-colors">
            Ver todos →
        </a>
    </div>

    <?php if (empty($leads_recentes)): ?>
        <div class="p-12 text-center text-softwhite/50">
            <p>Nenhum lead cadastrado ainda.</p>
            <p class="text-sm mt-2">Aguardando primeiro diagnóstico...</p>
        </div>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="border-b border-white/10">
                    <tr>
                        <th class="text-left p-4 text-sm font-medium text-olive">Protocolo</th>
                        <th class="text-left p-4 text-sm font-medium text-olive">Nome</th>
                        <th class="text-left p-4 text-sm font-medium text-olive">Empresa</th>
                        <th class="text-left p-4 text-sm font-medium text-olive">Segmento</th>
                        <th class="text-left p-4 text-sm font-medium text-olive">Status</th>
                        <th class="text-left p-4 text-sm font-medium text-olive">Data</th>
                        <th class="text-left p-4 text-sm font-medium text-olive">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($leads_recentes as $lead): ?>
                    <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
                        <td class="p-4 font-mono text-sm"><?= escape($lead['protocolo']) ?></td>
                        <td class="p-4"><?= escape($lead['nome']) ?></td>
                        <td class="p-4"><?= escape($lead['empresa']) ?></td>
                        <td class="p-4 text-sm text-softwhite/70"><?= ucfirst($lead['segmento']) ?></td>
                        <td class="p-4">
                            <span class="px-3 py-1 text-xs bg-olive/20 text-olive rounded-full">
                                <?= format_status($lead['status']) ?>
                            </span>
                        </td>
                        <td class="p-4 text-sm"><?= format_date($lead['created_at']) ?></td>
                        <td class="p-4">
                            <a href="/admin?view=lead&id=<?= $lead['id'] ?>"
                               class="text-olive hover:text-softwhite text-sm transition-colors">
                                Ver detalhes
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

</div>
