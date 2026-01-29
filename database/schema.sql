-- =====================================================
-- OPERON SYSTEM - DATABASE SCHEMA
-- Schema universal para SQLite e MySQL
-- =====================================================

-- Tabela de Leads (Diagnósticos do Arquiteto Neural)
CREATE TABLE IF NOT EXISTS leads (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    telefone VARCHAR(20),
    empresa VARCHAR(255),
    segmento VARCHAR(100),
    descricao_necessidade TEXT,
    diagnostico_ia TEXT,
    status VARCHAR(50) DEFAULT 'pendente',
    protocolo VARCHAR(20) UNIQUE,
    observacoes TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Índices para performance
CREATE INDEX IF NOT EXISTS idx_leads_status ON leads(status);
CREATE INDEX IF NOT EXISTS idx_leads_protocolo ON leads(protocolo);
CREATE INDEX IF NOT EXISTS idx_leads_created_at ON leads(created_at);
CREATE INDEX IF NOT EXISTS idx_leads_email ON leads(email);

-- Tabela de Usuários Administrativos
CREATE TABLE IF NOT EXISTS admin_users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    nome_completo VARCHAR(255),
    email VARCHAR(255),
    ultimo_acesso DATETIME,
    ativo BOOLEAN DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Inserir usuário admin padrão
-- Usuário: admin | Senha: operon2024
INSERT OR IGNORE INTO admin_users (username, password_hash, nome_completo)
VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrador Operon');

-- Tabela de Histórico de Alterações de Leads
CREATE TABLE IF NOT EXISTS lead_history (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    lead_id INTEGER NOT NULL,
    status_anterior VARCHAR(50),
    status_novo VARCHAR(50),
    observacao TEXT,
    usuario_id INTEGER,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (lead_id) REFERENCES leads(id) ON DELETE CASCADE
);

-- Tabela de Configurações do Sistema
CREATE TABLE IF NOT EXISTS system_settings (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    chave VARCHAR(100) UNIQUE NOT NULL,
    valor TEXT,
    descricao TEXT,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Configurações padrão
INSERT OR IGNORE INTO system_settings (chave, valor, descricao)
VALUES
    ('site_titulo', 'Operon Agents | Motor Replicável', 'Título do site'),
    ('site_email', 'contato@operon.com.br', 'E-mail de contato'),
    ('lead_email_notificacao', 'true', 'Enviar e-mail ao receber novo lead'),
    ('manutencao_modo', 'false', 'Ativar modo de manutenção');

-- =====================================================
-- NOTAS DE MIGRAÇÃO PARA MYSQL
-- =====================================================
-- Para MySQL, substitua:
-- 1. INTEGER PRIMARY KEY AUTOINCREMENT -> INT AUTO_INCREMENT PRIMARY KEY
-- 2. BOOLEAN -> TINYINT(1)
-- 3. DATETIME DEFAULT CURRENT_TIMESTAMP -> DATETIME DEFAULT CURRENT_TIMESTAMP
-- 4. INSERT OR IGNORE -> INSERT IGNORE
