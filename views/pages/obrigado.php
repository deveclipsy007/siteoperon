<?php
// Retrieve name from POST if available, or default to "Visitante"
$nome = isset($_POST['nome']) ? explode(' ', trim($_POST['nome']))[0] : 'Visitante';
?>

<section class="min-h-screen bg-petrol-deep bg-grid-dark text-white relative overflow-hidden flex items-center justify-center py-20 px-6">
    
    <!-- Ambient Glow -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-olive-light/5 rounded-full blur-3xl pointer-events-none"></div>

    <div class="container max-w-5xl relative z-10 w-full">
        
        <!-- Dashboard Container -->
        <div class="card-tech-dark p-0 overflow-hidden shadow-2xl border border-white/10 flex flex-col md:flex-row min-h-[600px]">
            
            <!-- Left: Sidebar / Status -->
            <div class="w-full md:w-1/3 bg-white/5 border-r border-white/10 p-8 flex flex-col justify-between relative overflow-hidden">
                <!-- Noise Texture Overlay -->
                <div class="absolute inset-0 bg-noise opacity-50 pointer-events-none"></div>

                <div class="relative z-10">
                     <div class="flex items-center space-x-3 mb-12">
                        <div class="w-8 h-8 bg-olive-light text-petrol-deep flex items-center justify-center rounded-sm font-bold font-mono">
                            OP
                        </div>
                        <span class="font-mono text-sm tracking-widest text-olive-light">SYSTEM V2.0</span>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <span class="block text-xs font-mono text-white/40 uppercase mb-1">Status do Protocolo</span>
                            <div class="flex items-center space-x-2">
                                <span class="w-2 h-2 rounded-full bg-olive-light animate-pulse"></span>
                                <span class="text-white font-medium tracking-wide">EM PROCESSAMENTO</span>
                            </div>
                        </div>
                        <div>
                            <span class="block text-xs font-mono text-white/40 uppercase mb-1">User ID</span>
                            <span class="text-white/80 font-mono text-sm"><?= isset($_GET['protocolo']) ? htmlspecialchars($_GET['protocolo']) : 'REQ-' . rand(1000, 9999) . '-XJ' ?></span>
                        </div>
                    </div>
                </div>

                <div class="relative z-10 mt-12 md:mt-0">
                    <p class="text-xs text-white/30 font-mono leading-relaxed">
                        Secure Connection Established.<br>
                        Encrypted End-to-End.<br>
                        Operon Agents Inc. © <?= date('Y') ?>
                    </p>
                </div>
            </div>

            <!-- Right: Content & Timeline -->
            <div class="w-full md:w-2/3 p-12 bg-petrol-deep/50 backdrop-blur-xl relative">
                
                <div class="mb-12">
                    <h1 class="text-4xl font-serif text-white mb-4">Bem-vindo ao Sistema, <?= htmlspecialchars($nome) ?>.</h1>
                    <p class="text-white/70 text-lg font-light leading-relaxed">
                        Recebemos seus dados. Um de nossos arquitetos operacionais analisará seu perfil e entrará em contato para liberar sua credencial.
                    </p>
                </div>

                <!-- Timeline / Process -->
                <div class="space-y-0 relative">
                    <!-- Vertical Line -->
                    <div class="absolute left-6 top-4 bottom-4 w-px bg-white/10"></div>

                    <!-- Step 1 (Current) -->
                    <div class="relative pl-20 pb-12 group">
                        <div class="absolute left-0 top-1 w-12 h-12 bg-olive-light rounded-full flex items-center justify-center shadow-glow z-10 border-4 border-petrol-deep">
                            <svg class="w-5 h-5 text-petrol-deep" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <h3 class="text-xl text-white font-serif mb-2 group-hover:text-olive-light transition-colors">1. Solicitação Recebida</h3>
                        <p class="text-sm text-white/50 leading-relaxed font-mono">
                            Seus dados foram inseridos em nossa fila de prioridade.
                        </p>
                    </div>

                    <!-- Step 2 (Next) -->
                    <div class="relative pl-20 pb-12 opacity-80 group">
                        <div class="absolute left-0 top-1 w-12 h-12 bg-petrol-deep border border-white/20 rounded-full flex items-center justify-center z-10 group-hover:border-olive-light transition-colors">
                            <span class="text-white/50 font-mono text-xs group-hover:text-olive-light">02</span>
                        </div>
                        <h3 class="text-xl text-white font-serif mb-2">2. Contato do Arquiteto</h3>
                        <p class="text-sm text-white/50 leading-relaxed font-mono">
                            Vamos agendar uma breve apresentação para entender seu cenário.
                        </p>
                    </div>

                    <!-- Step 3 (Goal) -->
                    <div class="relative pl-20 opacity-50 group hover:opacity-100 transition-opacity duration-300">
                        <div class="absolute left-0 top-1 w-12 h-12 bg-petrol-deep border border-white/10 rounded-full flex items-center justify-center z-10">
                            <span class="text-white/30 font-mono text-xs">03</span>
                        </div>
                        <h3 class="text-xl text-white font-serif mb-2">3. Demo do Software Proprietário</h3>
                        <p class="text-sm text-white/50 leading-relaxed font-mono">
                            Acesso visual à inteligência que gerencia operações sem caos.
                        </p>
                    </div>

                </div>

                <div class="mt-16 pt-8 border-t border-white/5 flex justify-between items-center">
                    <a href="?page=home" class="text-white/50 hover:text-white transition-colors text-sm font-mono flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Retornar ao site
                    </a>
                </div>

            </div>

        </div>
    </div>
</section>
