<footer class="bg-petrol-deep text-softwhite bg-noise relative overflow-hidden pt-24 pb-12">
    
    <!-- Top Gradient Line -->
    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-olive-light to-transparent opacity-30"></div>

    <div class="container mx-auto px-6 md:px-12 max-w-7xl relative z-10">
        
        <div class="grid grid-cols-1 md:grid-cols-12 gap-12 lg:gap-16 mb-20">
            
            <!-- Brand Column (Span 4) -->
            <div class="md:col-span-4 space-y-8">
                <div class="flex items-center space-x-3">
                    <img src="https://imagedelivery.net/mYdfeAeRRdkIXG5w7XJhtQ/8f0a01dd-7b87-4494-48f3-8af57dee3200/public" 
                         alt="Operon Agents Logo" 
                         class="h-10 md:h-12 w-auto">
                </div>
                <p class="text-white/80 max-w-sm leading-relaxed">
                    Arquitetura operacional de elite. Construímos sistemas proprietários que escalam sem ruído e garantem soberania técnica.
                </p>
            </div>

            <!-- Links (Span 2 each) -->
            <div class="md:col-span-2 md:col-start-7">
                <h4 class="text-xs font-mono uppercase tracking-wider text-olive-light mb-6 font-bold">Produto</h4>
                <ul class="space-y-4 text-sm text-white/90">
                    <li><a href="?page=home" class="hover:text-olive-light transition-colors">Motor</a></li>
                    <li><a href="?page=sobre" class="hover:text-olive-light transition-colors">Engenharia</a></li>
                    <li><a href="?page=servicos" class="hover:text-olive-light transition-colors">Serviços</a></li>
                </ul>
            </div>

            <div class="md:col-span-2">
                <h4 class="text-xs font-mono uppercase tracking-wider text-olive-light mb-6 font-bold">Empresa</h4>
                <ul class="space-y-4 text-sm text-white/90">
                    <li><a href="?page=sobre-nos" class="hover:text-olive-light transition-colors">Sobre Nós</a></li>
                    <li><a href="?page=parcerias" class="hover:text-olive-light transition-colors">Parcerias</a></li>
                    <li><a href="?page=agendamento" class="hover:text-olive-light transition-colors">Diagnóstico</a></li>
                    <li><a href="/admin" class="hover:text-olive-light transition-colors opacity-70">Admin</a></li>
                </ul>
            </div>

            <div class="md:col-span-2">
                <h4 class="text-xs font-mono uppercase tracking-wider text-olive-light mb-6 font-bold">Legal</h4>
                <ul class="space-y-4 text-sm text-white/90">
                    <li><a href="?page=termos" class="hover:text-olive-light transition-colors">Termos</a></li>
                    <li><a href="?page=seguranca" class="hover:text-olive-light transition-colors">Segurança</a></li>
                </ul>
            </div>

        </div>

        <!-- Bottom -->
        <div class="pt-8 border-t border-white/10 flex flex-col md:flex-row items-center justify-between text-xs text-white/60 space-y-4 md:space-y-0 font-mono">
            <p>© <?= date('Y') ?> Operon Agents Inc.</p>
            <p class="italic text-white/40 font-serif">Menos ferramenta. Mais motor.</p>
        </div>

    </div>
</footer>
