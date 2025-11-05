<?php
// --- Configurações do Banco de Dados ---
$host = 'localhost'; // Endereço do servidor MySQL
$db   = 'library_db';// O nome do seu banco de dados
$user = 'root'; // Usuário padrão do XAMPP/WAMP
$pass = '';     // Senha padrão do XAMPP/WAMP (vazia)

// --- Bloco Try/Catch para Conexão ---
// Usamos 'try...catch' para tentar conectar.
// Se a conexão falhar, o bloco 'catch' é executado.
try {
    // 1. CRIA A CONEXÃO PDO (PHP Data Objects)
    // PDO é a forma moderna e segura de conectar ao banco.
    // "charset=utf8" garante que acentos (ç, ã, etc.) funcionem.
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    
    // 2. CONFIGURA O MODO DE ERRO
    // Diz ao PDO para "lançar exceções" (erros) se algo der errado.
    // Isso torna mais fácil depurar o código.
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    // 3. CAPTURA O ERRO
    // Se a conexão no 'try' falhar, o script para (die)
    // e mostra a mensagem de erro.
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}
?>