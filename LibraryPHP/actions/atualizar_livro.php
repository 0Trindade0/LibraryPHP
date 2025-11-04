<?php
include '../includes/conexao.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $id = intval($_POST['id']);
    $titulo = htmlspecialchars($_POST['titulo']);
    $autor = htmlspecialchars($_POST['autor']);
    $genero = htmlspecialchars($_POST['genero']);
    $status = htmlspecialchars($_POST['status']);
    
    if (empty($titulo) || empty($id)) {
        die("Dados inválidos.");
    }

    // --- LÓGICA DE UPLOAD DA CAPA (ATUALIZAÇÃO) ---
    // Verifica se um NOVO arquivo foi enviado
    if (isset($_FILES['capa']) && $_FILES['capa']['error'] == 0) {
        $uploadDir = '../uploads/';
        $nomeArquivo = uniqid() . '_' . basename($_FILES['capa']['name']);
        $caminhoCapa = $uploadDir . $nomeArquivo;

        if (move_uploaded_file($_FILES['capa']['tmp_name'], $caminhoCapa)) {
            $caminhoCapaDB = 'uploads/' . $nomeArquivo;
            
            // Se um novo upload deu certo, atualiza a coluna 'capa'
            $sql = "UPDATE livros SET titulo = :titulo, autor = :autor, genero = :genero, status = :status, capa = :capa WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':capa', $caminhoCapaDB);
        } else {
            // Se o upload falhar, não atualiza a capa (mantém a antiga)
            $sql = "UPDATE livros SET titulo = :titulo, autor = :autor, genero = :genero, status = :status WHERE id = :id";
            $stmt = $pdo->prepare($sql);
        }
    } else {
        // Se nenhum novo arquivo foi enviado, não atualiza a coluna 'capa'
        $sql = "UPDATE livros SET titulo = :titulo, autor = :autor, genero = :genero, status = :status WHERE id = :id";
        $stmt = $pdo->prepare($sql);
    }
    // --- FIM DA LÓGICA DE UPLOAD ---

    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':autor', $autor);
    $stmt->bindParam(':genero', $genero);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':id', $id);
    
    try {
        $stmt->execute();
        header("Location: ../index.php?msg=atualizado");
        exit();
    } catch (PDOException $e) {
        die("Erro ao atualizar o livro: " . $e->getMessage());
    }
} else {
    header("Location: ../index.php");
    exit();
}
?>