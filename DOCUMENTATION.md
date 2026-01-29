# OPERON SYSTEM - DOCUMENTAÇÃO EVOLUTIVA

**Versão:** 1.0.0
**Data de Criação:** 2026-01-28
**Última Atualização:** 2026-01-28

---

## 📋 VISÃO GERAL

O Sistema Operon é uma plataforma de arquitetura modular construída com PHP moderno, projetada para gerenciar leads, diagnósticos inteligentes e operações administrativas. O sistema segue a filosofia **"Quiet Luxury"** no design e prioriza **soberania técnica**.

### Stack Tecnológica

- **Backend:** PHP 8.x (modular, sem frameworks pesados)
- **Frontend:** Tailwind CSS customizado
- **Database:** SQLite (desenvolvimento) / MySQL (produção) com detecção automática
- **Deploy:** Hostinger (pasta public_html)
- **Design:** Quiet Luxury (Petrol #0B2421, Olive #ACC18A, Off-white #F5F5F5)

---

## 🏗️ ARQUITETURA DO SISTEMA

### Padrão: Front Controller

O sistema utiliza um **Front Controller** (`index.php` raiz) que roteia todas as requisições para dois polos distintos:

1. **Polo Público:** Landing page, funil de diagnóstico, páginas institucionais
2. **Polo Administrativo:** Dashboard CMS, gestão de leads, controle operacional

### Estrutura de Pastas

```
/operon-system
├── /admin                      # POLO ADMINISTRATIVO
│   ├── /actions                # Lógica de processamento
│   │   ├── login.php
│   │   └── logout.php
│   ├── /components             # Componentes UI
│   │   └── sidebar.php
│   ├── /views                  # Views do dashboard
│   │   ├── dashboard.php
│   │   ├── leads.php
│   │   ├── lead-detail.php
│   │   ├── configuracoes.php
│   │   └── logs.php
│   └── index.php               # Entrada do admin
│
├── /app                        # CORAÇÃO DO SISTEMA
│   ├── /config
│   │   ├── database.php        # Conexão inteligente SQLite/MySQL
│   │   └── constants.php       # Constantes globais
│   ├── /helpers
│   │   ├── sanitize.php        # Funções de sanitização
│   │   └── format.php          # Funções de formatação
│   └── /services
│       └── diagnostic.php      # Processamento do Arquiteto Neural
│
├── /assets                     # ARQUIVOS ESTÁTICOS
│   ├── /css
│   │   ├── input.css           # Input Tailwind
│   │   └── operon.css          # CSS compilado
│   ├── /img                    # Imagens
│   └── /js
│       └── form-mask.js        # Máscaras de formulário
│
├── /database
│   ├── local.db                # SQLite (não versionado)
│   └── schema.sql              # Schema das tabelas
│
├── /views                      # POLO PÚBLICO
│   ├── /components
│   │   ├── header.php
│   │   └── footer.php
│   ├── /pages
│   │   ├── home.php
│   │   ├── sobre.php
│   │   ├── servicos.php
│   │   ├── parcerias.php
│   │   ├── agendamento.php
│   │   └── sucesso.php
│   └── layout.php              # Template base
│
├── .env                        # Variáveis de ambiente (NÃO VERSIONADO)
├── example.env                 # Template de .env
├── index.php                   # FRONT CONTROLLER
├── tailwind.config.js          # Config Tailwind
├── DOCUMENTATION.md            # Esta documentação
└── project_logs.json           # Logs de alterações
```

---

## 🔄 FLUXO DE DADOS

### Polo Público (Landing Page)

1. Usuário acessa o site via `index.php`
2. Front Controller detecta que não é `/admin` e carrega `views/layout.php`
3. Layout renderiza a página solicitada (ex: `home.php`, `agendamento.php`)
4. Usuário preenche formulário "Arquiteto Neural"
5. Dados são enviados para `app/services/diagnostic.php`
6. Diagnóstico é processado e salvo no banco
7. Protocolo único é gerado
8. Redirecionamento para página de sucesso

### Polo Administrativo (Dashboard)

1. Usuário acessa `/admin`
2. Front Controller detecta `/admin` e carrega `admin/index.php`
3. Se não autenticado, exibe `admin/actions/login.php`
4. Após login, dashboard é carregado com estatísticas
5. Admin pode visualizar leads, alterar status, adicionar observações
6. Alterações são registradas em `lead_history`

---

## 🗄️ BANCO DE DADOS

### Detecção Automática de Ambiente

A classe `Database` (`app/config/database.php`) detecta automaticamente o ambiente:

- **Local** (localhost, 127.0.0.1, *.local): Usa SQLite (`database/local.db`)
- **Produção** (Hostinger): Usa MySQL (credenciais do `.env`)

### Tabelas Principais

#### `leads`
Armazena diagnósticos do Arquiteto Neural.

| Campo                  | Tipo         | Descrição                        |
|------------------------|--------------|----------------------------------|
| id                     | INTEGER      | Chave primária                   |
| nome                   | VARCHAR(255) | Nome completo                    |
| email                  | VARCHAR(255) | E-mail corporativo               |
| telefone               | VARCHAR(20)  | Telefone                         |
| empresa                | VARCHAR(255) | Nome da empresa                  |
| segmento               | VARCHAR(100) | Segmento de atuação              |
| descricao_necessidade  | TEXT         | Dor operacional descrita         |
| diagnostico_ia         | TEXT         | Diagnóstico gerado               |
| status                 | VARCHAR(50)  | Status do lead                   |
| protocolo              | VARCHAR(20)  | Protocolo único (OP-XXXXXXXX)    |
| observacoes            | TEXT         | Notas internas                   |
| created_at             | DATETIME     | Data de criação                  |
| updated_at             | DATETIME     | Data de atualização              |

#### `admin_users`
Usuários administrativos.

| Campo          | Tipo          | Descrição                      |
|----------------|---------------|--------------------------------|
| id             | INTEGER       | Chave primária                 |
| username       | VARCHAR(100)  | Usuário de login (único)       |
| password_hash  | VARCHAR(255)  | Hash bcrypt da senha           |
| nome_completo  | VARCHAR(255)  | Nome completo                  |
| email          | VARCHAR(255)  | E-mail                         |
| ultimo_acesso  | DATETIME      | Último login                   |
| ativo          | BOOLEAN       | Status ativo/inativo           |
| created_at     | DATETIME      | Data de criação                |

**Usuário padrão:**
- Username: `admin`
- Senha: `operon2024`

#### `lead_history`
Histórico de alterações de status dos leads.

#### `system_settings`
Configurações gerais do sistema.

---

## 🔐 SEGURANÇA

### Práticas Implementadas

1. **Sanitização de Inputs:** Todas as entradas de usuário passam por `sanitize()` (XSS protection)
2. **Prepared Statements:** PDO com prepared statements (SQL injection protection)
3. **Password Hashing:** Bcrypt com custo 10
4. **Session-based Auth:** Autenticação via sessões PHP
5. **CSRF Protection:** (Pendente - Sprint 02)

### Funções de Segurança

- `sanitize($input)`: Remove tags HTML e caracteres especiais
- `sanitize_email($email)`: Valida e sanitiza e-mails
- `sanitize_phone($phone)`: Remove caracteres não numéricos
- `escape($string)`: Escapa output para prevenir XSS

---

## 🎨 DESIGN SYSTEM (QUIET LUXURY)

### Paleta de Cores

- **Petrol:** `#0B2421` - Cor principal (fundos escuros, textos)
- **Olive:** `#ACC18A` - Cor de destaque (CTAs, highlights)
- **Soft White:** `#F5F5F5` - Fundos claros, textos em fundos escuros

### Tipografia

- **Títulos:** Instrument Serif (serifada moderna)
- **Corpo:** Inter (sans-serif geométrica)
- **Código:** JetBrains Mono (monospace)

### Princípios de Design

1. **Espaçamento Generoso:** py-24, py-32 para seções
2. **Bordas Finas:** 1px com baixa opacidade
3. **Micro-interações Suaves:** Transitions de 300-500ms
4. **Glassmorphism Sutil:** bg-white/5 com bordas
5. **Grid Técnico:** Layout preciso e alinhado

---

## 🚀 DEPLOY NA HOSTINGER

### Pré-requisitos

- PHP 8.0 ou superior
- MySQL (ou SQLite para testes)
- Composer (opcional)
- Node.js + npm (para compilar Tailwind)

### Passos de Deploy

1. **Upload dos Arquivos**
   - Via FTP/SFTP ou Git, enviar todos os arquivos para `public_html`

2. **Configurar .env**
   - Acessar Gerenciador de Arquivos da Hostinger
   - Criar arquivo `.env` manualmente
   - Adicionar credenciais do banco MySQL

3. **Criar Banco de Dados MySQL**
   - Acessar painel MySQL da Hostinger
   - Criar database `operon_db`
   - Criar usuário e senha
   - Executar `database/schema.sql` via phpMyAdmin

4. **Ajustar Permissões**
   - Pasta `/database`: 755 (escrita para SQLite local)
   - Arquivos PHP: 644

5. **Compilar CSS (Local)**
   ```bash
   npm install
   npx tailwindcss -i ./assets/css/input.css -o ./assets/css/operon.css --minify
   ```
   Fazer upload do `operon.css` compilado

6. **Testar**
   - Acessar domínio e verificar homepage
   - Acessar `/admin` e fazer login
   - Testar formulário de diagnóstico

---

## 📊 MONITORAMENTO E LOGS

### project_logs.json

Arquivo JSON que registra todas as alterações no sistema:

```json
[
  {
    "timestamp": "2026-01-28T16:45:00Z",
    "action": "Inicialização do Sistema",
    "details": "Descrição da ação",
    "impact": ["arquivo1.php", "arquivo2.php"]
  }
]
```

Visualização disponível em: `/admin?view=logs`

---

## 🔧 MANUTENÇÃO E EVOLUÇÃO

### Adicionar Nova Página Pública

1. Criar arquivo em `views/pages/nova-pagina.php`
2. Adicionar à whitelist em `views/layout.php` (linha 18)
3. Adicionar link no header/footer

### Adicionar Nova View Admin

1. Criar arquivo em `admin/views/nova-view.php`
2. Adicionar rota no switch de `admin/index.php`
3. Adicionar link na sidebar

### Atualizar Schema do Banco

1. Editar `database/schema.sql`
2. Para SQLite: Deletar `database/local.db` e reconectar (recria automaticamente)
3. Para MySQL: Executar ALTER TABLE via phpMyAdmin

---

## 📝 NOTAS TÉCNICAS

### Por que não usar frameworks?

- **Soberania técnica total:** Zero dependências de terceiros
- **Facilidade de manutenção:** Código claro e direto
- **Performance superior:** Sem overhead de framework
- **Transferência de conhecimento:** Mais fácil de ensinar e documentar

### Por que SQLite + MySQL?

- **SQLite:** Desenvolvimento local rápido, sem configuração
- **MySQL:** Produção com suporte a múltiplas conexões e maior robustez
- **Detecção automática:** Código funciona em ambos sem modificação

### Tailwind JIT (Just-in-Time)

- Compila apenas classes utilizadas
- CSS final: < 50KB
- Performance otimizada

---

## 🚦 PRÓXIMAS ITERAÇÕES (ROADMAP)

### Sprint 02 (Prioridade Alta)

- [ ] Integração com Claude API para diagnósticos reais
- [ ] Sistema de envio de e-mails transacionais
- [ ] CRUD de serviços (CMS dinâmico)
- [ ] Exportação de leads (CSV/Excel)

### Sprint 03 (Prioridade Média)

- [ ] Analytics dashboard (métricas de conversão)
- [ ] Sistema de notificações (e-mail/SMS)
- [ ] Logs de auditoria detalhados
- [ ] API REST para integrações

### Sprint 04 (Prioridade Baixa)

- [ ] Multi-idioma (i18n)
- [ ] Modo escuro no admin
- [ ] Relatórios PDF automatizados
- [ ] Integração com CRM externo

---

## 🆘 TROUBLESHOOTING

### Erro de Conexão com Banco

**Sintoma:** "Erro de conexão com o banco de dados"

**Solução:**
1. Verificar credenciais no `.env`
2. Verificar se banco MySQL existe
3. Verificar permissões de escrita em `/database` (SQLite)

### CSS não carrega

**Sintoma:** Página sem estilo

**Solução:**
1. Verificar se `assets/css/operon.css` existe
2. Recompilar: `npx tailwindcss -i ./assets/css/input.css -o ./assets/css/operon.css`
3. Limpar cache do navegador

### Admin não autentica

**Sintoma:** Login falha mesmo com credenciais corretas

**Solução:**
1. Verificar se tabela `admin_users` existe
2. Verificar hash da senha no banco
3. Verificar sessões PHP habilitadas

---

## 📚 REFERÊNCIAS

- **Tailwind CSS:** https://tailwindcss.com/docs
- **PHP PDO:** https://www.php.net/manual/en/book.pdo.php
- **SQLite:** https://www.sqlite.org/docs.html
- **Hostinger Docs:** https://support.hostinger.com/

---

**Fim da Documentação v1.0.0**
