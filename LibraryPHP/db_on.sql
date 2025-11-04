-- Este script assume que você JÁ SELECIONOU seu banco de dados no phpMyAdmin
-- Ele NÃO usa 'CREATE DATABASE' ou 'USE'

-- Cria a tabela 'livros' já com a coluna 'capa'
CREATE TABLE IF NOT EXISTS livros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    autor VARCHAR(255),
    genero VARCHAR(100),
    status ENUM('Lido', 'Lendo', 'Quero Ler') DEFAULT 'Quero Ler',
    capa VARCHAR(255) NULL DEFAULT NULL,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);