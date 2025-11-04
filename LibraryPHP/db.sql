-- Cria o banco de dados (se não existir)
CREATE DATABASE IF NOT EXISTS biblioteca_db;

-- Usa o banco de dados
USE biblioteca_db;

-- Cria a tabela 'livros'
CREATE TABLE IF NOT EXISTS livros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    autor VARCHAR(255),
    genero VARCHAR(100),
    status ENUM('Lido', 'Lendo', 'Quero Ler') DEFAULT 'Quero Ler',
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);