<?php
include '../includes/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $titulo = htmlspecialchars($_POST['titulo']);
    $autor = htmlspecialchars($_POST['autor']);
    $genero = htmlspecialchars($_POST['genero']);
    $status = htmlspecialchars($_POST['status']);
    $caminhoCapa = null; // Inicia como nulo

    if (empty($titulo)) {
        die("O campo título é obrigatório.");
    }

    // --- LÓGICA DE UPLOAD DA CAPA ---
    if (isset($_FILES['capa']) && $_FILES['capa']['error'] == 0) {
        $uploadDir = '../uploads/'; // Pasta de destino
        
        // Gera um nome de arquivo único para evitar sobreposição
        $nomeArquivo = uniqid() . '_' . basename($_FILES['capa']['name']);
        $caminhoCapa = $uploadDir . $nomeArquivo;
        
        // Move o arquivo temporário para o destino final
        if (move_uploaded_file($_FILES['capa']['tmp_name'], $caminhoCapa)) {
            // Se o upload foi bem-sucedido, o $caminhoCapa está pronto
            // Nota: O caminho salvo no BD será "uploads/arquivo.jpg"
            $caminhoCapa = 'uploads/' . $nomeArquivo;
        } else {
            // Se falhar, $caminhoCapa continua nulo
            $caminhoCapa = null; 
        }
    }
    // --- FIM DA LÓGICA DE UPLOAD ---

    // SQL agora inclui a coluna 'capa'
    $sql = "INSERT INTO livros (titulo, autor, genero, status, capa) VALUES (:titulo, :autor, :genero, :status, :capa)";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':autor', $autor);
    $stmt->bindParam(':genero', $genero);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':capa', $caminhoCapa); // Adiciona o caminho da capa
    
    try {
        $stmt->execute();
        header("Location: ../index.php?msg=sucesso");
        exit();
    } catch (PDOException $e) {
        die("Erro ao salvar o livro: " . $e->getMessage());
    }
} else {
    header("Location: ../form_cadastro.php");
    exit();
}
?>