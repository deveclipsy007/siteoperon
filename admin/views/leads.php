<?php
// Filtros
$filter_status = $_GET['status'] ?? 'all';
$search = $_GET['search'] ?? '';

// Query base
$query = "SELECT * FROM leads WHERE 1=1";
$params = [];

// Aplicar filtros
if ($filter_status !== 'all') {
    $query .= " AND status = ?";
    $params[] = $filter_status;
}

if (!empty($search)) {
    $query .= " AND (nome LIKE ? OR empresa LIKE ? OR email LIKE ? OR protocolo LIKE ?)";
    $search_param = "%$search%";
    $params = array_merge($params, [$search_param, $search_param, $search_param, $search_param]);
}

$query .= " ORDER BY created_at DESC";

$stmt = $db->prepare($query);
$stmt->execute($params);
$leads = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Header -->
<header class="mb-8">
    <h1 class="text-3xl font-serif">Gestão de Leads</h1>
    <p class="text-softwhite/70 mt-2">Todos os diagnósticos recebidos</p>
</header>

<!-- Filtros -->
<div class="bg-white/5 border border-white/10 p-6 mb-6">
    <form method="GET" class="flex flex-wrap gap-4 items-end">
        <input type="hidden" name="view" value="leads">

        <!-- Busca -->
        <div class="flex-1 min-w-[200px]">
            <label class="block text-sm mb-2">Buscar</label>
            <input
                type="text"
                name="search"
                value="<?= escape($search) ?>"
                placeholder="Nome, empresa, email, protocolo..."
                class="w-full bg-white/10 border border-white/20 px-4 py-2 text-softwhite placeholder-softwhite/40 focus:outline-none focus:border-olive"
            >
        </div>

        <!-- Status -->
        <div class="min-w-[180px]">
            <label class="block text-sm mb-2">Status</label>
            <select
                name="status"
                class="w-full bg-white/10 border border-white/20 px-4 py-2 text-softwhite focus:outline-none focus:border-olive"
            >
                <option value="all" <?= ($filter_status === 'all') ? 'selected' : '' ?>>Todos</option>
                <option value="pendente" <?= ($filter_status === 'pendente') ? 'selected' : '' ?>>Pendentes</option>
                <option value="em_andamento" <?= ($filter_status === 'em_andamento') ? 'selected' : '' ?>>Em Andamento</option>
                <option value="protocolo_enviado" <?= ($filter_status === 'protocolo_enviado') ? 'selected' : '' ?>>Protocolo Enviado</option>
                <option value="em_reuniao" <?= ($filter_status === 'em_reuniao') ? 'selected' : '' ?>>Em Reunião</option>
                <option value="fechado" <?= ($filter_status === 'fechado') ? 'selected' : '' ?>>Fechado</option>
                <option value="cancelado" <?= ($filter_status === 'cancelado') ? 'selected' : '' ?>>Cancelado</option>
            </select>
        </div>

        <!-- Botões -->
        <button type="submit" class="bg-olive text-petrol px-6 py-2 font-medium hover:bg-olive/90 transition-all">
            Filtrar
        </button>

        <?php if (!empty($search) || $filter_status !== 'all'): ?>
        <a href="/admin?view=leads" class="border border-white/20 px-6 py-2 text-sm hover:bg-white/5 transition-all">
            Limpar
        </a>
        <?php endif; ?>
    </form>
</div>

<!-- Tabela de Leads -->
<div class="bg-white/5 border border-white/10">
    <div class="p-6 border-b border-white/10">
        <h2 class="text-xl font-semibold">
            <?= count($leads) ?> lead(s) encontrado(s)
        </h2>
    </div>

    <?php if (empty($leads)): ?>
        <div class="p-12 text-center text-softwhite/50">
            <p>Nenhum lead encontrado com os filtros aplicados.</p>
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
                    <?php foreach ($leads as $lead): ?>
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
