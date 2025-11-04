<?php
include '../includes/conexao.php';

// 1. Verificar se o ID foi passado via GET
if (!isset($_GET['id'])) {
    die("ID do livro não fornecido.");
}

$id = intval($_GET['id']); // Segurança

if ($id <= 0) {
    die("ID inválido.");
}

try {
    $sql = "DELETE FROM livros WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    // Redireciona para o index com mensagem de sucesso
    header("Location: ../index.php?msg=excluido");
    exit();
} catch (PDOException $e) {
    die("Erro ao excluir o livro: " . $e->getMessage());
}
?>