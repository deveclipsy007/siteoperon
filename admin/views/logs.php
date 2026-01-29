<?php
// Ler project_logs.json
$logs_file = __DIR__ . '/../../project_logs.json';
$logs = [];

if (file_exists($logs_file)) {
    $logs_content = file_get_contents($logs_file);
    $logs = json_decode($logs_content, true) ?? [];
}

// Ordenar logs por timestamp (mais recente primeiro)
usort($logs, function($a, $b) {
    return strtotime($b['timestamp']) - strtotime($a['timestamp']);
});
?>

<header class="mb-8">
    <h1 class="text-3xl font-serif">Logs do Sistema</h1>
    <p class="text-softwhite/70 mt-2">Histórico de alterações e manutenções</p>
</header>

<?php if (empty($logs)): ?>
    <div class="bg-white/5 border border-white/10 p-12 text-center text-softwhite/50">
        <p>Nenhum log registrado ainda.</p>
    </div>
<?php else: ?>
    <div class="space-y-4">
        <?php foreach ($logs as $index => $log): ?>
        <div class="bg-white/5 border border-white/10 p-6">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-olive"><?= escape($log['action'] ?? 'Ação não especificada') ?></h3>
                    <p class="text-xs text-softwhite/60 mt-1">
                        <?= format_datetime($log['timestamp'] ?? 'N/A') ?>
                    </p>
                </div>
                <span class="text-xs font-mono text-softwhite/60">#<?= ($index + 1) ?></span>
            </div>

            <?php if (!empty($log['details'])): ?>
            <p class="text-sm text-softwhite/80 mb-4"><?= escape($log['details']) ?></p>
            <?php endif; ?>

            <?php if (!empty($log['impact']) && is_array($log['impact'])): ?>
            <div>
                <p class="text-xs uppercase tracking-wider text-olive mb-2">Arquivos Afetados:</p>
                <div class="flex flex-wrap gap-2">
                    <?php foreach ($log['impact'] as $file): ?>
                    <span class="text-xs font-mono bg-white/10 px-2 py-1 border border-white/10">
                        <?= escape($file) ?>
                    </span>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
