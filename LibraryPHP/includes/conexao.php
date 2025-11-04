<?php
// --- Configurações do Banco de Dados ---
// Mude estas variáveis se o seu ambiente for diferente.
$host = 'localhost';
$db   = 'library_db';// O nome do seu banco de dados
$user = 'root'; // Usuário padrão do XAMPP/WAMP
$pass = '';     // Senha padrão do XAMPP/WAMP

// --- Bloco Try/Catch para Conexão ---
// Usar try/catch é uma boa prática. Se a conexão falhar,
// o 'catch' será executado, evitando que o erro quebre o site.
try {
    // A linha principal da conexão.
    // PDO (PHP Data Objects) é a forma moderna e segura de conectar com bancos.
    // "charset=utf8" garante que caracteres como "ç" e "ã" funcionem.
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);

    // Configura o PDO para relatar erros de forma mais clara (lançando exceções).
    // Isso ajuda muito na hora de depurar (descobrir erros).
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}
?>