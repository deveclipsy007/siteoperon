<aside class="w-64 bg-white/5 border-r border-white/10 min-h-screen p-6 flex flex-col">

    <!-- Logo -->
    <div class="mb-10">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-olive/20 border border-olive/50 flex items-center justify-center">
                <span class="text-olive font-mono text-xs font-bold">OP</span>
            </div>
            <div>
                <h2 class="text-lg font-serif">Operon Cockpit</h2>
                <p class="text-xs text-olive font-mono uppercase tracking-wider">Admin Panel</p>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 space-y-2">
        <a href="/admin" class="block px-4 py-3 text-sm hover:bg-white/5 transition-colors <?= (!isset($_GET['view'])) ? 'bg-white/10 text-olive' : 'text-softwhite/80' ?>">
            <span class="mr-2">📊</span> Dashboard
        </a>

        <a href="/admin?view=leads" class="block px-4 py-3 text-sm hover:bg-white/5 transition-colors <?= (isset($_GET['view']) && $_GET['view'] === 'leads') ? 'bg-white/10 text-olive' : 'text-softwhite/80' ?>">
            <span class="mr-2">👥</span> Leads
        </a>

        <a href="/admin?view=configuracoes" class="block px-4 py-3 text-sm hover:bg-white/5 transition-colors <?= (isset($_GET['view']) && $_GET['view'] === 'configuracoes') ? 'bg-white/10 text-olive' : 'text-softwhite/80' ?>">
            <span class="mr-2">⚙️</span> Configurações
        </a>

        <a href="/admin?view=logs" class="block px-4 py-3 text-sm hover:bg-white/5 transition-colors <?= (isset($_GET['view']) && $_GET['view'] === 'logs') ? 'bg-white/10 text-olive' : 'text-softwhite/80' ?>">
            <span class="mr-2">📝</span> Logs do Sistema
        </a>
    </nav>

    <!-- User Info & Logout -->
    <div class="border-t border-white/10 pt-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <p class="text-sm font-medium"><?= $_SESSION['admin_nome'] ?? 'Admin' ?></p>
                <p class="text-xs text-softwhite/60">@<?= $_SESSION['admin_username'] ?? 'admin' ?></p>
            </div>
        </div>

        <a href="/admin/actions/logout.php" class="block w-full text-center px-4 py-2 text-sm border border-white/20 hover:bg-white/5 transition-colors">
            Sair
        </a>

        <a href="/" target="_blank" class="block w-full text-center px-4 py-2 text-xs text-softwhite/60 hover:text-olive transition-colors mt-2">
            Ver site →
        </a>
    </div>

</aside>
