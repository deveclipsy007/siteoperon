/**
 * OPERON SYSTEM - FORM MASKS
 * Máscaras de formatação para campos de formulário
 */

document.addEventListener('DOMContentLoaded', function() {

    // Máscara de telefone brasileiro
    const phoneInputs = document.querySelectorAll('input[type="tel"]');
    phoneInputs.forEach(input => {
        input.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');

            if (value.length <= 10) {
                // (00) 0000-0000
                value = value.replace(/^(\d{2})(\d{4})(\d{4}).*/, '($1) $2-$3');
            } else {
                // (00) 90000-0000
                value = value.replace(/^(\d{2})(\d{5})(\d{4}).*/, '($1) $2-$3');
            }

            e.target.value = value;
        });
    });

    // Validação de e-mail em tempo real
    const emailInputs = document.querySelectorAll('input[type="email"]');
    emailInputs.forEach(input => {
        input.addEventListener('blur', function(e) {
            const email = e.target.value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (email && !emailRegex.test(email)) {
                e.target.classList.add('border-red-500');
            } else {
                e.target.classList.remove('border-red-500');
            }
        });
    });

    // Character counter para textareas
    const textareas = document.querySelectorAll('textarea[maxlength]');
    textareas.forEach(textarea => {
        const maxLength = textarea.getAttribute('maxlength');

        // Criar contador
        const counter = document.createElement('div');
        counter.className = 'text-xs text-petrol/60 mt-1 text-right';
        counter.textContent = `0 / ${maxLength}`;

        textarea.parentNode.appendChild(counter);

        // Atualizar contador
        textarea.addEventListener('input', function() {
            const length = textarea.value.length;
            counter.textContent = `${length} / ${maxLength}`;

            if (length >= maxLength * 0.9) {
                counter.classList.add('text-olive');
            }
        });
    });

    // Auto-resize para textareas
    const autoResizeTextareas = document.querySelectorAll('textarea');
    autoResizeTextareas.forEach(textarea => {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    });

    // Confirmação antes de enviar formulários importantes
    const importantForms = document.querySelectorAll('form[data-confirm]');
    importantForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const message = form.getAttribute('data-confirm');
            if (!confirm(message)) {
                e.preventDefault();
            }
        });
    });

    // Loading state em botões de submit
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                const originalText = submitBtn.textContent;
                submitBtn.textContent = 'Processando...';

                // Restaurar após 5 segundos (fallback)
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    submitBtn.textContent = originalText;
                }, 5000);
            }
        });
    });

});
