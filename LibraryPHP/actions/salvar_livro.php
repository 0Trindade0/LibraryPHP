<?php
// Inclui o arquivo de conexão
include '../includes/conexao.php';

// 1. VERIFICA SE O FORMULÁRIO FOI ENVIADO (MÉTODO POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 2. COLETA E LIMPA OS DADOS
    $titulo = htmlspecialchars($_POST['titulo']);
    $autor = htmlspecialchars($_POST['autor']);
    $genero = htmlspecialchars($_POST['genero']);
    $status = htmlspecialchars($_POST['status']);
    // Inicia a variável da capa como nula.
    // Ela só terá um valor se o upload funcionar.
    $caminhoCapa = null;

    // 3. VALIDAÇÃO BÁSICA
    if (empty($titulo)) {
        die("O campo título é obrigatório.");
    }

    // 4. LÓGICA DE UPLOAD DA CAPA
    // Verifica se um arquivo foi enviado E se não teve erro
    if (isset($_FILES['capa']) && $_FILES['capa']['error'] == 0) {
        $uploadDir = '../uploads/'; // Pasta de destino
        
        // Gera um nome de arquivo único para evitar que "capa.jpg" substitua outro "capa.jpg"
        $nomeArquivo = uniqid() . '_' . basename($_FILES['capa']['name']);
        $caminhoCapa = $uploadDir . $nomeArquivo;
        
        // Tenta mover o arquivo do local temporário do PHP para nossa pasta 'uploads'
        if (move_uploaded_file($_FILES['capa']['tmp_name'], $caminhoCapa)) {
            // Se o upload deu certo, define o caminho que será salvo no banco
            // (relativo à raiz do projeto, para o HTML encontrar)
            $caminhoCapa = 'uploads/' . $nomeArquivo;
        } else {
            // Se falhar (ex: permissão da pasta), a capa continua nula
            $caminhoCapa = null;
        }
    }
    // --- FIM DA LÓGICA DE UPLOAD ---

    // 5. PREPARA O SQL (COM PREPARED STATEMENTS)
    // A query inclui a coluna 'capa'
    $sql = "INSERT INTO livros (titulo, autor, genero, status, capa) VALUES (:titulo, :autor, :genero, :status, :capa)";
    // $pdo->prepare() previne SQL Injection
    $stmt = $pdo->prepare($sql);

    // 6. VINCULA (BIND) OS VALORES
    // Associa as variáveis do PHP aos marcadores (:nome) no SQL
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':autor', $autor);
    $stmt->bindParam(':genero', $genero);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':capa', $caminhoCapa); // Salva o caminho da capa (ou null)
    
    // 7. EXECUÇÃO E REDIRECIONAMENTO
    try {
        $stmt->execute();
        // Deu certo? Redireciona para o index
        header("Location: ../index.php?msg=sucesso");
        exit();
    } catch (PDOException $e) {
        // Se der erro, mostra o erro
        die("Erro ao salvar o livro: " . $e->getMessage());
    }
} else {
    // Se alguém acessar este arquivo sem ser via POST, redireciona
    header("Location: ../form_cadastro.php");
    exit();
}
?>