<header 
    x-data="{ scrolled: false, mobileMenuOpen: false }" 
    @scroll.window="scrolled = (window.pageYOffset > 20)"
    :class="{ 'bg-petrol-deep shadow-soft py-3': scrolled, 'bg-petrol-deep py-6': !scrolled }"
    class="fixed top-0 w-full z-50 transition-all duration-300 border-b border-transparent"
    :class="{ 'border-white/10': scrolled }">
    
    <div class="container mx-auto px-6 md:px-12 max-w-7xl">
        <div class="flex items-center justify-between">

            <!-- Logo -->
            <a href="?page=home" class="flex items-center group">
                <img src="https://imagedelivery.net/mYdfeAeRRdkIXG5w7XJhtQ/8f0a01dd-7b87-4494-48f3-8af57dee3200/public" 
                     alt="Operon Agents Logo" 
                     class="h-10 md:h-12 w-auto transition-transform duration-300 group-hover:scale-105">
            </a>

            <!-- Desktop Navigation -->
            <nav class="hidden md:flex items-center space-x-8">
                <?php 
                $menuItems = [
                    'home' => 'Motor',
                    'sobre' => 'Engenharia',
                    'servicos' => 'Serviços',
                    'parcerias' => 'Parcerias'
                ];
                $currentPage = $_GET['page'] ?? 'home';
                ?>
                
                <?php foreach ($menuItems as $slug => $label): ?>
                    <a href="?page=<?= $slug ?>" class="relative text-sm font-medium transition-colors duration-200 group <?= $currentPage === $slug ? 'text-white' : 'text-white/70 hover:text-white' ?>">
                        <?= $label ?>
                        <span class="absolute -bottom-1 left-0 w-0 h-px bg-white transition-all duration-300 group-hover:w-full <?= $currentPage === $slug ? 'w-full' : '' ?>"></span>
                    </a>
                <?php endforeach; ?>

                <a href="?page=agendamento" 
                   :class="scrolled ? 'bg-olive text-white' : 'bg-white text-petrol-deep'"
                   class="px-6 py-2.5 text-sm font-medium rounded-md hover:opacity-90 hover:-translate-y-0.5 transition-all duration-300 shadow-lg ml-4">
                    Agendar Diagnóstico
                </a>
            </nav>

            <!-- Mobile Menu Toggle -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 text-white">
                <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="absolute top-full left-0 w-full bg-petrol-deep border-b border-white/10 shadow-lg md:hidden">
        <div class="flex flex-col p-4 space-y-4">
            <?php foreach ($menuItems as $slug => $label): ?>
                <a href="?page=<?= $slug ?>" class="text-white font-medium py-2 px-4 hover:bg-white/10 rounded-lg">
                    <?= $label ?>
                </a>
            <?php endforeach; ?>
            <a href="?page=agendamento" class="text-center bg-white text-petrol-deep font-medium py-3 rounded-lg w-full mt-4">
                Agendar Diagnóstico
            </a>
        </div>
    </div>
</header> 
<!-- Spacer to prevent content jump -->
<div class="h-24 bg-olive-light"></div>
