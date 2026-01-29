Para construir esse "Motor Operon" com dois polos distintos (Público e Administrativo) sem criar um Frankenstein, a estrutura de pastas deve seguir um padrão de **Front Controller**. Isso garante que o seu `index.php` na raiz seja o maestro de tudo, facilitando o deploy na Hostinger e mantendo a segurança.

Aqui está o esqueleto organizado para o seu projeto de **Nível 1**:

---

## **📂 Estrutura de Pastas (Arquitetura Operon)**

Plaintext  
/operon-system  
├── /admin              \# Polo Administrativo (CMS/Dashboard)  
│   ├── /actions        \# Lógica de processamento (login, status de leads)  
│   ├── /components     \# UI do Dashboard (Sidebar, Stats Cards)  
│   └── index.php       \# Entrada do painel admin  
├── /app                \# O Coração do Sistema (Lógica Backend)  
│   ├── /config         \# Conexão DB (SQLite/MySQL) e variáveis  
│   ├── /helpers        \# Funções globais (Sanitização, Formatação)  
│   └── /services       \# Lógica do Diagnóstico e envio de Protocolos  
├── /assets             \# Arquivos Estáticos  
│   ├── /css            \# Tailwind compilado  
│   ├── /img            \# Assets visuais (os prompts que criamos)  
│   └── /js             \# Scripts de interatividade e máscara de campos  
├── /database           \# Local do SQLite (local.db)  
├── /views              \# Polo Público (Páginas do Site)  
│   ├── /components     \# Header, Footer, Botões (Reutilizáveis)  
│   ├── /pages          \# Arquivos de conteúdo das páginas  
│   └── layout.php      \# Template base (Quiet Luxury)  
├── .env                \# Variáveis sensíveis (Subir Manualmente)  
├── index.php           \# A PONTE (Front Controller da public\_html)  
├── DOCUMENTATION.md    \# Evolução do Software  
└── project\_logs.json   \# Log detalhado de alterações

---

## **🌐 Polo 01: O Site Público (Funil de Elite)**

As páginas foram pensadas para guiar o cliente do desconhecimento até a posse do próprio motor.

1. **Home (O Motor):** Foco na Proposta Única de Valor (USP) — "Menos ferramenta. Mais motor".  
2. **Sobre Nós (A Engenharia):** Detalhamento da visão da Operon e a filosofia do "Núcleo Replicável™".  
3. **Serviços (Os Ativos):** Explicação técnica sobre os Agentes de IA, Infraestrutura e Modularidade.  
4. **Parcerias & Franquias:** Página destinada a quem deseja replicar a estrutura Operon ou abrir novas células de operação/franqueamento.  
5. **Agendamento (O Arquiteto Neural):** O formulário inteligente que lê a intenção do cliente, gera o diagnóstico inicial e o coloca na base de dados para sua avaliação.

---

## **🖥️ Polo 02: Admin Dashboard (O Cockpit)**

Aqui você assume o controle soberano do sistema. Ele será protegido por login e servirá como seu **CMS e CRM-lite**.

* **Dashboard Principal:** Visualização de acessos e volume de novos agendamentos por período.  
* **Gestão de Leads:** Lista de pessoas que fizeram o diagnóstico, com visualização do que a IA "leu" sobre o negócio delas.  
* **Controle de Status:** Mudar o estágio do cliente no funil (Aguardando Contato \-\> Protocolo Enviado \-\> Em Reunião \-\> Fechado).  
* **Gestão de Serviços:** Área simples para você editar textos ou detalhes técnicos que aparecem no site (função de CMS).  
* **Logs do Sistema:** Visualização interna do `project_logs.json` para monitorar a saúde técnica.

---

## **🛠️ Regras de Implementação para o seu Nível 1**

* **A Ponte (`index.php` raiz):** Este arquivo vai verificar a URL. Se o usuário acessar `/admin`, ele chama o polo administrativo. Se acessar qualquer outra rota, ele carrega o polo público.  
* **Banco de Dados Soberano:** O software deve usar a classe de conexão em `/app/config` para identificar se está em `localhost` (usa SQLite em `/database`) ou na Hostinger (conecta no MySQL via `.env`).  
* **O Protocolo de Saída:** Quando o cliente termina o agendamento, o sistema salva os dados e gera um status "Pendente". No Admin, você revisa e clica em "Enviar Protocolo", o que dispara a automação para o cliente.

Essa estrutura garante que você tenha um **ativo proprietário** organizado, fácil de manter na Hostinger e pronto para escala sem virar um Frankenstein.

