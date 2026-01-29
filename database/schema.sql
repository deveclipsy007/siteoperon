-- =====================================================
-- OPERON SYSTEM - DATABASE SCHEMA (MySQL Version)
-- Compatível com Hostinger / phpMyAdmin
-- =====================================================

-- Tabela de Leads
CREATE TABLE IF NOT EXISTS leads (
    id INT AUTO_INCREMENT PRIMARY KEY,
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
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Índices
CREATE INDEX idx_leads_status ON leads(status);
CREATE INDEX idx_leads_protocolo ON leads(protocolo);
CREATE INDEX idx_leads_created_at ON leads(created_at);
CREATE INDEX idx_leads_email ON leads(email);

-- Tabela de Usuários Administrativos
CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    nome_completo VARCHAR(255),
    email VARCHAR(255),
    ultimo_acesso DATETIME,
    ativo TINYINT(1) DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Usuário Admin Padrão
INSERT IGNORE INTO admin_users (username, password_hash, nome_completo)
VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrador Operon');

-- Histórico de Leads
CREATE TABLE IF NOT EXISTS lead_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lead_id INT NOT NULL,
    status_anterior VARCHAR(50),
    status_novo VARCHAR(50),
    observacao TEXT,
    usuario_id INT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (lead_id) REFERENCES leads(id) ON DELETE CASCADE
);

-- Configurações do Sistema
CREATE TABLE IF NOT EXISTS system_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    chave VARCHAR(100) UNIQUE NOT NULL,
    valor TEXT,
    descricao TEXT,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Configurações padrão
INSERT IGNORE INTO system_settings (chave, valor, descricao)
VALUES
    ('site_titulo', 'Operon Agents | Motor Replicável', 'Título do site'),
    ('site_email', 'contato@operon.com.br', 'E-mail de contato'),
    ('lead_email_notificacao', 'true', 'Enviar e-mail ao receber novo lead'),
    ('manutencao_modo', 'false', 'Ativar modo de manutenção');
