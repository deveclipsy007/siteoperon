# ⚡ OPERON SYSTEM - GUIA DE INÍCIO RÁPIDO

**Versão 1.0.0** | Sistema pronto para uso

---

## 🚀 INÍCIO IMEDIATO (3 comandos)

```bash
# 1. Inicializar banco de dados
php database/init.php

# 2. Instalar Tailwind (opcional - CSS básico já incluído)
npm install && npm run build

# 3. Iniciar servidor
php -S localhost:8000
```

**Pronto!** Acesse [http://localhost:8000](http://localhost:8000)

---

## 🔐 ACESSO ADMIN

**URL:** [http://localhost:8000/admin](http://localhost:8000/admin)

**Credenciais:**
- Usuário: `admin`
- Senha: `operon2024`

⚠️ **Altere a senha após primeiro acesso!**

---

## 📋 VERIFICAÇÃO DO SISTEMA

```bash
# Verificar se tudo está funcionando
php check-system.php
```

Este comando verifica:
- ✓ Versão do PHP (8.0+)
- ✓ Estrutura de pastas completa
- ✓ Arquivos críticos presentes
- ✓ Extensões PHP necessárias
- ✓ Permissões de escrita
- ✓ Configuração (.env)
- ✓ Assets (CSS/JS)
- ✓ Conexão com banco de dados

---

## 🎨 COMPILAR CSS (TAILWIND)

### Desenvolvimento (watch mode)
```bash
npm run dev
```

### Produção (minificado)
```bash
npm run build
```

**Nota:** Um CSS básico já está incluído. Compilar é opcional mas recomendado.

---

## 📁 ESTRUTURA RÁPIDA

```
operon-system/
├── admin/          → Dashboard administrativo
├── app/            → Core (config, helpers, services)
├── assets/         → CSS, JS, imagens
├── database/       → SQLite e schema
├── views/          → Landing page pública
└── index.php       → Front Controller (ponte)
```

---

## 🧪 TESTAR O SISTEMA

### 1. Página Inicial
- Acesse: http://localhost:8000
- Verifique Hero Section e navegação

### 2. Formulário de Diagnóstico
- Acesse: http://localhost:8000/?page=agendamento
- Preencha e envie
- Verifique página de sucesso com protocolo

### 3. Dashboard Admin
- Acesse: http://localhost:8000/admin
- Faça login (admin/operon2024)
- Verifique estatísticas e lista de leads
- Teste visualização detalhada de lead

### 4. Atualizar Status
- No dashboard, clique em um lead
- Altere o status
- Adicione observações
- Salve e verifique histórico

---

## 🔧 PROBLEMAS COMUNS

### Erro: "Conexão com banco recusada"
**Solução:** Execute `php database/init.php`

### Erro: "Permission denied" na pasta database
**Solução:** `chmod 755 database/`

### CSS não carrega ou está básico
**Solução:** Compile o Tailwind: `npm run build`

### Página em branco
**Solução:** Verifique logs do PHP: `php -S localhost:8000 2>&1`

---

## 📚 DOCUMENTAÇÃO COMPLETA

- **README.md** - Visão geral e instalação
- **DOCUMENTATION.md** - Documentação técnica completa
- **project_logs.json** - Histórico de alterações

---

## 🎯 PRÓXIMOS PASSOS RECOMENDADOS

1. ✅ **Explorar o sistema**
   - Navegue por todas as páginas
   - Teste o formulário de diagnóstico
   - Familiarize-se com o admin

2. ✅ **Personalizar**
   - Edite cores em `tailwind.config.js`
   - Ajuste textos em `views/pages/*.php`
   - Customize logo/favicon

3. ✅ **Segurança**
   - Altere senha do admin
   - Configure `.env` para produção
   - Revise permissões de arquivos

4. ✅ **Deploy**
   - Siga guia de deploy na DOCUMENTATION.md
   - Configure banco MySQL na Hostinger
   - Faça upload via FTP/Git

---

## 🆘 SUPORTE

**Problemas?**
- Verifique DOCUMENTATION.md (seção Troubleshooting)
- Execute `php check-system.php` para diagnóstico
- Revise logs em `project_logs.json`

**Funciona?**
- ⭐ Marque o repositório
- 📝 Documente suas customizações
- 🚀 Compartilhe com o time

---

## ✅ CHECKLIST DE PRODUÇÃO

Antes de fazer deploy, garanta:

- [ ] Banco de dados MySQL configurado
- [ ] `.env` com credenciais de produção
- [ ] CSS compilado e minificado (`npm run build`)
- [ ] Senha do admin alterada
- [ ] Testes de formulário realizados
- [ ] Backup do banco local
- [ ] DNS apontado corretamente
- [ ] SSL/HTTPS configurado

---

**Sistema Operon** | Menos ferramenta. Mais motor.
v1.0.0 | 2026-01-28
