<?php
// Inclui o arquivo de conexão
include '../includes/conexao.php';

// 1. VERIFICA SE O ID FOI PASSADO PELA URL (MÉTODO GET)
if (!isset($_GET['id'])) {
    die("ID do livro não fornecido.");
}

// 2. COLETA E LIMPA O ID
// intval() garante que é um número, prevenindo SQL Injection
$id = intval($_GET['id']);

if ($id <= 0) {
    die("ID inválido.");
}

// 3. EXECUÇÃO DO SQL DELETE
try {
    // Prepara o SQL de forma segura
    $sql = "DELETE FROM livros WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    // Vincula o ID ao :id da query
    $stmt->bindParam(':id', $id);
    // Executa
    $stmt->execute();

    // 4. REDIRECIONAMENTO
    // Deu certo? Redireciona para o index com msg de sucesso
    header("Location: ../index.php?msg=excluido");
    exit();
} catch (PDOException $e) {
    // Se der erro (ex: chave estrangeira), mostra o erro
    die("Erro ao excluir o livro: " . $e->getMessage());
}
?>  