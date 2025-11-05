<?php
// Inclui o arquivo de conexão com o banco de dados
include '../includes/conexao.php';

// 1. VERIFICA SE O FORMULÁRIO FOI ENVIADO (MÉTODO POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 2. COLETA E LIMPA OS DADOS DO FORMULÁRIO
    // intval() garante que o ID é um número
    $id = intval($_POST['id']);
    // htmlspecialchars() previne ataques XSS
    $titulo = htmlspecialchars($_POST['titulo']);
    $autor = htmlspecialchars($_POST['autor']);
    $genero = htmlspecialchars($_POST['genero']);
    $status = htmlspecialchars($_POST['status']);
    
    // 3. VALIDAÇÃO BÁSICA
    if (empty($titulo) || empty($id)) {
        die("Dados inválidos.");
    }

    // 4. LÓGICA DE UPLOAD DA CAPA (ATUALIZAÇÃO)
    // Verifica se um NOVO arquivo foi enviado e se não teve erro
    if (isset($_FILES['capa']) && $_FILES['capa']['error'] == 0) {
        $uploadDir = '../uploads/';
        $nomeArquivo = uniqid() . '_' . basename($_FILES['capa']['name']);
        $caminhoCapa = $uploadDir . $nomeArquivo;

        // Tenta mover o arquivo para a pasta 'uploads'
        if (move_uploaded_file($_FILES['capa']['tmp_name'], $caminhoCapa)) {
            $caminhoCapaDB = 'uploads/' . $nomeArquivo;
            
            // Query SQL para ATUALIZAR TUDO, incluindo a nova capa
            $sql = "UPDATE livros SET titulo = :titulo, autor = :autor, genero = :genero, status = :status, capa = :capa WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            // Faz o "bind" do novo caminho da capa
            $stmt->bindParam(':capa', $caminhoCapaDB);
        } else {
            // Se o upload falhar, usa a query que NÃO atualiza a capa (mantém a antiga)
            $sql = "UPDATE livros SET titulo = :titulo, autor = :autor, genero = :genero, status = :status WHERE id = :id";
            $stmt = $pdo->prepare($sql);
        }
    } else {
        // Se nenhum novo arquivo foi enviado, usa a query que NÃO atualiza a capa
        $sql = "UPDATE livros SET titulo = :titulo, autor = :autor, genero = :genero, status = :status WHERE id = :id";
        $stmt = $pdo->prepare($sql);
    }
    // --- FIM DA LÓGICA DE UPLOAD ---

    // 5. VINCULA (BIND) OS PARÂMETROS COMUNS
    // Estes parâmetros são vinculados independentemente de ter havido upload ou não
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':autor', $autor);
    $stmt->bindParam(':genero', $genero);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':id', $id);
    
    // 6. EXECUÇÃO E REDIRECIONAMENTO
    try {
        $stmt->execute();
        // Deu certo? Redireciona para o index com msg de sucesso
        header("Location: ../index.php?msg=atualizado");
        exit();
    } catch (PDOException $e) {
        // Se der erro, mostra o erro
        die("Erro ao atualizar o livro: " . $e->getMessage());
    }
} else {
    // Se alguém acessar este arquivo sem ser via POST, redireciona para o index
    header("Location: ../index.php");
    exit();
}
?>