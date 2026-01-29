<header class="mb-8">
    <h1 class="text-3xl font-serif">Configurações</h1>
    <p class="text-softwhite/70 mt-2">Configurações gerais do sistema</p>
</header>

<div class="bg-white/5 border border-white/10 p-8">
    <h2 class="text-xl font-semibold mb-6">Informações do Sistema</h2>

    <div class="space-y-6">
        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="text-xs uppercase tracking-wider text-olive mb-1 block">Versão</label>
                <p class="text-softwhite font-mono">v<?= OPERON_VERSION ?></p>
            </div>

            <div>
                <label class="text-xs uppercase tracking-wider text-olive mb-1 block">Ambiente</label>
                <p class="text-softwhite font-mono"><?= Database::isLocal() ? 'Desenvolvimento (SQLite)' : 'Produção (MySQL)' ?></p>
            </div>

            <div>
                <label class="text-xs uppercase tracking-wider text-olive mb-1 block">PHP Version</label>
                <p class="text-softwhite font-mono"><?= phpversion() ?></p>
            </div>

            <div>
                <label class="text-xs uppercase tracking-wider text-olive mb-1 block">Servidor</label>
                <p class="text-softwhite font-mono"><?= $_SERVER['SERVER_SOFTWARE'] ?? 'N/A' ?></p>
            </div>
        </div>

        <hr class="border-white/10">

        <div>
            <h3 class="text-lg font-semibold mb-4">Banco de Dados</h3>
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="text-xs uppercase tracking-wider text-olive mb-1 block">Tipo</label>
                    <p class="text-softwhite"><?= Database::isLocal() ? 'SQLite' : 'MySQL' ?></p>
                </div>

                <div>
                    <label class="text-xs uppercase tracking-wider text-olive mb-1 block">Status</label>
                    <p class="text-olive">✓ Conectado</p>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Placeholder para configurações futuras -->
<div class="mt-6 bg-white/5 border border-white/10 p-8">
    <h2 class="text-xl font-semibold mb-4">Configurações Futuras</h2>
    <p class="text-softwhite/60 text-sm">
        Em desenvolvimento: Configurações de e-mail, notificações, integração com APIs externas, etc.
    </p>
</div>
