<section class="min-h-screen pt-32 pb-24 bg-softwhite bg-grid-light relative overflow-hidden">
    <div class="container mx-auto px-6 max-w-4xl relative z-10">
        
        <!-- Header -->
        <div class="text-center mb-16 space-y-6">
            <div class="badge-tech">Acesso Exclusivo</div>
            <h1 class="text-4xl md:text-6xl font-serif text-neutral-dark">Software & Arquitetura</h1>
            <p class="text-xl text-neutral-mid max-w-2xl mx-auto leading-relaxed">
                Nós não vendemos apenas código. Nós desenhamos <strong class="text-petrol-deep">sistemas operacionais</strong>. Solicite uma demo do nosso motor inteligente.
            </p>
        </div>

        <!-- Form Card -->
        <div class="card-tech p-8 md:p-12 shadow-card hover:translate-y-0">
            
            <form action="?page=processar-agendamento" method="POST" class="space-y-8">

                 <div class="space-y-6">
                    <!-- Nome -->
                    <div class="space-y-3">
                        <label for="nome" class="block text-sm font-semibold text-neutral-dark">
                            Nome Completo <span class="text-olive-light">*</span>
                        </label>
                        <input type="text" id="nome" name="nome" required class="input-tech" placeholder="Seu nome">
                    </div>

                    <!-- Email -->
                    <div class="space-y-3">
                        <label for="email" class="block text-sm font-semibold text-neutral-dark">
                            E-mail Corporativo <span class="text-olive-light">*</span>
                        </label>
                        <input type="email" id="email" name="email" required class="input-tech" placeholder="voce@empresa.com.br">
                    </div>

                    <!-- Telefone -->
                    <div class="space-y-3">
                        <label for="telefone" class="block text-sm font-semibold text-neutral-dark">
                            Whatsapp / Telefone <span class="text-olive-light">*</span>
                        </label>
                        <input type="tel" id="telefone" name="telefone" required class="input-tech" placeholder="(11) 90000-0000">
                    </div>
                </div>

                <!-- Consent -->
                <div class="bg-neutral-light/30 rounded-lg p-6 border border-neutral-light/50">
                    <div class="flex items-start space-x-4">
                        <input type="checkbox" id="consent" name="consent" required class="mt-1 w-5 h-5 rounded border-neutral-mid text-petrol-deep focus:ring-petrol-deep cursor-pointer">
                        <label for="consent" class="text-sm text-neutral-mid leading-relaxed cursor-pointer">
                            Autorizo o contato para agendamento da demonstração do software. Entendo que esta é uma aplicação comercial.
                        </label>
                    </div>
                </div>

                <!-- Submit -->
                <div class="pt-4">
                    <button type="submit" class="w-full btn-primary text-lg shadow-xl hover:shadow-2xl hover:-translate-y-1 transform transition-all duration-300">
                        Liberar Acesso à Demo
                    </button>
                    <p class="text-xs text-center text-neutral-mid/60 mt-4 font-mono">
                        Acesso concedido após validação
                    </p>
                </div>

            </form>
        </div>

        <!-- Trust Signals -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-16">
            <div class="text-center p-6 bg-white/50 rounded-lg border border-neutral-light/50 backdrop-blur-sm">
                <div class="w-10 h-10 mx-auto bg-olive-light/10 text-olive-light rounded-full flex items-center justify-center mb-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <h3 class="text-sm font-semibold text-neutral-dark">Confidencial</h3>
                <p class="text-xs text-neutral-mid">Seus dados estão protegidos</p>
            </div>

            <div class="text-center p-6 bg-white/50 rounded-lg border border-neutral-light/50 backdrop-blur-sm">
                <div class="w-10 h-10 mx-auto bg-olive-light/10 text-olive-light rounded-full flex items-center justify-center mb-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-sm font-semibold text-neutral-dark">Gratuito</h3>
                <p class="text-xs text-neutral-mid">Análise inicial sem custo</p>
            </div>

            <div class="text-center p-6 bg-white/50 rounded-lg border border-neutral-light/50 backdrop-blur-sm">
                 <div class="w-10 h-10 mx-auto bg-olive-light/10 text-olive-light rounded-full flex items-center justify-center mb-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <h3 class="text-sm font-semibold text-neutral-dark">Resposta Rápida</h3>
                <p class="text-xs text-neutral-mid">Retorno em 24h</p>
            </div>
        </div>

    </div>
</section>
