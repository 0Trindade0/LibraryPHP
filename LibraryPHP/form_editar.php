<?php
// Inclui os templates
include 'includes/header.php';
include 'includes/conexao.php';

// 1. VERIFICAÇÃO DO ID NA URL
// Pega o 'id' que veio da URL (ex: form_editar.php?id=5)
if (!isset($_GET['id'])) {
    die("ID do livro não fornecido.");
}
// Limpa o ID para garantir que é um número
$id = intval($_GET['id']); 

// 2. BUSCA OS DADOS ATUAIS DO LIVRO
// Faz um SELECT para buscar o livro com o ID recebido
try {
    $sql = "SELECT * FROM livros WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    
    // Pega os dados do livro como um array associativo
    $livro = $stmt->fetch(PDO::FETCH_ASSOC);

    // Se $livro for falso (não encontrou), para o script
    if (!$livro) {
        die("Livro não encontrado.");
    }
} catch (PDOException $e) {
    die("Erro ao buscar o livro: " . $e->getMessage());
}
?>

<h2>Editar Livro</h2>

<form action="actions/atualizar_livro.php" method="POST" id="form-livro" enctype="multipart/form-data">
    
    <input type="hidden" name="id" value="<?php echo $livro['id']; ?>">
    
    <div class="form-group">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($livro['titulo']); ?>" required>
    </div>
    <div class="form-group">
        <label for="autor">Autor:</label>
        <input type="text" id="autor" name="autor" value="<?php echo htmlspecialchars($livro['autor']); ?>">
    </div>
    <div class="form-group">
        <label for="genero">Gênero:</label>
        <input type="text" id="genero" name="genero" value="<?php echo htmlspecialchars($livro['genero']); ?>">
    </div>
    
    <div class="form-group">
        <label for="status">Status:</label>
        <select id="status" name="status">
            <option value="Quero Ler" <?php echo ($livro['status'] == 'Quero Ler') ? 'selected' : ''; ?>>Quero Ler</option>
            <option value="Lendo" <?php echo ($livro['status'] == 'Lendo') ? 'selected' : ''; ?>>Lendo</option>
            <option value="Lido" <?php echo ($livro['status'] == 'Lido') ? 'selected' : ''; ?>>Lido</option>
        </select>
    </div>

    <div class="form-group">
        <label for="capa">Nova Capa (Opcional, deixe em branco para manter a atual):</label>
        <input type="file" id="capa" name="capa">
        
        <?php if (!empty($livro['capa'])): ?>
            <p style="margin-top: 10px;">Capa Atual:</p>
            <img src="<?php echo htmlspecialchars($livro['capa']); ?>" alt="Capa" width="100">
        <?php endif; ?>
    </div>

    <button type="submit" class="btn btn-primary">Atualizar Livro</button>
</form>

<?php include 'includes/footer.php'; ?>