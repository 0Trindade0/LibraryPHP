-- Este script serve para criar a estrutura do banco de dados do zero.
-- O ideal é usá-lo em um banco de dados já existente (ex: 'library_db')
-- ou remover os comentários das duas primeiras linhas para criar o banco.

-- CREATE DATABASE IF NOT EXISTS library_db;
-- USE library_db;

-- --------------------------------------------------------

--
-- Estrutura da tabela `livros`
--

CREATE TABLE `livros` (
  -- `id`: Chave primária que se auto-incrementa a cada novo livro.
  `id` int(11) NOT NULL AUTO_INCREMENT,
  
  -- `titulo`: Obrigatório (NOT NULL).
  `titulo` varchar(255) NOT NULL,
  
  -- `autor`, `genero`: Opcionais (DEFAULT NULL).
  `autor` varchar(255) DEFAULT NULL,
  `genero` varchar(100) DEFAULT NULL,
  
  -- `status`: Um campo ENUM que só aceita 3 valores.
  -- Se nada for passado, o valor padrão é 'Quero Ler'.
  `status` enum('Lido','Lendo','Quero Ler') DEFAULT 'Quero Ler',
  
  -- `capa`: Caminho para a imagem. Opcional.
  `capa` varchar(255) DEFAULT NULL,
  
  -- `data_cadastro`: Data e hora de quando o registro foi criado.
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp(),
  
  -- Define que a coluna `id` é a Chave Primária.
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;