<?php
// Capturar protocolo da URL
$protocolo = $_GET['protocolo'] ?? 'N/A';
?>

<section class="py-24 px-6 bg-softwhite min-h-screen flex items-center">
    <div class="max-w-3xl mx-auto text-center">

        <!-- Ícone de Sucesso -->
        <div class="w-20 h-20 border-2 border-olive mx-auto flex items-center justify-center mb-8">
            <svg class="w-10 h-10 text-olive" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>

        <!-- Mensagem Principal -->
        <h1 class="text-4xl md:text-5xl font-serif mb-6 text-petrol">Diagnóstico Recebido</h1>

        <p class="text-xl text-petrol/70 mb-8 leading-relaxed">
            Seu diagnóstico foi processado e está sendo analisado pela nossa equipe de Arquitetos de Operações.
        </p>

        <!-- Protocolo -->
        <div class="bg-petrol/5 border border-petrol/10 p-6 mb-8">
            <p class="text-sm text-petrol/60 mb-2 uppercase tracking-wider">Seu Protocolo</p>
            <p class="text-2xl font-mono text-olive font-semibold"><?= escape($protocolo) ?></p>
            <p class="text-xs text-petrol/50 mt-2">Guarde este número para acompanhamento</p>
        </div>

        <!-- Próximos Passos -->
        <div class="text-left bg-white border border-petrol/10 p-8 mb-8">
            <h2 class="text-xl font-semibold mb-6 text-petrol text-center">Próximos Passos</h2>

            <ol class="space-y-4 text-petrol/70">
                <li class="flex items-start space-x-4">
                    <span class="text-olive font-mono text-sm mt-1">01</span>
                    <div>
                        <strong class="text-petrol block mb-1">Análise Técnica (24-48h)</strong>
                        <span class="text-sm">Nossa equipe analisa seu diagnóstico e mapeia oportunidades de otimização.</span>
                    </div>
                </li>

                <li class="flex items-start space-x-4">
                    <span class="text-olive font-mono text-sm mt-1">02</span>
                    <div>
                        <strong class="text-petrol block mb-1">Retorno Personalizado</strong>
                        <span class="text-sm">Você receberá um e-mail com insights técnicos e próximos passos sugeridos.</span>
                    </div>
                </li>

                <li class="flex items-start space-x-4">
                    <span class="text-olive font-mono text-sm mt-1">03</span>
                    <div>
                        <strong class="text-petrol block mb-1">Sessão de Arquitetura (Opcional)</strong>
                        <span class="text-sm">Se houver fit técnico, agendaremos uma sessão de 30min para aprofundar o mapeamento.</span>
                    </div>
                </li>
            </ol>
        </div>

        <!-- CTA -->
        <div class="space-y-4">
            <a href="?page=home" class="inline-block border border-petrol text-petrol px-8 py-3 hover:bg-petrol hover:text-softwhite transition-all duration-300 font-medium">
                Voltar ao início
            </a>

            <p class="text-sm text-petrol/60">
                Enquanto isso, conheça mais sobre <a href="?page=servicos" class="text-olive hover:underline">nossos serviços</a> e <a href="?page=sobre" class="text-olive hover:underline">nossa filosofia</a>.
            </p>
        </div>

        <!-- Informação de Contato -->
        <div class="mt-12 pt-8 border-t border-petrol/10">
            <p class="text-sm text-petrol/60">
                Dúvidas? Entre em contato: <a href="mailto:contato@operon.com.br" class="text-olive hover:underline">contato@operon.com.br</a>
            </p>
        </div>

    </div>
</section>
